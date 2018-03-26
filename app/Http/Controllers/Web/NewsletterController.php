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

        $name = $request->input('name');

        Newsletter::subscribeOrUpdate($request->input('email'), ['firstName' => $name]);

        \Mail::to($request->input('email'))->send(new NewsletterSuscribed($name));

        //flash()->success('Gracias por registrarte a nuestro newsletter. Esperemos disfrutes de las promociones');

        return redirect()->back();
    }
}
