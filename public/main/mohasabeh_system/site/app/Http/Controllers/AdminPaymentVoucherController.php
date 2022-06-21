<?php namespace App\Http\Controllers;

	use Illuminate\Support\Facades\Storage;
    use Session;
	use Request;
	use DB;
	use CRUDBooster;
	use Alert;
	use App\Traits\GeneralTrait;

	class AdminPaymentVoucherController extends \crocodicstudio_voila\crudbooster\controllers\CBController {
		use GeneralTrait;
	    public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "id";
			$this->limit = "20";
			$this->orderby = "id,desc";
			$this->global_privilege = false;
			$this->button_table_action = true;
			$this->button_bulk_action = true;
			$this->button_action_style = "button_icon";
			$this->button_add = true;
			$this->button_edit = true;
			$this->button_delete = true;
			$this->button_detail = true;
			$this->button_show = true;
			$this->button_filter = true;
			$this->button_import = false;
			$this->button_export = false;
			$this->table = "vouchers";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>"الرمز","name"=>"p_code"];
			$this->col[] = ["label"=>"التاريخ","name"=>"date"];
			$this->col[] = ["label"=>"الحساب المقابل","name"=>"debit","join"=>"accounts,name_ar"];
			$this->col[] = ["label"=>"الحساب الرئيسي","name"=>"credit","join"=>"accounts,name_ar"];
			$this->col[] = ["label"=>"البيان","name"=>"narration"];
			$this->col[] = ["label"=>"العملة","name"=>"currency_id","join"=>"currencies,name_ar"];
			$this->col[] = ["label"=>"القيمة","name"=>"amount"];
            if(CRUDBooster::isSuperAdmin())
                $this->col[] = ["label" => "الموظف", "name" => "staff_id", "join" => "cms_users,name"];
            else
                $this->col[] = ["label" => "الموظف", "name" => "staff_id", "join" => "cms_users,name","visible" => false];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE

			$id = CRUDBooster::myId();
            $me = DB::table('cms_users')->find($id);

			$this->form = [];
