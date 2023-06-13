<?php

namespace App\Models\Configration;

use Illuminate\Database\Eloquent\Model;

class PackageConfig extends Model
{
    public $table="package_config";
    protected $fillable = [
        'package_id', 'users_num','inventories_num', 'currencies_num',
        'clients_num','month_bills_num','backups_size','attachs_size', 
        'free_trial_start_date','free_trial_end_date','subscription_start_date','subscription_end_date'
    ];
    protected $hidden = [
      
    ];
    public $timestamps = false;

}