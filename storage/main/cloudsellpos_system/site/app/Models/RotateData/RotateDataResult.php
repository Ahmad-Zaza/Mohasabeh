<?php

namespace App\Models\RotateData;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class RotateDataResult extends Model
{
    public $table="rotate_data_result";

    protected $fillable = [
        'cycle_id','rotate_date','net_profit', 'gross_profit',
        'sales','purchases', 'sales_return','purchases_return',
        'earned_discount','granted_discount',
        'last_inventories_items_value','begin_inventories_items_value',
        'incomes', 'outgoings',
        'ex_rate_difference_value', 'date'
    ];
    public $timestamps =false;


}
