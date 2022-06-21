<?php
namespace App\Traits;

use DB;
use CRUDBooster;
use Request;

Trait GeneralTrait{
    
    //make copy from bill before edit and change all transaction (item,money) to new copy
    public function makeBillAsDeleted($id){ 

        $bill = DB::table("bills")->find($id);
        $delete_bill = collect($bill);
        $delete_bill->forget('id');

        
        $delete_bill->put('delete_at',date('Y-m-d H:i:s'));
        $delete_bill->put('delete_by',CRUDBooster::myId());
        $delete_bill->put('delete_action','edit');
        //dd($delete_bill);
        $delete_bill_id = DB::table("bills")->insertGetId($delete_bill->all());
        //dd($delete_bill_id);

        DB::table("bills_files")->where("bill_id",$id)->update([
            "bill_id"=>$delete_bill_id
        ]);

        DB::table("bill_item")->where("bill_id",$id)->update([
            "bill_id"=>$delete_bill_id
        ]);

        $base = DB::table("entry_base")->where("bill_id", $id)->get();
        foreach ($base as $item) {
            DB::table("entry_base")->where("id",$item->id)->update([
                "bill_id"=>$delete_bill_id,
                "delete_at"=>date('Y-m-d H:i:s'),
                "delete_by"=>CRUDBooster::myId()
            ]);

            DB::table("entries")->where("entry_base_id",$item->id)->update([
                //update delete_at, delete_by
                "delete_at"=>date('Y-m-d H:i:s'),
                "delete_by"=>CRUDBooster::myId()
            ]);
        }
       
        $tracking_records = DB::table("item_tracking")->where("bill_id", $id)->get();
        foreach ($tracking_records as $item) {
            DB::table("item_tracking")->where("id",$item->id)->update([
                "bill_id"=>$delete_bill_id,
                "delete_at"=>date('Y-m-d H:i:s'),
                "delete_by"=>CRUDBooster::myId(),
                "delete_action"=>"edit"
            ]);
        }
    }


    public function deleteBill($id){ 

        $bill = DB::table("bills")->find($id);
        $delete_bill = collect($bill);
       
        
        
        //dd($delete_bill);
        DB::table("bills")->where('id',$id)->update([
            'delete_by' => CRUDBooster::myId(),
            'delete_at' => date('Y-m-d H:i:s'),
            'delete_action' => 'delete',
        ]);
        //dd($delete_bill_id);

        $base = DB::table("entry_base")->where("bill_id", $id)->get();
        foreach ($base as $item) {
            DB::table("entry_base")->where("id",$item->id)->update([
                "delete_at"=>date('Y-m-d H:i:s'),
                "delete_by"=>CRUDBooster::myId()
            ]);

            DB::table("entries")->where("entry_base_id",$item->id)->update([
                //update delete_at, delete_by
                "delete_at"=>date('Y-m-d H:i:s'),
                "delete_by"=>CRUDBooster::myId()
            ]);
        }
       
        $tracking_records = DB::table("item_tracking")->where("bill_id", $id)->get();
        foreach ($tracking_records as $item) {
            DB::table("item_tracking")->where("id",$item->id)->update([
                "delete_at"=>date('Y-m-d H:i:s'),
                "delete_by"=>CRUDBooster::myId(),
                'delete_action' => 'delete'
            ]);
        }
    }

    
//make copy from Voucher before edit and change all transaction (item,money) to new copy
public function makeVoucherAsDeleted($id){ 

    $voucher = DB::table("vouchers")->find($id);
    $delete_voucher = collect($voucher);
    $delete_voucher->forget('id');

    
    
    $delete_voucher->put('delete_at',date('Y-m-d H:i:s'));
    $delete_voucher->put('delete_by',CRUDBooster::myId());
    $delete_voucher->put('delete_action','edit');
    //dd($delete_voucher);
    $delete_voucher_id = DB::table("vouchers")->insertGetId($delete_voucher->all());
    //dd($delete_voucher_id);

    DB::table("files_vouchers")->where("voucher_id",$id)->update([
        "voucher_id"=>$delete_voucher_id
    ]);


    $base = DB::table("entry_base")->where("voucher_id", $id)->get();
    foreach ($base as $item) {
        DB::table("entry_base")->where("id",$item->id)->update([
            "voucher_id"=>$delete_voucher_id,
            "delete_at"=>date('Y-m-d H:i:s'),
            "delete_by"=>CRUDBooster::myId()
        ]);

        DB::table("entries")->where("entry_base_id",$item->id)->update([
            //update delete_at, delete_by
            "delete_at"=>date('Y-m-d H:i:s'),
            "delete_by"=>CRUDBooster::myId()
        ]);
    }
   
}


  public function deleteVoucher($id){ 

        $voucher = DB::table("vouchers")->find($id);
        $delete_voucher = collect($voucher);
        
        //dd($delete_voucher);
        DB::table("vouchers")->where('id',$id)->update([
            'delete_by' => CRUDBooster::myId(),
            'delete_at' => date('Y-m-d H:i:s'),
            'delete_action' => 'delete',
        ]);
     

        $base = DB::table("entry_base")->where("voucher_id", $id)->get();
        foreach ($base as $item) {
            DB::table("entry_base")->where("id",$item->id)->update([
                "delete_at"=>date('Y-m-d H:i:s'),
                "delete_by"=>CRUDBooster::myId()
            ]);

            DB::table("entries")->where("entry_base_id",$item->id)->update([
                //update delete_at, delete_by
                "delete_at"=>date('Y-m-d H:i:s'),
                "delete_by"=>CRUDBooster::myId()
            ]);
        }
       
    }

    //make copy from Transfer Order before edit and make its deleted
    public function makeTransferOrderAsDeleted($id){ 

        $record = DB::table('item_tracking')->where('id',$id)->first();
        //dd($record);

        DB::table('item_tracking')->insert(
            ['code' => $record->code,
            'item_id' =>  $record->item_id,
            'source'=> $record->source,
            'destination'=>$record->destination,
            'date'=>$record->date,
            'quantity'=>$record->quantity,
            'inventory_id_type_id'=>6,
            'transaction_operation'=> 'out',
            'p_code' =>$record->p_code,
            'create_by'=>$record->create_by,
            'create_at'=>$record->create_at,
            "delete_at"=>date('Y-m-d H:i:s'),
            "delete_by"=>CRUDBooster::myId(),
            'delete_action'=>'edit',
            ]
        );

        DB::table('item_tracking')->insert(
            ['code' => $record->code, 'item_id' => $record->item_id,'source'=>$record->destination
                ,'date'=>$record->date,'quantity'=>$record->quantity,'inventory_id_type_id'=>6,
                'transaction_operation'=> 'in','p_code' =>$record->p_code,
                'create_by'=>$record->create_by,
                'create_at'=>$record->create_at,
                "delete_at"=>date('Y-m-d H:i:s'),
                "delete_by"=>CRUDBooster::myId(),
                'delete_action'=>'edit'
            ]
        );

    }

    public function makeInventoryBeginningAsDeleted($id){

        $record = DB::table('item_tracking')->where('id',$id)->first();
        //dd($record);
        DB::table('item_tracking')->insert(
            ['code' => $record->code,
            'item_id' =>  $record->item_id,
            'source'=> $record->source,
            'destination'=>$record->destination,
            'date'=>$record->date,
            'quantity'=>$record->quantity,
            'note'=>$record->note,
            'inventory_id_type_id'=>5,
            'transaction_operation'=> 'in',
            'p_code' =>$record->p_code,
            'create_by'=>$record->create_by,
            'create_at'=>$record->create_at,
            "delete_at"=>date('Y-m-d H:i:s'),
            "delete_by"=>CRUDBooster::myId(),
            'delete_action'=>'edit',
            ]
        );
    }

    public function deleteInventoryBeginning($id){
        DB::table("item_tracking")->where("id",$id)->update([
            "delete_at"=>date('Y-m-d H:i:s'),
            "delete_by"=>CRUDBooster::myId(),
            "delete_action"=>'delete',
        ]);
    }

    public function checkInventoryItemQty($inventory,$id,$request_qty){
        //check if inventory has all item amount
        //select form data base here
            $sql = "SELECT sum(quantity) as counters, transaction_operation FROM `item_tracking` 
                    WHERE item_id = $id and item_tracking.source = $inventory and delete_by = 0 and rotate_year is NULL
                    GROUP BY transaction_operation";
            $in_out_res=DB::select($sql);

            $income = 0;
            $outcome = 0;
            foreach($in_out_res as $res){
                if($res->transaction_operation== 'in'){
                    $income = $res->counters;
                }
                if($res->transaction_operation == 'out'){
                    $outcome = $res->counters;
                }
            }

            if($income < ($outcome + $request_qty)){
                return false;
            }else{
                return true; 
            }
           
        }
   
        public function checkBoxHasAmount($currency_id,$amount)
        {
            $me = DB::table('cms_users')->find(CRUDBooster::myId());
            if ($me->id_cms_privileges == 4)
            {
                $sql = "select (IFNULL(sum(entries.debit), 0)-IFNULL(sum(entries.credit), 0)) as q 
			 from entries , entry_base , accounts , currencies WHERE  
			 accounts.id=entries.account_id and accounts.id = ".$me->account_id."
			 AND entry_base.id=entries.entry_base_id 
			 AND currencies.id=entries.currency_id and entries.account_id= ".$me->account_id."
			 AND entries.currency_id=" . (int)$currency_id . "
			 AND entry_base.delete_by=0 AND entries.delete_by=0 And entries.rotate_year is NULL;
			";
            }
            else{
                if((int)$currency_id == '1')
                {

                    $sql = "select (IFNULL(sum(entries.debit), 0)-IFNULL(sum(entries.credit), 0)) as q 
			 from entries , entry_base , accounts , currencies WHERE  
			 accounts.id=entries.account_id and accounts.id = ".config('setting.Syrian_Pound_Box_Account')." 
			 AND entry_base.id=entries.entry_base_id 
			 AND currencies.id=entries.currency_id and entries.account_id=".config('setting.Syrian_Pound_Box_Account')."
			 AND entries.currency_id=" . (int)$currency_id . "
			 AND entry_base.delete_by=0 AND entries.delete_by=0 And entries.rotate_year is NULL;
			";
                }

                elseif((int)$currency_id == '2')
                {
                    $sql = "select (IFNULL(sum(entries.debit), 0)-IFNULL(sum(entries.credit), 0)) as q 
			 from entries , entry_base , accounts , currencies WHERE  
			 accounts.id=entries.account_id and accounts.id = ".config('setting.Dollar_Box_Account')." 
			 AND entry_base.id=entries.entry_base_id 
			 AND currencies.id=entries.currency_id and entries.account_id=".config('setting.Dollar_Box_Account')." 
			 AND entries.currency_id=" . (int)$currency_id . "
			 AND entry_base.delete_by=0 AND entries.delete_by=0 And entries.rotate_year is NULL;
			";
                }

                elseif((int)$currency_id == '3') {
                    $sql = "select (IFNULL(sum(entries.debit), 0)-IFNULL(sum(entries.credit), 0)) as q 
			 from entries , entry_base , accounts , currencies WHERE  
			 accounts.id=entries.account_id and accounts.id = ".config('setting.Euro_Box_Account')." 
			 AND entry_base.id=entries.entry_base_id 
			 AND currencies.id=entries.currency_id and entries.account_id=".config('setting.Euro_Box_Account')." 
			 AND entries.currency_id=" . (int)$currency_id . "
			 AND entry_base.delete_by=0 AND entries.delete_by=0 And entries.rotate_year is NULL;
			";
                }
            }



            $value = DB::select($sql);
          
            if ((int)$amount > (int)$value[0]->q) {
                return false;
            }else{
                return true;
            }


        }

    public function checkBill($postdata,$action,$id = '',$bill_type){
        $allRequestData = Request::all();
        //dd($postdata);
        $inv = $postdata['inventory_id'];
         //check if count of items in bill > 0 
         $itemsIds = $allRequestData['adafmad-item_id'];
         if( $itemsIds == null || ($itemsIds != null && count($itemsIds) < 0)){
             if($action == 'add'){
                return  CRUDBooster::redirect(CRUDBooster::mainpath("add/"),"رجاءا ادخل مواد ضمن الفاتورة","warning");
             }else{
                return  CRUDBooster::redirect(CRUDBooster::mainpath("edit/$id"),"رجاءا ادخل مواد ضمن الفاتورة","warning");
             }
             
         }
         //check if bill has inventory id
         if(  $inv == null){
            if($action == 'add'){
                return  CRUDBooster::redirect(CRUDBooster::mainpath("add/"),"يجب اختيار المستودع ضمن الفاتورة","warning");
            }else{
                return  CRUDBooster::redirect(CRUDBooster::mainpath("edit/$id"),"يجب اختيار المستودع ضمن الفاتورة","warning");
            }
            
         }

         if($bill_type == 2 || $bill_type == 3  ){ //تحقق من هذا الشرط في حال فاتورة مبيع و فاتورة مردود شراء
            //check if inventory doesn't have enough from item
            if($itemsIds != null && count($itemsIds) > 0){
                $itemsQty= $allRequestData['adafmad-quantity'];
                $itemsCount = count($itemsIds);
                $bool=true;
            
                for($i=0;$i<$itemsCount;$i++){
                    $b = $this->checkInventoryItemQty($inv,$itemsIds[$i],$itemsQty[$i]);
                    if($b==false){
                        $bool = false;
                    }
                }
            
                if($bool == false){ //أحدى مواد الفاتورة لايملك المستودع الكمية المطلوب منها
                    if($action == 'add'){
                        return  CRUDBooster::redirect(CRUDBooster::mainpath("add/"),"إحدى مواد الفاتورة لايملك المستودع الكمية المطلوبة منها","warning");
                    }else{
                        return  CRUDBooster::redirect(CRUDBooster::mainpath("edit/$id"),"إحدى مواد الفاتورة لايملك المستودع الكمية المطلوبة منها","warning");
                    }
                }


            }
        }
        
        if($bill_type == 1 || $bill_type == 4  ){ //تحقق من هذا الشرط في حال فاتورة شراء أو فاتورة مردود مبيع            
            if($postdata['is_cash'] == 1 ){
                //check if Box has all bill Amount
                $bool = $this->checkBoxHasAmount($postdata['currency_id'],$postdata['after_discount']);
                if(!$bool){
                    if($action == 'add'){
                        return  CRUDBooster::redirect(CRUDBooster::mainpath("add/"),"رصيد الصندوق لايملك قيمة الفاتورة","warning");
                    }else{
                        return  CRUDBooster::redirect(CRUDBooster::mainpath("edit/$id"),"رصيد الصندوق لايملك قيمة الفاتورة","warning");
                    }
                }
            }
        }
         
    }



    public function checkP_Code($p_code){
        $res = DB::table('bills')->where('p_code',$p_code)->where('delete_by',0)->where('rotate_year',NULL)->get();
        $bool = false;
        if(count($res) > 0){
            $bool = true;
        }
        if($bool){
            //in add operation 
            return  CRUDBooster::redirect(CRUDBooster::mainpath("add/"),"الحقل  (P_code) يجب أن يكون فريد","warning");
          
        }
    }

    public function checkVoucherP_Code($p_code){
        $res = DB::table('vouchers')->where('p_code',$p_code)->where('delete_by',0)->where('rotate_year',NULL)->get();
        $bool = false;
        if(count($res) > 0){
            $bool = true;
        }
        if($bool){
            //in add operation 
            return  CRUDBooster::redirect(CRUDBooster::mainpath("add/"),"الحقل  (P_code) يجب أن يكون فريد","warning");
          
        }
    }

    public function getExchangeRate($currencyId)
    {
        $currency = DB::table('currencies')->where('id',$currencyId)->first();
        return $currency;
    }

    public function changeExchangeRate($currency,$ex_rate){
        DB::table("currencies")->where("id",$currency)->update([
            "ex_rate"=>$ex_rate
        ]);
        DB::table('currency_history')->insert([
            'currency_id' => $currency,
            'ex_rate' => $ex_rate,
            'edit_by' => CRUDBooster::myId(),
        ]);
    }
}
