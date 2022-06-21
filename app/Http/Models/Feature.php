<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feature extends Model
{
    use SoftDeletes;
    protected $table = 'features';
    public $timestamps = true;
    
    protected $fillable = ['name_en','name_ar','description_ar','description_en','image','active'];
    
}
