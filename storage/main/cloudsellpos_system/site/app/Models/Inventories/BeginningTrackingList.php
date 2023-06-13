<?php

namespace App\Models\Inventories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Items\Item;
use App\Models\ItemsTracking\ItemTracking;

class BeginningTrackingList extends Model
{
    public $table = "inventory_beginning_items_list";

    protected $fillable = [
        'ib_tracking_id', 'item_id', 'item_unit', 'quantity', 'p_code','cycle_id'
    ];
    protected $hidden = [
        'active', 'sorting'
    ];
    public $timestamps = false;

    /**
     * Get the ib_track associated with the BeginningTrackingList
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function ib_track(): HasOne
    {
        return $this->hasOne(BeginningTracking::class, 'id', 'ib_tracking_id');
    }

    /**
     * Get the item associated with the BeginningTrackingList
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function item(): HasOne
    {
        return $this->hasOne(Item::class, 'id', 'item_id');
    }

    /**
     * Get the item_track associated with the BeginningTrackingList
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function item_track(): HasOne
    {
        return $this->hasOne(ItemTracking::class, 'p_code', 'p_code');
    }
}
