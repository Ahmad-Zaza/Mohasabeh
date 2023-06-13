<?php

namespace App\Models\Vouchers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class VoucherFile extends Model
{
    public $table="vouchers_files";

    protected $fillable = [
        'voucher_id','file_id'
    ];
    protected $hidden = [
        'active', 'sorting'
    ];
    public $timestamps =false;

    /**
     * Get the voucher associated with the VoucherFile
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function voucher(): HasOne
    {
        return $this->hasOne(Voucher::class, 'id', 'voucher_id');
    }
}