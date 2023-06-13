<?php

namespace App\Models\Inventories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TransferTracking extends Model
{
    public $table = "transfer_tracking";
    protected $fillable = [
        'transfer_number', 'source', 'destination', 'date', 'note', 'delegate_id' , 'staff_id', 'status',
        'receipt_date', 'receipt_by','cycle_id'
    ];
    protected $hidden = [
        'active', 'sorting'
    ];
    public $timestamps = false;

    /**
     * Get the source_inventory associated with the TransferTracking
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function source_inventory(): HasOne
    {
        return $this->hasOne(Inventory::class, 'id', 'source');
    }

    /**
     * Get the destination_inventory associated with the TransferTracking
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function destination_inventory(): HasOne
    {
        return $this->hasOne(Inventory::class, 'id', 'destination');
    }


    /**
     * Get all of the items_list for the TransferTracking
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items_list(): HasMany
    {
        return $this->hasMany(TransferTrackingList::class, 'transfer_tracking_id', 'id');
    }



}
