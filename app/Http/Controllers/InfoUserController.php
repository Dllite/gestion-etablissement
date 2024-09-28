<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\View;

class InfoUserController extends Controller
{

    public function create()
    {
        return view('pages.user-profile');
    }

    public function store(Request $request)
    {

        $attributes = request()->validate([
            'first_name' => ['required', 'max:50'],
            'last_name' => ['required', 'max:50'],
            'phone'     => ['max:50'],
            'location' => ['max:70'],
            'about_me'    => ['max:150'],
        ]);

        User::where('id', Auth::user()->id)
            ->update([
                'first_name'    => $attributes['first_name'],
                'last_name' => $attributes['last_name'],
                'phone'     => $attributes['phone'],
                'location' => $attributes['location'],
                'about_me'    => $attributes["about_me"],
            ]);


        return redirect()->back()->with('success', 'Profil mise à jour avec succès');
    }

    public function changeUserPassword(Request $request)
    {
        $fields = $request->validate([
            "old_password" => "required",
            "new_password" => "required",
            "c_password" => "required",
        ]);
        $response = [
            "type" => "",
            "message" => "",
        ];
        if ($fields["new_password"] === $fields["c_password"]) {
            if ($fields["new_password"] !== $fields["old_password"]) {
                try {

                    $attributes = [
                        "email" => auth()->user()->email,
                        "password" => $fields["old_password"]
                    ];

                    if (Auth::attempt($attributes)) {
                        $user_id = auth()->user()->id;
                        User::where('id', $user_id)->update([
                            "password" => Hash::make($fields["new_password"]),
                        ]);
                        $response = [
                            "type" => "success",
                            "message" => "Mot de passe modifié avec succès",
                        ];
                        Auth::logout();
                    } else {

                        $response = [
                            "type" => "danger",
                            "message" => "L'ancien mot de passe ne correspond pas",
                        ];
                    }
                } catch (\Throwable $th) {
                    $response = [
                        "type" => "danger",
                        "message" => "internal server error",
                    ];
                }
            } else {
                $response = [
                    "type" => "danger",
                    "message" => "Le nouveau mot de passe ne doit pas être identique à l'ancien",
                ];
            }
        } else {
            $response = [
                "type" => "danger",
                "message" => "Le mot de passe ne correspond pas",
            ];
        }

        return redirect()->back()->with($response['type'], $response['message']);
    }
}
