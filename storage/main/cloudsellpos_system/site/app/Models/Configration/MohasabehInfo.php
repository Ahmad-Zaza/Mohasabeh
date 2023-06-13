<?php

namespace App\Models\Configration;

use Illuminate\Database\Eloquent\Model;

class MohasabehInfo extends Model
{
    public $table="mohasabeh_info";
    protected $fillable = [
        'first_name', 'last_name','email', 'phone', 
        'photo','company','logo','contact_emails',
        'mohasabeh_phone','mohasabeh_email'
    ];
    protected $hidden = [
      
    ];
    public $timestamps = false;

}