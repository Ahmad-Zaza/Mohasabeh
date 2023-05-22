<?php

namespace App;

use App\PricingReport;
use Illuminate\Database\Eloquent\Model;

class PricePkg extends Model
{
    //
    public function price_pkg_options()
    {
        return $this->hasMany('\App\PricePkgOption', 'price_pkg_id');
    }
    public function price_pkg_main_options()
    {
        return $this->hasMany('\App\PricePkgOption', 'price_pkg_id')->where('type', 1);
    }
    public function price_pkg_mult_options()
    {
        $items = $this->hasMany('\App\PricePkgOption', 'price_pkg_id')->where('type', 2)->first();
        $values = explode(',', $items->value);
        $reports = PricingReport::select('*')->WhereIn('id', $values)->get();
        return $reports;
    }
}
