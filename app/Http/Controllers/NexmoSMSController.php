<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NexmoSMSController extends Controller
{
    //
    public function index()
    {
        try {

            $basic  = new \Nexmo\Client\Credentials\Basic(getenv("NEXMO_KEY"), getenv("NEXMO_SECRET"));
            $client = new \Nexmo\Client($basic);

            $receiverNumber = "918148743097";
            $message = "This is testing from ItSolutionStuff.com";

            $message = $client->message()->send([
                'to' => $receiverNumber,
                'from' => 'Vonage APIs',
                'text' => $message
            ]);

            dd('SMS Sent Successfully.');

        } catch (Exception $e) {
            dd("Error: ". $e->getMessage());
        }
    }
}
