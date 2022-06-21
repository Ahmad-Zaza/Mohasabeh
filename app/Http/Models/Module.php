<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Module extends Model
{
    use SoftDeletes;
    protected $table = 'modules';
    protected $fillable = ['name_en','name_ar','code','description_en','description_ar','month_price','year_price'];
}
