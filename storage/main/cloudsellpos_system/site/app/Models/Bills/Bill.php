<?php

namespace App\Models\Bills;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Items\Item;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use App\Models\Entries\Entry;
use App\Models\Entries\EntryBase;
use App\Models\ItemsTracking\ItemTracking;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Accounts\Account;
use App\Models\Inventories\Inventory;
use App\Models\Currencies\Currency;
use App\Models\Users\Delegate;

class Bill extends Model
{
    public $table = "bills";

    protected $fillable = [
        'code', 'p_code', 'debit', 'credit', 'date', 'bill_type_id', 'inventory_id', 'currency_id',
        'staff_id', 'note', 'is_cash', 'bill_number', 'amount', 'ex_rate', 'equalizer',
        'discount', 'after_discount', 'delegate_id', 'checked_for_update','status', 'action','cycle_id',
        'create_by','create_at','edit_by','edit_at', 'delete_by', 'delete_at'
    ];
    protected $hidden = [
        'active','sorting'
    ];
    public $timestamps = false;

    public function billType()
    {
        return $this->hasOne('App\Models\Bills\BillType', 'id', 'bill_type_id');
    }


    /**
     * Get all of the files for the Bill
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function files(): HasMany
    {
        return $this->hasMany(BillFile::class, 'bill_id', 'id');
    }

    /**
     * The items that belong to the Bill
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, 'bills_items', 'bill_id', 'item_id');
    }

    /**
     * Get all of the entries for the Bill
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function entries(): HasManyThrough
    {
        return $this->hasManyThrough(Entry::class, EntryBase::class,'bill_id','entry_base_id','id','id');
    }

    /**
     * Get all of the itemsTracking for the Bill
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function itemsTracking(): HasMany
    {
        return $this->hasMany(ItemTracking::class, 'bill_id', 'id');
    }

    /**
     * Get the debit_account associated with the Bill
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function debit_account(): HasOne
    {
        return $this->hasOne(Account::class, 'id', 'debit');
    }

    /**
     * Get the credit_account associated with the Bill
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function credit_account(): HasOne
    {
        return $this->hasOne(Account::class, 'id', 'credit');
    }

    /**
     * Get the inventory associated with the Bill
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function inventory(): HasOne
    {
        return $this->hasOne(Inventory::class, 'id', 'inventory_id');
    }

    /**
     * Get the currency associated with the Bill
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function currency(): HasOne
    {
        return $this->hasOne(Currency::class, 'id', 'currency_id');
    }

    /**
     * Get the delegate associated with the Bill
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function delegate(): HasOne
    {
        return $this->hasOne(Delegate::class, 'id', 'delegate_id');
    }

    
}
