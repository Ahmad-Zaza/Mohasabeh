<?php

namespace App\Models\Vouchers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InitialVouchersGroup extends Model
{
    public $table = "initial_vouchers_groups";
    protected $fillable = [
        'voucher_number', 'narration', 'date', 'staff_id','cycle_id'
    ];
    protected $hidden = [
        'active', 'sorting'
    ];

    public $timestamps = false;

    /**
     * Get all of the group_list for the InitialVouchersGroup
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function group_list(): HasMany
    {
        return $this->hasMany(BeginningTrackingList::class, 'iv_group_id', 'id');
    }

}
