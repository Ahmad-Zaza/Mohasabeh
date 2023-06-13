<?php

namespace App\Models\Currencies;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Accounts\Account;

class Currency extends Model
{
    public $table="currencies";
    protected $fillable = [
        'name_en', 'name_ar', 'code', 'account_id', 'is_major', 'note',
        'ex_rate','icon', 'color'
    ];
    protected $hidden = [
        'active', 'sorting'
    ];
    public $timestamps = false;

    /**
     * Get all of the history for the Currency
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function history(): HasMany
    {
        return $this->hasMany(CurrencyHistory::class, 'currency_id', 'id');
    }

    /**
     * Get the account associated with the Currency
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function account(): HasOne
    {
        return $this->hasOne(Account::class, 'id', 'account_id');
    }

}