<?php

namespace App\Models\Bills;

use Illuminate\Database\Eloquent\Model;

class BillItem extends Model
{
    public $table = "bills_items";
    protected $fillable = [
        'bill_id','item_id','unit_price','quantity','subtotal'
    ];
    protected $hidden = [
        'active', 'sorting'
    ];
    public $timestamps = false;



}
