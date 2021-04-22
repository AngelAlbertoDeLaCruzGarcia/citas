<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
class enviarNotiController extends Controller
{
    public function index(Request $request)
    {
        try {
            //$basic = new \Vonage\Client\Credentials\SignatureSecret('e19f5089', 'BH3e5nZJai5BG6RL', 'sha256');
            ///$client = new \Vonage\Client(new Vonage\Client\Credentials\SignatureSecret('e19f5089', 'BH3e5nZJai5BG6RL', 'sha256'));

            $basic  = new \Vonage\Client\Credentials\Basic(getenv("NEXMO_KEY"), getenv("NEXMO_SECRET"));
            $client = new \Vonage\Client($basic);
            $response = $client->sms()->send(
                new \Vonage\SMS\Message\SMS('527716838276', 'Huastecas', 'Probando SMS Huasteca')
            );

            $message = $response->current();

            if ($message->getStatus() == 0) {

                echo "Message status: " . $response->current()->getStatus() . "\n";
                echo "Sent message to " . $message->getTo() . ". Balance is now " . $message->getRemainingBalance() . PHP_EOL;
                echo "The message was sent successfully\n";

            } else {
                echo "The message failed with status: " . $message->getStatus() . "\n";
            }
        } catch (\Exception $e) {
            dd("Error: ". $e->getMessage());
        }

    }
}
