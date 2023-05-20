<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Inventory extends Model
{
    public $table="inventories";

    public $fillable = ['name_en','name_ar','code','delegate_id','major_classification','active','parent_id','sorting','note'];
    public $timestamps =false;

    public function childs() {
        return $this->hasMany('App\Inventory','parent_id','id') ;
    }
    
    
         public function parent()
        {
            return $this->belongsTo('App\Inventory', 'parent_id');
        }


	 	public function getParentsAttribute()
		{
		    $parents = collect([]);
		
		    $parent = $this->parent;
		
		    while(!is_null($parent)) {
		        $parents->push($parent);
		        $parent = $parent->parent;
		    }
		
		    return $parents;
		}

	  public function getAllChildren ()
	    {
	        $sections = new Collection();
	
	        foreach ($this->childs as $section) {
	            $sections->push($section);
	            $sections = $sections->merge($section->getAllChildren());
	        }
	
	        return $sections;
	    }
}