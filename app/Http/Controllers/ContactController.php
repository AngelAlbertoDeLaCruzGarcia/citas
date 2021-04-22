<?php

namespace App\Http\Controllers;
use App\Mail\ContactoMail;
use Illuminate\Support\Facades\Mail;

use Inertia\Inertia;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(){
        return Inertia::render('Contacto');
    }
    public function store(Request $request)
    {
        $contenido = new ContactoMail($request);
        Mail::to('contacto@meetpeople.com')->send($contenido);
        return redirect()->route('Contact.index');

    }
}
