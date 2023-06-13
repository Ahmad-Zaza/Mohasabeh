<?php

namespace App\Models\Vouchers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Users\Delegate;
use App\Models\Accounts\Account;
use App\Models\Users\User;
use App\Models\Entries\Entry;
use App\Models\Entries\EntryBase;

class Voucher extends Model
{
    public $table="vouchers";

    protected $fillable = [
        'code','p_code','voucher_number','voucher_type_id','debit','credit','staff_id',
        'delegate_id','narration','date','currency_id','amount',
        'ex_rate','equalizer', 'opposite', 'status', 'receipt_date', 'receipt_by', 'checked_for_update',
        'create_at', 'create_by','edit_by','edit_at', 'delete_at', 'delete_by','action','cycle_id'
    ];
    protected $hidden = [
        'active', 'sorting'
    ];
    public $timestamps =false;

    /**
     * Get the type that owns the Voucher
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(VoucherType::class, 'voucher_type_id', 'id');
    } 


    /**
     * Get all of the files for the Voucher
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function files(): HasMany
    {
        return $this->hasMany(VoucherFile::class, 'voucher_id', 'id');
    }

    /**
     * Get the delegate associated with the Voucher
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function delegate(): HasOne
    {
        return $this->hasOne(Delegate::class, 'id', 'delegate_id');
    }

    /**
     * Get the debit associated with the Voucher
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function debit_account(): HasOne
    {
        return $this->hasOne(Account::class, 'id', 'debit');
    }

    /**
     * Get the credit associated with the Voucher
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function credit_account(): HasOne
    {
        return $this->hasOne(Account::class, 'id', 'credit');
    }

    /**
     * Get the staff associated with the Voucher
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function staff(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'staff_id');
    }

    /**
     * Get all of the entries for the Voucher
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function entries(): HasManyThrough
    {
        return $this->hasManyThrough(Entry::class, EntryBase::class,'voucher_id','entry_base_id','id','id');
    }

}