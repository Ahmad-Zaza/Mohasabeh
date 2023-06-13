<?php

namespace App\Models\Entries;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EntryBase extends Model
{
    public $table="entry_base";
    protected $fillable = [
        'entry_number','narration','date','bill_id', 'voucher_id',
        'create_at', 'create_by','edit_by','edit_at','delete_at', 'delete_by','action','cycle_id',
    ];
    protected $hidden = [
        'active', 'sorting'
    ];
    public $timestamps =false;


    /**
     * Get all of the entries for the EntryBase
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function entries(): HasMany
    {
        return $this->hasMany(Entry::class, 'entry_base_id', 'id');
    }

}