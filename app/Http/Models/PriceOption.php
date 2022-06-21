<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PriceOption extends Model
{
    use SoftDeletes;
    protected $table = 'price_option';
    public $timestamps = true;
    
    protected $fillable = ['code','value','name_ar','name_en','month_price','year_price','active'];
}
