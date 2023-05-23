<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class WebsiteReCapcha implements Rule
{
    public function __construct()
    {
        //
    }
    public function passes($attribute, $token)
    {
        $secretKey = config('app.recaptcha_secret_key');
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = array(
            'secret' => $secretKey,
            'response' => $token,
        );
        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data),
            ),
        );

        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $response = json_decode($result);
        return $response->success;
    }

    public function message()
    {
        return $message = cbLang('alert_recaptcha');
    }
}
