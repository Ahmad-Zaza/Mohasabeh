<?php

namespace App\Models\Data;

use Illuminate\Database\Eloquent\Model;

class Backup extends Model
{
    public $table="backups";
    protected $fillable = [
        'name', 'file_name','attachs_folder', 'date', 'note'
    ];
    protected $hidden = [
        'active', 'sorting'
    ];
    public $timestamps = false;

}