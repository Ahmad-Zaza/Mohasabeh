<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Person extends Model
{
    public $table="persons";
    public $timestamps = false;
}