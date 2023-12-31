<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;
    protected $table   = 'customers';
    public $timestamps = true;

    protected $fillable = ['first_name', 'last_name', 'phone', 'email', 'subscription_type', 'company',
        'users_count', 'sys_lang', 'notes','custom_token'];
}