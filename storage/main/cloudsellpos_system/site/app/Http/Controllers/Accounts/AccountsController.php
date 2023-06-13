<?php 
	namespace App\Http\Controllers;
	namespace App\Http\Controllers\Accounts;
	
	use DB;
	use CRUDBooster;
	use Request;
	use Maatwebsite\Excel\Facades\Excel;
	use App\Models\Accounts\Account;
	use App\Models\Accounts\Person;
	use App\Models\Entries\Entry;

	class AccountsController extends \crocodicstudio_voila\crudbooster\controllers\CBController {

	    public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "name_en";
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
			$this->table = "accounts";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>trans('modules.name'),"name"=>"name_ar"];
			$this->col[] = ["label"=>trans('modules.code'),"name"=>"code"];
			$this->col[] = ["label"=>trans('modules.parent_id'),"name"=>"parent_id","join"=>"accounts,name_ar"];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			$this->form[] = ['label'=>trans('modules.name_en'),'name'=>'name_en','type'=>'text','width'=>'col-sm-10','validation'=>'unique:accounts,name_en'];
			$this->form[] = ['label'=>trans('modules.name_ar'),'name'=>'name_ar','type'=>'text','validation'=>'required|unique:accounts,name_ar','width'=>'col-sm-10'];
			$this->form[] = ['label'=>trans('modules.code'),'name'=>'code','type'=>'number','width'=>'col-sm-10','validation'=>'unique:accounts,code','help'=>trans('help.accounts_code_help')];
			
			if(CRUDBooster::getCurrentMethod()=='getEdit'){
				$acc_id = Request::segment(4);
				$this->form[] = ['label'=>trans('modules.parent_id'),'name'=>'parent_id','type'=>'select2','width'=>'col-sm-10','datatable'=>'accounts,name_ar','datatable_where'=>'major_classification=1 and id <> '.$acc_id];
			}else{
				$this->form[] = ['label'=>trans('modules.parent_id'),'name'=>'parent_id','type'=>'select2','width'=>'col-sm-10','datatable'=>'accounts,name_ar','datatable_where'=>'major_classification=1'];
			}
			
			//$this->form[] = ['label'=>trans('modules.closing_account_type'),'name'=>'closing_account_type','type'=>'select2','width'=>'col-sm-10','datatable'=>'closing_accounts_types,name_ar','datatable_where'=>'active=1'];
			$this->form[] = ['label'=>trans('modules.major_classification'),'name'=>'major_classification','type'=>'radio','validation'=>'required','width'=>'col-sm-10','dataenum'=>'1|'.trans('modules.yes').';0|'.trans('modules.no'),'value'=>'0'];
			
			$this->form[] = ['label'=>trans('modules.visible_to_delegates'),'name'=>'visible_to_delegates','type'=>'radio','validation'=>'required','width'=>'col-sm-10','dataenum'=>'1|'.trans('modules.yes').';0|'.trans('modules.no'),'value'=>'0'];
			
			
			# END FORM DO NOT REMOVE THIS LINE

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
	        $this->script_js = NULL;
			$this->script_js .="
				$('#name_en').change(function(){
					$(this).val($(this).val().trim());
				});
				$('#name_ar').change(function(){
					$(this).val($(this).val().trim());
				});
				$('#code').change(function(){
					let code = $(this).val();
					if(parseFloat(code) <= 0){
						$(this).val(parseFloat(code) * -1);
					}
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
	        $this->style_css = NULL;
			if (CRUDBooster::getCurrentMethod() == "getEdit") {
				$this->style_css .= "
						#form-group-code{
							cursor:not-allowed;
						}
						#form-group-code div {
							pointer-events: none;
						}
					";
			}


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
			//Your code here
			if( $postdata['parent_id'] == null &&  $postdata['code'] == null){
				CRUDBooster::redirect(CRUDBooster::mainpath("add/"),trans('messages.accounts_code_message'),"warning");
			}
			$postdata["code"]=$postdata["parent_id"]!=null ? Account::getCode($postdata["parent_id"]):$postdata["code"];
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
			if( $postdata['parent_id'] == null &&  $postdata['code'] == null){
				CRUDBooster::redirect(CRUDBooster::mainpath("edit/$id"),trans('messages.accounts_edit_code_message'),"warning");
			}
			if($postdata['parent_id']){
					$parent_id_old = Account::find($id)->parent_id;
					if($parent_id_old != $postdata['parent_id']){ //check if parent is changed
						$code = Account::getCode($postdata['parent_id']);
						$postdata['code'] = $code;	
					}
				
			}
	    }

	    /*
	    | ----------------------------------------------------------------------
	    | Hook for execute command after edit public static function called
	    | ----------------------------------------------------------------------
	    | @id       = current id
	    |
	    */
	    public function hook_after_edit($id) {
			//change childs accounts code after change parent code after edit
			$this->changeChildsCodeAfterEdit($id);
			//Your code here
			$account=Account::where("id",$id)->first();
			$person = Person::where('account_id',$id)->first();
			if($person){
				$person->update([
					"name_en"=>$account->name_en,
					"name_ar"=>$account->name_ar
				]);
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
	        
			$hasChildren = false;
			$children = Account::where('parent_id',$id)->get();
			if(count($children) > 0){
				$hasChildren = true;
			}
			if($hasChildren){
				return  CRUDBooster::redirect($_SERVER['HTTP_REFERER'],trans('messages.no_delete_account_has_sons'),"warning");
			}

			$res = Entry::where("account_id",$id)->get();
			if($res->count() > 0){
				return  CRUDBooster::redirect($_SERVER['HTTP_REFERER'],trans('messages.no_delete_account_has_entries'),"warning");
			}else{
				//delete this person and delete his account 
			    Person::where("account_id",$id)->delete();
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

		public function changeChildsCodeAfterEdit($id)
		{
		
			$childs = Account::where('parent_id',$id)->get();
			if(!$childs){ //account doesnot have children
				return false;
			} else {
				$parent_code=Account::find($id)->code;
				$child_code= $parent_code."00";
				foreach($childs as $child){
					$child_code = $child_code+1;
					$child->update([
						'code'=>$child_code
					]);
					$this->changeChildsCodeAfterEdit($child->id);
				}
				return true;
			}
		}

	    //By the way, you can still create your own method in here... :)


		public function getIndex() {
			
		if (!CRUDBooster::isView()) 
			return CRUDBooster::redirect($_SERVER['HTTP_REFERER'], trans('crudbooster.you_dont_have_access_permission'), "warning");

		$itemCategories = Account::where('parent_id', '=',NULL)->orderBy('code','asc')->get();
		$allItemCategories = Account::orderBy('code','asc')->get();
		$table_name="accounts";
		return view('itemCategories.categoryTreeview',compact('itemCategories','table_name','allItemCategories'));		
	}

        //export to excel file xls
		public function export(){
			$data=Account::get()->toArray();
			
			$new_data = array();
			foreach($data as $arr){
               
                $temp = array(
                     "name_en"=>$arr['name_en'],
                     "name_ar"=>$arr['name_ar'],
                     "code"=>$arr['code'],
                );

				array_push($new_data,$temp);
			}

			$data= $new_data;
			Excel::create('Accounts_'.date('Y-m-d H:i:s',time()), function($excel) use ($data) {

				// Set the title
				$excel->setTitle('Export To Excel');
			
				// Chain the setters
				$excel->setCreator('Voila')
					  ->setCompany('Voila');
			
				// Call them separately
				$excel->setDescription('Accounting System');

				$excel->getDefaultStyle()
					->getAlignment()
					->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$excel->sheet('Result', function($sheet) use ($data) {
					$sheet->setOrientation('landscape');
					$sheet->setPageMargin(0.25);
					
					$sheet->fromArray($data);
					// Add before first row
					$sheet->prependRow(1, array(
						"name_en"=>trans('modules.name_en'),
						"name_ar"=>trans('modules.name_ar'),
						"code"=>trans('modules.code'),
					));
					$sheet->row(1, function($row) {
						// call cell manipulation methods
						$row->setBackground('#cccccc');
					
					});
					
					$sheet->appendRow(2, array('','','',));

					$sheet->freezeFirstRow();
					// Set auto size for sheet
					$sheet->setAutoSize(true);

					

				});
			
			})->export('xls');
			
		}

}