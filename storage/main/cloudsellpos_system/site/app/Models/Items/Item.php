<?php

namespace App\Models\Items;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Bills\Bill;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\ItemsTracking\ItemTracking;

class Item extends Model
{
    public $table="items";

    protected $fillable = [
        'name_en', 'name_ar', 'item_number', 'code', 'p_code', 'item_category_id',
        'item_unit_id', 'cost', 'price', 'production_date', 'mix_number',
        'expiration_date', 'visible_to_delegates'
    ];
    protected $hidden = [
        'active', 'sorting'
    ];
    public $timestamps = false;

    /**
     * The bills that belong to the Item
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function bills(): BelongsToMany
    {
        return $this->belongsToMany(Bill::class, 'bills_items', 'item_id', 'bill_id');
    }

    /**
     * Get the category associated with the Item
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function category(): HasOne
    {
        return $this->hasOne(ItemCategory::class, 'id', 'item_category_id');
    }

    /**
     * Get the Unit associated with the Item
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function unit(): HasOne
    {
        return $this->hasOne(ItemUnit::class, 'id', 'item_unit_id');
    }

    
    /**
     * Get all of the item_tracking for the Item
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function item_tracking(): HasMany
    {
        return $this->hasMany(ItemTracking::class, 'item_id', 'id');
    }

}
