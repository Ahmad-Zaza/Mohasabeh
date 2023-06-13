<?php

namespace App\Models\ItemsTracking;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Inventories\Inventory;
use App\Models\Items\Item;

class ItemTracking extends Model
{
    public $table="item_tracking";

    protected $fillable = [
        'code', 'p_code', 'item_id', 'item_tracking_type_id', 'source', 'destination', 'date',
        'quantity', 'bill_id', 'note', 'transaction_operation', 'status',
        'create_at', 'create_by','edit_by','edit_at', 'delete_at', 'delete_by','action', 'cycle_id',
    ];
    protected $hidden = [
        'active', 'sorting'
    ];
    public $timestamps =false;

    /**
     * Get the type associated with the ItemTracking
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function type(): HasOne
    {
        return $this->hasOne(ItemTrackingType::class, 'id', 'item_tracking_type_id');
    }

    /**
     * Get the source associated with the ItemTracking
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function source_inventory(): HasOne
    {
        return $this->hasOne(Inventory::class, 'id', 'source');
    }

    /**
     * Get the destination associated with the ItemTracking
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function destination_inventory(): HasOne
    {
        return $this->hasOne(Inventory::class, 'id', 'destination');
    }

    /**
     * Get the item associated with the ItemTracking
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function item(): HasOne
    {
        return $this->hasOne(Item::class, 'id', 'item_id');
    }
    
}
