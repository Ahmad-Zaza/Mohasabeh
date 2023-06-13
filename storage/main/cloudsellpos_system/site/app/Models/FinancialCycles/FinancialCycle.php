<?php

namespace App\Models\FinancialCycles;

use Illuminate\Database\Eloquent\Model;

class FinancialCycle extends Model
{
    public $table="financial_cycles";
    protected $fillable = [
        'cycle_name','rotate_date', 'currencies_ex_rate','item_cost_type', 'profits_account_id', 'diff_ex_rate_account_id',
        'last_inventories_items_value_account_id','status','create_date'
    ];
    protected $hidden = [
        'active', 'sorting'
    ];
    public $timestamps = false;

}