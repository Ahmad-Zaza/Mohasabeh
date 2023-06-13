<?php
namespace App\Http\Controllers\General;

use App\Models\Inventories\TransferTrackingNote;
use CRUDBooster;
use App\Models\Inventories\TransferTracking;
use App\Models\Inventories\TransferTrackingList;
use App\Models\ItemsTracking\ItemTracking;

class InventoriesFunctionsController extends Controller{
	
	public function confirmReceiptItems($id,$items_track_ids_str){
		
		$user = CRUDBooster::getUser();
		$user_invs = $user->getInventoriesIds();

		$transfer_track = TransferTracking::where('id', $id)->first();
		if ($transfer_track) {
			$confirmed_items_track_ids = explode(',', $items_track_ids_str);
			$confirmed_items_count = count($confirmed_items_track_ids);

			if (!in_array($transfer_track->destination, $user_invs)) {
				return json_encode(array('status' => 'error', 'massege' => "You Don't have permission to confirm receipt items."));
			} else {
				$transfer_track_items_count = TransferTrackingList::where('transfer_tracking_id', $id)->get()->count();
				$status = 0; //not receipt any items yet
				if ($transfer_track_items_count == $confirmed_items_count) {
					$status = 1; // receipt all items.
				} elseif ($transfer_track_items_count > $confirmed_items_count) {
					$status = 2; // receipt some of items.
				}
				$transfer_track->update([
					'status' => $status,
					'receipt_date' => date('Y-m-d H:i:s'),
					'receipt_by' => $user->id
				]);

				ItemTracking::whereIn('id', $confirmed_items_track_ids)->update([
					'status' => 1
				]);

				return json_encode(array('status' => 'success', 'massege' => "Process done."));
			}
		} else {
			return json_encode(array('status'=>'error','massege'=>"Transfer items Tracking not found. Maybe it is deleted."));
		}
			
	}

	public function addNoteToReceiptItemsNotification($id,$user_id,$note)
	{
		$transfer_track = TransferTracking::where('id', $id)->first();
		if ($transfer_track) {
			TransferTrackingNote::insert([
				'transfer_tracking_id'=>$id,
				'user_id'=>$user_id,
				'note'=>$note
			]);
			return json_encode(array('status' => 'success', 'massege' => "Process done."));
		} else {
			return json_encode(array('status'=>'error','massege'=>"Transfer items Tracking not found. Maybe it is deleted."));
		}
	}


}