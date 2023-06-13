<?php

namespace App\Models\Items;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ItemUnit extends Model
{
    public $table="item_units";

    protected $fillable = [
        'name_en', 'name_ar'
    ];
    protected $hidden = [
        'active', 'sorting'
    ];

    /**
     * Get all of the items for the ItemUnit
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(Item::class, 'item_unit_id', 'id');
    }
}
