<?php

namespace App\Http\Controllers;

use App\Models\ConcourseWriter;
use Illuminate\Http\Request;

class ConcourseWriterController extends Controller
{
    //
    // public function index()
    // {
    //     $students = Student::where('status', '!=', 'deleted')->get();
    //     $formations = Formation::where('status', 'active')->get();
    //     return view('pages.student.student-management')
    //         ->with("formations", $formations)
    //         ->with("students", $students);
    // }
    // public function deletedStudent()
    // {
    //     $students = Student::where('status', 'deleted')->get();
    //     return view('pages.student.deleted-student')->with("students", $students);
    // }


    public function addConcourseWriters(Request $request)
    {
        $attributes = $request->validate([
            'first_name' => "required",
            'last_name' => "required",
            'type'     => "required",
            'address'     => "required",
            'contact' => "required",
            'libelle' => "required",
            'contact_number' => "required",
            'anciennete' => "required",
            'classe_id' => "required",
            'payment_mode'     => "required",
        ]);

        $response = [
            "type" => 422,
            "message" => "",
        ];


        try {

            ConcourseWriter::create($attributes);
            if ($attributes['type'] === "concourse") {
                $response = [
                    "type" => 200,
                    "message" => "Paiement et ajout du candidat effectuer avec succes",
                ];
            } else {
                $response = [
                    "type" => 200,
                    "message" => "Paiement et demande d'analyse du dossier effectuer avec succes",
                ];
            }
        } catch (\Throwable $th) {
            //throw $th;
            // dd($th->getMessage());
            $response = [
                "type" => 500,
                "message" => $th->getMessage(),
            ];
        }

        return response($response['message'], $response['type']);
        // return response()->json(['message' => 'Data submitted successfully']);
    }

    public function checkEmail($email)
    {
        if (ConcourseWriter::where("email", $email)->count() > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function changeConcourseWriterStatus($id, $status)
    {

        $response = [
            "type" => "",
            "message" => "",
        ];
        $concourseWriter = ConcourseWriter::find($id);
        if ($concourseWriter) {
            $concourseWriter->status = $status;
            $concourseWriter->save();

            if ($status === "accepted") {
                $response = [
                    "type" => "success",
                    "message" => "Candidat accepté avec succès",
                ];
            } else {
                $response = [
                    "type" => "success",
                    "message" => "Candidat rejetté avec succès",
                ];
            }
        } else {
            $response = [
                "type" => "danger",
                "message" => "Ce candidat n'existe pas",
            ];
        }
        return redirect()->back()->with($response['type'], $response["message"]);
    }
}
