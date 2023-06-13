<?php

namespace App\Models\ItemsTracking;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ItemTrackingType extends Model
{
    public $table="item_tracking_types";
    protected $fillable = [
        'name_en', 'name_ar', 'prefix'
    ];
    protected $hidden = [
        'active', 'sorting'
    ];
    public $timestamps =false;


    /**
     * Get all of the items_tracking for the ItemTrackingType
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items_tracking(): HasMany
    {
        return $this->hasMany(ItemTracking::class, 'item_tracking_type_id', 'id');
    }
    
}
