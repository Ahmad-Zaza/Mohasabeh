<?php

namespace App\Models\SystemConfigration;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class SystemSetting extends Model
{
    public $table="system_settings";

    protected $fillable = [
        'setting_key','setting_value'
    ];
    public $timestamps =false;


}
