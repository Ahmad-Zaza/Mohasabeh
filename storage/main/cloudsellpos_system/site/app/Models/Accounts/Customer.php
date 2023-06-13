<?php

namespace App\Models\Accounts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Users\Delegate;


class Customer extends Model
{
    public $table = "persons";
    protected $fillable = [
        'code', 'name_ar', 'name_en', 'email', 'phone_number','account_id','person_type_id', 'delegate_id'
    ];
    protected $hidden = [
        'active', 'sorting',
    ];
    public $timestamps = false;

    protected static function boot()
    {
        // make sure to call the parent method
        parent::boot();

        static::addGlobalScope('checkCustomer', function(\Illuminate\Database\Eloquent\Builder $builder) {
            
                $builder->where('person_type_id', 1);
            
        });
    }


	/**
     * Get the delegate associated with the Customer
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function delegate(): HasOne
    {
        return $this->hasOne(Delegate::class, 'id', 'delegate_id');
    }
   
    
}
