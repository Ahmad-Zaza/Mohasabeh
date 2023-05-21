<?php namespace App\Http\Controllers;

	use Session;
	use Request;
	use DB;
	use CRUDBooster;
	use App\ItemCategory;

	class AdminItemsController extends \crocodicstudio_voila\crudbooster\controllers\CBController {

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
			$this->table = "items";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>"الاسم بالعربي","name"=>"name_ar"];

			$this->col[] = ["label"=>"الرمز","name"=>"code"];
			$this->col[] = ["label"=>"تصنيف الأب","name"=>"item_category_id","join"=>"item_categories,name_ar"];
			$this->col[] = ["label"=>"الوحدة","name"=>"item_unit_id","join"=>"item_units,name_ar"];


			$this->col[] = ["label"=>"التكلفة","name"=>"cost"];
			$this->col[] = ["label"=>"السعر","name"=>"price"];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			$this->form[] = ['label'=>'الرمز','name'=>'code','type'=>'number','validation'=>'required|unique:items','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'الاسم بالإنكليزي','name'=>'name_en','type'=>'text','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'الاسم بالعربي','name'=>'name_ar','type'=>'text','validation'=>'required|unique:items','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'تصنيف الأب','name'=>'item_category_id','type'=>'select2','validation'=>'required','width'=>'col-sm-10','datatable'=>'item_categories,name_ar','datatable_where'=>'major_classification=1'];
			$this->form[] = ['label'=>'الوحدة','name'=>'item_unit_id','type'=>'select2','validation'=>'required','width'=>'col-sm-10','datatable'=>'item_units,name_ar'];
			$this->form[] = ['label'=>'التكلفة','name'=>'cost','step'=>'any','type'=>'number','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'السعر','name'=>'price','type'=>'number','step'=>'any','width'=>'col-sm-10'];
			# END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ['label'=>'Code','name'=>'code','type'=>'number','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Name En','name'=>'name_en','type'=>'text','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Name Ar','name'=>'name_ar','type'=>'text','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Item Category Id','name'=>'item_category_id','type'=>'select2','width'=>'col-sm-10','datatable'=>'item_categories,name_ar','datatable_where'=>'major_classification=1'];
			//$this->form[] = ['label'=>'Item Unit Id','name'=>'item_unit_id','type'=>'select2','width'=>'col-sm-10','datatable'=>'item_units,name_ar'];
			//$this->form[] = ['label'=>'Cost','name'=>'cost','type'=>'money','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Price','name'=>'price','type'=>'money','width'=>'col-sm-10'];
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

			$items_count=DB::table("items")->count();
			$cats_count=DB::table("item_categories")->count();
			if($items_count == 0 && $cats_count > 0){
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
	        //Your code here
            $code = ItemCategory::getCode($postdata['item_category_id']);
            $postdata['code']=$code;
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
			
			
			// $item=DB::table("items")->where("id",$id)->first();
			// $code=ItemCategory::getCode($item->item_category_id);
			
			// DB::table("item_categories")->insert([
			// 	"name_en"=>$item->name_en,
			// 	"name_ar"=>$item->name_ar,
			// 	"code"=>$code,
			// 	"major_classification"=>0,
			// 	"active"=>1,
			// 	"parent_id"=>$item->item_category_id,
			// 	"item_id"=>$id


			// ]);

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
			

			$item=DB::table("items")->where("id",$id)->first();
			
			DB::table("item_categories")->where("item_id",$id)->update([
				"name_en"=>$item->name_en,
				"name_ar"=>$item->name_ar
			]);

	    }

	    /*
	    | ----------------------------------------------------------------------
	    | Hook for execute command before delete public static function called
	    | ----------------------------------------------------------------------
	    | @id       = current id
	    |
	    */
	    public function hook_before_delete($id) {
	        
			$res = DB::table("item_tracking")->where("item_id",$id)->get();
			if($res->count() > 0){
				return  CRUDBooster::redirect($_SERVER['HTTP_REFERER'],"هذه المادة مرتبطة مع فواتير . لايمكن حزفها","warning");
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

		public function importDataForm(){
			$example_file= 'المواد.xlsx';
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
				Session::now('import_status', 'success');
				session()->save(); 
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
