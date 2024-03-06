<?php

namespace App\Service; // Ensure correct namespace declaration

use Twilio\Rest\Client;

class SmsSender
{
    public function sendSms($to, $message)
    {
        $accountSid = $_ENV['TWILIO_ACCOUNT_SID']; 
        $authToken = $_ENV['TWILIO_AUTH_TOKEN']; 
        $fromNumber = $_ENV['TWILIO_PHONE_NUMBER'];

        $client = new Client($accountSid, $authToken);
        $client->messages->create(
            $to,
            [
                'from' => $fromNumber,
                'body' => $message
            ]
        );
    }
}
