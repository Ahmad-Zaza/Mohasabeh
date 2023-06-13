<?php

namespace App\Models\Entries;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Accounts\Account;
use App\Models\Currencies\Currency;

class Entry extends Model
{
    public $table="entries";
    protected $fillable = [
        'entry_base_id', 'debit', 'credit', 'account_id', 'currency_id', 'ex_rate',
        'equalizer', 'opposite', 'status', 'create_at', 'create_by','edit_by','edit_at', 'delete_at', 'delete_by','action','cycle_id',
    ];
    protected $hidden = [
        'active', 'sorting'
    ];
    public $timestamps =false;

    /**
     * Get the account associated with the Entry
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function account(): HasOne
    {
        return $this->hasOne(Account::class, 'id', 'account_id');
    }

    /**
     * Get the currency associated with the Entry
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function currency(): HasOne
    {
        return $this->hasOne(Currency::class, 'id', 'currency_id');
    }

    /**
     * Get the base associated with the Entry
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function base(): HasOne
    {
        return $this->hasOne(EntryBase::class, 'id', 'entry_base_id');
    }

    

}