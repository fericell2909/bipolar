<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Newsletter;
use App\Mail\NewsletterSuscribed;

class NewsletterController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|max:255',
            'name'  => 'required|between:1,255',
        ]);
        

        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $remoteip = $_SERVER['REMOTE_ADDR'];
        $data = [
                'secret' => config('recaptcha.api_secret_key'),
                'response' => $request->get('recaptcha'),
                'remoteip' => $remoteip
            ];
        $options = [
                'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data)
                ]
            ];
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $resultJson = json_decode($result);
        
        if($resultJson->success != true ) {
             return response()->json(['message' => 'Mensaje No enviado']);
        }

        if($resultJson->score >= 0.9 ) {

            $name = $request->input('name');

            if(config('app.env') === 'production') {
                Newsletter::subscribeOrUpdate($request->input('email'), ['firstName' => $name], '', ['state' => 'pending']);
            }
    
            \Mail::to($request->input('email'))->send(new NewsletterSuscribed($name));
    
            return response()->json(['message' => 'Mensaje Enviado']);
        
        } else {

            $request->session()->flash('Mensaje No Enviado', false);
            return redirect()->back();
        
        } 
    }
}
