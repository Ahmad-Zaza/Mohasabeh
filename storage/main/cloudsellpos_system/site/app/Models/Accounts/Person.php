<?php

namespace App\Models\Accounts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Person extends Model
{
    public $table="persons";

    protected $fillable = [
        'code', 'name_en','name_ar','email','phone_number','account_id','person_type_id','delegate_id'
    ];

    protected $hidden = [
        'active','sorting'
    ];

    public $timestamps = false;

    /**
     * Get the type associated with the Person
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function type(): HasOne
    {
        return $this->hasOne(PersonType::class, 'id', 'person_type_id');
    }
}