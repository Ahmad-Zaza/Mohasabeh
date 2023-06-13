<?php

namespace App\Models\Tours;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class TourStepElements extends Model
{
    public $table="tours_steps_elements";
    protected $fillable = [
        'name', 'element_key'
    ];
    protected $hidden = [
        'active', 'sorting'
    ];
    public $timestamps = false;
}
