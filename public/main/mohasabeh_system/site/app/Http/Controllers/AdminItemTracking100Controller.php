<?php namespace App\Http\Controllers;

	use Session;
	use Request;
	use DB;
	use CRUDBooster;
	use App\Traits\GeneralTrait;
	class AdminItemTracking100Controller extends \crocodicstudio_voila\crudbooster\controllers\CBController {
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
			$this->col[] = ["label"=>"الرمز","name"=>"code"];
			$this->col[] = ["label"=>"المادة","name"=>"item_id","join"=>"items,name_ar"];
			$this->col[] = ["label"=>"المستودع","name"=>"source","join"=>"inventories,name_ar"];
			$this->col[] = ["label"=>"التاريخ","name"=>"date"];
			$this->col[] = ["label"=>"العدد","name"=>"quantity"];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			$this->form[] = ['label'=>'الرمز','name'=>'code','type'=>'number','validation'=>'','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'المادة','name'=>'item_id','type'=>'select2','validation'=>'required','width'=>'col-sm-10','datatable'=>'items,name_ar'];
			$this->form[] = ['label'=>'المستودع','name'=>'source','type'=>'select2','validation'=>'required','width'=>'col-sm-10','datatable'=>'inventories,name_ar','datatable_where'=>'major_classification=0'];
			$this->form[] = ['label'=>'العدد','name'=>'quantity','type'=>'number','validation'=>'required','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'ملاحظات','name'=>'note','type'=>'textarea','width'=>'col-sm-10'];
            # END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ['label'=>'Code','name'=>'code','type'=>'number','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Item','name'=>'item_id','type'=>'select2','width'=>'col-sm-10','datatable'=>'items,name_ar'];
			//$this->form[] = ['label'=>'Inventory','name'=>'source','type'=>'select2','width'=>'col-sm-10','datatable'=>'inventories,name_ar'];
			//$this->form[] = ['label'=>'Quantity','name'=>'quantity','type'=>'number','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Note','name'=>'note','type'=>'textarea','width'=>'col-sm-10'];
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

			$count=DB::table("item_tracking")->count();
			$items_count=DB::table("items")->count();
			if($count == 0 && $items_count > 0){
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
            $this->script_js = "$(document).ready(function(){
						let value = $('#item_id').val();
						//document.getElementById('item_id').options.length = 0;
						$.get('/bills/getItems',function(res){
						res.forEach(element => {
						$('#item_id').append(new Option(element.name_ar+' - '+element.code, element.id));

						});
						$('#item_id').val(value).select2();
						})
				})";


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
			$query->where("inventory_id_type_id",5);
			$query->where("delete_by",0);
			$query->where("rotate_year",NULL);
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
			
			$postdata["inventory_id_type_id"]=5;
			$postdata["transaction_operation"]="in";

			$postdata["date"]=date('Y-m-d');

			$code = $postdata["code"];
			$prefixCode = DB::table('inventory_type_id')->where('id', 5)->select('prefix')->first();
            $prefix = $prefixCode->prefix . '' . $code;
			$postdata["p_code"]=$prefix;

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
			
			//make copy of record and make it as delete 
			$this->makeInventoryBeginningAsDeleted($id);
			
			$postdata["inventory_id_type_id"]=5;
			$postdata["transaction_operation"]="in";
			$postdata["date"]=date('Y-m-d');

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
	        //dd($id);
			$this->deleteInventoryBeginning($id);

			return CRUDBooster::redirect($_SERVER['HTTP_REFERER'], "تم الحذف بنجاح.", "success");

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

		public function importDataForm(){
			$example_file= 'بضاعة أول المدة.xlsx';
			$example_file= 'examples/'.$example_file;
			//dd($example_file);
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
				if($result['import_status'] == 'success'){
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