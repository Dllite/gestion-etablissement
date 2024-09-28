<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    //

    public function index()
    {
        $roles = Role::get();
        $users = User::where('id', '!=', 1)->where('status', '!=', 'deleted')->get();
        return view('pages.user.user-management')->with("roles", $roles)->with("users", $users);
    }
    public function deletedUser()
    {
        $users = User::where('status', 'deleted')->get();
        return view('pages.user.deleted-user')->with("users", $users);
    }

    public function userProfile()
    {
        return view('pages.user.user-profile');
    }


    public function addUser(Request $request)
    {
        $attributes = $request->validate([
            'first_name' => "required|max:50|string",
            'last_name' => "required|max:50|string",
            'email'     => "required|max:50|string",
            'role_id'     => "required|max:50",
            'gender'    => "required",
        ]);


        $response = [
            "type" => "",
            "message" => "",
        ];

        if ($this->checkEmail($attributes['email'])) {

            $attributes['password'] = Hash::make('12345678');
            // dd($attributes);
            User::create($attributes);
            $response = [
                "type" => "success",
                "message" => "Utilisateur ajouté avec succès",
            ];
        } else {
            $response = [
                "type" => "danger",
                "message" => "Cet email existe déjà",
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

    public function changeUserStatus($id, $status)
    {

        $response = [
            "type" => "",
            "message" => "",
        ];
        $user = User::find($id);
        if ($user) {
            $user->status = $status;
            $user->save();

            if ($status === "active") {
                $response = [
                    "type" => "success",
                    "message" => "Utilisateur activé avec succès",
                ];
            } else {
                $response = [
                    "type" => "success",
                    "message" => "Utilisateur suspendu avec succès",
                ];
            }
        } else {
            $response = [
                "type" => "danger",
                "message" => "Cet utilisateur n'existe pas",
            ];
        }


        return redirect()->back()->with($response['type'], $response["message"]);
    }

    public function deleteUser($id)
    {

        try {
            $user = User::find($id);
            $user->status = "deleted";
            $user->save();

            $response = [
                "type" => "success",
                "message" => "Cet utilisateur a été supprimé avec succès",
            ];
        } catch (\Throwable $th) {
            $response = [
                "type" => "danger",
                "message" => "internal server error",
            ];
        }


        return redirect()->back()->with($response['type'], $response['message']);
    }

    public function restoreUsers()
    {

        try {
            User::where('status', 'deleted')->update([
                "status" => 'active'
            ]);

            $response = [
                "type" => "success",
                "message" => "Tous les utilisateurs on été restauré avec succès",
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
