<?php

namespace App\Services\Sms;

use Illuminate\Support\Facades\Http;

class SmsService
{
    private $api_sms;

    public function __construct()
    {
        $this->api_sms = env('MICROSERVICES_API_SMS');
    }

    public function send($phone, $message)
    {

        $data = ['phone' => $phone, 'message' => $message];

        try {
            $response = Http::post($this->api_sms . '/send', $data);
        } catch (\Exception $th) {
            return false;
        }

        return $response;
    }
}
