<?php
namespace App\Traits;

use DB;
use CRUDBooster;
use Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Users\User;
use App\Models\Bills\Bill;
use App\Models\Currencies\Currency;
use App\Models\Currencies\CurrencyHistory;
use App\Models\Entries\Entry;
use App\Models\Entries\EntryBase;
use App\Models\Vouchers\Voucher;
use App\Models\ItemsTracking\ItemTracking;
use App\Models\SystemConfigration\SystemConfig;
use App\Models\SystemConfigration\PackageConfig;
use App\Models\Bills\BillFile;
use App\Models\Vouchers\VoucherFile;
use App\Models\Bills\BillItem;
use App\Models\Users\Delegate;

trait GeneralTrait
{

    //make copy from Transfer Order before edit and make its deleted
    public function makeTransferOrderAsDeleted($id)
    {

        $record = ItemTracking::where('id', $id)->first();
        //dd($record);

        ItemTracking::insert(
        ['code' => $record->code,
            'item_id' => $record->item_id,
            'source' => $record->source,
            'destination' => $record->destination,
            'date' => $record->date,
            'quantity' => $record->quantity,
            'item_tracking_type_id' => 6,
            'transaction_operation' => 'out',
            'p_code' => $record->p_code,
            'create_by' => $record->create_by,
            'create_at' => $record->create_at,
            "delete_at" => date('Y-m-d H:i:s'),
            "delete_by" => CRUDBooster::myId(),
            'action' => 'edit',
            'cycle_id' => $record->cycle_id,
        ]
        );

        ItemTracking::insert(
        ['code' => $record->code, 'item_id' => $record->item_id, 'source' => $record->destination
            , 'date' => $record->date, 'quantity' => $record->quantity, 'item_tracking_type_id' => 6,
            'transaction_operation' => 'in', 'p_code' => $record->p_code,
            'create_by' => $record->create_by,
            'create_at' => $record->create_at,
            "delete_at" => date('Y-m-d H:i:s'),
            "delete_by" => CRUDBooster::myId(),
            'action' => 'edit',
            'cycle_id' => $record->cycle_id,
        ]
        );

    }

    public function makeInventoryBeginningAsDeleted($id)
    {

        $record = ItemTracking::where('id', $id)->first();
        ItemTracking::insert(
        ['code' => $record->code,
            'item_id' => $record->item_id,
            'source' => $record->source,
            'destination' => $record->destination,
            'date' => $record->date,
            'quantity' => $record->quantity,
            'note' => $record->note,
            'item_tracking_type_id' => 5,
            'transaction_operation' => 'in',
            'p_code' => $record->p_code,
            'create_by' => $record->create_by,
            'create_at' => $record->create_at,
            "delete_at" => date('Y-m-d H:i:s'),
            "delete_by" => CRUDBooster::myId(),
            'action' => 'edit',
            'cycle_id' => $record->cycle_id,
        ]
        );
    }

    public function deleteInventoryBeginning($id)
    {
        ItemTracking::where("id", $id)->update([
            "delete_at" => date('Y-m-d H:i:s'),
            "delete_by" => CRUDBooster::myId(),
            "action" => 'delete',
        ]);
    }

    public function getExchangeRate($currencyId)
    {
        $currency = Currency::where('id', $currencyId)->first();
        return $currency;
    }


    public function getAccountByCurrency($currencyId)
    {
        $currency = Currency::find($currencyId);
        return $currency->account_id;
    }
    /*************** Configration Functions *********************/
    //////////////////////////////////////////////////////////////

    public function getSystemConfigValue($key)
    {
        $config_value = Cache::rememberForever("$key", function () use ($key) {
            return SystemConfig::where('config_key', $key)->first()->config_value;
        });
        return $config_value;
    }


    public function getPackageConfigValue($key)
    {
        $config_value = Cache::rememberForever("$key", function () use ($key) {
            return PackageConfig::first()->$key;
        });
        if (!$config_value) {
            $config_value = 1;
        }
        return $config_value;
    }

    public function getInventories()
    {
        $id = CRUDBooster::myId();
        $me = User::find($id);
        $delegate_id = $me->id;

        $inventories_arr = Delegate::find($delegate_id)->inventories()->pluck('inventories.id')->toArray();
        return implode(',', $inventories_arr);
    }

	public function getDelegateCondition()
	{
		$query = '';
		$user = CRUDBooster::getUser();
		if (in_array($user->roleId,explode(',',config('setting.DELEGATES_ROLES_IDS')))) {
			$query = ' and id= ' . $user->id;
		}
		return $query;
	}

    public function getAdminsIds(){
        $admins_ids= [];
        $admins_ids = User::whereIn('id_cms_privileges',[1,2])->get()->pluck('id')->toArray();
        return $admins_ids;
     }
}
