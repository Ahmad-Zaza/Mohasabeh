<?php

namespace App\Models\Bills;

use Illuminate\Database\Eloquent\Model;

class BillFile extends Model
{
    public $table = "bills_files";
    protected $fillable = [
        'file_id', 'bill_id'
    ];
    protected $hidden = [
        'active', 'sorting'
    ];
    public $timestamps = false;

    /**
     * Get the Bill associated with the BillFile
     */
    public function bill()
    {
        return $this->hasOne(Bill::class, 'id', 'bill_id');
    }


}
