<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $fillable = ['name_en','parent_id','sorting'];
    public $timestamps =false;

    public function childs() {

        return $this->hasMany('App\Category','parent_id','id') ;

    }


}
