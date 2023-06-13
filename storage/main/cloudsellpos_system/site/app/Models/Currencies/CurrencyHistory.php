<?php

namespace App\Models\Currencies;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class CurrencyHistory extends Model
{
    public $table="currency_history";
    protected $fillable = [
        'ex_rate','currency_id','edit_by','edit_at'
    ];
    protected $hidden = [
        'active', 'sorting'
    ];
    public $timestamps = false;


}