<?php

namespace App\Models\ContactUs;

use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    protected $table = "contact_us_requests";
    protected $fillable = ['name', 'email', 'subject', 'message', 'phone'];

}
