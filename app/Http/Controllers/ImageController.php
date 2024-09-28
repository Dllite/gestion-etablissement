<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    //
    public function upload($image, $location)
    {
        if (!session_id()) {
            session_start();
            $unq = session_id();
        }else{
            $unq = session_id();
        }
        $imageName = time() . '_' . $image->getClientOriginalName();

        $imageName = $unq . '_' . time() . '_' . str_replace(array('!', "@", '#', '$', '%', '^', '&', ' ', '*', '(', ')', ':', ';', ',', '?', '/' . '\\', '~', '`', '-'), '_', strtolower($imageName));
        $image->storeAs($location, $imageName, 'public');
        // $image->move(public_path('books'), $imageName);
        return $imageName;
    }
}
