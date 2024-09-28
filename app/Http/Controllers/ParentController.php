<?php

namespace App\Http\Controllers;

use App\Models\ConcourseWriter;
use App\Models\ParentModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ParentController extends Controller
{
    //
    public function index()
    {
        $parents = User::where('role_id', 3)->get();
        $concourseWriters = ConcourseWriter::where('status', 'accepted')->get();
        return view('pages.parent.parent-management')
            ->with("concourseWriters", $concourseWriters)
            ->with("concourseWriters", $concourseWriters)
            ->with("parents", $parents);
    }

    public function generateRandomString($length = 8)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $randomString;
    }

    public function addParent(Request $request)
    {
        $attributes = $request->validate([
            'first_name' => "required",
            'last_name' => "required",
            'email'     => "required",
            'gender'     => "required",
            'student_id'     => "required",
        ]);

        $response = [
            "type" => "",
            "message" => "",
        ];

        $student = ConcourseWriter::find($attributes['student_id']);

        if ($student) {
            if ($this->checkEmail($attributes['email'])) {

                try {
                    //code...
                    $randomString = "";
                    do {
                        $randomString = $this->generateRandomString(8);
                    } while ($this->checkMatricule($randomString));
                    $attributes['role_id'] = 3;
                    $attributes['password'] = Hash::make('12345678');
                    $user = User::create($attributes);
                    $student->status = "student";
                    $student->matricule = $randomString;
                    $student->student_status = "active";
                    $student->payment_status = "not valid";
                    $student->user_id = $user->id;
                    $student->save();
                    $response = [
                        "type" => "success",
                        "message" => "Parent ajouté avec succès",
                    ];
                } catch (\Throwable $th) {
                    //throw $th;
                    dd($th->getMessage());
                    $response = [
                        "type" => "danger",
                        "message" => "Internal server error",
                    ];
                }
            } else {
                $response = [
                    "type" => "danger",
                    "message" => "Cet email existe déjà",
                ];
            }
        } else {
            $response = [
                "type" => "danger",
                "message" => "Ce candidat n'existe pas",
            ];
        }
        return redirect()->back()->with($response['type'], $response['message']);
    }

    public function checkEmail($email)
    {
        if (User::where("email", $email)->count() > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function checkMatricule($matricule)
    {
        if (ConcourseWriter::where("matricule", $matricule)->count() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function addStudentParent(Request $request)
    {
        $fields = $request->validate([
            "student_id" => 'required',
            "parent_id" => 'required'
        ]);

        $student = ConcourseWriter::find($fields['student_id']);
        $parent = User::find($fields['parent_id']);

        if ($student) {
            if ($parent) {
                try {
                    //code...
                    $randomString = "";
                    do {
                        $randomString = $this->generateRandomString(8);
                    } while ($this->checkMatricule($randomString));
                    $student->status = "student";
                    $student->student_status = "active";
                    $student->payment_status = "not valid";
                    $student->matricule = $randomString;
                    $student->user_id = $fields['parent_id'];
                    $student->save();
                    $response = [
                        "type" => "success",
                        "message" => "Elève ajouté au parent avec succès",
                    ];
                } catch (\Throwable $th) {
                    //throw $th;
                    dd($th->getMessage());
                    $response = [
                        "type" => "danger",
                        "message" => "Internal server error",
                    ];
                }
            } else {
                $response = [
                    "type" => "danger",
                    "message" => "Ce parent n'existe pas",
                ];
            }
        } else {
            $response = [
                "type" => "danger",
                "message" => "Ce candidat n'existe pas",
            ];
        }
        return redirect()->back()->with($response['type'], $response['message']);
    }
}
