<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    protected $fillable = [
        'customer_id',
        'payer_id',
        'payer_email',
        'payer_name',
        'payer_surname',
        'payment_id',
        'init_amount',
        'gross_amount',
        'net_amount',
        'fee',
        'currency',
        'status',
        'error_name',
        'error_message',
        'debug_id',
        'error_details',
    ];
}
