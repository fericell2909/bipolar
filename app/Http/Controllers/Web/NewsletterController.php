<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Newsletter;

class NewsletterController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|max:255',
            'name'  => 'required|between:1,255',
        ]);

        Newsletter::subscribeOrUpdate($request->input('email'), ['firstName' => $request->input('name')]);

        flash()->success('Gracias por registrarte a nuestro newsletter. Esperemos disfrutes de las promociones');

        return redirect()->back();
    }
}