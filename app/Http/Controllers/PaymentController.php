<?php

namespace App\Http\Controllers;

use App\Models\ConcourseWriter;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    
    
    public function store(Request $request)
    {
        session_start();
        $data = $request->all();

        // Stocker les données dans la session
        session()->put('payment_data', $data);

        // Effectuer une action quelconque, comme enregistrer les données (facultatif)
        // Par exemple : Payment::create($data);

        // Retourner une réponse JSON correcte
        return response()->json(['message' => 'Données reçues et stockées avec succès dans la session!', 'data' => $data], 200);
    }
    
    
    
    
    
    public function initPayment(Request $request)
    {
        // Définir les montants en fonction du type
        $amount = $request->type === 'concourse' ? 100000 : ($request->type === 'etude_dossier' ? 200000 : 0);

        // Vérifier si le type est valide
        if ($amount === 0) {
            return response()->json(['error' => 'Type de paiement invalide'], 400);
        }

        // Préparer les données de la requête
        $data = [
            'user_name' => $request->input('first_name'),
            'amount' => $amount,
            'description' => $request->input('libelle'),
            'token' => config('giselpay.token'),
            'reference_order' => 'REF-' . now()->format('YmdHis'), // Génération d'une référence unique
        ];
        // dd($data);

        // Loguer les données pour vérification (utilisé ici au lieu du dd)
        \Log::info('Données de paiement : ', $data);

        try {
            // Envoyer la requête via le client HTTP de Laravel
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post(config('giselpay.api_url') . 'payment', $data);

            // Vérifier la réponse

            $res = $response->json();
            // dd( $res);
            if ($res['statut'] === 'ok') {
                return response()->json($res);
            }

            // Gérer le cas où la réponse ne contient pas la référence ou est en échec
            return response()->json(['error' => 'Erreur de traitement'], 400);
        } catch (\Exception $e) {
            // Gérer les exceptions éventuelles
            \Log::error('Erreur lors du traitement du paiement : ' . $e->getMessage());
            return response()->json(['error' => 'Erreur lors de l\'envoi de la requête'], 500);
        }
    }

    public function checkPayment(Request $request)
    {
        $data = [
            'reference' => $request->input('reference'),
            'token' => config('giselpay.token'),
        ];

        // Utiliser le client HTTP de Laravel pour vérifier le paiement
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post(config('giselpay.api_url') . 'check', $data);

        if ($response->successful()) {
            return response()->json($response->json());
        }

        // Gérer les erreurs
        return response()->json(['error' => 'Erreur lors de la vérification du paiement'], 500);
    }
}
