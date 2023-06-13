<?php

namespace App\Models\Tours;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use App\Models\Tours\TourSteps;

class Tour extends Model
{
    public $table="tours";
    protected $fillable = [
        'name', 'module_id', 'page_type'
    ];
    protected $hidden = [
        'active', 'sorting'
    ];
    public $timestamps = false;

    public function steps(){
        return $this->hasMany(TourSteps::class,'tour_id','id')->where('active',true)->orderBy('sorting');
    }

}