//			$this->form[] = ['label'=>'الحساب','name'=>'debit','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'accounts,name_ar','datatable_format'=>"code,' - ',name_ar",'datatable_where'=>'major_classification=0'];
            $this->form[] = ['label'=>'الحساب','name'=>'debit','type'=>'select2','validation'=>'required','width'=>'col-sm-10','datatable'=>'accounts,name_ar','datatable_format'=>"code,' - ',name_ar",'datatable_where' =>'id in ('.implode(',',$this->getPersons()).')'];
 			if ($me->id_cms_privileges == 4) {
            	$this->form[] = ['label'=>'المندوب','name'=>'delegate_id','type'=>'select','validation'=>'required','width'=>'col-sm-10','datatable'=>'cms_users,name','datatable_where'=>'id_cms_privileges = 4'.$this->getDelegates()];
			 }else{
				$this->form[] = ['label'=>'المندوب','name'=>'delegate_id','type'=>'select','validation'=>'','width'=>'col-sm-10','datatable'=>'cms_users,name','datatable_where'=>'id_cms_privileges = 4'.$this->getDelegates()];
			 }
            $this->form[] = ['label'=>'البيان','name'=>'narration','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'التاريخ','name'=>'date','type'=>'date','value'=>date('Y-m-d H:i:s', time()),'validation'=>'required|date','width'=>'col-sm-10'];

			$this->form[] = ['label'=>'العملة','name'=>'currency_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'currencies,name_ar'];
            $this->form[] = ['label'=>'القيمة','name'=>'amount','type'=>'number','step'=>'any','validation'=>'required|min:0','width'=>'col-sm-10','value'=>0];
			$gfunc= new GeneralFunctionsController();
		    $curr_enum_str=$gfunc->getActiveCurrenciesAsEnumString();
            $this->form[] = ['label' => 'مقابل', 'name' => 'opposite', 'type' => 'radio', 'validation' => 'required', 'width' => 'col-sm-10', 'dataenum' => "$curr_enum_str"];
            $this->form[] = ['label'=>'سعر الصرف','name'=>'ex_rate','type'=>'number','step'=>'any','validation'=>'required|min:0','width'=>'col-sm-10','value'=>0];

            $this->form[] = ['label'=>'القيمة المعادلة','name'=>'equalizer','type'=>'number','step'=>'any','validation'=>'required|min:1','width'=>'col-sm-10','value'=>0];
            $columns[] = ['label' => 'الصورة', 'name' => 'file_id', 'type' => 'upload','required' => true];
            $this->form[] = ['label' => 'اضافة صورة', 'name' => 'files_vouchers', 'type' => 'child', 'columns' => $columns, 'table' => 'files_vouchers', 'foreign_key' => 'voucher_id'];
			# END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ['label'=>'الحساب','name'=>'debit','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'البيان','name'=>'narration','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'التاريخ','name'=>'date','type'=>'date','validation'=>'required|date','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'العملة','name'=>'currency_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'القيمة','name'=>'amount','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			# OLD END FORM

			/*
	        | ----------------------------------------------------------------------
	        | Sub Module
	        | ----------------------------------------------------------------------
			| @label          = Label of action
			| @path           = Path of sub module
			| @foreign_key 	  = foreign key of sub table/module
			| @button_color   = Bootstrap Class (primary,success,warning,danger)
			| @button_icon    = Font Awesome Class
			| @parent_columns = Sparate with comma, e.g : name,created_at
	        |
	        */
	        $this->sub_module = array();


	        /*
	        | ----------------------------------------------------------------------
	        | Add More Action Button / Menu
	        | ----------------------------------------------------------------------
	        | @label       = Label of action
	        | @url         = Target URL, you can use field alias. e.g : [id], [name], [title], etc
	        | @icon        = Font awesome class icon. e.g : fa fa-bars
	        | @color 	   = Default is primary. (primary, warning, succecss, info)
	        | @showIf 	   = If condition when action show. Use field alias. e.g : [id] == 1
	        |
	        */
	        $this->addaction = array();


	        /*
	        | ----------------------------------------------------------------------
	        | Add More Button Selected
	        | ----------------------------------------------------------------------
	        | @label       = Label of action
	        | @icon 	   = Icon from fontawesome
	        | @name 	   = Name of button
	        | Then about the action, you should code at actionButtonSelected method
	        |
	        */
	        $this->button_selected = array();


	        /*
	        | ----------------------------------------------------------------------
	        | Add alert message to this module at overheader
	        | ----------------------------------------------------------------------
	        | @message = Text of message
	        | @type    = warning,success,danger,info
	        |
	        */
	        $this->alert        = array();



	        /*
	        | ----------------------------------------------------------------------
	        | Add more button to header button
	        | ----------------------------------------------------------------------
	        | @label = Name of button
	        | @url   = URL Target
	        | @icon  = Icon from Awesome.
	        |
	        */
	        $this->index_button = array();



	        /*
	        | ----------------------------------------------------------------------
	        | Customize Table Row Color
	        | ----------------------------------------------------------------------
	        | @condition = If condition. You may use field alias. E.g : [id] == 1
	        | @color = Default is none. You can use bootstrap success,info,warning,danger,primary.
	        |
	        */
            $this->table_row_color = array();

           

	        /*
	        | ----------------------------------------------------------------------
	        | You may use this bellow array to add statistic at dashboard
	        | ----------------------------------------------------------------------
	        | @label, @count, @icon, @color
	        |
	        */
	        $this->index_statistic = array();



	        /*
	        | ----------------------------------------------------------------------
	        | Add javascript at body
	        | ----------------------------------------------------------------------
	        | javascript code in the variable
	        | $this->script_js = "function() { ... }";
	        |
	        */
	        $this->script_js = "

			$(document).ready(function(){
                var options_number = $('#delegate_id').find('option').length;
                if (options_number == 2){
                    var first_option = $('#delegate_id').find('option')[1];
                    $('#delegate_id').val(first_option.value).change();
                }
            });
		
		$('#amount').change(function(){
				var amount = $(this).val();
				var currencyId = $('#currency_id').val();
				$.get('/voucher/checkBox/'+currencyId+'/'+amount,function(res){
					console.log(res);
					if(res.res)
					{
						alert('للتذكرة رصيد الصندوق لا يكفي، ان الرصيد الحالي هو : '+res.sum);
					}
				});
		})
		
		$('#debit').change(function(){
		    var id = $(this).val();
		    
		$.get('/bills/getDelegateNameById/'+id,function(res){
//		debugger
		console.log(res);
		
		$('#delegate_id').val(res.id);
		
		});
		});
		
		$('#currency_id').change(function(){
			var currency_id = $(this).val();
            if(currency_id != 0){
                $('input:radio[name=opposite][value='+currency_id+']')[0].checked = true;
            }
            var opposite = $(\"input[name='opposite']:checked\").val();
            var amount = $('#amount').val();
            
		    $.get('/currency/getEx_rate/'+opposite,function(res){
        	    $('#ex_rate').val(res.ex_rate);
		    })
            var exRate = $('#ex_rate').val();
            $.get('/voucher/calculateAmountAfterOpposite/'+amount+'/'+currency_id+'/'+opposite+'/'+exRate,function(amount_after_opposite){
                //alert(amount_after_opposite);
                $('#equalizer').val(amount_after_opposite);
            });
		})
		$('#form-group-opposite input[type=radio]').change(function(){
      	    
			var opposite = $(this).val();
			var amount = $('#amount').val();
		  var  currency_id =   $('#currency_id').val();
		  var exRate = $('#ex_rate').val();
		  $.get('/voucher/calculateAmountAfterOpposite/'+amount+'/'+currency_id+'/'+opposite+'/'+exRate,function(amount_after_opposite){
			  //alert(amount_after_opposite);
			  $('#equalizer').val(amount_after_opposite);
		  });
		})
	  
	  
	  $('#amount').change(function(){
			  var amount = $(this).val();
			  var opposite = $(\"input[name='opposite']:checked\").val();
			  var  currency_id =   $('#currency_id').val();
				var exRate = $('#ex_rate').val();
			  $.get('/voucher/calculateAmountAfterOpposite/'+amount+'/'+currency_id+'/'+opposite+'/'+exRate,function(amount_after_opposite){
				  //alert(amount_after_opposite);
				  $('#equalizer').val(amount_after_opposite);
			  });    
	  })
	  
	  $('#ex_rate').change(function(){
		  var exRate = $(this).val();
		   var amount = $('#amount').val();
		   var opposite = $(\"input[name='opposite']:checked\").val();
		   var  currency_id =   $('#currency_id').val();
		  
		   $.get('/voucher/calculateAmountAfterOpposite/'+amount+'/'+currency_id+'/'+opposite+'/'+exRate,function(amount_after_opposite){
			  //alert(amount_after_opposite);
			  $('#equalizer').val(amount_after_opposite);
		  });
	  })
	  
	  
	  /*$('#equalizer').change(function(){
		  var equalizer = $(this).val();
		   var amount = $('#amount').val();
		   var opposite = $(\"input[name='opposite']:checked\").val();
		   var  currency_id =   $('#currency_id').val();
		   
			if(currency_id  == opposite)
			  {
				$('#equalizer').val(amount);
			  }
			  
			  else if(currency_id == 1 && opposite != 1)
					  {
						  $('#ex_rate').val(amount / equalizer);

					  }
					  
					  else if(currency_id != 1 && opposite == 1)
					  {
						  $('#ex_rate').val(equalizer / amount );

					  }
					  
					  else if(currency_id != 1 && opposite != 1)
					  {
						 
						 $('#ex_rate').val(equalizer / amount );


					  } 
	  
	  })*/
		";


		if(CRUDBooster::getCurrentMethod() != 'getEdit'){
			$this->script_js .= " 
			$(document).ready(function(){
				$.post('/bills/getDefaultCurrency',function(res){
						  $('#currency_id').val(res).change();
					})
			})
			";
		}

            /*
	        | ----------------------------------------------------------------------
	        | Include HTML Code before index table
	        | ----------------------------------------------------------------------
	        | html code to display it before index table
	        | $this->pre_index_html = "<p>test</p>";
	        |
	        */
	        $this->pre_index_html = null;



	        /*
	        | ----------------------------------------------------------------------
	        | Include HTML Code after index table
	        | ----------------------------------------------------------------------
	        | html code to display it after index table
	        | $this->post_index_html = "<p>test</p>";
	        |
	        */
	        $this->post_index_html = null;



	        /*
	        | ----------------------------------------------------------------------
	        | Include Javascript File
	        | ----------------------------------------------------------------------
	        | URL of your javascript each array
	        | $this->load_js[] = asset("myfile.js");
	        |
	        */
	        $this->load_js = array();



	        /*
	        | ----------------------------------------------------------------------
	        | Add css style at body
	        | ----------------------------------------------------------------------
	        | css code in the variable
	        | $this->style_css = ".style{....}";
	        |
	        */
			$this->style_css = "
				.selected-action {
					display: none !important;
				}
			";



	        /*
	        | ----------------------------------------------------------------------
	        | Include css File
	        | ----------------------------------------------------------------------
	        | URL of your css each array
	        | $this->load_css[] = asset("myfile.css");
	        |
	        */
	        $this->load_css = array();


	    }


	    /*
	    | ----------------------------------------------------------------------
	    | Hook for button selected
	    | ----------------------------------------------------------------------
	    | @id_selected = the id selected
	    | @button_name = the name of button
	    |
	    */
	    public function actionButtonSelected($id_selected,$button_name) {
	        //Your code here

	    }


	    /*
	    | ----------------------------------------------------------------------
	    | Hook for manipulate query of index result
	    | ----------------------------------------------------------------------
	    | @query = current sql query
	    |
	    */
	    public function hook_query_index(&$query) {

            $me = DB::table('cms_users')->find(CRUDBooster::myId());
            if ($me->id_cms_privileges == 4)
            {
                $query->where('delegate_id',$me->id);


            }
            $query->where("voucher_type_id", 2);
			$query->where("delete_by", 0);
			$query->where("rotate_year", NULL);
	    }

	    /*
	    | ----------------------------------------------------------------------
	    | Hook for manipulate row of index table html
	    | ----------------------------------------------------------------------
	    |
	    */
	    public function hook_row_index($column_index,&$column_value) {
	    	//Your code here
			if($column_index == 7){
				$column_value = number_format($column_value,2);
			}
	    }

	    /*
	    | ----------------------------------------------------------------------
	    | Hook for manipulate data input before add data is execute
	    | ----------------------------------------------------------------------
	    | @arr
	    |
	    */
	    public function hook_before_add(&$postdata)
        {
            $me = DB::table('cms_users')->find(CRUDBooster::myId());


            $max = DB::table('vouchers')->where("voucher_type_id", 2)->where('delete_by',0)->where('rotate_year',NULL)->max('code');
            $prefixCode = DB::table('voucher_types')->where('id', 2)->select('prefix')->first();

            $postdata["code"] = ($max) ? $max + 1 : 1;
            $postdata['p_code'] = $prefixCode->prefix . '' . $postdata['code'];

			//check if p_code unique
			$this->checkVoucherP_Code($postdata['p_code']);

            $postdata['voucher_type_id'] = 2;
            $postdata["staff_id"] = CRUDBooster::myId();

			
			//change ex_rate if is diffrent
            $currency = $this->getExchangeRate($postdata['currency_id']);
            if($postdata['ex_rate'] != $currency->ex_rate){
                $this->changeExchangeRate($currency->id,$postdata['ex_rate']);
            }

            if ($me->id_cms_privileges == 4)
            {
                $postdata['credit'] = $me->account_id;
            }
            else{
                $box_account_id = $this->getAccountByCurrency($postdata['currency_id']);
                if ($box_account_id)
                    $postdata['credit'] = $box_account_id;
            }
		     //dd($postdata);
			 //check credit box 
			 $res= $this->checkBox($postdata['currency_id'], $postdata['amount']);
			 $result=$res->original;
			 if($result['res']){
				 CRUDBooster::redirect(CRUDBooster::mainpath("add/"),' لا يمكن إتمام العملية لعدم توفر رصيد كافي بحساب الدائن، ان الرصيد الحالي هو : '.$result['sum'],"danger");
			 }
			
			 $postdata['create_by']=CRUDBooster::myId();


	    }

	    /*
	    | ----------------------------------------------------------------------
	    | Hook for execute command after add public static function called
	    | ----------------------------------------------------------------------
	    | @id = last insert id
	    |
	    */
	    public function hook_after_add($id) {

            DB::beginTransaction();
            try{
                DB::table('files_vouchers')->where('file_id',null)->delete();

                $voucher = DB::table('vouchers')->find($id);
                $max=DB::table('entry_base')->max('entry_number');
                $entry_number=$max+1;

                $entry_base_id=DB::table("entry_base")->insertGetId([
                    'entry_number'=>$entry_number,
                    'narration'=>$voucher->narration,
                    'date'=>$voucher->date,
                    'voucher_id'=>$id,
                    'active'=>1,
					'create_by'=> CRUDBooster::myId()

                ]);
				//حساب قيمة المعادل التي سيتم حفظها بالقيود المالية
				$entries_equalizer = $this->calculateVoucherEntriesEqualizer($voucher->amount,$voucher->currency_id,$voucher->opposite);  
                if ($voucher->currency_id != $voucher->opposite) {

                    

                    DB::table('entries')->insert([
                        'entry_base_id'=>$entry_base_id,
                        'debit'=>$voucher->equalizer,
                        'account_id'=>$voucher->debit,
                        'credit'=>null,
                        'ex_rate' => $voucher->ex_rate,
                        'equalizer' => $entries_equalizer,
                        'opposite' => $voucher->opposite,
                        'currency_id'=>$voucher->opposite,
                        'create_by'=> CRUDBooster::myId()

                    ]);

                    DB::table('entries')->insert([
                        'entry_base_id'=>$entry_base_id,
                        'credit'=>$voucher->amount,
                        'account_id'=>$voucher->credit,
                        'debit'=>null,
                        'ex_rate' => $voucher->ex_rate,
                        'equalizer' => $entries_equalizer,
                        'opposite' => $voucher->opposite,
                        'currency_id'=>$voucher->currency_id,
                        'create_by'=> CRUDBooster::myId()

                    ]);
                }
                else{
                    DB::table('entries')->insert([
                        'entry_base_id'=>$entry_base_id,
                        'debit'=>$voucher->amount,
                        'account_id'=>$voucher->debit,
                        'credit'=>null,
                        'ex_rate' => $voucher->ex_rate,
                        'equalizer' => $entries_equalizer,
                        'opposite' => $voucher->opposite,
                        'currency_id'=>$voucher->currency_id,
                        'create_by'=> CRUDBooster::myId()

                    ]);

                    DB::table('entries')->insert([
                        'entry_base_id'=>$entry_base_id,
                        'credit'=>$voucher->amount,
                        'account_id'=>$voucher->credit,
                        'debit'=>null,
                        'ex_rate' => $voucher->ex_rate,
                        'equalizer' => $entries_equalizer,
                        'opposite' => $voucher->opposite,
                        'currency_id'=>$voucher->currency_id,
                        'create_by'=> CRUDBooster::myId()

                    ]);
                }



                DB::commit();
            }

            catch (\Exception $e) {
                // Rollback Transaction
                DB::rollback();
            }


        }

	    /*
	    | ----------------------------------------------------------------------
	    | Hook for manipulate data input before update data is execute
	    | ----------------------------------------------------------------------
	    | @postdata = input post data
	    | @id       = current id
	    |
	    */
	    public function hook_before_edit(&$postdata,$id) {
	        

			$me = DB::table('cms_users')->find(CRUDBooster::myId());

            $postdata['voucher_type_id'] = 2;
            $postdata["staff_id"] = CRUDBooster::myId();

			//change ex_rate if is diffrent
			//dd($postdata);
            $currency = $this->getExchangeRate($postdata['currency_id']);
            if($postdata['ex_rate'] != $currency->ex_rate){
                $this->changeExchangeRate($currency->id,$postdata['ex_rate']);
            }


            if ($me->id_cms_privileges == 4)
            {
                $postdata['credit'] = $me->account_id;
            }
            else{
                $box_account_id = $this->getAccountByCurrency($postdata['currency_id']);
                if ($box_account_id)
                    $postdata['credit'] = $box_account_id;
            }
		     //dd($postdata);
			 //check credit box 
			 $res= $this->checkBox($postdata['currency_id'], $postdata['amount'],$id);
			 $result=$res->original;
			 if($result['res']){
				 CRUDBooster::redirect(CRUDBooster::mainpath("edit/".$id),' لا يمكن إتمام العملية لعدم توفر رصيد كافي بحساب الدائن، ان الرصيد الحالي هو : '.$result['sum'],"danger");
			 }

			$postdata['create_by']=CRUDBooster::myId();


            //create new Voucher with another id and save old data to new record with delete_by delete_at
            //change forgin key in others tables voucher_id to new copy of Voucher with delete_by delete_at
            $this->makeVoucherAsDeleted($id);

	    }

	    /*
	    | ----------------------------------------------------------------------
	    | Hook for execute command after edit public static function called
	    | ----------------------------------------------------------------------
	    | @id       = current id
	    |
	    */
	    public function hook_after_edit($id) {
	       
			DB::beginTransaction();
            try{
                DB::table('files_vouchers')->where('file_id',null)->delete();

                $voucher = DB::table('vouchers')->find($id);
                $max=DB::table('entry_base')->where('delete_by',0)->where('rotate_year',NULL)->max('entry_number');
                $entry_number=$max+1;

                $entry_base_id=DB::table("entry_base")->insertGetId([
                    'entry_number'=>$entry_number,
                    'narration'=>$voucher->narration,
                    'date'=>$voucher->date,
                    'voucher_id'=>$id,
                    'active'=>1,
					'create_by'=> CRUDBooster::myId()

                ]);
				//حساب قيمة المعادل التي ستحفظ بالقيود المالية
				$entries_equalizer = $this->calculateVoucherEntriesEqualizer($voucher->amount,$voucher->currency_id,$voucher->opposite);  
                if ($voucher->currency_id != $voucher->opposite) {

                    
					
                    DB::table('entries')->insert([
                        'entry_base_id'=>$entry_base_id,
                        'debit'=>$voucher->equalizer,
                        'account_id'=>$voucher->debit,
                        'credit'=>null,
                        'ex_rate' => $voucher->ex_rate,
                        'equalizer' => $entries_equalizer,
                        'opposite' => $voucher->opposite,
                        'currency_id'=>$voucher->opposite,
                        'create_by'=> CRUDBooster::myId()

                    ]);

                    DB::table('entries')->insert([
                        'entry_base_id'=>$entry_base_id,
                        'credit'=>$voucher->amount,
                        'account_id'=>$voucher->credit,
                        'debit'=>null,
                        'ex_rate' => $voucher->ex_rate,
                        'equalizer' => $entries_equalizer,
                        'opposite' => $voucher->opposite,
                        'currency_id'=>$voucher->currency_id,
                        'create_by'=> CRUDBooster::myId()

                    ]);
                }
                else{
                    DB::table('entries')->insert([
                        'entry_base_id'=>$entry_base_id,
                        'debit'=>$voucher->amount,
                        'account_id'=>$voucher->debit,
                        'credit'=>null,
                        'ex_rate' => $voucher->ex_rate,
                        'equalizer' => $entries_equalizer,
                        'opposite' => $voucher->opposite,
                        'currency_id'=>$voucher->currency_id,
                        'create_by'=> CRUDBooster::myId()

                    ]);

                    DB::table('entries')->insert([
                        'entry_base_id'=>$entry_base_id,
                        'credit'=>$voucher->amount,
                        'account_id'=>$voucher->credit,
                        'debit'=>null,
                        'ex_rate' => $voucher->ex_rate,
                        'equalizer' => $entries_equalizer,
                        'opposite' => $voucher->opposite,
                        'currency_id'=>$voucher->currency_id,
                        'create_by'=> CRUDBooster::myId()

                    ]);
                }



                DB::commit();
            }

            catch (\Exception $e) {
                // Rollback Transaction
                DB::rollback();
            }

	    }

	    /*
	    | ----------------------------------------------------------------------
	    | Hook for execute command before delete public static function called
	    | ----------------------------------------------------------------------
	    | @id       = current id
	    |
	    */
	    public function hook_before_delete($id) {
	        //Your code here
			
			 $this->deleteVoucher($id);

			 return CRUDBooster::redirect($_SERVER['HTTP_REFERER'], "تم حذف السند بنجاح.", "success");

	    }

	    /*
	    | ----------------------------------------------------------------------
    | Hook for execute command after delete public static function called
	    | ----------------------------------------------------------------------
	    | @id       = current id
	    |
	    */
	    public function hook_after_delete($id) {
	        //Your code here

	    }



	    //By the way, you can still create your own method in here... :)

        public function getDelegates()
        {
            $query = '';
            $id = CRUDBooster::myId();

            $me = DB::table('cms_users')->find($id);

            if ($me->id_cms_privileges == 4)
            {
                $query=' and id= '.$me->id;

            }


            return $query;
        }

        public function getCustomers()
        {
            $query = '';
            $id = CRUDBooster::myId();

            $me = DB::table('cms_users')->find($id);

            if ($me->id_cms_privileges == 4)
            {
                $query=' person_type_id= 2  or delegate_id = '.$me->id;

            }

            return $query;
        }

        public function checkBox($currency_id,$amount,$editedID=0)
        {
            $me = DB::table('cms_users')->find(CRUDBooster::myId());
            if ($me->id_cms_privileges == 4)
            {
                $sql = "select (IFNULL(sum(entries.debit), 0)-IFNULL(sum(entries.credit), 0)) as q 
			 from entries , entry_base , accounts , currencies WHERE  
			 accounts.id=entries.account_id and accounts.id = ".$me->account_id."
			 AND entry_base.id=entries.entry_base_id 
			 AND currencies.id=entries.currency_id and entries.account_id= ".$me->account_id."
			 AND entries.currency_id=" . (int)$currency_id . "
			 AND entry_base.delete_by=0 AND entries.delete_by=0 And entries.rotate_year is NULL;
			";
            }
            else{
				$box_account_id = $this->getAccountByCurrency($currency_id);
				if($box_account_id){
					$sql = "select (IFNULL(sum(entries.debit), 0)-IFNULL(sum(entries.credit), 0)) as q 
					from entries , entry_base , accounts , currencies WHERE  
					accounts.id=entries.account_id and accounts.id =$box_account_id 
					AND entry_base.id=entries.entry_base_id 
					AND currencies.id=entries.currency_id and entries.account_id=$box_account_id
					AND entries.currency_id=" . (int)$currency_id . "
					AND entry_base.delete_by=0 AND entries.delete_by=0 And entries.rotate_year is NULL;
				   ";
				}
                
            }



            $value = DB::select($sql);

			$amount_before_edit = 0;
			if($editedID != 0){ //check box when edit voucher
				$amount_before_edit = DB::table('vouchers')->where('id',$editedID)->first()->amount;
			}
			$box_amount = $value[0]->q + $amount_before_edit;
            if ((int)$amount > (int)$box_amount) {

            	$data = Array("res" => true, "sum" => $box_amount);

            }

			//$data = Array("res" => true, "sum" => $value[0]->q);

            return response()->json($data);


        }

        public function getPersons(){

            $accountsIds = [];
            $accountsarr = [];

            $id = CRUDBooster::myId();

            $me = DB::table('cms_users')->find($id);

            if ($me->id_cms_privileges == 4) {
                $accounts = DB::table('persons')->where('delegate_id','=',$me->id)->select('account_id')->get();

                foreach ($accounts as $account)
                {
                    array_push($accountsarr,$account->account_id);

                }
//                dd($accountsarr);

                $persons = DB::table('accounts')->select('id')->whereIn('id',$accountsarr)->get();


            } else {
                $persons = DB::table('accounts')->select('id')->where('major_classification',0)->get();

            }

            foreach ($persons as $person)
            {
                array_push($accountsIds,$person->id);
            }
            return $accountsIds;


        }


		public function calculateVoucherEntriesEqualizer($amount,$currency_id,$opposite){

            //dd($amount);
            $gfunc = new GeneralFunctionsController();
            $majorCurr = $gfunc->getMajorCurrency();
            $entries_equalizer = 0;
            if($currency_id == $majorCurr->id){
                $entries_equalizer = $amount;
            }elseif($currency_id != $majorCurr->id && $opposite == $majorCurr->id){
                $ex_rate = DB::table('currencies')->where('id',$currency_id)->first()->ex_rate;
                $entries_equalizer = $amount * $ex_rate;
            }elseif($currency_id != $majorCurr->id && $opposite != $majorCurr->id){
                if($currency_id == $opposite){
                    $ex_rate = DB::table('currencies')->where('id',$currency_id)->first()->ex_rate;
                    $entries_equalizer = $amount * $ex_rate;
                }
            }
            return $entries_equalizer;
        }

    }
