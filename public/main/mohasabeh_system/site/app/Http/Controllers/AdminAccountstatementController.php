<?php namespace App\Http\Controllers;

	use Session;
	use Request;
	use DB;
	use CRUDBooster;
	use Maatwebsite\Excel\Facades\Excel;

	class AdminAccountstatementController extends \crocodicstudio_voila\crudbooster\controllers\CBController {

	    public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "id";
			$this->limit = "20";
			$this->orderby = "sorting,asc";
			$this->global_privilege = false;
			$this->button_table_action = true;
			$this->button_bulk_action = true;
			$this->button_action_style = "button_icon";
			$this->button_add = false;
			$this->button_edit = false;
			$this->button_delete = false;
			$this->button_detail = true;
			$this->button_show = false;
			$this->button_filter = false;
			$this->button_import = false;
			$this->button_export = true;
			$this->table = "entries";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>"Entry Base Id","name"=>"entry_base_id","join"=>"entry_base,id"];
			$this->col[] = ["label"=>"Debit","name"=>"debit"];
			$this->col[] = ["label"=>"Credit","name"=>"credit"];
			$this->col[] = ["label"=>"Account Id","name"=>"account_id","join"=>"accounts,id"];
			$this->col[] = ["label"=>"Sorting","name"=>"sorting"];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			$this->form[] = ['label'=>'Entry Base Id','name'=>'entry_base_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'entry_base,id'];
			$this->form[] = ['label'=>'Debit','name'=>'debit','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Credit','name'=>'credit','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Account Id','name'=>'account_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'account,id'];
			$this->form[] = ['label'=>'Active','name'=>'active','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Sorting','name'=>'sorting','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			# END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ['label'=>'Entry Base Id','name'=>'entry_base_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'entry_base,id'];
			//$this->form[] = ['label'=>'Debit','name'=>'debit','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Credit','name'=>'credit','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Account Id','name'=>'account_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'account,id'];
			//$this->form[] = ['label'=>'Active','name'=>'active','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Sorting','name'=>'sorting','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
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
	        //Your code here

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
        public function getIndex(\Illuminate\Http\Request $request)
        {

			if(CRUDBooster::isSuperAdmin()) {
            	if (!CRUDBooster::isView()) CRUDBooster::denyAccess();
			}
            $conditions = array(['entry_base.delete_by', '=',  0 ],['entries.delete_by', '=',  0 ],['entry_base.rotate_year', '=',  NULL ],['entries.rotate_year', '=',  NULL]);

            if ($request->has('from_date')&& $request->input('from_date') !=null ) {

                array_push($conditions, ['entry_base.date', '>=',  $request->from_date ]);

            }

            if ($request->has('to_date')&& $request->input('to_date')!=null ) {

                array_push($conditions, ['entry_base.date', '<=',  $request->to_date ]);

            }

            if ($request->has('currency_id')&& $request->input('currency_id')!=-1 && is_numeric($request->currency_id)) {

                array_push($conditions, ['currencies.id', '=',  $request->currency_id ]);

            }
            $currencies = DB::table("currencies")->get();

			$id = CRUDBooster::myId();
			$me = DB::table('cms_users')->find($id);
			if ($me->id_cms_privileges == 4) {
				$persons = DB::table('persons')->where('delegate_id','=',$me->id)->get();
			}else{
				$persons = DB::table('persons')->get();
			}

           

            $query = DB::table("entry_base")->select(
                'entry_base.date as entryDate','entry_base.narration as entryNarration','entry_base.id as entryBaseId',
                'entries.debit as debit','entries.credit as credit',
                'bills.p_code as billCode', 'bill_type.name_ar as billTypeName', 'bills.id as billId'
                ,'bill_type.id as billTypeId' ,'currencies.name_ar as currency_nameAr',
				'vouchers.id as VoucherId','vouchers.p_code as VoucherCode',
				'vouchers.voucher_type_id as VoucherTypeId',
				'voucher_types.name_ar as VoucherTypeName',
				'accounts.name_ar as accountName'
				

            )
                ->join("entries", "entries.entry_base_id", "entry_base.id")
                ->leftjoin("bills", "bills.id", "entry_base.bill_id")
				->leftjoin("vouchers", "vouchers.id", "entry_base.voucher_id")
				->leftjoin("voucher_types", "vouchers.voucher_type_id", "voucher_types.id")
                ->leftjoin("bill_type", "bill_type.id", "bills.bill_type_id")
                ->join("accounts", "accounts.id", "entries.account_id")
                ->join("persons", "persons.account_id", "accounts.id")
                ->join("currencies", "currencies.id", "entries.currency_id")
                ->where($conditions);



            if ($request->input('person_id') != -1 && $request->input('person_id') != null) {

                $person = DB::table('persons')->select('account_id')->where('id',$request->input('person_id'))->first();
                $base = DB::table('entries')->select('entry_base_id')->where('account_id',$person->account_id)->where('delete_by',0)->get();

                $currencies = [];

                foreach ($base as $value)
                {
                    $currency  = DB::table('entries')->select('currency_id')
                        ->where('entry_base_id',$value->entry_base_id)->where('delete_by',0)->first();


                    array_push($currencies,$currency->currency_id);
                }

                $currencies =  DB::table("currencies")->whereIn('id',$currencies)->get();

                $person = DB::table('persons')->where('id',$request->person_id)->first();

                $query->where('entries.account_id', $person->account_id);

                $data = $query->orderBy('entry_base.date')->distinct()->get();

            }
			//dd($data);
			Session::put('account_statement_report',$data);

            return view("report.accountStatement", Array("data" => $data,
                "persons" => $persons, "person_id" => $request->input('person_id'),
                        'from_date' => $request->from_date,'to_date'=> $request->to_date,"currencies" => $currencies,"currency_id"=>$request->input('currency_id')));


        }

        public function getDealCurrencies($account_id)
        {
            $person = DB::table('persons')->select('account_id')->where('id',$account_id)->first();
            $base = DB::table('entries')->select('entry_base_id')->where('account_id',$person->account_id)->where('delete_by',0)->get();

            $currencies = [];

            foreach ($base as $value)
            {
                $currency  = DB::table('entries')->select('currency_id')
                    ->where('entry_base_id',$value->entry_base_id)->where('delete_by',0)->first();

                array_push($currencies,$currency->currency_id);
            }

            $currenciesToSent =  DB::table("currencies")->whereIn('id',$currencies)->get();

            return $currenciesToSent;

        }

		//export to excel file xls
		public function export($filter){
			//get report from session
			$report = Session::get('account_statement_report');
			$json  = json_encode($report);
			$data = json_decode($json, true);
			if($data==null){
				return "No Data, Please using filter to show your data and press export aging.";
			}
			$rows_count = count($data) + 3;
			//dd($data);
			$new_data = array();
			$all_debit=0;
			$all_credit=0;
			$all_total=0;

			foreach($data as $arr){
				$debit= $arr['debit']!=null?$arr['debit']:'0';
				$credit=$arr['credit']!=null?$arr['credit']:'0';
				$temp = array(
					"accountName"=>$arr['accountName'],
					"entryDate"=>$arr['entryDate'],
					"entryNarration"=>$arr['entryNarration'],
					"debit"=>$debit,
					"credit"=>$credit,
					"currency_nameAr"=>$arr['currency_nameAr']
				);
				
				$all_debit +=$debit;
				$all_credit +=$credit;

				array_push($new_data,$temp);
			}
			$result =  array(
					"accountName"=>'',
					"entryDate"=>'',
					"entryNarration"=>'',
					"debit"=>$all_debit,
					"credit"=>$all_credit,
					"currency"=>'',
					'total'=>($all_debit - $all_credit)
				);
			array_push($new_data,$result);
			$data= $new_data;
			
			Excel::create('export_account_statement_'.date('Y-m-d H:i:s',time()), function($excel) use ($data,$rows_count) {

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

				$excel->sheet('Result', function($sheet) use ($data,$rows_count) {
					$sheet->setOrientation('landscape');
					$sheet->setPageMargin(0.25);
					
					$sheet->fromArray($data);
					// Add before first row
					$sheet->prependRow(1, array(
						"accountName"=>"الحساب",
						"entryDate"=>"التاريخ",
						"entryNarration"=>"البيان",
						"debit"=>"مدين",
						"credit"=>"دائن",
						"currency_nameAr"=>"العملة"
					));
					$sheet->row(1, function($row) {
						// call cell manipulation methods
						$row->setBackground('#cccccc');
					
					});
					$sheet->row($rows_count, function($row) {
						//style last row
						$row->setBackground('#cccccc');
					
					});
					$sheet->appendRow(2, array(
						'', '','','','','','', '','',''
					));

					$sheet->freezeFirstRow();
					// Set auto size for sheet
					$sheet->setAutoSize(true);

					

				});
			
			})->export('xls');
			
		}

	}
