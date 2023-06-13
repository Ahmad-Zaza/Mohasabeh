<?php

namespace App\Models\FinancialCycles;

use Illuminate\Database\Eloquent\Model;

class ReCalculateCycleHistory extends Model
{
    public $table="recalculate_cycle_history";
    protected $fillable = [
        'cycle_id','action', 'options','upgrade_cycle_id', 'date'
    ];
    
    public $timestamps = false;

}