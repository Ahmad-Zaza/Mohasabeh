<?php

namespace App\Http\Models;

use App\SiteStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    use SoftDeletes;
    protected $table   = 'customers';
    public $timestamps = true;
    protected $guard = 'customer';
    protected $fillable = [
        'first_name', 'last_name', 'phone', 'email', 'subscription_type', 'company',
        'users_count', 'custom_token','address'
    ];

    public function customer_report()
    {
        return $this->hasOne(SiteStatus::class);
    }
}
