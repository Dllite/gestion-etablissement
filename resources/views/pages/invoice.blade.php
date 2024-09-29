<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reçu de Paiement - Collège</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <style>
        body {
            background-color: #fffff;
            font-family: 'Poppins', sans-serif;
        }
        .invoice {
            max-width: 800px;
            margin: 40px auto;
            padding: 30px;
            border: 1px solid #ddd;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            page-break-after: avoid;
        }
        .invoice-header {
            border-bottom: 1px solid #ddd;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        .invoice-logo {
            max-width: 150px;
        }
        .invoice-title {
            font-size: 28px;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }
        .invoice-summary .total {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
        .qr-code-container h5 {
            margin-bottom: 10px;
        }
        .footer {
            padding: 20px;
            border-top: 1px solid #ddd;
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
            background: #f9f9f9;
        }
        .footer .icon {
            margin: 0 10px;
            color: #333;
        }
        .btn-back {
            background-color: #343a40;
            color: #fff;
            border-radius: 5px;
            padding: 10px 20px;
        }
        .btn-back:hover {
            background-color: #495057;
            text-decoration: none;
        }
        @media print {
            @page {
                size: A4 portrait;
                margin: 20mm;
            }
            body {
                -webkit-print-color-adjust: exact;
            }
            .invoice {
                box-shadow: none;
                margin: 0;
            }
            .btn, .btn-back {
                display: none;
            }
        }
    </style>
</head>
<body>
<div class="invoice" id="invoice-content">
    <div class="invoice-header text-center">
        <img src="/assets/img/logo.png" alt="College Logo" class="invoice-logo mb-3">
        <h1 class="invoice-title">Reçu de Paiement</h1>
        <p class="text-muted">Collège Saint Charles LWANGA D'AMBAM</p>
    </div>

    <div class="row invoice-details">
        <div class="col-6">
            <h5>Facturé à :</h5>
            <p>
                <strong>Nom :</strong> {{ $invoiceData['first_name'] }} {{ $invoiceData['last_name'] }}<br>
                <strong>Ancienneté :</strong> {{ $invoiceData['anciennete'] }}<br>
                <strong>Classe :</strong> {{ $invoiceData['classe_id'] }}<br>
                <strong>Adresse :</strong> {{ $invoiceData['address'] }}<br>
                <strong>Contact :</strong> {{ $invoiceData['contact'] }}<br>
            </p>
        </div>
        <div class="col-6 text-right">
            <h5>Détails de la Facture :</h5>
            <p>
                <strong>Numéro de Facture :</strong> {{ $invoiceData['invoice_number'] }}<br>
                <strong>Date :</strong> {{ $invoiceData['date'] }}<br>
                <strong>Moyen de Paiement :</strong> {{ $invoiceData['payment_mode'] }}<br>
            </p>
        </div>
    </div>

    <table class="table table-bordered table-hover">
        <thead>
        <tr class="table-active">
            <th>Description</th>
            <th>Montant (FCFA)</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{ $invoiceData['libelle'] }}</td>
            <td class="text-end">{{ number_format($invoiceData['total_amount'] ?? 0, 0, ',', ' ') }}</td>
        </tr>
        </tbody>
    </table>

    <div class="invoice-summary text-right">
        <p class="total">Montant Total : {{ number_format($invoiceData['total_amount'] ?? 0, 0, ',', ' ') }} FCFA</p>
    </div>

    <div class="qr-code-container text-center">
        <h5>Code QR de la Facture :</h5>
        <div>{!! $qrCodeData !!}</div>
    </div>

    <div class="footer">
        <p><strong>Collège Saint Charles LWANGA D'AMBAM</strong></p>
        <p>169, Rue de l'Éducation, Yaoundé, Cameroun</p>
        <p>
            <a href="tel:+237123456789" class="icon"><i class="fas fa-phone"></i> +237 123 456 789</a> |
            <a href="mailto:info@college-lwanga.cm" class="icon"><i class="fas fa-envelope"></i> info@college-lwanga.cm</a> |
            <a href="https://www.google.com/maps?q=Collège+Saint+Charles+LWANGA+D'AMBAM" target="_blank" class="icon"><i class="fas fa-map-marker-alt"></i> Yaoundé, Cameroun</a>
        </p>
    </div>
</div>

<div class="text-center mt-5">
    <a href="/" class="btn btn-back">Retour à la Page d'Accueil</a>
</div>
<!-- Boutons d'actions -->
<div class="text-center mt-4">
    <button id="printInvoice" class="btn btn-secondary">Imprimer</button>
    <button id="downloadInvoice" class="btn btn-success">Télécharger en PDF</button>
</div>

<!-- Inclusion de html2pdf.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>

<script>
    // Fonction pour imprimer uniquement le contenu de la facture
    document.getElementById('printInvoice').addEventListener('click', function () {
        var printContents = document.getElementById('invoice-content').innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
        window.location.reload(); // Recharger la page pour éviter les problèmes d'affichage après impression
    });

    // Fonction pour télécharger le reçu en PDF avec html2pdf.js
    document.getElementById('downloadInvoice').addEventListener('click', function () {
        const element = document.getElementById('invoice-content');
        html2pdf().from(element).set({
            filename: 'recu_paiement_college.pdf',
            jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
        }).save();
    });
</script>
</body>
</html>
