<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use Illuminate\Http\Request;

class FormationController extends Controller
{
    //

    public function index()
    {
        $formations = Formation::where('status', '!=', 'deleted')->get();
        return view('pages.formation.formation-management')->with("formations", $formations);
    }
    public function deletedFormation()
    {
        $formations = Formation::where('status', 'deleted')->get();
        return view('pages.formation.deleted-formation')->with("formations", $formations);
    }


    public function addFormation(Request $request)
    {
        $attributes = $request->validate([
            'name' => "required",
            'price' => "required",
            'installment_date_one'     => "required",
            'installment_date_two'     => "required",
            'installment_date_three'     => "required",
        ]);

        // dd($attributes);

        $response = [
            "type" => "",
            "message" => "",
        ];

        if ($this->checkName($attributes['name'])) {
            $attributes['user_id'] = auth()->user()->id;
            $price = (int)$attributes['price'];
            $attributes['installment_one'] = (string)round($price/3, 2);
            $attributes['installment_two'] = (string)round($price/3, 2);
            $attributes['installment_three'] = (string)round($price/3, 2);
            Formation::create($attributes);
            $response = [
                "type" => "success",
                "message" => "Formation added successfully",
            ];
        } else {
            $response = [
                "type" => "danger",
                "message" => "This name has already been used",
            ];
        }


        return redirect()->back()->with($response['type'], $response['message']);
    }

    public function checkName($name)
    {
        if (Formation::where("name", $name)->count() > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function changeFormationStatus($id, $status)
    {

        $response = [
            "type" => "",
            "message" => "",
        ];
        $formation = Formation::find($id);
        if ($formation) {
            $formation->status = $status;
            $formation->save();

            if ($status === "active") {
                $response = [
                    "type" => "success",
                    "message" => "formation activated successfully",
                ];
            } else {
                $response = [
                    "type" => "success",
                    "message" => "formation suspended successfully",
                ];
            }
        } else {
            $response = [
                "type" => "danger",
                "message" => "This formation doesn't exist",
            ];
        }


        return redirect()->back()->with($response['type'], $response["message"]);
    }

    public function deleteFormation($id)
    {

        try {
            $formation = Formation::find($id);
            $formation->status = "deleted";
            $formation->save();

            $response = [
                "type" => "success",
                "message" => "The formation has successfully deleted",
            ];
        } catch (\Throwable $th) {
            $response = [
                "type" => "danger",
                "message" => "internal server error",
            ];
        }


        return redirect()->back()->with($response['type'], $response['message']);
    }

    public function restoreFormations()
    {

        try {
            Formation::where('status', 'deleted')->update([
                "status" => 'active'
            ]);

            $response = [
                "type" => "success",
                "message" => "all deleted formations has successfully restored",
            ];
        } catch (\Throwable $th) {
            $response = [
                "type" => "danger",
                "message" => "internal server error",
            ];
        }


        return redirect()->back()->with($response['type'], $response['message']);
    }
}
