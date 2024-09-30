@extends('layouts.user_type.guest')

@section('content')
    <style>
        .container-main {
            background-color: #c8ad7f86;
            height: 100vh;
        }
    </style>
    <main class="main-content container-main mt-0">
        <section>
            <div class="page-header">
                <div class="container">
                    <div class="row">
                        <div class="card form-main mt-2">
                            <div class="card-header pb-0 text-left bg-transparent">
                                <h3 class="font-weight-bolder text-info text-gradient"> <a href="/">Paiement de concours
                                        ou Examen de dossier</a></h3>
                            </div>
                            <div class="card-body">
                                <form role="form" method="POST" id="myForm">
                                    @csrf
                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <label>Nom</label>
                                            <input type="name" class="form-control" name="first_name" id="first_name"
                                                placeholder="Nom de l'élève" aria-label="name" required>
                                        </div>
                                        <div class="col-6">
                                            <label>Prénom</label>
                                            <input type="name" class="form-control" name="last_name" id="last_name"
                                                placeholder="Prénom de l'élève" aria-label="name" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <label>Ancienneté</label>
                                            <select class="form-control" name="anciennete" id="anciennete" required>
                                                <option></option>
                                                <option value="ancien">Ancien</option>
                                                <option value="nouveau">Nouveau</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <label for="payment_mode">Cycle</label>
                                            <select class="form-control" name="cycle" id="cycle" required>
                                                <option></option>
                                                <option value="1">Cycle 1</option>
                                                <option value="2">Cycle 2</option>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label for="payment_mode">Classe</label>
                                            <select class="form-control" name="classe_id" id="classe_id" required>
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label>Droit scolaire</label>
                                        <select class="form-control" name="type" id="type" required>
                                            <option></option>
                                            <option value="concourse">Concours : 100 000</option>
                                            <option value="etude_dossier"> Etude de dossier : 200 000</option>
                                        </select>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <label>Adresse</label>
                                            <input type="name" class="form-control" name="address" id="address"
                                                placeholder="Adresse" aria-label="name" required>
                                        </div>
                                        <div class="col-6">
                                            <label>Contact</label>
                                            <input minlength="9" maxlength="9" class="form-control" name="contact_number"
                                                id="contact" placeholder="Contact" required>
                                        </div>
                                    </div>
                                    <label>Libelle</label>
                                    <div class="mb-3">
                                        <textarea class="form-control" name="libelle" id="libelle" cols="30" rows="5" required></textarea>
                                    </div>
                                    <label for="payment_mode">Moyen de paiement</label>
                                    <div class="mb-3">
                                        <select class="form-control" name="payment_mode" id="payment_mode" required>
                                            <option></option>
                                            <option value="Orange">OM</option>
                                            <option value="MTN">MOMO</option>
                                        </select>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">Valider</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src='https://terminal.giselpay.com/live/start?v=1.0'></script>

    <script>
        document.getElementById('myForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Empêche le rechargement de la page

            // Déterminez le montant en fonction du type de paiement sélectionné
            var amount = document.getElementById('type').value === 'concourse' ? 500 : 1000;

            // Récupérer les valeurs du formulaire et inclure le montant dans formData2
            var formData2 = {
                first_name: document.getElementById('first_name').value,
                last_name: document.getElementById('last_name').value,
                anciennete: document.getElementById('anciennete').value,
                cycle: document.getElementById('cycle').value,
                classe_id: document.getElementById('classe_id').value,
                type: document.getElementById('type').value,
                address: document.getElementById('address').value,
                contact: document.getElementById('contact').value,
                libelle: document.getElementById('libelle').value,
                payment_mode: document.getElementById('payment_mode').value,
                total_amount: amount // Ajout du montant à formData2
            };

            // Initialiser les données de paiement pour GiselPay
            var formData = {
                user_name: document.getElementById('first_name').value + ' ' + document.getElementById(
                    'last_name').value,
                amount: amount, // Utiliser la même valeur pour le montant
                description: document.getElementById('libelle').value,
                token: '22EMN+K2QBZ8enkEw5GPz.f9ANmKzs20240928', // Remplacez par votre vrai token GiselPay
                reference_order: 'INV-' + new Date().getTime() // Générer une référence unique
            };

            console.log("Données du paiement à envoyer :", formData);

            // Étape 1 : Initialiser le paiement via l'API GiselPay
            $.ajax({
                type: "POST",
                url: "https://app.giselpay.com/api/v2/payment",
                data: JSON.stringify(formData),
                contentType: "application/json",
                dataType: "json",
                success: function(response) {
                    console.log('Réponse de GiselPay :', response);

                    // Vérifier si l'initialisation du paiement est réussie
                    if (response && response.reference) {
                        Swal.fire({
                            title: 'Paiement en cours',
                            text: 'Veuillez valider votre paiement.',
                            icon: 'info',
                            showConfirmButton: false,
                            allowOutsideClick: false
                        });

                        // Lancer le panel de paiement avec la référence renvoyée
                        init_giselpay(response.reference);

                        // Étape 2 : Écouter la fermeture du panel de paiement GiselPay pour récupérer la référence
                        window.addEventListener("message", function(e) {
                            var data = e.data;
                            if (data.close_panel !== undefined) {
                                var ref = data.ref;
                                console.log('Panel de paiement fermé avec la référence :', ref);

                                // Vérification du statut du paiement via GiselPay API
                                $.ajax({
                                    type: "POST",
                                    url: "https://app.giselpay.com/api/v2/check",
                                    data: JSON.stringify({
                                        "reference": ref,
                                        "token": '22EMN+K2QBZ8enkEw5GPz.f9ANmKzs20240928'
                                    }),
                                    contentType: "application/json",
                                    dataType: "json",
                                    success: function(response) {
                                        console.log(
                                            'Réponse de la vérification du paiement :',
                                            response);
                                        console.log(
                                            'Statut :',
                                            response.statut);
                                        console.log(
                                            'Result :',
                                            response.result.statut);
                                        if (response && response.result.statut === 'valide') {
                                            formData2.payment_reference =
                                            ref; // Ajouter la référence de paiement

                                            // Soumettre les données au backend
                                            fetch("{{ route('add-concourse-writer') }}", {
                                                    method: 'POST',
                                                    headers: {
                                                        'Content-Type': 'application/json',
                                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                    },
                                                    body: JSON.stringify(
                                                        formData2)
                                                })
                                                .then(response => response.json())
                                                .then(data => {
                                                    console.log(
                                                        'Réponse du backend après soumission :',
                                                        data);

                                                    Swal.fire({
                                                        title: 'Paiement Terminé!',
                                                        text: 'Votre paiement a été validé et les données ont été enregistrées.',
                                                        icon: 'success',
                                                        confirmButtonText: 'OK'
                                                    }).then(() => {
                                                        window.location
                                                            .href =
                                                            "/generate-invoice"; // Redirige vers la page d'accueil ou une autre page
                                                    });
                                                })
                                                .catch(error => {
                                                    console.error(
                                                        'Erreur lors de la soumission des données :',
                                                        error);
                                                    Swal.fire({
                                                        title: 'Erreur!',
                                                        text: 'Erreur lors de la soumission des données après le paiement : ' +
                                                            error
                                                            .message,
                                                        icon: 'error',
                                                        confirmButtonText: 'Réessayer'
                                                    });
                                                });
                                        } else {
                                            Swal.fire({
                                                title: 'Erreur!',
                                                text: 'Le paiement n\'a pas pu être validé. Veuillez réessayer.',
                                                icon: 'error',
                                                confirmButtonText: 'Réessayer'
                                            });
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        console.error(
                                            "Erreur lors de la vérification du paiement :",
                                            error);
                                    }
                                });
                            }
                        });

                    } else {
                        Swal.fire({
                            title: 'Erreur!',
                            text: 'Impossible de lancer le paiement. Veuillez réessayer.',
                            icon: 'error',
                            confirmButtonText: 'Réessayer'
                        });
                    }
                },
                error: function(error) {
                    console.error('Erreur lors de l\'initialisation du paiement :', error);
                    Swal.fire({
                        title: 'Erreur!',
                        text: 'Erreur lors de l\'initialisation du paiement. Veuillez réessayer.',
                        icon: 'error',
                        confirmButtonText: 'Réessayer'
                    });
                }
            });
        });




        // javascript pour gerer les classes en fonction des cycles
        var selectElement = document.getElementById('cycle');
        var selectUser = document.getElementById('classe_id');

        var users = {!! json_encode($classes->toArray()) !!};

        selectElement.addEventListener('change', function() {
            var value = this.value;
            var newUsers = [];
            users.forEach(user => {
                if (user.cycle == value) {
                    newUsers.push(user)
                }
            });
            var startingHtml = "<option></option>";

            newUsers.forEach(user => {
                startingHtml = startingHtml +
                    `<option value="${user.id}">${user.name}</option>`;
            })

            selectUser.innerHTML = startingHtml;
        });

        // //payment function
        // function placePayment() {
        //     const apiUrl = 'https://api.monetbil.com/payment/v1/placePayment';
        //     const contact = document.getElementById('contact').value;
        //     const requestBody = {
        //         service: 'geYKBeSEmjzCr9xj4gaxSzTvQKp5kcXM',
        //         phonenumber: contact,
        //         amount: '100',
        //         notify_url: 'http://localhost:8000',
        //     };

        //     return new Promise((resolve, reject) => {
        //         fetch(apiUrl, {
        //                 method: 'POST',
        //                 headers: {
        //                     'Content-Type': 'application/json',
        //                 },
        //                 body: JSON.stringify(requestBody),
        //             })
        //             .then(response => {
        //                 if (response.ok) {
        //                     return response.json();
        //                 } else {
        //                     throw new Error('Request failed');
        //                 }
        //             })
        //             .then(data => {
        //                 resolve({
        //                     status: true,
        //                     response: data
        //                 });
        //             })
        //             .catch(error => {
        //                 console.error('API request failed:', error);
        //                 resolve({
        //                     status: false,
        //                     response: error
        //                 });
        //             });
        //     });
        // }

        // function checkPayment(paymentId) {
        //     const apiUrl = 'https://api.monetbil.com/payment/v1/checkPayment';
        //     const data = new URLSearchParams({
        //         paymentId
        //     });

        //     return fetch(apiUrl, {
        //             method: 'POST',
        //             headers: {
        //                 'Content-Type': 'application/x-www-form-urlencoded',
        //             },
        //             body: data.toString(),
        //         })
        //         .then(response => {
        //             if (response.ok) {
        //                 return response.json();
        //             } else {
        //                 throw new Error('Request failed');
        //             }
        //         })
        //         .then(jsonArry => {
        //             if (jsonArry.transaction) {
        //                 const status = jsonArry.transaction.status;
        //                 console.log(jsonArry.transaction.status);
        //                 if (status == 1) {
        //                     // Successful payment
        //                     return {
        //                         status: 'success'
        //                     };
        //                 } else if (status == -1) {
        //                     alert('Annuler le paiement');
        //                     // Transaction cancelled
        //                     return {
        //                         status: 'cancelled'
        //                     };
        //                 } else {
        //                     alert('Echec du paiement');
        //                     // Payment failed
        //                     return {
        //                         status: 'failed'
        //                     };
        //                 }
        //             } else {
        //                 document.getElementById('paymentMessage').innerHTML = "En attente de validation....";
        //                 return {
        //                     status: 'waiting'
        //                 };
        //             }
        //         })
        //         .catch(error => {
        //             console.error('API request failed:', error);
        //             return {
        //                 status: 'error',
        //                 error
        //             };
        //         });
        // }

        // function pollPaymentStatus(paymentId) {
        //     const checkInterval = 5000; // 5 seconds

        //     function checkAndHandleStatus() {
        //         checkPayment(paymentId)
        //             .then(result => {
        //                 if (result.status == 'success' || result.status == 'cancelled' || result.status ==
        //                     'failed') {
        //                     $(function() {

        //                         $.ajax({
        //                             url: '{{ url('add-concourse-writer') }}',
        //                             type: 'POST',
        //                             data: $('#myForm').serialize(),
        //                             success: function(response) {
        //                                 console.log("response", response);
        //                                 alert('Paiement effectué avec succès')
        //                                 modal.style.display = 'none';
        //                                 document.getElementById('myForm').reset();
        //                             },
        //                             error: function(error) {
        //                                 console.log("error", error);
        //                                 alert('Erreur lors de l\'ajout du paiement')
        //                                 modal.style.display = 'none';
        //                             }
        //                         })
        //                     })
        //                 } else {
        //                     // Continue polling
        //                     setTimeout(checkAndHandleStatus, checkInterval);
        //                 }
        //             });
        //     }

        //     checkAndHandleStatus(); // Initial check
        // }
    </script>
@endsection
