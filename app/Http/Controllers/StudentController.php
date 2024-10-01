<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\ConcourseWriter;
use App\Models\Formation;
use App\Models\Payment;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    //
    public function index()
    {
        $students = ConcourseWriter::where('status', 'student');
        if (auth()->user()->role_id === 3) {
            $students = $students->where('user_id', auth()->user()->id)->get();
        }else{
            $students = $students->get();
        }
        return view('pages.student.student-management')
            ->with("students", $students);
    }


    public function addStudent(Request $request)
    {
        $attributes = $request->validate([
            'first_name' => "required",
            'last_name' => "required",
            'address'     => "required",
            'contact_number' => "required",
            'classe_id' => "required",
        ]);

        $response = [
            "type" => "",
            "message" => "",
        ];


        try {
            $attributes['status'] = "accepted";
            $attributes['anciennete'] = "ancien";
            $attributes['payment_mode'] = "";
            $attributes['type'] = "ancien";
            $attributes['libelle'] = "";
            ConcourseWriter::create($attributes);
            $response = [
                "type" => "success",
                "message" => "Success",
            ];
        } catch (\Throwable $th) {
            //throw $th;
            // dd($th->getMessage());
            $response = [
                "type" => "danger",
                "message" => $th->getMessage(),
            ];
        }

        return redirect()->back()->with($response['type'], $response["message"]);
    }

    public function viewStudent($id)
    {
        $response = [
            "type" => "",
            "message" => "",
        ];
        try {
            //code...
            $student = ConcourseWriter::find($id);
            $amount_paid = Payment::where('concourse_writer_id', $id)->sum('amount_paid');
            $payments = Payment::where('concourse_writer_id', $id)->get();
            $max = 110000 - (int)$amount_paid;
            return view('pages.student.view-student')
                ->with('amount_paid', $amount_paid)
                ->with('payments', $payments)
                ->with('student', $student)
                ->with('max', $max);
        } catch (\Throwable $th) {
            dd($th->getMessage());
            $response = [
                "type" => "danger",
                "message" => "internal server error",
            ];
        }


        return redirect()->back()->with($response['type'], $response["message"]);
    }



    public function changeStudentStatus($id, $status)
    {

        $response = [
            "type" => "",
            "message" => "",
        ];
        $student = ConcourseWriter::find($id);
        if ($student) {
            $student->student_status = $status;
            $student->save();

            if ($status === "active") {
                $response = [
                    "type" => "success",
                    "message" => "élève activé avec succès",
                ];
            } else {
                $response = [
                    "type" => "success",
                    "message" => "élève suspendu avec succès",
                ];
            }
        } else {
            $response = [
                "type" => "danger",
                "message" => "Cet élève n'existe pas",
            ];
        }


        return redirect()->back()->with($response['type'], $response["message"]);
    }

}
