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
        session_start();
        $data = $request->all();
        try {
            // Stocker les données dans la session
            session()->put('payment_data', $data);
            // Créer un nouvel enregistrement dans la base de données avec les données validées
            ConcourseWriter::create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'type' => $data['type'],
                'address' => $data['address'],
                'contact_number' => $data['contact'],
                'contact' => $data['contact'],
                'libelle' => $data['libelle'],
                'anciennete' => $data['anciennete'],
                'classe_id' => $data['classe_id'],
                'payment_mode' => $data['payment_mode'],
            ]);

            // Retourner une réponse JSON correcte
            return response()->json(['message' => 'Données reçues et stockées avec succès dans la session!', 'data' => $data], 200);
        } catch (\Throwable $th) {
            \Log::error("erreur lors de l'enregistrement du paiement :" . $th->getMessage());
            \Log::error("erreur :" . json_encode($data));
        }
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
