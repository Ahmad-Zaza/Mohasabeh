<?php namespace App\Http\Controllers;

	use Session;
	use Request;
	use DB;
	use CRUDBooster;

	class AdminBillsController extends \crocodicstudio_voila\crudbooster\controllers\CBController {

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
			$this->button_delete = false;
			$this->button_detail = true;
			$this->button_show = true;
			$this->button_filter = true;
			$this->button_import = false;
			$this->button_export = false;
			$this->table = "bills";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>"Document number","name"=>"bill_number"];
			$this->col[] = ["label"=>"Code","name"=>"code"];
			$this->col[] = ["label"=>"Debit","name"=>"debit","join"=>"accounts,name_en"];
			$this->col[] = ["label"=>"Credit","name"=>"credit","join"=>"accounts,name_en"];
			$this->col[] = ["label"=>"Date","name"=>"date"];
			$this->col[] = ["label"=>"Bill Type","name"=>"bill_type_id","join"=>"bill_type,name_en"];
			$this->col[] = ["label"=>"Inventory","name"=>"inventory_id","join"=>"inventories,name_en"];
			$this->col[] = ["label"=>"Currency","name"=>"currency_id","join"=>"currencies,name_en"];
			$this->col[] = ["label"=>"Staff","name"=>"staff_id","join"=>"cms_users,name"];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			$this->form[] = ['label'=>'Document number','name'=>'bill_number','validation'=>'required','width'=>'col-sm-9'];
			$this->form[] = ['label'=>'Code','name'=>'code','type'=>'number','width'=>'col-sm-10','datatable'=>'accounts,name_ar','datatable_where'=>'major_classification=0'];
			$this->form[] = ['label'=>'Debit','name'=>'debit','type'=>'select2','width'=>'col-sm-10','datatable'=>'accounts,name_ar','datatable_where'=>'major_classification=0'];
			$this->form[] = ['label'=>'Credit','name'=>'credit','type'=>'select2','width'=>'col-sm-10','datatable'=>'bill_type,name_ar'];
			$this->form[] = ['label'=>'Bill Type','name'=>'bill_type_id','type'=>'select2','width'=>'col-sm-10','datatable'=>'inventories,name_ar'];
			$this->form[] = ['label'=>'Inventory','name'=>'inventory_id','type'=>'select2','width'=>'col-sm-10','datatable'=>'currencies,name_ar'];
			$this->form[] = ['label'=>'Currency','name'=>'currency_id','type'=>'select2','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Note','name'=>'note','type'=>'textarea','width'=>'col-sm-10','dataenum'=>'1|yes;0|no'];
			$this->form[] = ['label'=>'Cash','name'=>'is_cash','type'=>'radio','width'=>'col-sm-10','table'=>'bill_item','foreign_key'=>'bill_id'];
			$this->form[] = ['label'=>'Add Items','name'=>'bill_item','type'=>'child','width'=>'col-sm-10'];
			# END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ['label'=>'Code','name'=>'code','type'=>'number','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Debit','name'=>'debit','type'=>'select2','width'=>'col-sm-10','datatable'=>'accounts,name_ar','datatable_where'=>'major_classification=0'];
			//$this->form[] = ['label'=>'Credit','name'=>'credit','type'=>'select2','width'=>'col-sm-10','datatable'=>'accounts,name_ar','datatable_where'=>'major_classification=0'];
			//$this->form[] = ['label'=>'Bill Type','name'=>'bill_type_id','type'=>'select2','width'=>'col-sm-10','datatable'=>'bill_type,name_ar'];
			//$this->form[] = ['label'=>'Inventory','name'=>'inventory_id','type'=>'select2','width'=>'col-sm-10','datatable'=>'inventories,name_ar'];
			//$this->form[] = ['label'=>'Currency','name'=>'currency_id','type'=>'select2','width'=>'col-sm-10','datatable'=>'currencies,name_ar'];
			//$this->form[] = ['label'=>'Note','name'=>'note','type'=>'textarea','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Cash','name'=>'is_cash','type'=>'radio','width'=>'col-sm-10','dataenum'=>'1|yes;0|no'];
			//$this->form[] = ['label'=>'Add Items','name'=>'bill_item','type'=>'child','width'=>'col-sm-10','table'=>'bill_item','foreign_key'=>'bill_id'];
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
			
			$query=$query->where("bill_type_id",1);

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
			$postdata["staff_id"]=CRUDBooster::myId();
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
		DB::beginTransaction();
		try{
			$bill=DB::table("bills")->find($id);
			$bill_details=DB::table("bill_item")->where('bill_id',$bill->id)->sum('subtotal');
			$max=DB::table('entry_base')->max('entry_number');
			$entry_number=$max+1;

			$entry_base_id=DB::table("entry_base")->insertGetId([
				'entry_number'=>$entry_number,
				'narration'=>$bill->note,
				'date'=>$bill->date,
				'bill_id'=>$id,
				'active'=>1
			]);

			DB::table('entries')->insert([
				'entry_base_id'=>$entry_base_id,
				'debit'=>$bill_details,
				'account_id'=>$bill->debit,
				'credit'=>null,

			]);

			DB::table('entries')->insert([
				'entry_base_id'=>$entry_base_id,
				'credit'=>$bill_details,
				'account_id'=>$bill->credit,
				'debit'=>null,

			]);


			$max=DB::table('item_tracking')->max('code');
			$Bills_items=DB::table("bill_item")->where("bill_id",$id)->get();
			$bill=DB::table("bills")->find($id);
			
			$opr="";
			if($bill->bill_type_id==1){
				$opr="in";
			}else if($bill->bill_type_id==2){
				$opr="out";
			}
			else if($bill->bill_type_id==3){
				$opr="out";
			}
			else if($bill->bill_type_id==4){
				$opr="in";
			}

			
			foreach ($Bills_items as $key => $item) {
				DB::table('item_tracking')->insert([
					'code'=>$max,
					'item_id'=>$item->item_id,
					'inventory_id_type_id'=>$bill->bill_type_id,
					'source'=>$bill->inventory_id,
					'date'=>date('Y-m-d'),
					'quantity'=>$item->quantity,
					'bill_id'=>$bill->id,
					'note'=>$bill->note,
					'transaction_operation'=>$opr
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
			//Your code here
			$postdata["staff_id"]=CRUDBooster::myId();


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
			DB::beginTransaction();
			try{
				$bill=DB::table("bills")->find($id);
				$base=DB::table("entry_base")->where("bill_id",$bill->id)->first();
				DB::table("entry_base")->where("bill_id",$bill->id)->delete();
				DB::table("entries")->where("entry_base_id",$base->id)->delete();
	
				$bill_details=DB::table("bill_item")->where('bill_id',$bill->id)->sum('subtotal');
				$max=DB::table('entry_base')->max('entry_number');
				$entry_number=$max+1;
	
				$entry_base_id=DB::table("entry_base")->insertGetId([
					'entry_number'=>$entry_number,
					'narration'=>$bill->note,
					'date'=>$bill->date,
					'bill_id'=>$id,
					'active'=>1
				]);
	
				DB::table('entries')->insert([
					'entry_base_id'=>$entry_base_id,
					'debit'=>$bill_details,
					'account_id'=>$bill->debit,
					'credit'=>null,
	
				]);
	
				DB::table('entries')->insert([
					'entry_base_id'=>$entry_base_id,
					'credit'=>$bill_details,
					'account_id'=>$bill->credit,
					'debit'=>null,
	
				]);
	
	
	
				DB::table("item_tracking")->where("bill_id",$bill->id)->delete();
				
				$max=DB::table('item_tracking')->max('code');
				$Bills_items=DB::table("bill_item")->where("bill_id",$id)->get();
				$bill=DB::table("bills")->find($id);
				
				$opr="";
				if($bill->bill_type_id==1){
					$opr="in";
				}else if($bill->bill_type_id==2){
					$opr="out";
				}
				else if($bill->bill_type_id==3){
					$opr="out";
				}
				else if($bill->bill_type_id==4){
					$opr="in";
				}
	
		// dd($Bills_items);
				foreach ($Bills_items as $key => $item) {
					DB::table('item_tracking')->insert([
						'code'=>$max,
						'item_id'=>$item->item_id,
						'inventory_id_type_id'=>$bill->bill_type_id,
						'source'=>$bill->inventory_id,
						'date'=>date('Y-m-d'),
						'quantity'=>$item->quantity,
						'bill_id'=>$bill->id,
						'note'=>$bill->note,
						'transaction_operation'=>$opr
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


	}