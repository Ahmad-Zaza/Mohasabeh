<?php

namespace App\Models\SystemConfigration;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class SystemConfig extends Model
{
    public $table="system_config";

    protected $fillable = [
        'config_key','config_value'
    ];
    public $timestamps =false;


}
