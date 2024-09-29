<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Facture</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">

    <!-- External CSS libraries -->
    <link type="text/css" rel="stylesheet" href="assets-invoice/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="assets-invoice/fonts/font-awesome/css/font-awesome.min.css">

    <!-- Favicon icon -->
    <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">

    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900">

    <!-- Custom Stylesheet -->
    <link type="text/css" rel="stylesheet" href="assets/css/style.css">

    <!-- Print-specific styles -->
    <style>
        @media print {
            @page {
                margin: 0; /* Supprime les marges de la page */
            }
            body {
                margin: 0; /* Supprime les marges du body */
                padding: 0; /* Supprime tout remplissage du body */
            }
            #invoice_wrapper {
                margin: 0;
                padding: 0;
                width: 100%; /* Prend toute la largeur de la page */
            }
        }

        /* Style spécifique pour redimensionner le QR code */
        .qr-code-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }
        .qr-code-container svg {
            width: 100px; /* Définit la largeur du QR code */
            height: 100px; /* Définit la hauteur du QR code */
        }
    </style>
</head>
<body>

<!-- Invoice 1 start -->
<div class="invoice-1 invoice-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="invoice-inner clearfix">
                    <div class="invoice-info clearfix" id="invoice_wrapper">
                        <div class="invoice-headar">
                            <div class="row g-0">
                                <div class="col-sm-6">
                                    <div class="invoice-logo">
                                        <div class="logo">
                                            <img src="assets/img/logos/logo.png" alt="logo">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 invoice-id">
                                    <div class="info">
                                        <h1 class="color-white inv-header-1">FACTURE</h1>
                                        <p class="color-white mb-1">Numero <span>#45613</span></p>
                                        <p class="color-white mb-0">Date <span id="invoice_date"></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="invoice-top">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="invoice-number mb-30">
                                        <h4 class="inv-title-1">Facture à</h4>
                                        <h2 class="name mb-10">Jean Dupont</h2>
                                        <p class="invo-addr-1">
                                            Contact : 6236959 <br/>
                                            Yaoundé, Cameroun <br/>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="invoice-number mb-30">
                                        <div class="invoice-number-inner">
                                            <h4 class="inv-title-1">Facture par</h4>
                                            <h2 class="name mb-10"> Collège Saint Charles LWANGA D'AMBAM</h2>
                                            <p class="invo-addr-1">
                                                169 Teroghoria, Bangladesh <br/>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="invoice-center">
                            <div class="table-responsive">
                                <table class="table mb-0 table-striped invoice-table">
                                    <thead class="bg-active">
                                    <tr class="tr">
                                        <th class="pl0 text-start"> Description</th>
                                        <th class="text-end">Montant</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr class="tr">
                                        <td class="pl0">Paiement frais de concours</td>
                                        <td class="text-end">$600.00</td>
                                    </tr>
                                    <tr class="tr2">
                                        <td></td>
                                        <td class="f-w-600 text-end active-color">$795.99</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="invoice-bottom">
                            <div class="row">
                                <div class="col-lg-6 col-md-8 col-sm-7"></div>
                                <div class="col-lg-6 col-md-4 col-sm-5">
                                    <div class="qr-code-container">
                                        {!! $qrCodeData !!}
                                    </div>

                                    <div class="mb-30 payment-method">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="invoice-contact clearfix">
                            <div class="row g-0">
                                <div class="col-lg-9 col-md-11 col-sm-12">
                                    <div class="contact-info">
                                        <a href="tel:+55-4XX-634-7071"><i class="fa fa-phone"></i> +00 123 647 840</a>
                                        <a href="mailto:info@themevessel.com"><i class="fa fa-envelope"></i> info@csc.com</a>
                                        <a href="#" class="mr-0 d-none-580"><i class="fa fa-map-marker"></i> Yaoundé, Cameroun</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="invoice-btn-section clearfix d-print-none">
                        <a href="javascript:window.print()" class="btn btn-lg btn-print">
                            <i class="fa fa-print"></i> Imprimer
                        </a>
                        <a id="invoice_download_btn" class="btn btn-lg btn-download btn-theme">
                            <i class="fa fa-download"></i> Télécharger
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Invoice 1 end -->

<script src="assets-vitrine/js/jquery.min.js"></script>
<script src="assets-vitrine/js/jspdf.min.js"></script>
<script src="assets-vitrine/js/html2canvas.js"></script>
<script>
    // Génération de la date actuelle
    document.getElementById('invoice_date').textContent = new Date().toLocaleDateString('fr-FR');

    // Téléchargement en PDF avec suppression des marges
    document.getElementById('invoice_download_btn').addEventListener('click', function () {
        html2canvas(document.getElementById('invoice_wrapper')).then(canvas => {
            const imgData = canvas.toDataURL('image/png');
            const pdf = new jsPDF('p', 'mm', 'a4');
            const imgWidth = 210; // Largeur du PDF
            const imgHeight = canvas.height * imgWidth / canvas.width;
            pdf.addImage(imgData, 'PNG', 0, 0, imgWidth, imgHeight);
            pdf.save("facture_sans_marge.pdf");
        });
    });
</script>
</body>
</html>
