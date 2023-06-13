<?php

namespace App\Models\Users;
use Illuminate\Database\Eloquent\Model;


class Privilege extends Model
{

    public $table= "cms_privileges";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'is_superadmin','theme_color'
    ];
    protected $hidden = [
        'created_at', 'updated_at'
    ];
    
    
}
