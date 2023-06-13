<?php

namespace App\Models\Accounts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class PersonType extends Model
{
    public $table="person_type";
    protected $fillable = [
        'name_en','name_ar'
    ];
    protected $hidden = [
        'active','sorting'
    ];
    public $timestamps = false;
}