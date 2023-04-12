<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Http;

class ReCaptcha implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $client = new Client([
            'secret' => config('app.recaptcha_secret_key'),
            'response' => $value
        ]);
        $res = $client->request("GET", "https://www.google.com/recaptcha/api/siteverify");
        
        $data = json_decode($res->getBody()->getContents()); 
        return $data["success"];
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $message = __('data.alert_recaptcha');;
    }
}
