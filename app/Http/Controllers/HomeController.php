<?php

namespace App\Http\Controllers;
use App\Models\team_user;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $role = team_user::select('role')->where('user_id', Auth::id())->value('role');
        if (Auth::check()) {
            if ($role=='admin')
            return Redirect::route('dashboard');
            else{
                return Redirect::route('Inicio.index');

            }

        }
    }
}
