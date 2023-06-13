<?php

namespace App\Models\Inventories;

use Illuminate\Database\Eloquent\Model;

class TransferTrackingNote extends Model
{
    public $table = "transfer_tracking_notes";
    protected $fillable = [
        'transfer_tracking_id', 'user_id', 'note', 'date'
    ];

    public $timestamps = false;

}
