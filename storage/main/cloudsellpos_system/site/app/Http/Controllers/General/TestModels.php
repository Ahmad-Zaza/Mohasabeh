<?php
namespace App\Http\Controllers\General;
use App\Models\Accounts\Account;
use App\Models\Bills\BillItem;
use App\Models\Bills\BillType;
use App\Models\Bills\Bill;
use App\Models\Vouchers\InitialVouchersList;
use App\Models\Vouchers\VoucherFile;
use Illuminate\Support\Facades\DB;
use App\Models\Bills\BillFile;
use App\Models\Items\Item;
use App\Models\Items\ItemCategory;
use App\Models\Items\ItemUnit;
use App\Models\Vouchers\Voucher;
use App\Models\Vouchers\VoucherType;
use App\Models\ItemsTracking\ItemTrackingType;
use App\Models\ItemsTracking\ItemTracking;
use App\Models\Inventories\Inventory;
use App\Models\Users\Delegate;
use App\Models\Accounts\Supplier;
use App\Models\Accounts\Customer;
use App\Models\Accounts\Person;
use App\Models\Currencies\Currency;
use App\Models\Entries\Entry;
use App\Models\Entries\EntryBase;
use App\Models\Inventories\BeginningTracking;
use App\Models\Inventories\TransferTracking;
use App\Models\SystemConfigration\SystemConfig;
use App\Models\SystemConfigration\PackageConfig;
use App\Models\RotateData\RotateDataResult;
use App\Models\SystemConfigration\StatisticSetting;
use App\Models\Accounts\ClosingAccountType;
use Storage;


class TestModels{

