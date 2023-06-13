<?php namespace App\Http\Controllers\Data;

	use App\Http\Controllers\General\GeneralFunctionsController;
	use App\Models\Data\Backup;
	use App\Traits\GeneralTrait;
	use Illuminate\Support\Facades\Storage;
	use Illuminate\Support\Facades\File; 
	use Session;
	use Request;
	use DB;
	use CRUDBooster;
	use Schema;
	class BackupsManagementController extends \crocodicstudio_voila\crudbooster\controllers\CBController {
		use GeneralTrait;
	    public function cbInit() {

			#check if table not exist build backups table
			if(!Schema::hasTable('backups')){
				DB::statement("
					CREATE TABLE IF NOT EXISTS `backups` (
						`id` int(11) NOT NULL AUTO_INCREMENT,
						`name` varchar(255) NOT NULL,
						`file_name` varchar(255) NOT NULL,
						`attachs_folder` varchar(255) NOT NULL,
						`date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
						`note` text NOT NULL,
						`status` int(11) NOT NULL DEFAULT '1',
						`active` int(11) NOT NULL DEFAULT '1',
						`sorting` int(11) DEFAULT NULL,
						PRIMARY KEY (`id`)
					) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;
				");
			}
	    	# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->table 			   = "backups";
			$this->title_field         = "name";
			$this->limit               = 20;
			$this->orderby             = "date,desc";
			$this->show_numbering      = FALSE;
			$this->global_privilege    = FALSE;
			$this->button_table_action = TRUE;
			$this->button_action_style = "button_icon";
			$this->button_add          = false;
			$this->button_delete       = true;
			$this->button_edit         = true;
			$this->button_detail       = false;
			$this->button_show         = TRUE;
			$this->button_filter       = TRUE;
			$this->button_export       = FALSE;
			$this->button_import       = FALSE;
			$this->button_bulk_action  = TRUE;
			$this->sidebar_mode		   = "normal"; //normal,mini,collapse,collapse-mini
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
	        $this->col = [];
			$this->col[] = array("label"=>trans('modules.name'),"name"=>"name" );
			$this->col[] = array("label"=>trans('modules.file_name'),"name"=>"file_name" );
			$this->col[] = array("label"=>trans('modules.attachs_folder'),"name"=>"attachs_folder" );
			$this->col[] = array("label"=>trans('modules.date'),"name"=>"date" );
			$this->col[] = array("label"=>trans('modules.notes'),"name"=>"note" );
			$this->col[] = array("label"=>trans('modules.status'),"name"=>"status" );
			# END COLUMNS DO NOT REMOVE THIS LINE
			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			$this->form[] = ["label"=>trans('modules.name'),"name"=>"name","type"=>"text","required"=>TRUE,"validation"=>"required|string|min:2|max:70","placeholder"=>trans('labels.please_insert_only_latters')];
			//$this->form[] = ["label"=>trans('modules.file_name'),"name"=>"file_name","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>trans('modules.date'),"name"=>"date","type"=>"datetime","required"=>TRUE,"validation"=>"required|date_format:Y-m-d H:i:s"];
			$this->form[] = ["label"=>trans('modules.notes'),"name"=>"note","type"=>"textarea","required"=>TRUE,"validation"=>"required|string"];
			
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
			$this->addaction[] = ['label' => '', 'url' => CRUDBooster::mainpath('restore/[id]'), 'icon' => 'fa  fa-retweet', 'color' => 'success','title'=> trans('labels.restore_backup'), 'showIf' => "1",'confirmation'=>true,'confirmation_title'=> trans('labels.are_you_confirm'),'confirmation_text'=>trans('labels.restore_backup_message')];
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
			if(CRUDBooster::getCurrentMethod()=='getIndex'){
				$this->index_button[] = ['label' => trans('modules.create_backup'), 'url' => CRUDBooster::mainpath("create"), "icon" => "fa fa-database"];
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
	        | FESAL VOILA DONT REMOVE THIS LINE
	        | ----------------------------------------------------------------------
            | IF NOT SUCCESS ADD  $this->col[] = ["label"=>"Active","name"=>"active"]; IN COLUMNS
            |
            */

			$this->table_row_color[] = ["condition"=>"[active]==1","color"=>"success"];
			$this->table_row_color[] = ["condition"=>"[active]==0","color"=>"danger"];


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

			$gfunc = new GeneralFunctionsController();
			$totat_backups_size = $this->getPackageConfigValue('backups_size');
			
			$backups_db_path = storage_path('app/backups');
			$backups_attacts_path = storage_path('app/backups_attachs');
			$current_backups_size = $gfunc->getFolderSize($backups_db_path) + $gfunc->getFolderSize($backups_attacts_path);
			$persent = 0;
			if($totat_backups_size == '-1'){
				$totat_backups_size = trans('labels.unlimited');
				$persent = 0;
			} else {
				$persent = ($current_backups_size * 100)/$totat_backups_size;
			}

			$status_class = "bg-green";
			if(($totat_backups_size > 0) && $current_backups_size >= $totat_backups_size ){
				$status_class = "bg-red";
			}
			$this->post_index_html = "
			<div class='row'> 
				<div class='col-sm-4'></div>
				<div class='col-sm-4 '>
					<div class='info-box ".$status_class."'>
						<span class='info-box-icon'><i class='fa fa-database'></i></span>
						<div class='info-box-content'>
							<span class='info-box-text'>".trans('labels.current_backups_size')."</span>
							<span class='info-box-number'>".$current_backups_size." M</span>
								<div class='progress'>
								<div class='progress-bar' style='width: ".$persent."%'></div>
								</div>
							<span class='progress-description'>
									".trans('labels.total_backups_size_is',['totat_backups_size'=>$totat_backups_size])."
							</span>
						</div>
					</div>
				</div>
			</div>
		";



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
			$this->style_css .= "
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

	    }

	    /*
	    | ----------------------------------------------------------------------
	    | Hook for manipulate row of index table html
	    | ----------------------------------------------------------------------
	    |
	    */
	    public function hook_row_index($column_index,&$column_value) {
	    	if($column_index == 6){
				if ($column_value == 2) {
					$column_value = trans("labels.before_rotate_data");
				} else {
					$column_value = trans("labels.normal");
				}
			}
	    }

	    /*
	    | ----------------------------------------------------------------------
	    | Hook for manipulate data input before add data is execute
	    | ----------------------------------------------------------------------
	    | @arr
	    |
	    */
	    public function hook_before_add(&$postdata) {
	     
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
			$backup = Backup::find($id);
			$file_name = $backup->file_name;
			$backup_file ='app/backups/' . $file_name . ".sql";
			$backup_file_path = storage_path($backup_file);
			//delete backup file
			if(file_exists($backup_file_path)){
				unlink($backup_file_path);
			}

			$attchs_folder = 'app/backups_attachs/'.$backup->attachs_folder;
			$attach_folder_path =storage_path($attchs_folder);
			if(file_exists($attach_folder_path)){
				File::deleteDirectory($attach_folder_path);
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
	        
	    }



	    //By the way, you can still create your own method in here... :)

		public function createBackup()
		{
			 //check if package config allow to add New Backup
			$gfunc = new GeneralFunctionsController();
			$totat_backups_size = $this->getPackageConfigValue('backups_size');
			
			$backups_db_path = storage_path('app/backups');
			$backups_attacts_path = storage_path('app/backups_attachs');
			$current_backups_size = $gfunc->getFolderSize($backups_db_path) + $gfunc->getFolderSize($backups_attacts_path);

			$showErrorMsg = 0;
			if ($totat_backups_size > 0 && ($current_backups_size >= $totat_backups_size)) {
				$showErrorMsg = 1;
			}

			return view('data.create_backup',array('showErrorMsg'=>$showErrorMsg));
		}

		public function restoreBackup($id)
		{
			
			$backup_info= Backup::find($id);
			$file_name = $backup_info->file_name;
			$backupCtr = new BackupController();
			$status = $backupCtr->restoreBackupDB($file_name);
			if($status){
				$backup_name = $backup_info->name;
				$backup_date = $backup_info->date;
				
				//forget cycle sessions and reconfigrate its.
				Session::forget('display_cycle');
				Session::forget('current_cycle');
				CRUDBooster::redirect($_SERVER['HTTP_REFERER'],trans('messages.restore_backup_success',['name'=>$backup_name,'date'=>$backup_date]),"success");
			}else{
				CRUDBooster::redirect($_SERVER['HTTP_REFERER'],trans('messages.restore_backup_failed'),"danger");
			    
			}
		}
		
	}