<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Concourse;
use App\Models\ConcourseWriter;
use App\Models\Formation;
use Illuminate\Http\Request;

class ConcourseController extends Controller
{
    //

    // public function index()
    // {
    //     $formations = Formation::where('status', 'active')->get();
    //     $concourses = Concourse::where('status', '!=', 'deleted')->get();
    //     return view('pages.concourse.concourse-management')
    //         ->with("formations", $formations)
    //         ->with("concourses", $concourses);
    // }
    // public function deletedConcourse()
    // {
    //     $concourses = Concourse::where('status', 'deleted')->get();
    //     return view('pages.concourse.deleted-concourse')->with("concourses", $concourses);
    // }

    public function concourseWriters()
    {
        $concourseWriters = ConcourseWriter::get();
        $classes = Classe::where('status', 'active')->get();
        return view('pages.concourse.concourse-writers')
            ->with("classes", $classes)
            ->with('concourseWriters', $concourseWriters);
    }

}
