<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Models\Module;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerModule extends Model
{
    use SoftDeletes;
    protected $table = 'customer_module';

    protected $fillable = ['customers_id','modules_id'];

    public function module(){
        return $this->belongsTo(Module::class,'modules_id');
    }
    
}
