<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SessionsController extends Controller
{
    public function create()
    {
        return view('session.login-session');
    }

    public function store()
    {
        $attributes = request()->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($attributes)) {
            session()->regenerate();
            if (auth()->user()->role_id === 3) {
                return redirect('user-profile')->with(['success' => 'Vous êtes connecté.']);
            }
            return redirect('dashboard')->with(['success' => 'Vous êtes connecté.']);
        } else {

            return back()->withErrors(['email' => 'Email ou Mot de passe non valide .']);
        }
    }

    public function destroy()
    {

        Auth::logout();

        return redirect('/')->with(['success' => 'Vous avez été déconnecté.']);
    }
}
