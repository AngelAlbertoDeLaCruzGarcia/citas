<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\ChatMessage;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Stevebauman\Purify\Facades\Purify;

class UsuariosController extends Controller
{
    public function index(){
        return Inertia::render('User/Inicio', [
            'Usuarios' => User::all(),
        ]);
    }
    public function perfil()
    {
        $us = User::where('id',Auth::id())->get();
        $hist= ChatMessage::where('user_id',Auth::id())
        ->with('user')
        ->orderBy('created_at','asc')
        ->get();
        return Inertia::render('User/Perfil', [
            'usuarios'  => $us,
            'hists'     => $hist,
        ]);
    }
    public function show($idusuarios)
    {
        $hist= ChatMessage::where('user_id',$idusuarios)
        ->with('user')
        ->orderBy('created_at','asc')
        ->get();
        $usuarios = User::where('id',$idusuarios)->first();

        return Inertia::render('User/Show',[
            'usuarios' => $usuarios,
            'hists'     => $hist,
        ]);
    }
    public function newhistory(Request $request)
    {
        $newMessage = new ChatMessage();
        $newMessage->user_id      = Auth::id();
        $newMessage->chat_room_id = 1;
        $newMessage->titulo      = $request->titulo;
        $newMessage->message      = $request->historia;
        $newMessage->save();
        return Redirect::route('Perfil.index');

    }
    public function guardarImg(Request $request)
    {
        $nombre= $request['photo']->store('/storage/img','subirArchivos');
        $nombre='/'.$nombre;
        user::updateOrInsert(['id'=>Auth::id()],[
            'profile_photo_path'=>       $nombre,
        ]);
        return Redirect::route('Perfil.index');
    }
    public function buscar(Request $request)
    {
        $pa=User::where('name','LIKE','%'.$request->usuario.'%')
        ->orWhere('email','LIKE','%'.$request->usuario.'%')
        ->orWhere('estado','LIKE','%'.$request->usuario.'%')
        ->orWhere('sexo','LIKE','%'.$request->usuario.'%')
        ->orWhere('edad','LIKE','%'.$request->usuario.'%')
        ->get();
        return Inertia::render('User/Buscar',[
            'Usuarios' => $pa,
            'nombre'=>$request->usuario,
        ]);
    }
    public function buscarA(Request $request)
    {
        $pa=User::where('estado','LIKE','%'.$request->estado.'%')
        ->where([
            ['edad', '>=', $request->edadmin],
            ['edad', '<=', $request->edadmax],
        ])
        ->get();
        return Inertia::render('User/Buscar',[
            'Usuarios' => $pa,
            'nombre'=>$request->usuario,
        ]);
    }

    /*
    public function store(Request $request)
    {
        $request->validate([
            'name'=>   'required',
            'email'=>      'required|unique:Users,email',
            'password'=>      'required',
        ],
        [
            'name.required' => 'El nombre es requerido',
            'emal.required' => 'La correo es requerida',
            'password.required' => 'La contraseña es requerida',
        ]);
        User::updateOrInsert([
            'name'=>      Purify::clean($request->name),
            'email'=>     $request->email,
            'password'=>  Hash::make($request->password),
            'created_at'=>     now(),
            'updated_at'=>     now(),

        ]);
        return redirect()->route('Inicio.index')->with('success','Mensaje enviado');

    }*/
}
