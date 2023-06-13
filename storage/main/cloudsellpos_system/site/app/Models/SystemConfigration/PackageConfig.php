<?php

namespace App\Models\SystemConfigration;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class PackageConfig extends Model
{
    public $table="package_config";

    protected $fillable = [
        'config_key','config_value'
    ];
    public $timestamps =false;


}
