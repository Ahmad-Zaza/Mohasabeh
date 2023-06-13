<?php

namespace App\Models\Accounts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ClosingAccountType extends Model
{
    public $table="closing_accounts_types";

    protected $fillable = [
        'name_ar'
    ];
    protected $hidden = [
        'active','sorting'
    ];
    public $timestamps = false;
}