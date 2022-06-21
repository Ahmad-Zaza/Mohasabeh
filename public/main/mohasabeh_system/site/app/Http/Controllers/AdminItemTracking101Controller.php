<?php namespace App\Http\Controllers;

	use Session;
	use Request;
	use DB;
	use CRUDBooster;
	use App\Traits\GeneralTrait;

	class AdminItemTracking101Controller extends \crocodicstudio_voila\crudbooster\controllers\CBController {
		use GeneralTrait;
	    public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "id";
			$this->limit = "20";
			$this->orderby = "sorting,asc";
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
			$this->table = "item_tracking";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>"الرمز","name"=>"p_code"];
			$this->col[] = ["label"=>"المادة","name"=>"item_id","join"=>"items,name_ar"];
			$this->col[] = ["label"=>"من مستودع","name"=>"source","join"=>"inventories,name_ar"];
			$this->col[] = ["label"=>"إلى مستودع","name"=>"destination","join"=>"inventories,name_ar"];
			$this->col[] = ["label"=>"التاريخ","name"=>"date"];
			$this->col[] = ["label"=>"العدد","name"=>"quantity"];
			# END COLUMNS DO NOT REMOVE THIS LINE
			
			# START FORM DO NOT REMOVE THIS LINE
			$gfunc= new GeneralFunctionsController();

			$this->form = [];
			$this->form[] = ['label'=>'المادة','name'=>'item_id','type'=>'select2','width'=>'col-sm-10','validation'=>'required','datatable'=>'items,name_ar','datatable_where'=>'id in ('.implode($gfunc->getItemsIds(),',').')'];
			$this->form[] = ['label'=>'من مستودع','name'=>'source','type'=>'select2','width'=>'col-sm-10','validation'=>'required','datatable'=>'inventories,name_ar','datatable_where'=>'major_classification=0'.$this->getInventories()];
			$this->form[] = ['label'=>'إلى مستودع','name'=>'destination','type'=>'select2','width'=>'col-sm-10','validation'=>'required','datatable'=>'inventories,name_ar','datatable_where'=>'major_classification=0'.$this->getInventories()];
			$this->form[] = ['label'=>'التاريخ','name'=>'date','type'=>'date','width'=>'col-sm-10','validation'=>'required|date'];
			$this->form[] = ['label'=>'العدد','name'=>'quantity','type'=>'number','width'=>'col-sm-10','validation'=>'required'];
			# END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ['label'=>'Item','name'=>'item_id','type'=>'select2','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'From','name'=>'source','type'=>'select2','width'=>'col-sm-10','datatable'=>'items,name_ar'];
			//$this->form[] = ['label'=>'To','name'=>'destination','type'=>'select2','width'=>'col-sm-10','datatable'=>'inventories,name_ar'];
			//$this->form[] = ['label'=>'Date','name'=>'date','type'=>'date','width'=>'col-sm-10','datatable'=>'inventories,name_ar'];
			//$this->form[] = ['label'=>'Quantity','name'=>'quantity','type'=>'number','width'=>'col-sm-10'];
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
									var options_number = $('#source').find('option').length;
									if (options_number == 2){
										var first_option = $('#source').find('option')[1];
										$('#source').val(first_option.value).change();
									} 
								});

								
								$(document).ready(function(){
									let value = $('#item_id').val();
									document.getElementById('item_id').options.length = 0;
									$.get('/inventories/getItems',function(res){
									res.forEach(element => {
										$('#item_id').append(new Option(element.name_ar+' - '+element.code, element.id));
										});
										$('#item_id').val(value).select2();
									})
								})
								
								

								";


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
			//$this->load_js[] = asset("vendor/crudbooster/assets/select2/dist/js/select2.full.min.js");					


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
			//$this->load_css[] = asset("vendor/crudbooster/assets/select2/dist/css/select2.min.css");

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

			$id = CRUDBooster::myId();
			$me = DB::table('cms_users')->find($id);
			if ($me->id_cms_privileges == 4) {
				$delegate_inventories_id= DB::table('inventories')->where('delegate_id',$id)->pluck('id')->toArray();

				$query->whereIn('destination',$delegate_inventories_id)->orwhereIn('source',$delegate_inventories_id);
				//dd($delegate_inventories_id);
			}

			$query->where("delete_by",0);
			$query->where("rotate_year",NULL);

            $query->where("inventory_id_type_id",6)->where('destination','!=',null)->orderby('p_code','disc');
	        //Your code here

	    }

	    /*
	    | ----------------------------------------------------------------------
	    | Hook for manipulate row of index table html
	    | ----------------------------------------------------------------------
	    |
	    */
	    public function hook_row_index($column_index,&$column_value) {
	    	//Your code here
	    }

	    /*
	    | ----------------------------------------------------------------------
	    | Hook for manipulate data input before add data is execute
	    | ----------------------------------------------------------------------
	    | @arr
	    |
	    */
	    public function hook_before_add(&$postdata) {

			if($postdata['source'] == $postdata['destination']){
				CRUDBooster::redirect(CRUDBooster::mainpath("add/"),"المستودع المصدر هو نفسه مستودع الهدف!. لا يمكن نقل مادة إلى المستودع نفس. رجاءاً اختر مستودع أخر لنقل المادة إليه .","warning");
			}

			//check if source has quantity
			$gfunc= new GeneralFunctionsController();
			$hasEnough= $gfunc->getInventoryQauntityItem($postdata['source'],$postdata['item_id'],$postdata['quantity']);
			if(!$hasEnough){
				CRUDBooster::redirect(CRUDBooster::mainpath("add/"),"المستودع المصدر لا يملك الكمية المراد نقلها","warning");
			}

			

            $max = DB::table('item_tracking')->where("inventory_id_type_id", 6)->where('delete_by',0)->where('rotate_year',NULL)->max('code');
            $prefixCode = DB::table('inventory_type_id')->where('id',6)->select('prefix')->first();

            $maxCode = ($max) ? $max + 1 : 1;
            $prefix = $prefixCode->prefix .''. $maxCode;
//            dd($prefix);
            //Your code here
            DB::table('item_tracking')->insert(
                ['code' => $maxCode, 'item_id' => $postdata['item_id'],'source'=>$postdata['source'],'destination'=>$postdata['destination']
                ,'date'=>$postdata['date'],'quantity'=>$postdata['quantity'],'inventory_id_type_id'=>6,'transaction_operation'=> 'out','p_code' =>$prefix,'create_by'=>CRUDBooster::myId()
                ]
            );

            DB::table('item_tracking')->insert(
                ['code' => $maxCode, 'item_id' => $postdata['item_id'],'source'=>$postdata['destination']
                    ,'date'=>$postdata['date'],'quantity'=>$postdata['quantity'],'inventory_id_type_id'=>6,'transaction_operation'=> 'in','p_code' =>$prefix,'create_by'=>CRUDBooster::myId()
                ]
            );


			return  CRUDBooster::redirect(CRUDBooster::mainpath(),"تمت عملية النقل بنجاح","success");

        }

	    /*
	    | ----------------------------------------------------------------------
	    | Hook for execute command after add public static function called
	    | ----------------------------------------------------------------------
	    | @id = last insert id
	    |
	    */
	    public function hook_after_add($id) {
	        //Your code here

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
	       
			if($postdata['source'] == $postdata['destination']){
				CRUDBooster::redirect(CRUDBooster::mainpath("add/"),"المستودع المصدر هو نفسه مستودع الهدف!. لا يمكن نقل مادة إلى المستودع نفس. رجاءاً اختر مستودع أخر لنقل المادة إليه .","warning");
			}
			
			//dd($postdata);
			//check if inventory has enough quantity
			$gfunc= new GeneralFunctionsController();
			$hasEnough= $gfunc->getInventoryQauntityItem($postdata['source'],$postdata['item_id'],$postdata['quantity']);
			if(!$hasEnough){
				CRUDBooster::redirect(CRUDBooster::mainpath("edit/$id"),"المستودع المصدر لا يملك الكمية المراد نقلها","warning");
			}

			//make order as delete in GeneralTrail
			$this->makeTransferOrderAsDeleted($id);
			
			$p_code = DB::table('item_tracking')->where('id',$id)->first()->p_code;
			
			DB::table('item_tracking')->where('p_code',$p_code)->where('destination',NULL)
									  ->where('delete_by',0)->update([
												'item_id' => $postdata['item_id'],
												'source'=>$postdata['destination'],
												'date'=>$postdata['date'],
												'quantity'=>$postdata['quantity']
												] );

	    }

	    /*
	    | ----------------------------------------------------------------------
	    | Hook for execute command after edit public static function called
	    | ----------------------------------------------------------------------
	    | @id       = current id
	    |
	    */
	    public function hook_after_edit($id) {
            $postdata['inventory_id_type_id']=6;
            
	    }

	    /*
	    | ----------------------------------------------------------------------
	    | Hook for execute command before delete public static function called
	    | ----------------------------------------------------------------------
	    | @id       = current id
	    |
	    */
	    public function hook_before_delete($id) {
	       
			$p_code = DB::table('item_tracking')->where('id',$id)->first()->p_code;
			
			DB::table('item_tracking')->where('p_code',$p_code)->update(
                [
				'delete_by'=>CRUDBooster::myId(),
				'delete_at'=>date('Y-m-d H:i:s'),
				'delete_action'=>'delete',
                ]
            );
			return  CRUDBooster::redirect(CRUDBooster::mainpath(),"تمت عملية الحذف بنجاح","success");

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

		public function getInventories()
		{
			$query = '';
			$id = CRUDBooster::myId();
	
			$me = DB::table('cms_users')->find($id);
	
			if ($me->id_cms_privileges == 4) {
				$query = ' and delegate_id= ' . $me->id;
			}
	
	
			return $query;
		}



	}