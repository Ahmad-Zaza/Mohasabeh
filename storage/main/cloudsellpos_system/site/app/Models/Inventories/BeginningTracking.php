<?php

namespace App\Models\Inventories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BeginningTracking extends Model
{
    public $table = "inventory_beginning_tracking";
    protected $fillable = [
        'ib_number', 'source', 'date', 'note', 'staff_id','cycle_id'
    ];
    protected $hidden = [
        'active', 'sorting'
    ];

    public $timestamps = false;

    /**
     * Get all of the items_list for the BeginningTracking
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items_list(): HasMany
    {
        return $this->hasMany(BeginningTrackingList::class, 'ib_tracking_id', 'id');
    }

}
