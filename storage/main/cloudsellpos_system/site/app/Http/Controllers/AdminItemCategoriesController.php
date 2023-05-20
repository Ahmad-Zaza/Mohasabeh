<?php namespace App\Http\Controllers;

	use Session;
	use Request;
	use DB;
	use CRUDBooster;
	use App\ItemCategory;
	
	class AdminItemCategoriesController extends \crocodicstudio_voila\crudbooster\controllers\CBController {

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
			$this->table = "item_categories";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>"الاسم بالعربي","name"=>"name_ar"];
			$this->col[] = ["label"=>"الرمز","name"=>"code"];
			$this->col[] = ["label"=>"تصنيف الأب","name"=>"parent_id","join"=>"item_categories,name_en"];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			$this->form[] = ['label'=>'الاسم بالإنكليزي','name'=>'name_en','type'=>'text','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'الاسم بالعربي','name'=>'name_ar','type'=>'text','validation'=>'required','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'الرمز','name'=>'code','type'=>'number','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'تصنيف الاب','name'=>'parent_id','type'=>'select2','width'=>'col-sm-10','datatable'=>'item_categories,name_ar'];
			$this->form[] = ['label'=>'تصنيف رئيسي','name'=>'major_classification','type'=>'radio','validation'=>'required','width'=>'col-sm-10','dataenum'=>'1|نعم;0|لا'];
			# END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ['label'=>'Name En','name'=>'name_en','type'=>'text','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Name Ar','name'=>'name_ar','type'=>'text','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Code','name'=>'code','type'=>'number','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Parent Id','name'=>'parent_id','type'=>'select2','width'=>'col-sm-10','datatable'=>'item_categories,name_ar'];
			//$this->form[] = ['label'=>'Major Classification','name'=>'major_classification','type'=>'radio','width'=>'col-sm-10','dataenum'=>'1|yes;0|no'];
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
			$this->script_js = NULL;
			


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
			//dd($postdata);

	        if($postdata['major_classification'] == 1 && $postdata['parent_id'] == null &&  $postdata['code'] == null){
				CRUDBooster::redirect(CRUDBooster::mainpath("add/"),"عند إضافة تصنيف رأيسي ليس له تصنيف أب يجب إدخال الرمز","warning");
			}

			if($postdata['parent_id'] != null){
				$parent_id = $postdata['parent_id'] ;
				$postdata["code"]= ItemCategory::getCode($postdata["parent_id"]);
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
			$item_category=DB::table("item_categories")->where("id",$id)->first();

			if($postdata['major_classification'] == 1 && $postdata['parent_id'] == null &&  $postdata['code'] == null){
				CRUDBooster::redirect(CRUDBooster::mainpath("edit/$id"),"عند إضافة تصنيف رأيسي ليس له تصنيف أب يجب إدخال الرمز","warning");
			}

			if($postdata['parent_id'] != null && $postdata['parent_id'] != $item_category->parent_id){
				$parent_id = $postdata['parent_id'] ;
				$postdata["code"]= ItemCategory::getCode($postdata["parent_id"]);
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
			$hasRecords = false;
			$records = DB::table('items')->where('item_category_id',$id)->get();
			if(count($records) > 0){
				$hasRecords = true;
			}
			if($hasRecords){
				return  CRUDBooster::redirect($_SERVER['HTTP_REFERER'],"لايمكن حذف التصنيف لأن هناك مواد متعلقة به ","warning");
			}

			$hasChildren = false;
			$children = DB::table('item_categories')->where('parent_id',$id)->get();
			if(count($children) > 0){
				$hasChildren = true;
			}
			if($hasChildren){
				return  CRUDBooster::redirect($_SERVER['HTTP_REFERER'],"لايمكن حذف التصنيف لأن له تصنيفات ضمنه ","warning");
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



		public function getIndex() {
			
		$itemCategories = ItemCategory::where('parent_id', '=', NULL)->orderBy('sorting','asc')->get();
			
		$allItemCategories = ItemCategory::orderBy('sorting','asc')->get();
				
		$table_name="item_categories";
		
	// dd($allItemCategories);
	return view('itemCategories.categoryTreeview',compact('itemCategories','table_name','allItemCategories'));
				
	}

	


	 //By the way, you can still create your own method in here... :)


	 public function importDataForm(){
		$example_file= 'تصنيف المواد.xlsx';
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
			//dd($result);
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