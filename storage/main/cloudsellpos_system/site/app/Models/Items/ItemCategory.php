<?php

namespace App\Models\Items;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ItemCategory extends Model
{
    public $table="item_categories";

    protected $fillable = [
        'name_en', 'name_ar', 'code', 'major_classification', 'parent_id'
    ];

    protected $hidden = [
        'active', 'sorting'
    ];
    public $timestamps =false;

    public function childs() {
        return $this->hasMany('App\Models\Items\ItemCategory','parent_id','id') ;
    }
    

        public function parent()
    {
        return $this->belongsTo('App\Models\Items\ItemCategory', 'parent_id');
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

        /**
         * Get all of the items for the ItemCategory
         *
         * @return \Illuminate\Database\Eloquent\Relations\HasMany
         */
        public function items(): HasMany
        {
            return $this->hasMany(Item::class, 'item_category_id', 'id');
        }
}
