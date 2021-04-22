<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\HomeController;
use App\Models\team_user;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
/*
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});*/
Route::get('/redirects',[HomeController::class,'index']);

Route::get('/', function () {
    return Redirect::route('Inicio.index');
});

Route::resource('/Inicio', 'App\Http\Controllers\UsuariosController');
Route::get('/Perfil', 'App\Http\Controllers\UsuariosController@perfil')->name('Perfil.index');
Route::post('/newhistory', 'App\Http\Controllers\UsuariosController@newhistory');
Route::post('/guardarImg', 'App\Http\Controllers\UsuariosController@guardarImg');

Route::resource('/Contact', 'App\Http\Controllers\ContactController');
Route::resource('/users', 'App\Http\Controllers\UsersController');
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    $role = team_user::select('role')->where('user_id', Auth::id())->value('role');
    if ($role=='admin')
        return Inertia::render('Dashboard');
    else
       return Redirect::route('Inicio.index');

})->name('dashboard');
Route::get('/enviarNoti','App\Http\Controllers\enviarNotiController@index');
Route::get('/IS', function () {
    return Inertia::render('User/Login');
})->name('IS');
Route::get('/Reg', function () {
    return Inertia::render('User/Registrar');
})->name('Reg');
Route::post('/bcorreo', 'App\Http\Controllers\bcorreoController@store');

///chat
Route::get('chat', function () {
    return Inertia::render('User/Chat/Contenedor');
});
Route::get('/chat/rooms', 'App\Http\Controllers\ChatController@rooms');
Route::get('/chat/room/{roomId}/messages', 'App\Http\Controllers\ChatController@messages');
Route::post('/chat/room/{roomId}/message', 'App\Http\Controllers\ChatController@newMessage');

Route::post('/buscar', 'App\Http\Controllers\UsuariosController@buscar');
Route::post('/buscarA', 'App\Http\Controllers\UsuariosController@buscarA');
Route::get('/buscarB', 'App\Http\Controllers\UsuariosController@buscar');


Route::get('datos', function () {
    return Auth::user();
})->name('datos');
