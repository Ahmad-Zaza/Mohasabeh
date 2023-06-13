<?php
namespace App\Http\Controllers\General;
use App\Models\Bills\Bill;
use App\Models\Bills\BillItem;
use App\Models\Inventories\Inventory;
use App\Models\Items\Item;
use App\Models\ItemsTracking\ItemTracking;
use App\Models\Users\Delegate;
use App\Models\Users\GeneralDelegate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use CRUDBooster;
use App\Models\Users\User;
use Session;

class BillsFunctionsController extends Controller{

    
    public function getInventoryByDelegate($id)
    {

        if ($id == '-1') {
            $inventories_for_delegate = Inventory::select('id', 'name_ar')->where('major_classification', 0)->get();
        }
        else {
            $inventories_for_delegate=GeneralDelegate::find($id)->inventories->makeHidden(['name_en','note','pivot','active','sorting']);
        }

        return response()->json($inventories_for_delegate);
    }



    public function getPriceById($id)
    {
        $itemId = Item::find($id);
        return response()->json($itemId);
    }
    
   
    //جلب أخر سعر مبيع  لزبون معين
    public function getItemPriceByIdForCustomer($currency, $id, $customer = 0)
    {
        if ($customer == 0) {
            $item = Item::select('id', 'price')->find($id);
            return response()->json($item);
        }
        else {
            $conditions = array(['bills.action', '=', NULL]);
            $item = BillItem::select('items.id as id', 'bills_items.unit_price as price', 'bills.date as date')
                ->join('items', 'items.id', 'bills_items.item_id')
                ->join('bills', 'bills.id', 'bills_items.bill_id')
                ->where($conditions)
                ->where('bills_items.item_id', $id)
                ->where('bills.currency_id', $currency)
                ->where('bills.debit', $customer)
                ->where('bills.bill_type_id', 2)->orderby('bills.date', 'desc')->first();

            if ($item) {
                return response()->json($item);
            }
            else {
                $item = Item::select('id', 'price')->find($id);
                return response()->json($item);
            }

        }
    }
    
        //جلب أخر سعر شراء من مورد
        public function getItemPriceByIdForSupplier($currency, $id, $suplier = 0)
        {
            if ($suplier == 0) {
                $item = Item::select('id', 'price')->find($id);
                return response()->json($item);
            }
            else {
                $conditions = array(['bills.action', '=', NULL]);
                $item = BillItem::select('items.id as id', 'bills_items.unit_price as price', 'bills.date as date')
                    ->join('items', 'items.id', 'bills_items.item_id')
                    ->join('bills', 'bills.id', 'bills_items.bill_id')
                    ->where($conditions)
                    ->where('bills_items.item_id', $id)
                    ->where('bills.currency_id', $currency)
                    ->where('bills.credit', $suplier)
                    ->where('bills.bill_type_id', 1)->orderby('bills.date', 'desc')->first();
    
                if ($item) {
                    return response()->json($item);
                }
                else {
                    $item = Item::select('id', 'price')->find($id);
                    return response()->json($item);
                }
    
            }
        }
    
    
        public function getItems()
        {
    
            $user = CRUDBooster::getUser();
            if (in_array($user->roleId,explode(',',config('setting.DELEGATES_ROLES_IDS')))) {
                $items = Item::where('visible_to_delegates', 1)->get();
            }
            else {
                $items = Item::get();
            }
    
            return $items;
        }

        public function getInventoryItems($id,$editID = 0)
        {
           
            $date = Carbon::now();
            $query = DB::table("item_tracking as t0")
                ->select("t0.item_id as itemId", 't0.id as record_id', 'items.name_ar as nameAr', 'items.p_code as pCode', 'source.name_ar as sourceInventory',
                DB::raw("(SELECT SUM(t1.quantity) FROM item_tracking as t1
                                    WHERE t1.transaction_operation = 'in' 
                                    and t1.action is NULL 
                                    and t1.cycle_id = ".Session::get('display_cycle')."  
                                    and t1.status = 1 
                                    and t1.item_id = t0.item_id 
                                    and t0.source = t1.source
                                    and t1.date <= '" . ($date) . "') as item_in "),
                DB::raw("(SELECT SUM(t2.quantity) FROM item_tracking as t2
                                   WHERE t2.transaction_operation = 'out'
                                    and t2.action is NULL 
                                    and t2.cycle_id = ".Session::get('display_cycle')."   
                                    and t0.status = 1
                                    and t0.item_id = t2.item_id 
                                    and t0.source = t2.source) as item_out"))
                ->join("items", "items.id", "t0.item_id")
                ->leftjoin("inventories as source", "t0.source", "source.id")->where('t0.date', '<=', $date)
    
                ->GROUPby('itemId', 't0.source');
    
            $query->where('t0.source', $id);
            $query->where('t0.status', 1);
            $query->where('t0.action', NULL);
            $query->where('t0.cycle_id', Session::get('display_cycle'));
           
            $items = $query->get();
            //return $items;
            if($editID != 0){
                $bill_items_qty = BillItem::select(DB::raw("sum(quantity) as item_qty"),'item_id')
                ->where('bill_id',$editID)
                ->GROUPby('item_id')->pluck('item_qty','item_id');
                $items->each(function($item) use($bill_items_qty){
                    $item_qty_in_bill = ($bill_items_qty["$item->itemId"])?$bill_items_qty["$item->itemId"]:0;
                    $item->item_out = $item->item_out - $item_qty_in_bill;
                    $item->qty_in_bill = $item_qty_in_bill;
                });
            }else{ 
                $items->each(function($item){
                    $item->qty_in_bill = 0;
                });
            }
            
            return $items;
        }

        
    public function checkInventoryItem($inventory, $id, $request_qty)
    {
        //check if inventory has all item amount
       $in_out_res = ItemTracking::select(DB::raw("sum(quantity) as counters"),'transaction_operation')
                            ->where([['item_id','=',$id],['source','=',$inventory],['action','=',NULL]])
                            ->GROUPby('transaction_operation')->get();  
        $income = 0;
        $outcome = 0;
        foreach ($in_out_res as $res) {
            if ($res->transaction_operation == 'in') {
                $income = $res->counters;
            }
            if ($res->transaction_operation == 'out') {
                $outcome = $res->counters;
            }
        }

        if ($income < ($outcome + $request_qty)) {
            return trans('messages.inventory_doesnot_have_all_quantity');
        }
    }

    public function getDelegateInventories($delegate_id){
        $inventories = [];
        if($delegate_id != 0){ //no choose delegate
            $delegate = GeneralDelegate::find($delegate_id);
            if($delegate->id_cms_privileges == 3){ //sales manager
                $inventories = Inventory::where('major_classification',0)->get();
            }else{ //delegate & factory delegate
                $inventories = $delegate->inventories;
            }
        }else{
            $inventories = Inventory::where('major_classification',0)->get();
        }
        return $inventories;
    }

}