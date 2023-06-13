<?php
namespace App\Traits;

use App\Models\Items\Item;
use DB;
use CRUDBooster;
use Request;

trait ItemsTrait
{

	public function checkItemP_Code($p_code)
	{
		$res = Item::where('p_code', $p_code)->get();
		$bool = false;
		if (count($res) > 0) {
			$bool = true;
		}
		if ($bool) {
			//in add operation 
			return CRUDBooster::redirect(CRUDBooster::mainpath("add/"), trans('messages.p_code_must_unique'), "warning");

		}
	}
}