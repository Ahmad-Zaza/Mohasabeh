<?php

namespace App;

use App\Http\Models\Customer;
use Illuminate\Database\Eloquent\Model;

class SiteStatus extends Model
{
    protected $table   = 'customer_report';

    protected $fillable = [
        'customer_id', 'bills_count', 'vouches_count', 'allowed_users_count', 'used_users_count', 'allowed_inventories_count',
        'used_inventories_count', 'allowed_currencies_count', 'used_currencies_count', 'allowed_clients_count', 'used_clients_count', 'allowed_attachs_size', 'used_attachs_size', 'subscription_type', 'subscription_start_date', 'subscription_end_date'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
