<?php

namespace App\Http\Controllers;

use App\Models\ConcourseWriter;
use App\Models\Payment;
use Illuminate\Http\Request;


class PaymentController extends Controller
{
    //
    public function addPayment(Request $request)
    {
        // dd('request', $request);
        $attributes = $request->validate([
            'amount_paid' => "required",
            'libelle' => "required",
            'contact' => "required",
            'tranche' => "required",
            'payment_mode' => "required",
            'student_id' => 'required',
        ]);


        $response = [
            "type" => 422,
            "message" => "",
        ];

        $student = ConcourseWriter::find($attributes['student_id']);

        if ($student) {
            try {

                $attributes["user_id"] = auth()->user()->id;
                $attributes["concourse_writer_id"] = $attributes['student_id'];
                // dd($attributes['student_id'], $attributes);

                Payment::create($attributes);

                $amount_paid = Payment::where('concourse_writer_id', $attributes['student_id'])->sum('amount_paid');
                $payments = Payment::where('concourse_writer_id', $attributes['student_id'])->get();
                $max = -100000 - (int)$amount_paid;

                if ($max === 0) {
                    $student->payment_status = "valid";
                    $student->save();
                }

                $response = [
                    "type" => 200,
                    "message" => "Paiement effectué avec succès",
                ];
            } catch (\Throwable $th) {
                $response = [
                    "type" => 500,
                    "message" => $th->getMessage(),
                ];
            }
        } else {

            $response = [
                "type" => 422,
                "message" => "L'élève n'existe pas",
            ];
        }
        return response($response['message'], $response['type']);
    }
}
