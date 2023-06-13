<?php

namespace App\Models\SystemConfigration;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class StatisticSetting extends Model
{
    public $table="statistics_setting";

    protected $fillable = [
        'name','value'
    ];
    public $timestamps =false;


}