    public function test(){
        //$bill_types = BillType::get();
        
        ######### bills - bill_types - bills_items - bill_files #######
        //$bill_type = BillType::first();
        //$bills = $bill_type->bills;

        //$bill = Bill::first();
        //$bill_type = $bill->billType;
        //dd(collect($bill));

        //$bills = BillType::find(1)->bills()->where('inventory_id',3)->get();
        //return $bills;


        /*
        $bills = Bill::with(['billType' => function($q){
            return $q->select('id','name_ar'); //forign key must be in select feilds
        }])->get();
        return $bills;
        */

        //$b = DB::table('bills')->where('id',1)->first();
        //return response()->json($b);
        
        //$bill = BillFile::first()->bill;
        
        

        //$bill = Bill::with('files')->get();
        //dd($bill);

        //$bill = Bill::with('items')->first();
        //dd($bill->items); 
        //return $bill->items;

        //$item = Item::with('bills')->first();
        //return $item;

         
        //$cat = ItemCategory::get();
        //return $cat[1]->items;
        

        // $unit = ItemUnit::get();
        // return $unit[0]->items;

        //$voucher = Voucher::with(['delegate','debit_account','credit_account','staff'])->find('87');
        //return $voucher->type;
        //return $voucher->files;
        //return $voucher->delegate;
        //return $voucher;

        // $vtype = VoucherType::first();
        // return $vtype->vouchers;


        // $bill = Bill::first();
        // return $bill->itemsTracking;

        //$tracking_type = ItemTrackingType::first();
        //return $tracking_type->items_tracking;


        //$itemTracking = ItemTracking::first();
        //return $itemTracking->type;

        // $itemTracking = ItemTracking::first();
        // return $itemTracking->source_inventory;


        // $itemTracking = ItemTracking::first();
        // return $itemTracking->item;

        //$item = Item::find(2);
        //return $item->item_tracking;

        //$inv = Inventory::with('delegates')->find(6);
        //return $inv;
         
        //$dels = Delegate::with('inventories')->find(2);
        //return $dels;

        //$dels = Delegate::with('suppliers')->find(2);
        //return $dels;

        // $dels = Delegate::with('customers')->find(2);
        // return $dels;


        //$sups = Supplier::get();
        //return $sups;

        // $sups = Supplier::with('delegates')->get();
        // return $sups;


        // $customers = Customer::with('delegate')->get();
        // return $customers;

        // $persons = Person::with('type')->get();
        // return $persons;

        // $currencies = Currency::with('history')->get();
        // return $currencies;

        // $currencies = Currency::with('account')->get();
        // return $currencies;

        // $entry = Entry::with(['account','currency','base'])->first();
        // return $entry;

        // $entry_base = EntryBase::with('entries')->first();
        // return $entry_base;


        //$ib_track = BeginningTracking::with('items_list')->first();
        //return $ib_track->items_list[0]->item_track;

        
        // $t_track = TransferTracking::with('items_list')->first();
        // return $t_track->items_list[0]->item_track;

        // $configs = SystemConfig::get();
        // return $configs;
        
        // $configs = PackageConfig::get();
        // return $configs;

        //$configs = RotateDataResult::get();
        //return $configs;

        // $configs = StatisticSetting::get();
        // return $configs;

        // $configs = ClosingAccountType::get();
        //  return $configs;


        //$bill = Bill::with('items')->first();
        //return $bill;

        //$gfunc = new GeneralFunctionsController();
        //return $gfunc->getItemsIds();

        //for test
        // $customers = Delegate::query()->with(['customers'=> function ($q){
        //     $q->select('id','name_ar','delegate_id');
        // }])->where('id',4)->first();
        //return $customers;
        
        //$bfunc = new BillsFunctionsController();
        //return $bfunc->checkInventoryItem(4,1,600);

        //$voucher = Voucher::find(15);
        //return $voucher->entries->where('account_id',21)->first();


    }

/*
    public function fixOldEditedBillsAndVouchers(){
        $edited_bills = Bill::where('action','edit')->get();
        //return $edited_bills;
        $edited_bills->each(function($bill){
            if($bill->edit_by == 0){
                $bill->update([
                    "edit_by"=>$bill->delete_by,
                    "edit_at"=>$bill->delete_at
                ]);

                Bill::where('p_code',$bill->p_code)->where('edit_by',0)->update([
                    "edit_by"=>$bill->delete_by,
                    "edit_at"=>$bill->delete_at
                ]);
            }
            
            $entry_base = EntryBase::where('bill_id',$bill->id)->first();
            if($entry_base->edit_by == 0){
                $entry_base->update([
                    "edit_by"=>$bill->delete_by,
                    "edit_at"=>$bill->delete_at
                ]);
            }
            $entries = Entry::where('entry_base_id',$entry_base->id)->get();
            foreach($entries as $entry){
                if($entry->edit_by == 0){
                    $entry->update([
                        "edit_by"=>$bill->delete_by,
                        "edit_at"=>$bill->delete_at
                    ]);
                }
            }
            
            $item_tracking = ItemTracking::where('bill_id',$bill->id)->get();
           foreach($item_tracking as $t){
                if($t->edit_by == 0){
                    $t->update([
                        "edit_by"=>$bill->delete_by,
                        "edit_at"=>$bill->delete_at
                    ]);
                }
            }
            
        });

        $edited_vouchers = Voucher::where('action','edit')->get();
        //return $edited_vouchers;
        $edited_vouchers->each(function($voucher){
            
            if($voucher->edit_by == 0){
                $voucher->update([
                    "edit_by"=>$voucher->delete_by,
                    "edit_at"=>$voucher->delete_at
                ]);

                Voucher::where('p_code',$voucher->p_code)->where('edit_by',0)->update([
                    "edit_by"=>$voucher->delete_by,
                    "edit_at"=>$voucher->delete_at
                ]);
            }
            
            $entry_base = EntryBase::where('voucher_id',$voucher->id)->first();
            if($entry_base->edit_by == 0){
                $entry_base->update([
                    "edit_by"=>$voucher->delete_by,
                    "edit_at"=>$voucher->delete_at
                ]);
            }
            $entries = Entry::where('entry_base_id',$entry_base->id)->get();
            foreach($entries as $entry){
                if($entry->edit_by == 0){
                    $entry->update([
                        "edit_by"=>$voucher->delete_by,
                        "edit_at"=>$voucher->delete_at
                    ]);
                }
            }
        
        });
        return "Fixed Old Edited Bills And Vouchers Done.";
    }


    public function fixedEditedDeletedActionOldData(){
        
        $edited_bills = Bill::where('action','edit')->get();
        //return $edited_bills;
        $edited_bills->each(function($bill){
            if($bill->edit_by != 0){
                $bill->update([
                    "delete_by"=>0,
                    "delete_at"=>NULL
                ]);
            }
            
            $entry_base = EntryBase::where('bill_id',$bill->id)->first();
            if($entry_base->edit_by != 0){
                $entry_base->update([
                    "delete_by"=>0,
                    "delete_at"=>NULL,
                    "action"=>"edit"
                ]);
            }
            $entries = Entry::where('entry_base_id',$entry_base->id)->get();
            foreach($entries as $entry){
                if($entry->edit_by != 0 ){
                    $entry->update([
                        "delete_by"=>0,
                        "delete_at"=>NULL,
                        "action"=>"edit"
                    ]);
                }
            }
            
            $item_tracking = ItemTracking::where('bill_id',$bill->id)->get();
           foreach($item_tracking as $t){
                if($t->edit_by != 0){
                    $t->update([
                        "delete_by"=>0,
                        "delete_at"=>NULL
                    ]);
                }
            }    
        });

        $deleted_bills = Bill::where('action','delete')->get();
        //return $deleted_bills;
        $deleted_bills->each(function($bill){
            $entry_base = EntryBase::where('bill_id',$bill->id)->first();
            if($entry_base->delete_by != 0){
                $entry_base->update([
                    "action"=>"delete"
                ]);
            }
            $entries = Entry::where('entry_base_id',$entry_base->id)->get();
            foreach($entries as $entry){
                if($entry->delete_by != 0 ){
                    $entry->update([
                        "action"=>"delete"
                    ]);
                }
            }   
        });


        //fix edit and delete vouchers here
        $edited_vouchers = Voucher::where('action','edit')->get();
        //return $edited_vouchers;
        $edited_vouchers->each(function($voucher){
            if($voucher->delete_by != 0){
                $voucher->update([
                    "delete_by"=>0,
                    "delete_at"=>NULL
                ]);
            }
            
            $entry_base = EntryBase::where('voucher_id',$voucher->id)->first();
            if($entry_base->delete_by != 0){
                $entry_base->update([
                    "delete_by"=>0,
                    "delete_at"=>NULL,
                    "action"=>"edit"
                ]);
            }
            $entries = Entry::where('entry_base_id',$entry_base->id)->get();
            foreach($entries as $entry){
                if($entry->delete_by != 0){
                    $entry->update([
                        "delete_by"=>0,
                        "delete_at"=>NULL,
                        "action"=>"edit"
                    ]);
                }
            }
        });

        $deleted_vouchers = Voucher::where('action','delete')->get();
        //return $deleted_vouchers;
        $deleted_vouchers->each(function($voucher){ 
            $entry_base = EntryBase::where('voucher_id',$voucher->id)->first();
            if($entry_base->delete_by != 0){
                $entry_base->update([
                    "action"=>"delete"
                ]);
            }
            $entries = Entry::where('entry_base_id',$entry_base->id)->get();
            foreach($entries as $entry){
                if($entry->delete_by != 0){
                    $entry->update([
                        "action"=>"delete"
                    ]);
                }
            }
        });

        return "Fixed Old Edited Bills And Vouchers Done. And Fill entry_base And entries Action Field with correct value";
    }
*/

/*
    public function fixAllDeletedRecords()
    {
        //fix bills
        Bill::where('delete_by', '<>', 0)->update([
            'action' => 'delete'
        ]); 
        //fix Vouchers 
        Voucher::where('delete_by', '<>', 0)->update([
            'action' => 'delete'
        ]);
        //fix item_tracking
        ItemTracking::where('delete_by', '<>', 0)->update([
            'action' => 'delete'
        ]);
        //fix entry_base
        EntryBase::where('delete_by', '<>', 0)->update([
            'action' => 'delete'
        ]);
        //fix entries
        Entry::where('delete_by', '<>', 0)->update([
            'action' => 'delete'
        ]);

        return "fix All Deleted Records";
    }
    public function deleteAllEditedDeletedRecords()
    {
        //delete bills & bills_files & bills_items
        $bills = Bill::where('action','<>',NULL)->get();
        $bills->each(function ($bill) {
            BillFile::where('bill_id', $bill->id)->delete();
            BillItem::where('bill_id', $bill->id)->delete();

            $entry_base = EntryBase::where('bill_id', $bill->id)->first();
            Entry::where('entry_base_id', $entry_base->id)->delete();
            $entry_base->delete();

            ItemTracking::where('bill_id', $bill->id)->delete();

            $bill->delete();
        });
        
        //delete Vouchers & vouchers_files
        $vouchers = Voucher::where('action','<>',NULL)->get();
        $vouchers->each(function ($voucher) {
            VoucherFile::where('voucher_id', $voucher->id)->delete();

            $entry_base = EntryBase::where('voucher_id',$voucher->id)->first();            
            Entry::where('entry_base_id',$entry_base->id)->delete();
            $entry_base->delete();            

            $voucher->delete();    
        });

        //delete item_tracking
        ItemTracking::where('action','<>',NULL)->delete();
        //delete entry_base & entries
        EntryBase::where('action','<>',NULL)->delete();
        Entry::where('action','<>',NULL)->delete();
        
        return "delete All Edited & Deleted Records";
    }

    public function fixEditedFieldsForBillsAndVouchers()
    {
        Bill::where('action',NULL)->update([
            "edit_by"=>0,
            "edit_at"=>NULL
        ]);
         
        Voucher::where('action',NULL)->update([
            "edit_by"=>0,
            "edit_at"=>NULL
        ]); 
        
        return "fix Edited Fields For Bills And Vouchers";
    }
*/

/*
    public function fixInitialVouchersList()
    {
        $iv_list = InitialVouchersList::get();
        $problems_count = 0;
        $problems_vouchers_p_code_arr = array();
        $problems_accounts_arr = array();
        
        foreach($iv_list as $rec){
            $voucher = Voucher::where('p_code', $rec->p_code)->first();
            $entry_base = EntryBase::where('voucher_id', $voucher->id)->first();
            $iv_entry = Entry::where('entry_base_id', $entry_base->id)->first();
            
            if ($iv_entry->currency_id != $rec->currency_id) {
                $problems_count++;
                array_push($problems_vouchers_p_code_arr, $rec);
                $account = Account::select('id','name_ar')->where('id', $rec->account_id)->first();
                array_push($problems_accounts_arr,$account);
                
                 $iv_entry->update([
                     'currency_id'=>$rec->currency_id
                 ]);
            }
        }
        //return $problems_vouchers_p_code_arr;
        return "Initial Vouchers are Fixed";
    }
    */

}