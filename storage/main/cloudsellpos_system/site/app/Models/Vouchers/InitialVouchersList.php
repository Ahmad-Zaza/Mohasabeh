<?php

namespace App\Models\Vouchers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class InitialVouchersList extends Model
{
    public $table = "initial_vouchers_list";

    protected $fillable = [
        'iv_group_id', 'account_id', 'currency_id', 'amount', 'p_code','cycle_id'
    ];
    protected $hidden = [
        'active', 'sorting'
    ];
    public $timestamps = false;

    /**
     * Get the iv_group associated with the InitialVouchersList
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function iv_group(): HasOne
    {
        return $this->hasOne(InitialVouchersGroup::class, 'id', 'iv_group_id');
    }

}
