<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        return view('pages.home');
    }

    public function payConcourse(){
        $classes = Classe::where('status', 'active')->get();
        return view('pages.pay-concourse')
        ->with('classes', $classes)
        ;
    }
}
