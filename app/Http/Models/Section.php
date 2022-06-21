<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use SoftDeletes;
    protected $table = 'sections';
    public $timestamps = true;
    
    protected $fillable = ['code','title_en','title_ar', 'subtitle_en','subtitle_ar', 'description_ar','description_en',
    'image','active'];
    
}
