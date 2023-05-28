<?php

namespace App\Rules;

use crocodicstudio\crudbooster\helpers\CRUDBooster;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Lang;

class NotGlobalDomain implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $globalDomains = explode(", ", CRUDBooster::getSetting('not_allowed_domains'));
        dd($globalDomains);
        foreach ($globalDomains as $globalDomain) {
            if ($value == $globalDomain) {
                return false;
            }
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('data.domain_not_allowed', [], Lang::getLocale());
    }
}
