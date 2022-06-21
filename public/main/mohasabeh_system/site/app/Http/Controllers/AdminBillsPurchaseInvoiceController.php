<?php

namespace App\Http\Controllers;

use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Storage;
use Session;
use Illuminate\Http\Request;
use DB;
use CRUDBooster;

class AdminBillsPurchaseInvoiceController extends \crocodicstudio_voila\crudbooster\controllers\CBController
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
        $this->col[] = ["label" => "المورد", "name" => "credit", "join" => "accounts,name_ar"];
        $this->col[] = ["label" => "التاريخ", "name" => "date"];
        $this->col[] = ["label" => "نوع الوثيقة", "name" => "bill_type_id", "join" => "bill_type,name_ar"];
        $this->col[] = ["label" => "المستودع", "name" => "inventory_id", "join" => "inventories,name_ar"];
        $this->col[] = ["label" => "العملة", "name" => "currency_id", "join" => "currencies,name_ar"];
        $this->col[] = ["label" => "الموظف", "name" => "staff_id", "join" => "cms_users,name"];
        $this->col[] = ["label" => "", "name" => "checked_for_update", "visible" => false];

        # END COLUMNS DO NOT REMOVE THIS LINE

        # START FORM DO NOT REMOVE THIS LINE
        $this->form = [];
        $this->form[] = ['label' => 'رقم الوثيقة', 'name' => 'bill_number', 'type' => 'text', 'validation' => 'unique:bills', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'المورد', 'name' => 'credit', 'type' => 'select2', 'validation' => '', 'width' => 'col-sm-10', 'datatable' => 'accounts,name_ar', 'datatable_format' => "code,' - ',name_ar",'datatable_where' =>'id in ('.implode(',',$this->getPersons()).')'];
        $this->form[] = ['label' => 'المستودع', 'name' => 'inventory_id', 'type' => 'select2', 'validation' => 'required', 'width' => 'col-sm-10', 'datatable' => 'inventories,name_ar', 'datatable_where' => 'major_classification=0'];
        $this->form[] = ['label' => 'العملة', 'name' => 'currency_id', 'type' => 'select2', 'validation' => 'required', 'width' => 'col-sm-10', 'datatable' => 'currencies,name_ar'];
        $this->form[] = ['label' => 'سعر الصرف', 'name' => 'ex_rate', 'type' => 'number', 'step' => 'any', 'validation' => 'required|min:0', 'width' => 'col-sm-10', 'value' => 0];
        $this->form[] = ['label'=>'التاريخ','name'=>'date','type'=>'date','value'=>date('Y-m-d', time()),'validation'=>'required|date','width'=>'col-sm-10'];
        $this->form[] = ['label' => 'ملاحظات', 'name' => 'note', 'type' => 'textarea', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'نقدي', 'name' => 'is_cash', 'type' => 'radio', 'validation' => 'required', 'width' => 'col-sm-10', 'dataenum' => '1|نعم;0|لا','value'=>'0'];
        $this->form[] = ['label' => 'نوع الفاتورة', 'name' => 'bill_type_id', 'type' => 'text', 'validation' => 'required', 'width' => 'col-sm-10', 'style' => 'display:none', 'value' => '1'];

        $columns[] = ['label' => 'المادة', 'name' => 'item_id', 'type' => 'select', 'datatable' => 'items,name_ar', 'required' => true];
        $columns[] = ['label' => 'العدد', 'name' => 'quantity', 'type' => 'number', 'required' => true];
        $columns[] = ['label' => 'سعر الوحدة', 'name' => 'unit_price', 'type' => 'number', 'required' => true];
        $columns[] = ['label' => 'المجموع', 'name' => 'subtotal', 'type' => 'number', 'formula' => "[unit_price] * [quantity]", "readonly" => true, 'required' => true];

        $this->form[] = ['label' => 'اضافة مادة', 'name' => 'bill_item', 'type' => 'child', 'columns' => $columns, 'table' => 'bill_item', 'foreign_key' => 'bill_id'];
        $columnsFiles[] = ['label' => 'الصورة', 'name' => 'file_id', 'type' => 'upload' ,'required' => true];

        $this->form[] = ['label' => 'اضافة صورة', 'name' => 'bills_files', 'type' => 'child', 'columns' => $columnsFiles, 'table' => 'bills_files', 'foreign_key' => 'bill_id'];
        $this->form[] = ['label' => 'اجمالي الفاتورة', 'name' => 'amount', 'type' => 'number', "readonly" => true, 'required' => true];
        $this->form[] = ['label' => 'الحسم', 'name' => 'discount', 'type' => 'number','step'=>'any', 'required' => true,'value'=>0,'min'=>0];
        $this->form[] = ['label' => 'اجمالي الفاتورة بعد الحسم', 'name' => 'after_discount', 'type' => 'number','step'=>'any', "readonly" => true, 'required' => true];

        # END FORM DO NOT REMOVE THIS LINE

        # OLD START FORM
        //$this->form = [];
        //$this->form[] = ['label'=>'Document number','name'=>'bill_number','type'=>'number','validation'=>'required','width'=>'col-sm-10'];
        //$this->form[] = ['label'=>'Customer Name','name'=>'credit','type'=>'select2','validation'=>'required','width'=>'col-sm-10','datatable'=>'accounts,name_ar','datatable_where'=>'major_classification=0'];
        //$this->form[] = ['label'=>'Inventory','name'=>'inventory_id','type'=>'select2','validation'=>'required','width'=>'col-sm-10','datatable'=>'inventories,name_ar'];
        //$this->form[] = ['label'=>'Currency','name'=>'currency_id','type'=>'select2','validation'=>'required','width'=>'col-sm-10','datatable'=>'currencies,name_ar'];
        //$this->form[] = ['label'=>'Note','name'=>'note','type'=>'textarea','validation'=>'required','width'=>'col-sm-10'];
        //$this->form[] = ['label'=>'Cash','name'=>'is_cash','type'=>'radio','validation'=>'required','width'=>'col-sm-10','dataenum'=>'1|yes;0|no'];
        //$this->form[] = ['label'=>'bill_type_id','name'=>'bill_type_id','type'=>'text','validation'=>'required','width'=>'col-sm-10','style'=>'display:none','value'=>'1'];
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
        if(CRUDBooster::isSuperAdmin()) {
            $this->addaction[] = ['label'=>'','url'=>CRUDBooster::mainpath('set-status/true/[id]'),'icon'=>'fa fa-check','color'=>'success','title'=> 'تدقيق','showIf'=>"[checked_for_update] == '0'"];
            $this->addaction[] = ['label'=>'','url'=>CRUDBooster::mainpath('set-status/false/[id]'),'icon'=>'fa fa-ban','color'=>'warning','title'=> 'إلغاء التدقيق','showIf'=>"[checked_for_update] == '1'"];
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
        $this->script_js = "$('#adafmaditem_id').change(function(){
		    var id = $(this).val();
		$.get('/items/getPrice/'+id,function(res){
		console.log(res);
		
		$('#adafmadunit_price').val(res.price) 
		})
		})
		
		$(document).ready(function(){
		
//		document.getElementById('adafmaditem_id').options.length = 0;
		$('#adafmaditem_id')
    .find('option')
    .remove()
    .end()
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

                    var credit = $('#credit').val();
                    var is_cash= document.querySelector('input[name=is_cash]:checked').value;
                    if(credit == '' && is_cash == 0){
                        alert('تنبيه : في حال الدفع أجل يجب اختيار المورد ');
                    }

                    $('#adafmaditem_id').focus();
                
                })
                
           $('#discount').change(function(){
           		    var discount = $(this).val();
           		    var amount = $('#amount').val();
           		    $('#after_discount').val(amount - discount);       
           })
            
           $('#currency_id').change(function(){
            var  currency_id =   $(this).val();
            $('#ex_rate').attr('data-currency',currency_id);
            $.get('/currency/getEx_rate/'+currency_id,function(res1){
                $('#ex_rate').val(res1.ex_rate); 
            })
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

    public function getSetStatus($status,$id) {


        if ($status == 'true')
            $status = true;
        elseif ($status == 'false')
            $status = false;


        DB::table('bills')->where('id',$id)->update(['checked_for_update'=>$status]);

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

        $query = $query->where("bill_type_id", 1);
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
        $this->checkBill($postdata,'add',null,1);

       


        $max = DB::table('bills')->where("bill_type_id", 1)->where('delete_by',0)->where('rotate_year',NULL)->max('code');
        $prefixCode = DB::table('bill_type')->where('id', 1)->select('prefix')->first();
        $postdata["code"] = ($max) ? $max + 1 : 1;
        $postdata['p_code'] = $prefixCode->prefix . '' . $postdata['code'];

        //check if p_code is unique
        $this->checkP_Code($postdata['p_code']);

        $postdata["staff_id"] = CRUDBooster::myId();
        $account = DB::table("accounts")->where("id", "=", $this->getSystemConfigValue('Purchases_Account'))->first();
        $postdata["debit"] = $account->id;
//        $postdata["credit"] = $customerAccountId->account_id;

        //change ex_rate if is different
        $currency = $this->getExchangeRate($postdata['currency_id']);
        if($postdata['ex_rate'] != $currency->ex_rate){
            $this->changeExchangeRate($currency->id,$postdata['ex_rate']);
        }

        $postdata['equalizer'] = (int)$postdata['ex_rate'] * (int)$postdata['amount'];

        $postdata["bill_type_id"] = 1;
        if ($postdata["is_cash"] == 1) {


            $box_account_id = $this->getAccountByCurrency($postdata['currency_id']);
            if ($box_account_id) {
                $this->box = $box_account_id;
            }

        }

        if ($postdata["is_cash"] == 0 && $postdata["credit"] == null) { //check if debit not null if is_cash is 0
            return  CRUDBooster::redirect(CRUDBooster::mainpath("add/"),"  (المورد)لا يمكن اجراء فاتورة بدفع أجل و لم يتم تحديد حساب العميل","danger");
        }

        $postdata['create_by']=CRUDBooster::myId();
        
    }

    public $customerId;
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
            $bill_details = DB::table("bill_item")->where('bill_id', $bill->id)->sum('subtotal');
            $afterDiscount_amount = $bill->after_discount;
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
            if($bill->credit != NULL){  //في حال كانت عملية شراء كاش لمورد  ليس له حساب
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
                if($bill->credit != NULL){  //في حال كانت عملية شراء كاش لمورد  ليس له حساب
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
                if($bill->credit != NULL){  //في حال كانت عملية شراء كاش لمورد  ليس له حساب
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

            $prefixCode = DB::table('inventory_type_id')->where('id', 1)->select('prefix')->first();
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
         $this->checkBill($postdata,'edit',$id,1);

        $postdata["staff_id"] = CRUDBooster::myId();
        $account = DB::table("accounts")->where("id", "=", $this->getSystemConfigValue('Purchases_Account'))->first();
        $postdata["debit"] = $account->id;

        $postdata["bill_type_id"] = 1;
        if ($postdata["is_cash"] == 1) {
            $box_account_id = $this->getAccountByCurrency($postdata['currency_id']);
            if ($box_account_id)
                $this->editBox = $box_account_id;
        }

        if ($postdata["is_cash"] == 0 && $postdata["credit"] == null) { //check if debit not null if is_cash is 0
            return  CRUDBooster::redirect(CRUDBooster::mainpath("edit/".$id),"  (مورد)لا يمكن اجراء فاتورة بدفع أجل و لم يتم تحديد حساب العميل","danger");
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
            if($bill->credit != NULL){  //في حال كانت عملية شراء كاش لمورد  ليس له حساب
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


            if ($bill->is_cash) {

                DB::table('entries')->insert([
                    'entry_base_id' => $entry_base_id,
                    'credit' => $afterDiscount_amount,
                    'account_id' => $this->editBox,
                    'debit' => null,
                    'ex_rate' => $bill->ex_rate,
                    'equalizer' => (int)$bill->ex_rate * (int)$afterDiscount_amount,
                    'currency_id' => $bill->currency_id,
                    'create_by'=> CRUDBooster::myId()

                ]);
                if($bill->credit != NULL){  //في حال كانت عملية شراء كاش لمورد  ليس له حساب
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


            if($bill->discount > 0)
            {
                
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
                if($bill->credit != NULL){  //في حال كانت عملية شراء كاش لمورد  ليس له حساب
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
            $prefixCode = DB::table('inventory_type_id')->where('id', 1)->select('prefix')->first();
            $prefix = $prefixCode->prefix . '' . ($max + 1);

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

            // dd($Bills_items);
            foreach ($Bills_items as $key => $item) {
                DB::table('item_tracking')->insert([
                    'code' => $max +1,
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


    public function checkBox(Request $request)
    {
        $me = DB::table('cms_users')->find(CRUDBooster::myId());
        if ($me->id_cms_privileges == 4)
        {
            $sql = "select (IFNULL(sum(entries.debit), 0)-IFNULL(sum(entries.credit), 0)) as q 
			 from entries , entry_base , accounts , currencies WHERE  
			 accounts.id=entries.account_id and accounts.id = ".$me->account_id."
			 AND entry_base.id=entries.entry_base_id 
			 AND currencies.id=entries.currency_id and entries.account_id= ".$me->account_id."
			 AND entries.currency_id=" . (int)$request->input('currency') . "
             AND entry_base.delete_by=0 AND entries.delete_by=0 And entries.rotate_year is NULL;
			";
        }
        else{
            $box_account_id = $this->getAccountByCurrency($request->input('currency'));
            if($box_account_id)
            {
                $sql = "select (IFNULL(sum(entries.debit), 0)-IFNULL(sum(entries.credit), 0)) as q 
                    from entries , entry_base , accounts , currencies WHERE  
                    accounts.id=entries.account_id and accounts.id = $box_account_id 
                    AND entry_base.id=entries.entry_base_id 
                    AND currencies.id=entries.currency_id and entries.account_id=$box_account_id  
                    AND entries.currency_id=" . $request->input('currency') . "
                    AND entry_base.delete_by=0 AND entries.delete_by=0 And entries.rotate_year is NULL;
			        ";
            }
        }



        Storage::disk('local')->put('t.txt',$request);
        $value = DB::select($sql);

        if ((int)$request->input('sum') > ( int)$value[0]->q) {
            $data = Array("res" => false, "sum" => $value[0]->q);
            return response()->json($data);

        }

        $data = Array("res" => true, "sum" => $value[0]->q);

        return response()->json($data);


    }


    //By the way, you can still create your own method in here... :)

    public function getPriceById($id)
    {
        $itemId = DB::table('items')->find($id);
        return response()->json($itemId);
    }

    public function getItems()
    {
        $items = DB::table('items')->get();
        return $items;
    }

   
    public  function getEdit($id)
    {

        $bill = DB::table('bills')->find($id);
        if(!CRUDBooster::isSuperAdmin() && $bill->checked_for_update == 1)
        {
            return  CRUDBooster::redirect($_SERVER['HTTP_REFERER'],"أنت لا تملك صلاحية التعديل على هذه الفاتورة","warning");

        }

        return parent::getEdit($id); // TODO: Change the autogenerated stub
    }

    public function getDefaultCurrency()
    {
        $currency = DB::table('currencies')->where('is_major',1)->first();

        return $currency->id;
    }

  

    
    
    public function getPersons(){

        $accountsIds = [];
       $persons = DB::table('persons')->where('person_type_id',2)->select('account_id')->get();

       foreach ($persons as $person)
       {
            array_push($accountsIds,$person->account_id);
       }
       if($accountsIds == null)
        return  CRUDBooster::redirect($_SERVER['HTTP_REFERER'],"لا يمكنك الدخول إلى صفحة المشتريات حتى يكون لديك مورد واحد على الاقل","warning");

        return $accountsIds;


    }
}
