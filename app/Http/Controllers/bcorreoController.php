<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\verifyCorreoMail;

use Illuminate\Http\Request;

class bcorreoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nombre' =>'required|max:30|string',
            'correo' =>'required|email|unique:users,email',
            'cadena' => 'required|max:6|alpha_num'
        ]);

        $contenido = new verifyCorreoMail($request);
        Mail::to($request->correo)->send($contenido);
        return redirect()->route('Reg');
        Log::channel('daily')->info('Verificacion de correo al registrar usuario '.$request->correo);
    }
}
