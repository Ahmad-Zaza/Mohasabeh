<?php
namespace App\Http\Controllers\General;
use App\Models\Accounts\Account;
use App\Models\Accounts\Person;
use App\Models\Currencies\Currency;
use App\Models\Vouchers\Voucher;
use App\Models\Users\User;
use DB;
use CRUDBooster;
use App\Traits\GeneralTrait;
use Session;
class VouchersFunctionsController extends Controller{
	use GeneralTrait;
	
	public function checkBoxBalance($currency_id, $amount, $editedID = 0)
	{
		$user = CRUDBooster::getUser();
		if ($user->hasBox == 'own') {
			$sql = "select (IFNULL(sum(entries.debit), 0)-IFNULL(sum(entries.credit), 0)) as q 
			 from entries , entry_base , accounts , currencies WHERE  
			 accounts.id=entries.account_id and accounts.id = " . $user->boxAccount . "
			 AND entry_base.id=entries.entry_base_id 
			 AND currencies.id=entries.currency_id and entries.account_id= " . $user->boxAccount . "
			 AND entries.currency_id=" . (int)$currency_id . "
			 AND entries.status = 1 AND entries.action is NULL
			 AND entries.cycle_id = ".Session::get('display_cycle')." ;
			";
		}
		else {
			$box_account_id = $this->getSystemConfigValue("General_Box");
			if ($box_account_id) {
				$sql = "select (IFNULL(sum(entries.debit), 0)-IFNULL(sum(entries.credit), 0)) as q 
					from entries , entry_base , accounts , currencies WHERE  
					accounts.id=entries.account_id and accounts.id =$box_account_id 
					AND entry_base.id=entries.entry_base_id 
					AND currencies.id=entries.currency_id and entries.account_id=$box_account_id
					AND entries.currency_id=" . (int)$currency_id . "
					AND entries.status = 1 AND entries.action is NULL
					AND entries.cycle_id = ".Session::get('display_cycle')." ;
				   ";
			}

		}

		$value = DB::select($sql);

		$amount_before_edit = 0;
		if ($editedID != 0) { //check box when edit voucher
			$amount_before_edit = Voucher::where('id', $editedID)
			->where('cycle_id', Session::get('display_cycle'))
			->where('currency_id',$currency_id)->first()->amount;
		}
		$box_amount = $value[0]->q + $amount_before_edit;
		if ((int)$amount > (int)$box_amount) {

			$data = array("res" => true, "sum" => $box_amount);

		}

		return response()->json($data);
	}


	
	public function checkAccountBalance($currency_id, $amount,$account_id,$editedID=0)
	{
		$sql = "select (IFNULL(sum(entries.debit), 0)-IFNULL(sum(entries.credit), 0)) as q 
		 from entries , entry_base , accounts , currencies WHERE  
		 accounts.id=entries.account_id and accounts.id = " . $account_id . "
		 AND entry_base.id=entries.entry_base_id 
		 AND currencies.id=entries.currency_id and entries.account_id= " . $account_id . "
		 AND entries.currency_id=" . (int)$currency_id . "
		 AND entries.status = 1 AND entries.action is NULL 
		 AND entries.cycle_id = ".Session::get('display_cycle').";
		";
		
		$value = DB::select($sql);

		$amount_before_edit = 0;
		if($editedID != 0){ //check box when edit voucher
			$amount_before_edit = Voucher::where('id',$editedID)
			->where('cycle_id', Session::get('display_cycle'))
			->where('currency_id',$currency_id)->first()->amount;
		}
		$account_amount = $value[0]->q + $amount_before_edit;
		if ((int)$amount > (int)$account_amount) {
			$account_name = Account::find($account_id)->name_ar;
			$data = Array("res" => true,"account_name" => $account_name, "sum" => $account_amount);
		}
		return response()->json($data);
	}

	
	public function getTransferVoucherAccountsIds(){
		$accountsIds = [];
		$user = CRUDBooster::getUser();
		if (in_array($user->roleId,explode(',',config('setting.ROLES_IDS_HAS_VOUCHER_PERMISSION')))) { //Sales Manager , Delegate , Factory Cashier
			$gfunc = new GeneralFunctionsController();
			$general_box_account = $gfunc->getSystemConfigValue("General_Box");
			array_push($accountsIds,$general_box_account);

			$delegates_accounts = User::whereIn('id_cms_privileges',explode(',',config('setting.ROLES_IDS_HAS_VOUCHER_PERMISSION')))->where('id','!=',$user->id)->select('account_id')->get();
			foreach ($delegates_accounts as $account)
			{
				array_push($accountsIds,$account->account_id);
			}
		}else{ //Admin, Manager
			$delegates_accounts = User::whereIn('id_cms_privileges',explode(',',config('setting.ROLES_IDS_HAS_VOUCHER_PERMISSION')))->where('id','!=',$user->id)->select('account_id')->get();
			foreach ($delegates_accounts as $account)
			{
				array_push($accountsIds,$account->account_id);
			}
		}
		return $accountsIds;
	}

	
    public function calculateVoucherAmountAfterOppositeTransfer($amount, $currency_id, $opposite, $curr_ex_rate = 0)
    {

        $gfunc = new GeneralFunctionsController();
        $majorCurr = $gfunc->getMajorCurrency();
        $amountAfterOpposite = 0;
        if ($currency_id == $majorCurr->id && $opposite == $majorCurr->id) {
            $amountAfterOpposite = $amount;
        }
        elseif ($currency_id == $majorCurr->id && $opposite != $majorCurr->id) {
            $opposite_ex_rate = Currency::where('id', $opposite)->first()->ex_rate;
            if ($opposite_ex_rate == $curr_ex_rate) {
                $amountAfterOpposite = $amount / $opposite_ex_rate;
            }
            else {
                $amountAfterOpposite = $amount / $curr_ex_rate;
            }
        }
        elseif ($currency_id != $majorCurr->id && $opposite == $majorCurr->id) {
            $ex_rate = Currency::where('id', $currency_id)->first()->ex_rate;
            if ($curr_ex_rate != 0) { //تم تغير سعر الصرف  الافتراضي
                $ex_rate = $curr_ex_rate;
            }
            $amountAfterOpposite = $amount * $ex_rate;
        }
        elseif ($currency_id != $majorCurr->id && $opposite != $majorCurr->id) {
            if ($currency_id == $opposite) {
                $amountAfterOpposite = $amount;
            }
            else {
                $ex_rate = Currency::where('id', $currency_id)->first()->ex_rate;
                if ($curr_ex_rate != 0) { //تم تغير سعر الصرف  الافتراضي
                    $ex_rate = $curr_ex_rate;
                }
                $temp1 = $amount * $ex_rate;
                $amountAfterOpposite = $temp1;
            }
        }

        return round($amountAfterOpposite, 2);
    }

	
        //تحقق من أن حسابات المدين والدائن متوافقة مع العملة 
        public function checkAccountsSuitableWithCurrency($debit,$credit,$currency_id){
            $bool = true;
            $gfunc = new GeneralFunctionsController();
            $activeCurrencies = $gfunc->getActiveCurrencies();
            $mainBoxAccountsIds = [];
            foreach($activeCurrencies as $curr){
                array_push($mainBoxAccountsIds,$curr->account_id);
            }
            $box_account_id = $this->getAccountByCurrency($currency_id);
            if(in_array($debit,$mainBoxAccountsIds) && $debit != $box_account_id){
               $bool = false;
            }
            if(in_array($credit,$mainBoxAccountsIds) && $credit != $box_account_id){
                $bool = false;
             }

            return $bool;
        }


	public function confirmReceiptAmount($voucher_id){
		
		$user = CRUDBooster::getUser(); 
		$voucher = Voucher::where('id', $voucher_id)->where('cycle_id', Session::get('display_cycle'))->first();
		if($voucher && ($voucher->action == NULL)){
			if($voucher->debit != $user->boxAccount){
				return json_encode(array('status'=>'error','massege'=>"You Don't have permission to confirm receipt This voucher."));
			} else {
				$voucher->update([
					'status'=>1,
					'receipt_date'=>date('Y-m-d H:i:s'),
					'receipt_by'=>$user->id
				]);

				$debit_entry = $voucher->entries->where('account_id',$user->boxAccount)->first();
				if($debit_entry){
					$debit_entry->update([
						'status'=>1
					]);
				}

				return json_encode(array('status'=>'success','massege'=>"Process done."));
			}
		} else {
			return json_encode(array('status'=>'error','massege'=>"Voucher not found. Maybe it is deleted."));
		}
	}

}