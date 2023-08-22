<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendGridController extends Controller
{
    public function index() {
        return view('holding-page');
    }

    public function sendGird(Request $request){
        $email = new \SendGrid\Mail\Mail();
        $email->setFrom("discoverhamid@gmail.com", "Example User");
        $email->setSubject("Sending with SendGrid is Fun");
        $email->addTo("discovermasroorab@gmail.com", "Example User");
        $email->addContent("text/plain", "and easy to do anywhere, even with PHP");
        $email->addContent(
            "text/html", "<strong>and easy to do anywhere, even with PHP</strong>"
        );
        $sendgrid = new \SendGrid(config('services.sendgrid.key'));
        try {
            $response = $sendgrid->send($email);
            print $response->statusCode() . "\n";
            print_r($response->headers());
            print $response->body() . "\n";
        } catch (Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }
        
    }
}
