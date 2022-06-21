<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Account extends Model
{
    public $table="accounts";
    
        public $fillable = ['name_en','name_ar','code','major_classification','active','parent_id','sorting','person_id'];
        public $timestamps =false;
    
        public function childs() {
            return $this->hasMany('App\Account','parent_id','id') ;
        }
        
        
             public function parent()
            {
                return $this->belongsTo('App\Account', 'parent_id');
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

                
                $parent=Account::where("id",$parent_id)->first();

                $code_parent=$parent->code;
                $childern=$parent->getAllChildren();

                if(count($childern)>0){
                    $max=Account::where("parent_id",$parent_id)->max('code');
                    return $max+1;
                }
                else{
                    return $code_parent."01";
                }
                
            }
}
