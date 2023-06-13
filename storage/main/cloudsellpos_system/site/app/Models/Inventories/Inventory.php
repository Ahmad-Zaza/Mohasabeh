<?php

namespace App\Models\Inventories;

use App\Models\Users\GeneralDelegate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Users\Delegate;


class Inventory extends Model
{
    public $table="inventories";

    protected $fillable = [
		'name_en','name_ar','code','delegate_id','major_classification','parent_id','note'
	];
	protected $hidden = [
		'active', 'sorting'
	];
    public $timestamps =false;

    public function childs() {
        return $this->hasMany('App\Models\Inventories\Inventory','parent_id','id') ;
    }
    

		public function parent()
	{
		return $this->belongsTo('App\Models\Inventories\Inventory', 'parent_id');
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

	/**
	 * The delegates that belong to the Inventory
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function delegates(): BelongsToMany
	{
		return $this->belongsToMany(GeneralDelegate::class, 'inventories_delegates', 'inventory_id', 'delegate_id');
	}

	

	public static function getCode($parent_id)
	{
		$parent = Inventory::where("id", $parent_id)->first();

		$code_parent = $parent->code;
		$childern = Inventory::where("parent_id", $parent->id)->get();

		if (count($childern) > 0) {
			$max = Inventory::where("parent_id", $parent_id)->max('code');
			return $max + 1;
		}
		else {
			return $code_parent . "01";
		}
	}

}