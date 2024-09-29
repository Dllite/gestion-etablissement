<?php

namespace App\Http\Controllers;

use BaconQrCode\Writer;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class QrCodeController extends Controller
{
    public function generateInvoiceAndQrCode()
    {
        session_start();
        try {
            // Récupérer les données de paiement depuis la session
            $data = session()->get('payment_data');

            // Vérifier si les données existent dans la session
            if (!$data) {
                return response()->json(['error' => 'Les données de paiement ne sont pas disponibles dans la session.'], 400);
            }

            // Génération de l'ID de la facture (par exemple, basé sur la date et l'heure actuelle)
            $invoiceNumber = 'INV-' . now()->format('YmdHis');

            // Ajout de l'ID de la facture aux données
            $data['invoice_number'] = $invoiceNumber;
            $data['date'] = now()->toDateString(); // Ajouter la date de génération

            // Génération du QR code
            $renderer = new ImageRenderer(
                new RendererStyle(200), // Taille du QR code
                new SvgImageBackEnd()
            );
            $writer = new Writer($renderer);

            // Contenu du QR code : les informations de la facture et du paiement
            $qrCodeContent = json_encode([
                'invoice_number' => $invoiceNumber,
                //'total_amount' => $data['total_amount'],
                'customer_name' => $data['first_name'] . ' ' . $data['last_name'],
                'date' => $data['date'],
            ]);

            // Générer le QR code avec les informations de la facture
            $qrCodeData = $writer->writeString($qrCodeContent); // Générer le QR code en format SVG

            // Retourner la vue avec le QR code et les informations de la facture
            return view('pages.invoice', [
                'qrCodeData' => $qrCodeData, // Le code QR généré
                'invoiceData' => $data // Les informations de la facture
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la génération de la facture et du QR Code', 'message' => $e->getMessage()], 500);
        }
    }
}
