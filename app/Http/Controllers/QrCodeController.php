<?php

namespace App\Http\Controllers;

use BaconQrCode\Writer;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\Image\Png;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;

class QrCodeController extends Controller
{
    public function generate()
    {
        // Configuration du générateur de QR Code avec un backend SVG
        $renderer = new ImageRenderer(
            new RendererStyle(400),
            new SvgImageBackEnd()
        );
        $writer = new Writer($renderer);

        // Informations du reçu à inclure dans le QR code
        $receiptData = [
            'receipt_id' => '123456',
            'total_amount' => '250.00',
            'customer_name' => 'John Doe',
            'date' => now()->toDateString(),
        ];

        // Contenu structuré sous forme de JSON
        $qrCodeContent = json_encode($receiptData);

        // Générer le QR code avec les informations du reçu
        $qrCodeData = $writer->writeString($qrCodeContent);

        // Retourner la vue avec le QR code
        return view('pages.facture', ['qrCodeData' => $qrCodeData, 'receiptData' => $receiptData]);
    }

    public function saveQrCode()
    {
        // Configuration pour générer un QR code au format PNG
        $renderer = new ImageRenderer(
            new RendererStyle(200),
            new Png()
        );
        $writer = new Writer($renderer);

        // Contenu du reçu à inclure dans le QR code
        $receiptData = [
            'receipt_id' => '123456',
            'total_amount' => '250.00',
            'customer_name' => 'John Doe',
            'date' => now()->toDateString(),
        ];

        // Convertir les données en JSON
        $qrCodeContent = json_encode($receiptData);

        // Générer le QR code en chaîne de caractères (format PNG)
        $qrCodeData = $writer->writeString($qrCodeContent);

        // Chemin pour sauvegarder le fichier
        $outputFilePath = public_path('qrcodes/receipt_qrcode.png');

        // Créer le dossier "qrcodes" s'il n'existe pas
        if (!File::exists(public_path('qrcodes'))) {
            File::makeDirectory(public_path('qrcodes'), 0755, true);
        }

        // Sauvegarder le QR code sous forme d'image PNG
        file_put_contents($outputFilePath, $qrCodeData);

        return response()->json(['message' => 'QR Code generated and saved successfully!', 'file' => $outputFilePath]);
    }
}
