<?php

namespace App\Models\Bills;

use Illuminate\Database\Eloquent\Model;

class BillType extends Model
{
    public $table = "bill_types";
    protected $fillable = [
        'name_en','name_ar','code','prefix'
    ];

    protected $hidden = [
        'active', 'sorting'
    ];
    public $timestamps = false;

    public function bills()
    {
        return $this->hasMany('App\Models\Bills\Bill', 'bill_type_id', 'id');
    }


}
