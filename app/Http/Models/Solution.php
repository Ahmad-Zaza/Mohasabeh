<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Solution extends Model
{
    use SoftDeletes;
    protected $table = 'solutions';
    public $timestamps = true;
    
    protected $fillable = ['name_ar','name_en', 'description_en', 'description_ar',
    'image','active'];

    public function modules(){
        return $this->hasMany(Module::class);
    }
    
}