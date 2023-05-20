<?php namespace App\Http\Controllers;

use App\Account;
use Session;
	use Request;
	use DB;
	use CRUDBooster;
	use App\Traits\GeneralTrait;
	class AdminPersonsController extends \crocodicstudio_voila\crudbooster\controllers\CBController {
		use GeneralTrait;
	    public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "first_name_en";
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
			$this->table = "persons";
			# END CONFIGURATION DO NOT REMOVE THIS LINE
			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>"الرمز","name"=>"code"];
			$this->col[] = ["label"=>"الاسم بالعربي","name"=>"name_ar"];
			$this->col[] = ["label"=>"البريد الإلكتروني","name"=>"email"];
			$this->col[] = ["label"=>"رقم الهاتف المحمول","name"=>"phone_number"];
			$this->col[] = ["label"=>"الحساب","name"=>"account_id","join"=>"accounts,name_ar"];
			$this->col[] = ["label"=>"المندوب","name"=>"delegate_id","join"=>"cms_users,name"];
			# END COLUMNS DO NOT REMOVE THIS LINE
			$id = CRUDBooster::myId();
			$me = DB::table('cms_users')->find($id);
		
			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			$this->form[] = ['label'=>'الاسم بالإنكليزي','name'=>'name_en','type'=>'text','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'الاسم بالعربي','name'=>'name_ar','type'=>'text','validation'=>'required','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'البريد الإلكتروني','name'=>'email','type'=>'email','width'=>'col-sm-10','placeholder'=>'رجاءاً أدخل بريد إلكتروني صحيح'];
			$this->form[] = ['label'=>'رقم الهاتف المحمول','name'=>'phone_number','type'=>'number','validation'=>'required','width'=>'col-sm-10','placeholder'=>'يمكنك فقط إدخال أرقام'];
			if ($me->id_cms_privileges != 4) {
				$this->form[] = ['label'=>'الحساب الأب','name'=>'account_id','type'=>'select2','validation'=>'required','width'=>'col-sm-10','datatable'=>'accounts,name_ar','datatable_where'=>'major_classification=1 and parent_id = '.$this->getSystemConfigValue('Customers_Account')];
			}
			
			//$this->form[] = ['label'=>'النوع','name'=>'person_type_id','type'=>'select2','validation'=>'required','width'=>'col-sm-10','datatable'=>'person_type,name_ar'];
			$this->form[] = ['label'=>'المندوب','name'=>'delegate_id','type'=>'select2','width'=>'col-sm-10','datatable'=>'cms_users,name','datatable_where'=>'id_cms_privileges=4'. $this->getDelegates()];
			# END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ['label'=>'Name En','name'=>'name_en','type'=>'text','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Name Ar','name'=>'name_ar','type'=>'text','validation'=>'required','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Email','name'=>'email','type'=>'email','width'=>'col-sm-10','placeholder'=>'Please enter a valid email address'];
			//$this->form[] = ['label'=>'Phone Number','name'=>'phone_number','type'=>'number','validation'=>'required','width'=>'col-sm-10','placeholder'=>'You can only enter the number only'];
			//$this->form[] = ['label'=>'Account Id','name'=>'account_id','type'=>'select2','validation'=>'required','width'=>'col-sm-10','datatable'=>'accounts,name_ar'];
			//$this->form[] = ['label'=>'Person Type','name'=>'person_type_id','type'=>'select2','validation'=>'required','width'=>'col-sm-10','datatable'=>'person_type,name_ar'];
			//$this->form[] = ['label'=>'Delegate','name'=>'delegate_id','type'=>'select2','width'=>'col-sm-9','datatable'=>'delegates,name_ar'];
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

			$count=DB::table("persons")->where('person_type_id',1)->count();
			if($count == 0 ){
				$this->index_button[] = ['label'=>'استيراد البيانات','url'=>CRUDBooster::mainpath("import-data-form"),"icon"=>"fa fa-download"];
			}

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

							
							$.get('/persons/getParentAccount/".Request::segment(4)."',function(parent_id){
									$('#account_id').val(parent_id).select2();
								})
							

						});
			
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
	        //Your code here

			$id = CRUDBooster::myId();
			$me = DB::table('cms_users')->find($id);
			if ($me->id_cms_privileges == 4) {
				$query->where('delegate_id',$id);
			}
			

			$query->where('person_type_id',1);
			$query->orderBy('id', 'DESC');
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
	        
            DB::beginTransaction();
            try {
				//عند الدخول كحساب مندوب نقوم بإضافة الزبائن ضمن حساب زبائنه ديناميكيا
				if($postdata['account_id'] == null){
					$id = CRUDBooster::myId();
					$customers_account_id = DB::table('cms_users')->where('id',$id)->first()->customers_account_id;
					$postdata['account_id'] = $customers_account_id;
				}
				
                $code = Account::getCode($postdata['account_id']);

                $accountId = DB::table('accounts')->insertGetId([
                    'name_en' => $postdata['name_en'],
                    'name_ar' => $postdata['name_ar'],
                    'code' => $code,
                    'parent_id' => $postdata['account_id'],
                    'major_classification' => 0,
                    "active" => 1

                ]);

				$postdata['person_type_id'] = 1;
                $postdata['account_id'] = $accountId;
                $postdata['code'] = $code;
                DB::commit();

            }catch (Exception $e)

            {
                DB::rollback();
            }
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
	        //Your code here
			$customer_account_id = DB::table('persons')->where('id',$id)->first()->account_id;
			//dd($supplier_account_id);
			
			$parent_id = $postdata['account_id'];
			//change parent_id and code for supplier account
			$code = Account::getCode($parent_id); 
			DB::table('accounts')->where('id',$customer_account_id)->update([
				"parent_id"=>$parent_id,
				"code"=>$code
			]);
			
			$postdata['account_id'] = $customer_account_id;

	    }

	    /*
	    | ----------------------------------------------------------------------
	    | Hook for execute command after edit public static function called
	    | ----------------------------------------------------------------------
	    | @id       = current id
	    |
	    */
	    public function hook_after_edit($id) {
			//Your code here
			



	    }

	    /*
	    | ----------------------------------------------------------------------
	    | Hook for execute command before delete public static function called
	    | ----------------------------------------------------------------------
	    | @id       = current id
	    |
	    */
	    public function hook_before_delete($id) {
	       
			$person = DB::table("persons")->where("id",$id)->first();
			$account_id = $person->account_id;
			$res = DB::table("entries")->where("account_id",$account_id)->get();
			if($res->count() > 0){
				return  CRUDBooster::redirect($_SERVER['HTTP_REFERER']," هذا زبون  مرتبط بقيود . لايمكن حذفه","warning");
			}else{
				//delete this person and delete his account 
				//dd($account_id);
			    DB::table("accounts")->where("id",$account_id)->delete();

			}
			
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
	
			if ($me->id_cms_privileges == 4) {
				$query = ' and id= ' . $me->id;
			}
	
	
			return $query;
		}

		//importing data methods

		public function importDataForm(){
			$example_file= 'الزبائن.xlsx';
			$example_file= 'examples/'.$example_file;
			return view('data.import',compact('example_file'));
		}
	
		public function getDataFromExcel(Request $request)
		{
			//dd($request);
			
			$this->cbLoader();
			
			if (Request::hasFile('userfile')) {
				$importCtrl= new ImportController();
				$url_filename =  $importCtrl -> uploadExcelDatafile($request);
				$result = $importCtrl->importDataforModule($url_filename);
				//dd($result);
				Session::now('import_status', 'success');
				session()->save();
				if($result['import_status'] == 'success'){
					//return  CRUDBooster::redirect(config('crudbooster.ADMIN_PATH').'/persons',"تمت استيراد البيانات بنجاح","success");
					return redirect()->back()->with([
						'import_status'=>'success',
						'reports'=>$result['reports'],
					]);
				}else{
					return redirect()->back()->with([
						'import_status'=>'failed',
						'reports'=>$result['reports'],
					]);
				}
			} else {
				return redirect()->back()->with([
					'import_status'=>'failed',
					'reports'=>array("لم يتم رفع الملف بنجاح حاول مرة أخرى"),
				]);
			}
		
		}

}