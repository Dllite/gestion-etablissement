<?php

namespace App\Http\Controllers;

use App\Models\ConcourseWriter;
use App\Models\Formation;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index(){
        $users = User::count();
        $accountants = User::where('role_id', 2)->count();
        $parents = User::where('role_id', 3)->count();
        $students = ConcourseWriter::where('status', 'student')->count();

        return view('pages.dashboard')
        ->with('users', $users)
        ->with('accountants', $accountants)
        ->with('parents', $parents)
        ->with('students', $students);
    }
}
