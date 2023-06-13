<?php

namespace App\Models\Accounts;

use App\Models\Users\GeneralDelegate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Users\Delegate;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Entries\Entry;


class Supplier extends Model
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

        static::addGlobalScope('checkSupplier', function(\Illuminate\Database\Eloquent\Builder $builder) {
            
                $builder->where('person_type_id', 2);
            
        });
    }


	/**
	 * The delegates that belong to the Inventory
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function delegates(): BelongsToMany
	{
		return $this->belongsToMany(GeneralDelegate::class, 'suppliers_delegates', 'supplier_id', 'delegate_id');
	}
   
    /**
     * Get the account associated with the Supplier
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function account(): HasOne
    {
        return $this->hasOne(Account::class, 'id', 'account_id');
    }

    /**
     * Get all of the entries for the Supplier
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function entries(): HasMany
    {
        return $this->hasMany(Entry::class, 'account_id', 'account_id');
    }
    
}
