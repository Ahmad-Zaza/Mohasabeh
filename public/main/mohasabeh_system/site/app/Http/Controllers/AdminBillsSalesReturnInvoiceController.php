<?php namespace App\Http\Controllers;

    use App\Traits\GeneralTrait;
	use Session;
	use Request;
	use DB;
	use CRUDBooster;

	class AdminBillsSalesReturnInvoiceController extends \crocodicstudio_voila\crudbooster\controllers\CBController
    {
        use GeneralTrait;
        public function cbInit()
        {

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
            $this->table = "bills";
            # END CONFIGURATION DO NOT REMOVE THIS LINE

            # START COLUMNS DO NOT REMOVE THIS LINE
            $this->col = [];
            $this->col[] = ["label" => "الرمز", "name" => "p_code"];
            $this->col[] = ["label" => "رقم الوثيقة", "name" => "bill_number"];
            $this->col[] = ["label" => "الحساب", "name" => "debit", "join" => "accounts,name_ar"];
            $this->col[] = ["label" => "الزبون", "name" => "credit", "join" => "accounts,name_ar"];
            $this->col[] = ["label" => "التاريخ", "name" => "date"];
            $this->col[] = ["label" => "نوع الوثيقة", "name" => "bill_type_id", "join" => "bill_type,name_ar"];
            $this->col[] = ["label" => "المستودع", "name" => "inventory_id", "join" => "inventories,name_ar"];
            $this->col[] = ["label" => "العملة", "name" => "currency_id", "join" => "currencies,name_ar"];
            $this->col[] = ["label" => "الموظف", "name" => "staff_id", "join" => "cms_users,name"];
            $this->col[] = ["label" => "المندوب", "name" => "delegate_id", "join" => "cms_users,name"];
            $this->col[] = ["label" => "", "name" => "checked_for_update", "visible" => false];


            # END COLUMNS DO NOT REMOVE THIS LINE

            # START FORM DO NOT REMOVE THIS LINE
            $this->form = [];
            $this->form[] = ['label' => 'رقم الوثيقة', 'name' => 'bill_number', 'type' => 'text', 'validation' => 'unique:bills', 'width' => 'col-sm-10'];
            $id = CRUDBooster::myId();

            $me = DB::table('cms_users')->find($id);
            if ($me->id_cms_privileges == 4) {
                $persons = DB::table('persons')->where('person_type_id', 1)->where('delegate_id', $me->id)->select('account_id')->get();
                if (count($persons) == 0) {
                    $this->form[] = ['label' => 'الزبون', 'name' => 'credit', 'type' => 'select2', 'validation' => '', 'width' => 'col-sm-10', 'datatable' => 'accounts,name_ar', 'datatable_format' => "code,' - ',name_ar", 'datatable_where' => 'id = 0'];
                } else {
                    $this->form[] = ['label' => 'الزبون', 'name' => 'credit', 'type' => 'select2', 'validation' => '', 'width' => 'col-sm-10', 'datatable' => 'accounts,name_ar', 'datatable_format' => "code,' - ',name_ar", 'datatable_where' => 'id in (' . implode(',', $this->getPersons()) . ')'];
                }
            } else {
                $this->form[] = ['label' => 'الزبون', 'name' => 'credit', 'type' => 'select2', 'validation' => '', 'width' => 'col-sm-10', 'datatable' => 'accounts,name_ar', 'datatable_format' => "code,' - ',name_ar", 'datatable_where' => 'id in (' . implode(',', $this->getPersons()) . ')'];
            }

            if ($me->id_cms_privileges == 4) {
                $this->form[] = ['label' => 'المندوب', 'name' => 'delegate_id', 'type' => 'select2', 'validation' => 'required', 'width' => 'col-sm-10', 'datatable' => 'cms_users,name', 'datatable_where' => 'id_cms_privileges = 4' . $this->getDelegates()];
            }else{
                $this->form[] = ['label' => 'المندوب', 'name' => 'delegate_id', 'type' => 'select2', 'validation' => '', 'width' => 'col-sm-10', 'datatable' => 'cms_users,name', 'datatable_where' => 'id_cms_privileges = 4' . $this->getDelegates()];
            }

            if ($me->id_cms_privileges == 4) {
                $this->form[] = ['label' => 'المستودع', 'name' => 'inventory_id', 'type' => 'select2', 'validation' => 'required', 'width' => 'col-sm-10', 'datatable' => 'inventories,name_ar', 'datatable_where' => 'major_classification=0 and delegate_id ='.$me->id];
            }else{
                $this->form[] = ['label' => 'المستودع', 'name' => 'inventory_id', 'type' => 'select2', 'validation' => 'required', 'width' => 'col-sm-10', 'datatable' => 'inventories,name_ar', 'datatable_where' => 'major_classification=0'];
            }
            $this->form[] = ['label' => 'العملة', 'name' => 'currency_id', 'type' => 'select2', 'validation' => 'required', 'width' => 'col-sm-10', 'datatable' => 'currencies,name_ar'];
            $this->form[] = ['label' => 'سعر الصرف', 'name' => 'ex_rate', 'type' => 'number', 'step' => 'any', 'validation' => 'required|min:0', 'width' => 'col-sm-10', 'value' => 0];
            $this->form[] = ['label' => 'التاريخ', 'name' => 'date', 'type' => 'date', 'value' => date('Y-m-d', time()), 'validation' => 'required|date', 'width' => 'col-sm-10'];
            $this->form[] = ['label' => 'ملاحظات', 'name' => 'note', 'type' => 'textarea', 'width' => 'col-sm-10'];
            $this->form[] = ['label' => 'نقدي', 'name' => 'is_cash', 'type' => 'radio', 'validation' => 'required', 'width' => 'col-sm-10', 'dataenum' => '1|نعم;0|لا', 'value' => '0'];
            $this->form[] = ['label' => 'bill_type_id', 'name' => 'bill_type_id', 'type' => 'text', 'validation' => 'required', 'width' => 'col-sm-10', 'style' => 'display:none', 'value' => '4'];

            $columns[] = ['label' => 'المادة', 'name' => 'item_id', 'type' => 'select', 'datatable' => 'items,name_ar'];
            $columns[] = ['label' => 'العدد', 'name' => 'quantity', 'type' => 'number', 'required' => true];
            $columns[] = ['label' => 'سعر الوحدة', 'name' => 'unit_price', 'type' => 'number', 'required' => true];
            $columns[] = ['label' => 'المجموع', 'name' => 'subtotal', 'type' => 'number', 'formula' => "[unit_price] * [quantity]", "readonly" => true, 'required' => true];
            $this->form[] = ['label' => 'أضافة مادة', 'name' => 'bill_item', 'type' => 'child', 'columns' => $columns, 'table' => 'bill_item', 'foreign_key' => 'bill_id'];
            $columnsFiles[] = ['label' => 'الصورة', 'name' => 'file_id', 'type' => 'upload', 'required' => true];
            $this->form[] = ['label' => 'اضافة صورة', 'name' => 'bills_files', 'type' => 'child', 'columns' => $columnsFiles, 'table' => 'bills_files', 'foreign_key' => 'bill_id'];
            $this->form[] = ['label' => 'اجمالي الفاتورة', 'name' => 'amount', 'type' => 'number', "readonly" => true, 'required' => true];
            $this->form[] = ['label' => 'الحسم', 'name' => 'discount', 'type' => 'number', 'step' => 'any', 'required' => true, 'value' => 0, 'min' => 0];
            $this->form[] = ['label' => 'اجمالي الفاتورة بعد الحسم', 'name' => 'after_discount', 'type' => 'number', 'step' => 'any', "readonly" => true, 'required' => true];

            # END FORM DO NOT REMOVE THIS LINE

            # OLD START FORM
            //$this->form = [];
            //$this->form[] = ['label'=>'Document number','name'=>'bill_number','type'=>'number','validation'=>'required','width'=>'col-sm-10'];
            //$this->form[] = ['label'=>'Customer Name','name'=>'credit','type'=>'select2','validation'=>'required','width'=>'col-sm-10','datatable'=>'accounts,name_ar','datatable_where'=>'major_classification=0'];
            //$this->form[] = ['label'=>'Inventory','name'=>'inventory_id','type'=>'select2','validation'=>'required','width'=>'col-sm-10','datatable'=>'inventories,name_ar'];
            //$this->form[] = ['label'=>'Currency','name'=>'currency_id','type'=>'select2','validation'=>'required','width'=>'col-sm-10','datatable'=>'currencies,name_ar'];
            //$this->form[] = ['label'=>'Note','name'=>'note','type'=>'textarea','validation'=>'required','width'=>'col-sm-10'];
            //$this->form[] = ['label'=>'Cash','name'=>'is_cash','type'=>'radio','validation'=>'required','width'=>'col-sm-10','dataenum'=>'1|yes;0|no'];
            //$this->form[] = ['label'=>'bill_type_id','name'=>'bill_type_id','type'=>'text','validation'=>'required','width'=>'col-sm-10','style'=>'display:none','value'=>'4'];
            //
            //
            //$columns[] = ['label' => 'Item', 'name' => 'item_id', 'type' => 'datamodal', 'datamodal_table' => 'items', 'datamodal_columns' => 'name_en,price', 'datamodal_select_to' => 'price:unit_price', 'datamodal_where' => '', 'datamodal_size' => 'large'];
            //$columns[] = ['label' => 'Unit Price', 'name' => 'unit_price', 'type' => 'number', 'required' => true];
            //$columns[] = ['label' => 'QTY', 'name' => 'quantity', 'type' => 'number', 'required' => true];
            //$columns[] = ['label' => 'Sub Total', 'name' => 'subtotal', 'type' => 'number', 'formula' => "[unit_price] * [quantity]", "readonly" => true, 'required' => true];
            //$this->form[] = ['label' => 'Add Items', 'name' => 'bill_item', 'type' => 'child', 'columns' => $columns, 'table' => 'bill_item', 'foreign_key' => 'bill_id'];
            //$this->form[] = ['label' => 'amount', 'name' => 'amount', 'type' => 'number', "readonly" => true, 'required' => true];
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
            if (CRUDBooster::isSuperAdmin()) {
                $this->addaction[] = ['label' => '', 'url' => CRUDBooster::mainpath('set-status/true/[id]'), 'icon' => 'fa fa-check', 'color' => 'success','title'=> 'تدقيق', 'showIf' => "[checked_for_update] == '0'"];
                $this->addaction[] = ['label' => '', 'url' => CRUDBooster::mainpath('set-status/false/[id]'), 'icon' => 'fa fa-ban', 'color' => 'warning','title'=> 'إلغاء التدقيق' , 'showIf' => "[checked_for_update] == '1'"];
                $this->button_edit = true;
            }


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

                var options_number = $('#inventory_id').find('option').length;
                    if (options_number == 2){
                        var first_option = $('#inventory_id').find('option')[1];
                        $('#inventory_id').val(first_option.value).change();
                    }
            });

            $('#adafmaditem_id').change(function(){
		        var id = $(this).val();
                    $.get('/items/getPrice/'+id,function(res){
                    console.log(res);
                    $('#adafmadunit_price').val(res.price) 
                    })
		    })
		
		/*$('#credit').change(function(){
		    var id = $(this).val();
		    
            $.get('/bills/getDelegateNameById/'+id,function(res){
                console.log(res);
                
                $('#delegate_id').val(res.id).change();
                $('#inventory_id').val(res.inventory_id).change();
            });
		});*/
		
		$(document).ready(function(){
                $('#adafmaditem_id')
            .find('option')
            .remove()
            .end();
                $.get('/bills/getItems',function(res){
                res.forEach(element => {
                $('#adafmaditem_id').append(new Option(element.name_ar+' - '+element.code, element.id));

                });
		})
		
		})
		
				$(document).ready(function(){
				
					$.post('/bills/getDefaultCurrency',function(res){
        				     
        				     var currency = $('#currency_id').val();
                            if(currency == 0)
        				      $('#currency_id').val(res).change();
		})

})
		$('#btn-add-table-adafmad').click(function(){
                $('#adafmaditem_id').focus();
                   /* var after_discount = $('#after_discount').val();
                    var currencyId = $('#currency_id').val();
                    $.get('/voucher/checkBox/'+currencyId+'/'+after_discount,function(res){
                        if(res.res)
                        {
                            alert('للتذكرة رصيد الصندوق لا يكفي، ان الرصيد الحالي هو : '+res.sum);
                        } 
                    });
                    */
                    var credit = $('#credit').val();
                    var is_cash= document.querySelector('input[name=is_cash]:checked').value;
                    if(credit == '' && is_cash == 0){
                        alert('تنبيه : في حال الدفع أجل يجب اختيار الزبون ');
                    }

        })
                
                
                $('#discount').change(function(){
           		    var discount = $(this).val();
           		    var amount = $('#amount').val();
           		    $('#after_discount').val(amount - discount);

           
           })

           $('#inventory_id').change(function(){
		    var id = $(this).val();
                $('#adafmaditem_id').attr('data-inv',id);
                $('#adafmaditem_id')
                .find('option')
                .remove()
                .end();
                //get items from spesific inventory
                $.get('/inventory/items/'+id,function(res){
                     $('#adafmaditem_id').append(new Option('أختر المادة'));
                     res.forEach(element => {
                        $('#adafmaditem_id').append(new Option(element.name_ar+' - '+element.code, element.id));
                    });
                });
		});
           
        $('#currency_id').change(function(){
            var  currency_id =   $(this).val();
            $('#ex_rate').attr('data-currency',currency_id);
            $.get('/currency/getEx_rate/'+currency_id,function(res1){
                $('#ex_rate').val(res1.ex_rate); 
            })
        });
		";

        if (CRUDBooster::isSuperAdmin()) {
            $this->script_js .="
            $('#delegate_id').change(function(){
                var id = $(this).val();
                if(id == ''){
                    id = -1;
                }
                $('#inventory_id').find('option').remove().end();   
                $.get('/bills/getInventoryByDelegate/'+id,function(res){
                    $('#inventory_id').append(new Option('أختر المستودع'));
                    res.forEach(element => {
                        $('#inventory_id').append(new Option(element.name_ar, element.id));
                    });
    
                    var options_number = $('#inventory_id').find('option').length;
                    if (options_number == 2){
                        var first_option = $('#inventory_id').find('option')[1];
                        $('#inventory_id').val(first_option.value).change();
                    }
                });
            });
            "; 
        }

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

        public function getSetStatus($status, $id)
        {


            if ($status == 'true')
                $status = true;
            elseif ($status == 'false')
                $status = false;


            DB::table('bills')->where('id', $id)->update(['checked_for_update' => $status]);

            //This will redirect back and gives a message
            if($status){
                CRUDBooster::redirect($_SERVER['HTTP_REFERER'],"  تم تغيير حالة الفاتورة بنجاح بعد التحقق منها علما أنه لم يعد للمندوب صلاحية التعديل عليها","success");
            }else{
                CRUDBooster::redirect($_SERVER['HTTP_REFERER'],"    تم تغيير حالة الفاتورة بنجاح  وإعادة  صلاحية التعديل عليها للمندوب","success");
            }
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

            $me = DB::table('cms_users')->find(CRUDBooster::myId());
            if ($me->id_cms_privileges == 4) {
                $query->where('bills.delegate_id', $me->id);

            }

            $query = $query->where("bill_type_id", 4);
            $query = $query->where("delete_by", 0);
            $query = $query->where("rotate_year", NULL);
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

            //check bill to prevent empty bill or box don't have enought money
            $this->checkBill($postdata,'add',null,4);

            $me = DB::table('cms_users')->find(CRUDBooster::myId());

            
            $max = DB::table('bills')->where("bill_type_id", 4)->where('delete_by',0)->where('rotate_year',NULL)->max('code');
            $prefixCode = DB::table('bill_type')->where('id', 4)->select('prefix')->first();

            $postdata["code"] = ($max) ? $max + 1 : 1;
            $postdata['p_code'] = $prefixCode->prefix . '' . $postdata['code'];

            //check if p_code is unique
            $this->checkP_Code($postdata['p_code']);

            $postdata["staff_id"] = CRUDBooster::myId();
            $account = DB::table("accounts")->where("id", "=", $this->getSystemConfigValue('Sales_Return_Account'))->first();
            $postdata["debit"] = $account->id;
//            $postdata["credit"] = $customerAccountId->account_id;

            $currency = $this->getExchangeRate($postdata['currency_id']);
            if($postdata['ex_rate'] != $currency->ex_rate){
                $this->changeExchangeRate($currency->id,$postdata['ex_rate']);
            }
           
            $postdata['equalizer'] = (int)$postdata['ex_rate'] * (int)$postdata['amount'];

            $postdata["bill_type_id"] = 4;
//            $postdata['delegate_id'] = $customerAccountId->delegate_id;
            if ($postdata["is_cash"] == 1) {
                if ($me->id_cms_privileges == 4) {
                    $this->box = $me->account_id;
                } else {

                    $box_account_id = $this->getAccountByCurrency($postdata['currency_id']);
                    if ($box_account_id)
                        $this->box = $box_account_id;
                }
            }

            if ($postdata["is_cash"] == 0 && $postdata["credit"] == null) { //check if debit not null if is_cash is 0
                return  CRUDBooster::redirect(CRUDBooster::mainpath("add/"),"  (الزبون)لا يمكن اجراء فاتورة بدفع أجل و لم يتم تحديد حساب العميل","danger");
            }

            $postdata['create_by']=CRUDBooster::myId();
            //$postdata['create_at']=date('Y-m-d H:i:s'); // تضاف تلقائيا من الداتا بيز

        }

        public $customerId;
        public $accountId;
        public $box;

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
            DB::beginTransaction();
            try {
                $bill = DB::table("bills")->find($id);
                $afterDiscount_amount = $bill->after_discount;

                $bill_details = DB::table("bill_item")->where('bill_id', $bill->id)->sum('subtotal');
                $max = DB::table('entry_base')->where('delete_by',0)->where('rotate_year',NULL)->max('entry_number');
                $entry_number = $max + 1;

                $entry_base_id = DB::table("entry_base")->insertGetId([
                    'entry_number' => $entry_number,
                    'narration' => $bill->note,
                    'date' => $bill->date,
                    'bill_id' => $id,
                    'active' => 1,
                    'create_by'=> CRUDBooster::myId()

                ]);

                DB::table('entries')->insert([
                    'entry_base_id' => $entry_base_id,
                    'debit' => $bill_details,
                    'account_id' => $bill->debit,
                    'credit' => null,
                    'ex_rate' => $bill->ex_rate,
                    'equalizer' => (int)$bill->ex_rate * (int)$bill_details,
                    'currency_id' => $bill->currency_id,
                    'create_by'=> CRUDBooster::myId()

                ]);
                if($bill->credit != NULL){  //في حال كانت عملية مردود مبيع كاش لزبون  ليس له حساب
                    DB::table('entries')->insert([
                        'entry_base_id' => $entry_base_id,
                        'credit' => $bill_details,
                        'account_id' => $bill->credit,
                        'debit' => null,
                        'ex_rate' => $bill->ex_rate,
                        'equalizer' => (int)$bill->ex_rate * (int)$bill_details,
                        'currency_id' => $bill->currency_id,
                        'create_by'=> CRUDBooster::myId()

                    ]);
                }


                if ($bill->is_cash) {

                
                    DB::table('entries')->insert([
                        'entry_base_id' => $entry_base_id,
                        'credit' => $afterDiscount_amount,
                        'account_id' => $this->box,
                        'debit' => null,
                        'ex_rate' => $bill->ex_rate,
                        'equalizer' => (int)$bill->ex_rate * (int)$afterDiscount_amount,
                        'currency_id' => $bill->currency_id,
                        'create_by'=> CRUDBooster::myId()

                    ]);
                    if($bill->credit != NULL){  //في حال كانت عملية مردود مبيع كاش لزبون  ليس له حساب
                        DB::table('entries')->insert([
                            'entry_base_id' => $entry_base_id,
                            'debit' => $afterDiscount_amount,
                            'account_id' => $bill->credit,
                            'credit' => null,
                            'ex_rate' => $bill->ex_rate,
                            'equalizer' => (int)$bill->ex_rate * (int)$afterDiscount_amount,
                            'currency_id' => $bill->currency_id,
                            'create_by'=> CRUDBooster::myId()

                        ]);
                    }
                }

                if ($bill->discount > 0) {

                    DB::table('entries')->insert([
                        'entry_base_id' => $entry_base_id,
                        'credit' => $bill->discount,
                        'account_id' => $this->getSystemConfigValue('Earned_Discount'),
                        'debit' => null,
                        'ex_rate' => $bill->ex_rate,
                        'equalizer' => (int)$bill->ex_rate * (int)$bill->discount,
                        'currency_id' => $bill->currency_id,
                        'create_by'=> CRUDBooster::myId()

                    ]);
                    if($bill->credit != NULL){  //في حال كانت عملية مردود مبيع كاش لزبون  ليس له حساب
                        DB::table('entries')->insert([
                            'entry_base_id' => $entry_base_id,
                            'debit' => $bill->discount,
                            'account_id' => $bill->credit,
                            'credit' => null,
                            'ex_rate' => $bill->ex_rate,
                            'equalizer' => (int)$bill->ex_rate * (int)$bill->discount,
                            'currency_id' => $bill->currency_id,
                            'create_by'=> CRUDBooster::myId()

                        ]);
                    }
                }


                $max = DB::table('item_tracking')->where('delete_by',0)->where('rotate_year',NULL)->max('code');
                $Bills_items = DB::table("bill_item")->where("bill_id", $id)->get();
                $bill = DB::table("bills")->find($id);

                $opr = "";
                if ($bill->bill_type_id == 1) {
                    $opr = "in";
                } else if ($bill->bill_type_id == 2) {
                    $opr = "out";
                } else if ($bill->bill_type_id == 3) {
                    $opr = "out";
                } else if ($bill->bill_type_id == 4) {
                    $opr = "in";
                }
                $prefixCode = DB::table('inventory_type_id')->where('id', 4)->select('prefix')->first();
                $prefix = $prefixCode->prefix . '' . ($max + 1);

                foreach ($Bills_items as $key => $item) {
                    DB::table('item_tracking')->insert([
                        'code' => $max + 1,
                        'item_id' => $item->item_id,
                        'inventory_id_type_id' => $bill->bill_type_id,
                        'source' => $bill->inventory_id,
                        'date' => $bill->date,
                        'quantity' => $item->quantity,
                        'bill_id' => $bill->id,
                        'note' => $bill->note,
                        'transaction_operation' => $opr,
                        'p_code' => $prefix,
                        'create_by'=> CRUDBooster::myId()

                    ]);
                }
                DB::commit();

            } catch (\Exception $e) {
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
        public function hook_before_edit(&$postdata, $id)
        {
            //check bill to prevent empty bill or box don't have enought money
            $this->checkBill($postdata,'edit',$id,4);

            $me = DB::table('cms_users')->find(CRUDBooster::myId());

           
            $postdata["staff_id"] = CRUDBooster::myId();

            $account = DB::table("accounts")->where("id", "=", $this->getSystemConfigValue('Sales_Return_Account'))->first();
            $postdata["debit"] = $account->id;

            $postdata["bill_type_id"] = 4;

            if ($postdata["is_cash"] == 1) {
                if ($me->id_cms_privileges == 4) {
                    $this->editBox = $me->account_id;
                } else {

                    $box_account_id = $this->getAccountByCurrency($postdata['currency_id']);
                    if ($box_account_id)
                        $this->editBox = $box_account_id;
                }
            }

            if ($postdata["is_cash"] == 0 && $postdata["credit"] == null) { //check if debit not null if is_cash is 0
                return  CRUDBooster::redirect(CRUDBooster::mainpath("edit/".$id),"  (الزبون)لا يمكن اجراء فاتورة بدفع أجل و لم يتم تحديد حساب العميل","danger");
            }

            //change ex_rate if is different
            $currency = $this->getExchangeRate($postdata['currency_id']);
            if($postdata['ex_rate'] != $currency->ex_rate){
                $this->changeExchangeRate($currency->id,$postdata['ex_rate']);
            }

            //create new bill with another id and save old data to new record with delete_by delete_at
            //change forgin key in others tables bill_id to new copy of bill with delete_by delete_at
            $this->makeBillAsDeleted($id); //in GeneralTrait


        }

        public $editCustomerId;

        public $editBox;

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
            DB::beginTransaction();
            try {

                $bill = DB::table("bills")->find($id);
                $afterDiscount_amount = $bill->after_discount;


                $bill_details = DB::table("bill_item")->where('bill_id', $bill->id)->sum('subtotal');
                $max = DB::table('entry_base')->where('delete_by',0)->where('rotate_year',NULL)->max('entry_number');
                $entry_number = $max + 1;

                $entry_base_id = DB::table("entry_base")->insertGetId([
                    'entry_number' => $entry_number,
                    'narration' => $bill->note,
                    'date' => $bill->date,
                    'bill_id' => $id,
                    'active' => 1,
                    'create_by'=> CRUDBooster::myId()
                ]);

                DB::table('entries')->insert([
                    'entry_base_id' => $entry_base_id,
                    'debit' => $bill_details,
                    'account_id' => $bill->debit,
                    'credit' => null,
                    'ex_rate' => $bill->ex_rate,
                    'equalizer' => (int)$bill->ex_rate * (int)$bill_details,
                    'currency_id' => $bill->currency_id,
                    'create_by'=> CRUDBooster::myId()


                ]);
                if($bill->credit != NULL){  //في حال كانت عملية مردود مبيع كاش لزبون  ليس له حساب
                    DB::table('entries')->insert([
                        'entry_base_id' => $entry_base_id,
                        'credit' => $bill_details,
                        'account_id' => $bill->credit,
                        'debit' => null,
                        'ex_rate' => $bill->ex_rate,
                        'equalizer' => (int)$bill->ex_rate * (int)$bill_details,
                        'currency_id' => $bill->currency_id,
                        'create_by'=> CRUDBooster::myId()


                    ]);
                }


                if ($bill->is_cash) {

                  

                    DB::table('entries')->insert([
                        'entry_base_id' => $entry_base_id,
                        'credit' => $afterDiscount_amount,
                        'account_id' => $this->editBox,
                        'debit' => null,
                        'ex_rate' => $bill->ex_rate,
                        'equalizer' => (int)$bill->ex_rate * (int)$bill->discount,
                        'currency_id' => $bill->currency_id,
                        'create_by'=> CRUDBooster::myId()


                    ]);
                    if($bill->credit != NULL){  //في حال كانت عملية مردود مبيع كاش لزبون  ليس له حساب
                        DB::table('entries')->insert([
                            'entry_base_id' => $entry_base_id,
                            'debit' => $afterDiscount_amount,
                            'account_id' => $bill->credit,
                            'credit' => null,
                            'ex_rate' => $bill->ex_rate,
                            'equalizer' => (int)$bill->ex_rate * (int)$bill->discount,
                            'currency_id' => $bill->currency_id,
                            'create_by'=> CRUDBooster::myId()
                        ]);
                    }
                }
                if ($bill->discount > 0) {
                   

                    DB::table('entries')->insert([
                        'entry_base_id' => $entry_base_id,
                        'credit' => $bill->discount,
                        'account_id' => $this->getSystemConfigValue('Earned_Discount'),
                        'debit' => null,
                        'ex_rate' => $bill->ex_rate,
                        'equalizer' => (int)$bill->ex_rate * (int)$afterDiscount_amount,
                        'currency_id' => $bill->currency_id,
                        'create_by'=> CRUDBooster::myId()

                    ]);
                    if($bill->credit != NULL){  //في حال كانت عملية مردود مبيع كاش لزبون  ليس له حساب
                        DB::table('entries')->insert([
                            'entry_base_id' => $entry_base_id,
                            'debit' => $bill->discount,
                            'account_id' => $bill->credit,
                            'credit' => null,
                            'ex_rate' => $bill->ex_rate,
                            'equalizer' => (int)$bill->ex_rate * (int)$afterDiscount_amount,
                            'currency_id' => $bill->currency_id,
                            'create_by'=> CRUDBooster::myId()

                        ]);
                    }
                }


               

                $max = DB::table('item_tracking')->where('delete_by',0)->where('rotate_year',NULL)->max('code');
                $Bills_items = DB::table("bill_item")->where("bill_id", $id)->get();
                $bill = DB::table("bills")->find($id);

                $opr = "";
                if ($bill->bill_type_id == 1) {
                    $opr = "in";
                } else if ($bill->bill_type_id == 2) {
                    $opr = "out";
                } else if ($bill->bill_type_id == 3) {
                    $opr = "out";
                } else if ($bill->bill_type_id == 4) {
                    $opr = "in";
                }

                $prefixCode = DB::table('inventory_type_id')->where('id', 4)->select('prefix')->first();
                $prefix = $prefixCode->prefix . '' . ($max + 1);

                // dd($Bills_items);
                foreach ($Bills_items as $key => $item) {
                    DB::table('item_tracking')->insert([
                        'code' => $max +1 ,
                        'item_id' => $item->item_id,
                        'inventory_id_type_id' => $bill->bill_type_id,
                        'source' => $bill->inventory_id,
                        'date' => $bill->date,
                        'quantity' => $item->quantity,
                        'bill_id' => $bill->id,
                        'note' => $bill->note,
                        'transaction_operation' => $opr,
                        'p_code' => $prefix,
                        'create_by'=> CRUDBooster::myId()

                    ]);
                }


                DB::commit();

            } catch (\Exception $e) {
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
        public function hook_before_delete($id)
        {
            $this->deleteBill($id);

            return CRUDBooster::redirect($_SERVER['HTTP_REFERER'], "تم حذف الفاتورة بنجاح.", "success");

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

        public function getCustomers()
        {
            $query = '';
            $id = CRUDBooster::myId();

            $me = DB::table('cms_users')->find($id);

            if ($me->id_cms_privileges == 4) {
                $query = 'and delegate_id = ' . $me->id;

            }


            return $query;
        }

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

       
        public function getEdit($id)
        {

            $bill = DB::table('bills')->find($id);
            if (!CRUDBooster::isSuperAdmin() && $bill->checked_for_update == 1) {
                return CRUDBooster::redirect($_SERVER['HTTP_REFERER'], "أنت لا تملك صلاحية التعديل على هذه الفاتورة !!", "warning");

            }
            return parent::getEdit($id); // TODO: Change the autogenerated stub
        }

      

        
        
        public function getPersons()
        {

            $accountsIds = [];
            $id = CRUDBooster::myId();

            $me = DB::table('cms_users')->find($id);

            if ($me->id_cms_privileges == 4) {
                $persons = DB::table('persons')->where('person_type_id', 1)->where('delegate_id', $me->id)->select('account_id')->get();
            } else {
                $persons = DB::table('persons')->where('person_type_id', 1)->select('account_id')->get();
            }

            foreach ($persons as $person) {
                array_push($accountsIds, $person->account_id);
            }
            if(count($accountsIds) <= 0){
                array_push($accountsIds, 0);
            }
            return $accountsIds;


        }

    }