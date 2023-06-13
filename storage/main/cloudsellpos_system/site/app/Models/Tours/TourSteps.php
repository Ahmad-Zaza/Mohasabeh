<?php

namespace App\Models\Tours;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use App\Models\Tours\Tour;

class TourSteps extends Model
{
    public $table="tours_steps";
    protected $fillable = [
        'tour_id', 'title', 'description', 'element_id', 'element_key'
    ];
    protected $hidden = [
        'active', 'sorting'
    ];
    public $timestamps = false;

    public function tour(){
        return $this->belongsTo(Tour::class,'tour_id','id');
    }

    public function stepElement(){
        return $this->hasOne(TourStepElements::class,'id','element_id');
    }

}
