<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use Illuminate\Http\Request;

class ClasseController extends Controller
{
    //
    public function index()
    {
        $classes = Classe::get();
        return view('pages.classe.classe-management')->with("classes", $classes);
    }


    public function addClasse(Request $request)
    {
        $attributes = $request->validate([
            'name' => "required",
            'cycle' => "required",
        ]);


        $response = [
            "type" => "",
            "message" => "",
        ];

        if ($this->checkClasseName($attributes['name'])) {
            Classe::create($attributes);
            $response = [
                "type" => "success",
                "message" => "Classe ajoutée avec succès",
            ];
        } else {
            $response = [
                "type" => "danger",
                "message" => "Cette classe existe déjà",
            ];
        }


        return redirect()->back()->with($response['type'], $response['message']);
    }

    public function checkClasseName($name)
    {
        if (Classe::where("name", $name)->count() > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function changeClassesStatus($id, $status)
    {

        $response = [
            "type" => "",
            "message" => "",
        ];
        $classe = Classe::find($id);
        if ($classe) {
            $classe->status = $status;
            $classe->save();

            if ($status === "active") {
                $response = [
                    "type" => "success",
                    "message" => "Classe activée avec succès",
                ];
            } else {
                $response = [
                    "type" => "success",
                    "message" => "Classe suspendue avec succès",
                ];
            }
        } else {
            $response = [
                "type" => "danger",
                "message" => "Cette classe n'existe pas!",
            ];
        }


        return redirect()->back()->with($response['type'], $response["message"]);
    }

}
