<?php
namespace App\Http\Controllers\General;
use App\Models\Currencies\Currency;

class CurrenciesFunctionsController extends Controller{

    public function getDefaultCurrency()
    {
        $currency = Currency::where('is_major', 1)->first();

        return $currency->id;
    }

    public function getExchangeRate($currencyId)
    {
        $currency = Currency::find($currencyId);
        return response()->json($currency);
    }

    
    public function getOppositeExchangeRate($currency_id,$opposite)
    {
        $gfunc = new GeneralFunctionsController();
        $majorCurr = $gfunc->getMajorCurrency();
        $opposite_ex_rate = 0;
        if ($currency_id == $majorCurr->id && $opposite == $majorCurr->id) {
            $opposite_ex_rate = 1;
        }
        elseif ($currency_id == $majorCurr->id && $opposite != $majorCurr->id) {
            $opposite_ex_rate = Currency::where('id', $opposite)->first()->ex_rate; 
        }
        elseif ($currency_id != $majorCurr->id && $opposite == $majorCurr->id) {
            $opposite_ex_rate = Currency::where('id', $currency_id)->first()->ex_rate;
        }
        elseif ($currency_id != $majorCurr->id && $opposite != $majorCurr->id) {
            if ($currency_id == $opposite) {
                $opposite_ex_rate = 1;
            }
            else {
                $curr_ex_rate = Currency::where('id', $currency_id)->first()->ex_rate;
                $opp_ex_rate = Currency::where('id', $opposite)->first()->ex_rate;
                $opposite_ex_rate = $curr_ex_rate / $opp_ex_rate;
            }
        }

        return round($opposite_ex_rate, 2);
    }

}