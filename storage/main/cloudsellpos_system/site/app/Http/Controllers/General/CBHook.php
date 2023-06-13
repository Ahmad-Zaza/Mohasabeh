<?php 
namespace App\Http\Controllers;
namespace App\Http\Controllers\General;

class CBHook extends Controller {

	/*
	| --------------------------------------
	| Please note that you should re-login to see the session work
	| --------------------------------------
	|
	*/
	
	
	public function afterLogin() {
		
		return redirect()->back();
	}
}