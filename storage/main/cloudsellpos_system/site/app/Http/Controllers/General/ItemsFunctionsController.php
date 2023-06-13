<?php
namespace App\Http\Controllers\General;
use App\Models\Items\Item;
use App\Models\Items\ItemCategory;

class ItemsFunctionsController extends Controller{

	public function getItemUnit($id)
	{
		$unit_name = Item::join('item_units', 'item_units.id', 'items.item_unit_id')
			->where('items.id', $id)->first()->name_ar;
		return $unit_name;
	}
    
	public function checkCategoryParentIsCorrect($id,$new_parent_id){
		$cat_info=ItemCategory::where('id',$id)->first();
		$all_children = $cat_info->getAllChildren();
		$new_parent_is_correct = true;
		foreach($all_children as $child){
			if($child->id == $new_parent_id){ //new parent is child to this categories
				$new_parent_is_correct = false;
				break;
			}
		}
		return $new_parent_is_correct;
	}

}