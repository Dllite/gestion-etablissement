@extends('layouts.user_type.guest')

@section('content')
    <style>
        .container-main {
            background-color: #c8ad7f86;
            height: 100vh;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
        }

        .modal-content {
            background-color: #fff;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            border: 1px solid #333;
            border-radius: 5px;
            text-align: center;
        }

        .close {
            position: absolute;
            right: 10px;
            top: 10px;
            font-size: 20px;
            cursor: pointer;
        }
    </style>
    <main class="main-content container-main  mt-0">


        <div id="modal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Paiement</h2>
                <p>En attente de validation du paiement sur le numéro<span id="pay_number"></span> </p>
                <p id="paymentMessage"></p>
                <button class="btn btn-primary" id="closeModalBtn">Annuler</button>
            </div>
        </div>


        <section>
            <div class="page-header">
                <div class="container">
                    <div class="row">

                        @if (\Session::has('info'))
                            <div class="alert alert-info alert-dismissible fade show" role="alert">
                                <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                                <span class="alert-text"><strong>Info!</strong> {!! \Session::get('info') !!}</span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @php
                                Session::forget('info');
                            @endphp
                        @endif
                        @if (\Session::has('danger'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                                <span class="alert-text"><strong>Danger!</strong> {!! \Session::get('danger') !!}</span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @php
                                Session::forget('danger');
                            @endphp
                        @endif
                        @if (\Session::has('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                                <span class="alert-text"><strong>Succès!</strong> {!! \Session::get('success') !!}</span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @php
                                Session::forget('success');
                            @endphp
                        @endif
                        @if (\Session::has('warning'))
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                                <span class="alert-text"><strong>Attention!</strong>{!! \Session::get('warning') !!}</span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @php
                                Session::forget('warning');
                            @endphp
                        @endif
                        <div class="card form-main mt-2">
                            <div class="card-header pb-0 text-left bg-transparent">
                                <h3 class="font-weight-bolder text-info text-gradient"> <a href="/">
                                         </a> Paiement de concours ou Examen de dossier</h3>
                            </div>
                            <div class="card-body">
                                <form role="form" method="POST" id="myForm" action="{{ route('payment.init') }}">
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
                                            <div class="mb-3">
                                                <select class="form-control" name="anciennete" id="anciennete" required>
                                                    <option></option>
                                                    <option value="ancien">Ancien</option>
                                                    <option value="nouveau">Nouveau</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <label for="payment_mode">Cycle</label>
                                            <div class="mb-3">
                                                <select class="form-control" name="cycle" id="cycle" required>
                                                    <option></option>
                                                    <option value="1">Cycle 1</option>
                                                    <option value="2">Cycle 2</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <label for="payment_mode">Classe</label>
                                            <div class="mb-3">
                                                <select class="form-control" name="classe_id" id="classe_id" required>
                                                    <option></option>
                                                </select>
                                            </div>
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
                                            <div class="mb-3">
                                                <input type="name" class="form-control" name="address" id="address"
                                                    placeholder="Adresse" aria-label="name" required>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <label>Contact</label>
                                            <input minlength="9" maxlength="9" class="form-control"
                                                name="contact_number" id="contact" placeholder="Contact" required>
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
                                        <button type="submit"
                                            class="btn bg-gradient-info w-100 mt-4 mb-0">Valider</button>
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
    <script src='https://terminal.giselpay.com/live/start?v=1.0'></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.getElementById('myForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Empêche le rechargement de la page

            // Récupérer les valeurs des champs
            var name = document.getElementById('first_name').value;
            var libelle = document.getElementById('libelle').value;
            var type = document.getElementById('type').value;

            // Préparer les données pour l'initialisation du paiement
            var data = {
                first_name: name,
                libelle: libelle,
                type: type,
                _token: '{{ csrf_token() }}' // Inclure le token CSRF
            };

            // Envoi de la requête AJAX vers la route payment.init
            fetch('/giselpay/init', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(data => {
                    // Si la requête a réussi et renvoie une référence
                    if (data.statut === 'ok') {

                        console.log("Référence de paiement : ", data);
                        // Ici, tu peux rediriger l'utilisateur vers GiselPay pour finaliser le paiement
                        init_giselpay(data.reference);

                        // Ecouter les messages de l'iframe de GiselPay
                        window.addEventListener("message", (e) => {
                            var eventData = e.data;
                            if (eventData.close_panel !== undefined) {
                                var ref = eventData.ref;
                                console.log('Pop-up fermée', eventData);

                                fetch('/giselpay/check', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json', // Correction de l'erreur ici
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        },
                                        body: JSON.stringify({
                                            ref: ref
                                        }) // Encapsuler correctement les données
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        console.log('Données après la fermeture du pop-up', data);

                                        if (data.statut === 'valide') {
                                            Swal.fire({
                                                title: 'Paiement réussi!',
                                                text: 'Référence de paiement : ' + data
                                                    .reference,
                                                icon: 'success',
                                                confirmButtonText: 'OK'
                                            }).then(() => {
                                                // Logique pour envoyer les données via Ajax après validation du paiement
                                                $(function() {
                                                    $.ajax({
                                                        url: '{{ url('add-concourse-writer') }}',
                                                        type: 'POST',
                                                        data: $('#myForm')
                                                            .serialize(), // Sérialiser le formulaire
                                                        success: function(
                                                            response) {
                                                            console.log(
                                                                "response",
                                                                response
                                                                );
                                                            alert(
                                                                'Paiement effectué avec succès');
                                                            modal.style
                                                                .display =
                                                                'none';
                                                            document
                                                                .getElementById(
                                                                    'myForm'
                                                                    )
                                                                .reset(); // Réinitialiser le formulaire
                                                        },
                                                        error: function(
                                                            error) {
                                                            console.log(
                                                                "error",
                                                                error
                                                                );
                                                            alert(
                                                                'Erreur lors de l\'ajout du paiement');
                                                            modal.style
                                                                .display =
                                                                'none';
                                                        }
                                                    });
                                                });
                                                var recudata = {
                                                    nom: data.result.user_name,
                                                    prenom: data.result.user_name,
                                                    description: libelle,
                                                    type: type,
                                                    montant: data.result.amount,
                                                    date: data.result.date_init,
                                                    heure: data.heure_init,
                                                    statut: data.result.statut,
                                                }
                                                console.log(recudata)

                                                fetch('/recu', {
                                                    method: 'POST', // Ajout de la méthode POST
                                                    headers: {
                                                        'Content-Type': 'application/json',
                                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                    },
                                                    body: JSON.stringify(recuData)
                                                }).then(response => {
                                                    console.log(
                                                        'Reçu envoyé avec succès'
                                                    );
                                                }).catch(error => {
                                                    console.error(
                                                        'Erreur lors de l\'envoi du reçu : ' +
                                                        error.message);
                                                });
                                                console.log('Paiement terminé');
                                            });
                                        } else if (data.statut === 'error') {
                                            Swal.fire({
                                                title: 'Erreur!',
                                                text: 'Le paiement n\'a pas été effectué',
                                                icon: 'error',
                                                confirmButtonText: 'Réessayer'
                                            });
                                        }
                                    })
                                    .catch(error => {
                                        Swal.fire({
                                            title: 'Erreur!',
                                            text: 'Erreur lors de la vérification du paiement : ' +
                                                error.message,
                                            icon: 'error',
                                            confirmButtonText: 'OK'
                                        });
                                    });
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'Erreur!',
                            text: 'Erreur lors de l\'initialisation du paiement',
                            icon: 'error',
                            confirmButtonText: 'Réessayer'
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        title: 'Erreur!',
                        text: 'Erreur lors de l\'initialisation du paiement : ' + error.message,
                        icon: 'error',
                        confirmButtonText: 'Réessayer'
                    });
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
