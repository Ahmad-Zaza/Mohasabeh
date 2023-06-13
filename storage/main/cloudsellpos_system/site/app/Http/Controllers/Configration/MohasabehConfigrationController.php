<?php
namespace App\Http\Controllers\Configration;
use App\Http\Controllers\General\GeneralFunctionsController;
use App\Models\Accounts\Person;
use App\Models\Bills\Bill;
use App\Models\Configration\MohasabehInfo;
use App\Models\Configration\PackageConfig;
use App\Models\Currencies\Currency;
use App\Models\Inventories\Inventory;
use App\Models\Users\User;
use Carbon\Carbon;
use Request;
use CRUDBooster;
use Illuminate\Support\Facades\File;
use Session;

class MohasabehConfigrationController extends \crocodicstudio_voila\crudbooster\controllers\CBController
{

	public function cbInit()
	{
		# START CONFIGURATION DO NOT REMOVE THIS LINE
		$this->table = "reports";
		$this->title_field = "account_name";
		$this->limit = 20;
		$this->orderby = "sorting,asc";
		$this->show_numbering = FALSE;
		$this->global_privilege = FALSE;
		$this->button_table_action = FALSE;
		$this->button_action_style = "button_icon";
		$this->button_add = FALSE;
		$this->button_delete = FALSE;
		$this->button_edit = FALSE;
		$this->button_detail = FALSE;
		$this->button_show = FALSE;
		$this->button_filter = FALSE;
		$this->button_export = FALSE;
		$this->button_import = FALSE;
		$this->button_bulk_action = FALSE;
		$this->sidebar_mode = "normal"; //normal,mini,collapse,collapse-mini
		# END CONFIGURATION DO NOT REMOVE THIS LINE

		# START COLUMNS DO NOT REMOVE THIS LINE
		$this->col = [];
		

		# END COLUMNS DO NOT REMOVE THIS LINE
		# START FORM DO NOT REMOVE THIS LINE
		$this->form = [];
	
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

		$this->table_row_color[] = ["condition" => "[active]==1", "color" => "success"];
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

	public function getIndex()
	{
		$gfunc = new GeneralFunctionsController();
		$data = PackageConfig::first();
		//dd($data);
 
		
		//users Number
		$current_users_num = User::get()->count();
		$data->current_users_num = $current_users_num - 1;
		if($data->users_num == '-1'){
			$data->users_num = trans('labels.unlimited');
			$data->avilable_users_num = trans('labels.unlimited');
		} else {
			$data->avilable_users_num = $data->users_num - $data->current_users_num;
		}

		//Inventories Number
		$data->current_inventories_num = Inventory::where('major_classification', 0)->get()->count();
		if($data->inventories_num == '-1'){
			$data->inventories_num = trans('labels.unlimited');
			$data->avilable_inventories_num = trans('labels.unlimited');
		} else {
			$data->avilable_inventories_num = $data->inventories_num - $data->current_inventories_num;
		}

		//Currencies Number
		$data->current_currencies_num =  Currency::where('active',1)->get()->count();
		if($data->currencies_num == '-1'){
			$data->currencies_num = trans('labels.unlimited');
			$data->avilable_currencies_num = trans('labels.unlimited');
		} else {
			$data->avilable_currencies_num = $data->currencies_num - $data->current_currencies_num;
		}

		//clients Number
		$data->current_clients_num = Person::get()->count();
		if($data->clients_num == '-1'){
			$data->clients_num = trans('labels.unlimited');
			$data->avilable_clients_num = trans('labels.unlimited');
		} else {
			$data->avilable_clients_num = $data->clients_num - $data->current_clients_num;
		}
 
		//month bills count
		$data->current_month_bills_num = Bill::where('action',NULL)
												->where('cycle_id', Session::get('display_cycle'))
												->whereMonth('date', Carbon::now()->month)->get()->count();
		if($data->month_bills_num == '-1'){
			$data->month_bills_num = trans('labels.unlimited');
			$data->avilable_month_bills_num = trans('labels.unlimited');
		} else {
			$data->avilable_month_bills_num = $data->month_bills_num - $data->current_month_bills_num;
		}

		//Backups Size
		$backups_db_path = storage_path('app/backups');
		$backups_attacts_path = storage_path('app/backups_attachs');
		$data->current_backups_size = $gfunc->getFolderSize($backups_db_path) + $gfunc->getFolderSize($backups_attacts_path);
		if($data->backups_size == '-1'){
			$data->backups_size = trans('labels.unlimited');
			$data->avilable_backups_size = trans('labels.unlimited');
		} else {
			$data->avilable_backups_size = $data->backups_size - $data->current_backups_size;
			if($data->avilable_backups_size < 0){
				$data->avilable_backups_size = 0;
			}
		}

		//attachs Size
		$attachs_path = storage_path('app/uploads');
		$data->current_attachs_size = $gfunc->getFolderSize($attachs_path);
		if($data->attachs_size == '-1'){
			$data->attachs_size = trans('labels.unlimited');
			$data->avilable_attachs_size = trans('labels.unlimited');
		} else {
			$data->avilable_attachs_size = $data->attachs_size - $data->current_attachs_size;
			if($data->avilable_attachs_size < 0){
				$data->avilable_attachs_size = 0;
			}
		}
		
		
		
		if($data->free_trial_start_date == NULL || $data->free_trial_start_date == '0000-00-00'){
			$data->free_trial_start_date = '';
		}
		if($data->free_trial_end_date == NULL || $data->free_trial_end_date == '0000-00-00'){
			$data->free_trial_end_date = '';
			$data->free_trail_remaining_days = '';
		} else {
			$free_trail_all_days = $gfunc->getDaysBetweenTwoDate($data->free_trial_start_date, $data->free_trial_end_date);
			$today=date('Y-m-d');
			$free_trail_used_days = $gfunc->getDaysBetweenTwoDate($data->free_trial_start_date, $today);
			$free_trail_remaining_days = $free_trail_all_days - $free_trail_used_days;
			if($free_trail_remaining_days > 0){
				$data->free_trail_remaining_days = (int)$free_trail_remaining_days;
				$data->free_trail_remaining_days = $data->free_trail_remaining_days ." ". trans('labels.day');
			}else{
				if ($data->subscription_start_date == NULL || $data->subscription_start_date == '0000-00-00') {
					$data->free_trail_remaining_days = trans('labels.free_trail_period_was_finished_please_subscribe');
				} else {
					$data->free_trail_remaining_days = trans('labels.free_trail_period_was_finished');
				}
				
			}
		}
		


		if($data->subscription_start_date == NULL || $data->subscription_start_date == '0000-00-00'){
			$data->subscription_start_date = trans('labels.unsubscribe');
		}
		if($data->subscription_end_date == NULL || $data->subscription_end_date == '0000-00-00'){
			$data->subscription_end_date =  trans('labels.unsubscribe');
			$data->subscription_remaining_days =  trans('labels.unsubscribe');
		} else {
			$subscription_all_days = $gfunc->getDaysBetweenTwoDate($data->subscription_start_date, $data->subscription_end_date);
			$today=date('Y-m-d');
			$subscription_used_days = $gfunc->getDaysBetweenTwoDate($data->subscription_start_date, $today);
			$subscription_remaining_days = $subscription_all_days - $subscription_used_days;
			if($subscription_remaining_days > 0){
				$data->subscription_remaining_days = (int)$subscription_remaining_days;
				$data->subscription_remaining_days = $data->subscription_remaining_days ." ". trans('labels.day');
			}else{
				$data->subscription_remaining_days = trans('labels.subscription_period_was_finished_please_renewal');
			}
		}

		$mohasabeh_info = MohasabehInfo::first();
		//dd($data);


		return view("configration.mohasabeh", array("data" => $data,'mohasabeh_info'=>$mohasabeh_info));
	}


	public function sendDomainRequest($domain,$msg=''){
		$site_url =  Request::root();
		$customer_email = User::where('id',2)->first()->email;
		$mohasabeh_contact_email = MohasabehInfo::first()->contact_emails;
		
		$data = ['customer_email'=>"$customer_email",'site_url'=>"$site_url",'domain'=>"$domain",'customer_message'=>"$msg"];
		try{
			CRUDBooster::sendEmail(['to'=>$mohasabeh_contact_email,'data'=>$data,'template'=>'domain_request','attachments'=>[]]);
			return json_encode(array('status'=>'success','message'=> trans('messages.request_was_sent_successfully')));
		}
		catch(\Exception $e){
			return json_encode(array('status'=>'error','message'=> trans('messages.failed_request_was_not_sent_successfully')));
		}
	}

	public function mailMohasabehTeam($msg){
		$site_url =  Request::root();
		$customer_email = User::where('id',2)->first()->email;
		$mohasabeh_contact_email = MohasabehInfo::first()->contact_emails;

		$data = ['customer_email'=>"$customer_email",'site_url'=>"$site_url",'customer_message'=>"$msg"];
		try{
			CRUDBooster::sendEmail(['to'=>$mohasabeh_contact_email,'data'=>$data,'template'=>'mail_mohasabeh_team','attachments'=>[]]);
			return json_encode(array('status'=>'success','message'=> trans('messages.your_message_was_sent_successfully')));
		}
		catch(\Exception $e){
			return json_encode(array('status'=>'error','message'=> trans('messages.failed_your_message_was_not_sent_successfully')));
		}
	}

	public function sendRenewalRequest($period,$msg){
		$site_url =  Request::root();
		$customer_email = User::where('id',2)->first()->email;
		$mohasabeh_contact_email = MohasabehInfo::first()->contact_emails;

		$data = ['customer_email'=>"$customer_email",'site_url'=>"$site_url",'renewal_period'=>trans("labels.$period") ,'customer_message'=>"$msg"];
		try{
			CRUDBooster::sendEmail(['to'=>$mohasabeh_contact_email,'data'=>$data,'template'=>'renewal_request','attachments'=>[]]);
			return json_encode(array('status'=>'success','message'=> trans('messages.request_was_sent_successfully')));
		}
		catch(\Exception $e){
			return json_encode(array('status'=>'error','message'=> trans('messages.failed_request_was_not_sent_successfully')));
		}
	}
}

