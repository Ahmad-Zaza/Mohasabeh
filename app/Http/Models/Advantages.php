<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Advantages extends Model
{
    use SoftDeletes;
    protected $table = 'advantages';
    public $timestamps = true;
    
    protected $fillable = ['description_ar','description_en','image','active'];
    
    public function foods() {
        return $this->hasMany(Food::class);
    }

}
