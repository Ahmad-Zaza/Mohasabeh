<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Inventories\Inventory;
use App\Models\Accounts\Supplier;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Accounts\Customer;

class GeneralDelegate extends Model
{
    public $table = "cms_users";
	protected $fillable = [
        'name', 'photo', 'email', 'id_cms_privileges','account_id','customers_account_id'
    ];
    protected $hidden = [
        'password', 'created_at', 'updated_at', 'status'
    ];
    public $timestamps = false;

    protected static function boot()
    {
        // make sure to call the parent method
        parent::boot();

        static::addGlobalScope('checkDelegate', function(\Illuminate\Database\Eloquent\Builder $builder) {
            
                $builder->whereIn('id_cms_privileges', [3,4,6]);//Sales Manager and Delegates and Factory Delegate
            
        });
    }
   

    /**
	 * The inventories that belong to the Inventory
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function inventories(): BelongsToMany
	{
		return $this->belongsToMany(Inventory::class, 'inventories_delegates', 'delegate_id', 'inventory_id');
	}

    /**
	 * The suppliers that belong to the Inventory
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function suppliers(): BelongsToMany
	{
		return $this->belongsToMany(Supplier::class, 'suppliers_delegates', 'delegate_id', 'supplier_id');
	}
    
	/**
	 * Get all of the customers for the Delegate
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function customers(): HasMany
	{
		return $this->hasMany(Customer::class, 'delegate_id', 'id');
	}

	
}
