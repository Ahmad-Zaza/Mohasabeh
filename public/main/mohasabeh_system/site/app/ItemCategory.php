<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ItemCategory extends Model
{
    public $table="item_categories";

    public $fillable = ['name_en','name_ar','code','major_classification','active','parent_id','sorting'];
    public $timestamps =false;

    public function childs() {
        return $this->hasMany('App\ItemCategory','parent_id','id') ;
    }
    
    
         public function parent()
        {
            return $this->belongsTo('App\ItemCategory', 'parent_id');
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
		


			public static function getCode($parent_id)
            {

                
                $parent=ItemCategory::where("id",$parent_id)->first();

                $code_parent=$parent->code;
                $childern=$parent->getAllChildren();

                if(count($childern)>0){
                    $max=ItemCategory::where("parent_id",$parent_id)->max('code');
                    return $max+1;
                }
                else{
                    return $code_parent."01";
                }
                
            }
}
