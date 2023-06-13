<?php

namespace App\Models\Vouchers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VoucherType extends Model
{
    public $table="voucher_types";
    protected $fillable = [
        'name_ar', 'name_en', 'prefix'
    ];

    protected $hidden = [
        'active', 'sorting'
    ];

    public $timestamps =false;

    /**
     * Get all of the vouchers for the VoucherType
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function vouchers(): HasMany
    {
        return $this->hasMany(Voucher::class, 'voucher_type_id', 'id');
    }

}