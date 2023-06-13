<?php

namespace App\Models\Inventories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Items\Item;
use App\Models\ItemsTracking\ItemTracking;

class TransferTrackingList extends Model
{
    public $table = "transfer_items_list";
    protected $fillable = [
        'transfer_tracking_id', 'item_id', 'quantity', 'p_code','cycle_id'
    ];

    protected $hidden = [
        'active', 'sorting'
    ];
    public $timestamps = false;

    /**
     * Get the transfer_track associated with the TransferTrackingList
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function transfer_track(): HasOne
    {
        return $this->hasOne(TransferTracking::class, 'id', 'transfer_tracking_id');
    }

    /**
     * Get the item associated with the TransferTrackingList
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function item(): HasOne
    {
        return $this->hasOne(Item::class, 'id', 'item_id');
    }

    /**
     * Get the item_track associated with the TransferTrackingList
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function item_track(): HasOne
    {
        return $this->hasOne(ItemTracking::class, 'p_code', 'p_code');
    }
}
