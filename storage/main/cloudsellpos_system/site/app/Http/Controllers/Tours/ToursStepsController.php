<?php
namespace App\Http\Controllers;
namespace App\Http\Controllers\Tours;

class ToursStepsController extends \crocodicstudio_voila\crudbooster\controllers\CBController
{

	public function cbInit()
	{
		# START CONFIGURATION DO NOT REMOVE THIS LINE
		$this->table = "tours_steps";
		$this->title_field = "title";
		$this->limit = 20;
		$this->orderby = "sorting,asc";
		$this->show_numbering = FALSE;
		$this->global_privilege = FALSE;
		$this->button_table_action = TRUE;
		$this->button_action_style = "button_icon";
		$this->button_add = TRUE;
		$this->button_delete = TRUE;
		$this->button_edit = TRUE;
		$this->button_detail = TRUE;
		$this->button_show = TRUE;
		$this->button_filter = TRUE;
		$this->button_export = FALSE;
		$this->button_import = FALSE;
		$this->button_bulk_action = TRUE;
		$this->sidebar_mode = "normal"; //normal,mini,collapse,collapse-mini
		# END CONFIGURATION DO NOT REMOVE THIS LINE

		# START COLUMNS DO NOT REMOVE THIS LINE
		$this->col = [];
		$this->col[] = array("label" => trans('modules.tour'), "name" => "tour_id", "join" => "tours,name");
		$this->col[] = array("label" => trans('modules.title'), "name" => "title");
		$this->col[] = array("label" => trans('modules.description'), "name" => "description");
		//$this->col[] = array("label"=>trans('modules.choose_element'),"name"=>"element_id","join"=>"tours_steps_elements,name");
		//$this->col[] = array("label"=>trans('modules.element_key'),"name"=>"element_key" );
		$this->col[] = array("label" => trans('modules.active'), "name" => "active");

		# END COLUMNS DO NOT REMOVE THIS LINE
		# START FORM DO NOT REMOVE THIS LINE
		$this->form = [];
		$this->form[] = ["label" => trans('modules.tour'), "name" => "tour_id", "type" => "select2", "required" => TRUE, "validation" => "required", "datatable" => "tours,name"];
		$this->form[] = ["label" => trans('modules.title'), "name" => "title", "type" => "text", "required" => TRUE, "validation" => "required|string|min:3|max:255", "placeholder" => ""];
		$this->form[] = ["label" => trans('modules.description'), "name" => "description", "type" => "textarea", "required" => TRUE, "validation" => "required|string|min:5|max:5000"];
		$this->form[] = ["label" => trans('modules.choose_element'), "name" => "element_id", "type" => "select2", "datatable" => "tours_steps_elements,name"];
		$this->form[] = ["label" => trans('modules.element_key'), "name" => "element_key", "type" => "text", "validation" => ""];

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
		$this->alert = array();



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
		 | FESAL VOILA DONT REMOVE THIS LINE
		 | ----------------------------------------------------------------------
		 | IF NOT SUCCESS ADD  $this->col[] = ["label"=>"Active","name"=>"active"]; IN COLUMNS
		 |
		 */

		//$this->table_row_color[] = ["condition"=>"[active]==1","color"=>"success"];
		$this->table_row_color[] = ["condition" => "[active]==0", "color" => "danger"];


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
	public function actionButtonSelected($id_selected, $button_name)
	{
	//Your code here

	}


	/*
	 | ----------------------------------------------------------------------
	 | Hook for manipulate query of index result
	 | ----------------------------------------------------------------------
	 | @query = current sql query
	 |
	 */
	public function hook_query_index(&$query)
	{
	//Your code here

	}

	/*
	 | ----------------------------------------------------------------------
	 | Hook for manipulate row of index table html
	 | ----------------------------------------------------------------------
	 |
	 */
	public function hook_row_index($column_index, &$column_value)
	{
	//Your code here
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
	//Your code here

	}

	/*
	 | ----------------------------------------------------------------------
	 | Hook for execute command after add public static function called
	 | ----------------------------------------------------------------------
	 | @id = last insert id
	 |
	 */
	public function hook_after_add($id)
	{
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
	public function hook_before_edit(&$postdata, $id)
	{
	//Your code here

	}

	/*
	 | ----------------------------------------------------------------------
	 | Hook for execute command after edit public static function called
	 | ----------------------------------------------------------------------
	 | @id       = current id
	 |
	 */
	public function hook_after_edit($id)
	{
	//Your code here

	}

	/*
	 | ----------------------------------------------------------------------
	 | Hook for execute command before delete public static function called
	 | ----------------------------------------------------------------------
	 | @id       = current id
	 |
	 */
	public function hook_before_delete($id)
	{
	//Your code here

	}

	/*
	 | ----------------------------------------------------------------------
	 | Hook for execute command after delete public static function called
	 | ----------------------------------------------------------------------
	 | @id       = current id
	 |
	 */
	public function hook_after_delete($id)
	{
	//Your code here

	}



//By the way, you can still create your own method in here... :)


}