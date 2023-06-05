<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    protected $fillable = [
        'payer_id',
        'payer_email',
        'payment_id',
        'amount',
        'currency',
        'status',
        
        'error_name',
        'error_message',
        'debug_id',
        'error_details'
    ];
}
