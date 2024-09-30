@extends('layouts.user_type.auth')

@section('content')
    <style>
        .new-modal {
            display: none;
            position: fixed;
            z-index: 3000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
        }

        .new-modal-content {
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

    {{-- <div id="newModal" class="new-modal">
        <div class="new-modal-content">
            <span class="close">&times;</span>
            <h2>Paiement</h2>
            <p>En attente de validation sur le numéro <span id="pay_number"></span> </p>
            <p id="paymentMessage"></p>
            <button class="btn btn-primary" id="closeModalBtn">Annuler</button>
        </div>
    </div> --}}
    <div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModalMessage" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Effectuer le paiement</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form id="myForm" action="/add-payment" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <input type="number" value="{{ $student->id }}" name="student_id" required
                                    style="display: none">
                                <div class="form-group col-12">
                                    <label>Montant du paiement</label>
                                    <input name="amount_paid" id="amount_paid" placeholder="amuont paied" type="number"
                                        max="{{ $max }}" class="form-control" required readonly />
                                </div>
                                <div class="mb-3">
                                    <label>Tranche</label>
                                    <select class="form-control" name="tranche" id="tranche" required>
                                        <option></option>
                                        <option value="inscription">Inscription : 10 000</option>
                                        <option value="tranche1">1er tranche : 30 000</option>
                                        <option value="tranche2"> 2e tranche: 30 000</option>
                                        <option value="tranche3"> 3e tranche : 40 000</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Libellé</label>
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
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn bg-gradient-success">Effectuer le paiment</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 mt-4">
                    <div class="card mb-4">
                        <div class="card-header pb-0 p-3 d-flex flex-row justify-content-between">
                            <div class="col-auto my-auto">
                                <h5 class="mb-1">
                                    {{ $student->first_name }} {{ $student->last_name }}
                                </h5>
                            </div>

                            @if ($student->payment_status !== 'valid' && auth()->user()->role_id === 3)
                                <button type="button" class="btn bg-gradient-success btn-block mb-3" data-bs-toggle="modal"
                                    data-bs-target="#exampleModalMessage">
                                    +&nbsp; Effectuer le paiement
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-12">
                    <div class="card h-100">
                        <div class="card-header pb-0 p-3">
                            <div class="row">
                                <div class="col-md-8 d-flex align-items-center">
                                    <h6 class="mb-0">Information du Profil</h6>
                                </div>
                            </div>
                        </div>
                        <div class="row card-body">
                            <div class="col-6">
                                <ul class="list-group">
                                    <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">
                                            Nom de l'élève:</strong> &nbsp;{{ $student->first_name }}
                                        {{ $student->last_name }}
                                    </li>
                                    <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">
                                            Matricule:</strong> &nbsp;{{ $student->matricule }}</li>
                                    <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">
                                            Ancienneté:</strong> &nbsp;{{ $student->anciennete }}</li>
                                    <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">
                                            Cycle:</strong> &nbsp;{{ $student->classe->cycle }}</li>
                                    <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">
                                            Classe:</strong> &nbsp;{{ $student->classe->name }}</li>
                                    <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">
                                            Adresse:</strong> &nbsp;{{ $student->address }}</li>
                                    <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">
                                            Status:</strong> &nbsp;{{ $student->student_status }}</li>

                                    <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">
                                            Statut du paiement:</strong> &nbsp;{{ $student->payment_status }}</li>
                                    <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">
                                            Date de Création:</strong> &nbsp;{{ $student->created_at }}</li>
                                </ul>
                            </div>
                            <div class="col-6">
                                <ul class="list-group">
                                    <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">
                                            Prix:</strong> &nbsp;110000 Fcfa</li>
                                    <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">
                                            Inscription:</strong>
                                        &nbsp;10 000 Fcfa
                                    </li>
                                    <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">
                                            Premier Versement:</strong>
                                        &nbsp;30 000 Fcfa
                                    </li>
                                    <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">
                                            Second Versement:</strong>
                                        &nbsp;30 000 Fcfa
                                    </li>
                                    <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">
                                            Troisième Versement:</strong>
                                        &nbsp;40 000 Fcfa
                                    </li>
                                    <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">
                                            Nom du Parent:</strong> &nbsp;{{ $student->user->first_name }}
                                        {{ $student->user->last_name }}</li>
                                    <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">
                                            Email du Parent:</strong> &nbsp;{{ $student->user->email }}</li>
                                    <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">
                                            Contact du Parent:</strong> &nbsp;{{ $student->user->phone }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-12 mt-4">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="d-flex flex-row justify-content-between">
                                <div>
                                    <h5 class="mb-0">Tous les paiement des élèves ( {{ count($payments) }} ) /
                                        {{ $amount_paid }} Fcfa payé et {{ $max }} Fcfa restant </h5>
                                </div>
                            </div>
                        </div>

                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">

                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                ID
                                            </th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Montant
                                            </th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                libellé
                                            </th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Numero de paiement
                                            </th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Moyen de paiement
                                            </th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                tranche
                                            </th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Créer à
                                            </th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Payer par
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($payments as $payment)
                                            <tr>
                                                <td class="ps-4">
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        {{ $payment->id }}
                                                    </p>
                                                </td>
                                                <td class="text-center">
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        {{ $payment->amount_paid }} Fcfa
                                                    </p>
                                                </td>

                                                <td class="text-center">
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        {{ $payment->libelle }}
                                                    </p>
                                                </td>

                                                <td class="text-center">
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        {{ $payment->contact }}
                                                    </p>
                                                </td>
                                                <td class="text-center">
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        {{ $payment->payment_mode }}
                                                    </p>
                                                </td>

                                                <td class="text-center">
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        {{ $payment->tranche }}
                                                    </p>
                                                </td>
                                                <td class="text-center">
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        {{ $payment->created_at }}
                                                    </p>
                                                </td>

                                                <td class="text-center">
                                                    <span class="text-secondary text-xs font-weight-bold">
                                                        {{ $payment->user->first_name }} {{ $payment->user->last_name }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src='https://terminal.giselpay.com/live/start?v=1.0'></script>
    <script>
        var modal = document.getElementById('exampleModalMessage');
        var openModalBtn = document.getElementById('openModalBtn');
        var closeModalBtn = document.getElementById('closeModalBtn');
        var student_id = {!! $student->id !!};
        // Fonction pour mettre à jour le montant en fonction du type de paiement sélectionné
        function updateAmount() {
            var trancheValue = document.getElementById('tranche').value;

            // Déterminer le montant en fonction du type de tranche
            var amount = trancheValue === 'inscription' ? 10000 :
                trancheValue === 'tranche1' ? 30000 :
                trancheValue === 'tranche2' ? 30000 :
                trancheValue === 'tranche3' ? 40000 : 0;

            // Modifier la valeur du champ 'amount_paid' avec le montant correspondant
            document.getElementById('amount_paid').value = amount;
        }
        amount = document.getElementById('amount_paid').value;

        // Ajouter un écouteur d'événement pour détecter les changements dans le champ de sélection 'tranche'
        document.getElementById('tranche').addEventListener('change', updateAmount);

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('myForm').addEventListener('submit', function(e) {
                e.preventDefault();
                // Fermer le modal
                var modal = new bootstrap.Modal(document.getElementById('exampleModalMessage'));
                modal.hide();

                // Récupérer les valeurs du formulaire et inclure le montant dans formData2
                // Récupérer la valeur de la tranche
                var tranche = document.getElementById('tranche').value;

                // Définir le prénom de l'étudiant à partir de Blade
                var first_name = "{{ $student->first_name }}";

                // Créer l'objet formData2
                var formData2 = {
                    first_name: "{{ $student->first_name }}", // Valeur depuis Blade
                    last_name: "{{ $student->last_name }}", // Valeur depuis Blade
                    tranche: tranche, // Récupéré depuis l'élément HTML
                    libelle: 'Paiement ' + tranche + ' pour l\'etudiant ' +
                        first_name, // Concaténation correcte
                    payment_mode: document.getElementById('payment_mode')
                        .value, // Récupéré depuis l'élément HTML
                    total_amount: document.getElementById('amount_paid').value, // Montant
                    anciennete: "{{ $student->anciennete }}", // Valeur depuis Blade
                    cycle: "{{ $student->classe->cycle }}", // Valeur depuis Blade
                    classe_id: "{{ $student->classe->id }}", // Valeur depuis Blade
                    type: tranche, // Tranche récupérée
                    address: "{{ $student->address }}", // Valeur depuis Blade
                    contact: "{{$student->contact}}", // Valeur fixe (à modifier si nécessaire après paiement réussi)
                    concourse_writer_id: "{{ $student->id }}"
                };


                //Initialiser les données de paiement pour GiselPay
                var formData = {
                    user_name: "{{ Auth::user()->first_name ?? '' }} {{ Auth::user()->last_name ?? '' }}",
                    amount: document.getElementById('amount_paid')
                    .value, // Utiliser la même valeur pour le montant
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
                                    console.log(
                                        'Panel de paiement fermé avec la référence :',
                                        ref);

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
                                            if (response && response.result
                                                .statut ===
                                                'valide') {
                                                formData2
                                                    .payment_reference =
                                                    ref;// Ajouter la référence de paiement

                                                // Soumettre les données au backend
                                                fetch("{{ route('recu') }}", {
                                                        method: 'POST',
                                                        headers: {
                                                            'Content-Type': 'application/json',
                                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                        },
                                                        body: JSON
                                                            .stringify(
                                                                formData2
                                                            )
                                                    })
                                                    .then(response =>
                                                        response.json())
                                                    .then(data => {
                                                        console.log(
                                                            'Réponse du backend après soumission :',
                                                            data);

                                                        Swal.fire({
                                                            title: 'Paiement Terminé!',
                                                            text: 'Votre paiement a été validé et les données ont été enregistrées.',
                                                            icon: 'success',
                                                            confirmButtonText: 'OK'
                                                        }).then(
                                                            () => {
                                                                window
                                                                    .location
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

                //document.getElementById('pay_number').innerHTML = contact;

                //placePayment()
                //  .then(result => {
                //    if (result.status) {
                //      const paymentId = result.response.paymentId;
                //    pollPaymentStatus(paymentId);
                //} else {
                //  console.error('Payment failed:', result.response);
                //}
                //});

            });
        });


        // closeModalBtn.addEventListener('click', function() {
        //     modal.style.display = 'none';
        // });


        //payment function
        // function placePayment() {
        //   const apiUrl = 'https://api.monetbil.com/payment/v1/placePayment';
        // const contact = document.getElementById('contact').value;
        //const requestBody = {
        //  service: 'geYKBeSEmjzCr9xj4gaxSzTvQKp5kcXM',
        // phonenumber: contact,
        //amount: '100',
        // notify_url: 'http://localhost:8000',
        //};

        //return new Promise((resolve, reject) => {
        //  fetch(apiUrl, {
        //        method: 'POST',
        //      headers: {
        //        'Content-Type': 'application/json',
        //  },
        //body: JSON.stringify(requestBody),
        // })
        //.then(response => {
        //  if (response.ok) {
        //    return response.json();
        //} else {
        //  throw new Error('Request failed');
        //}
        //})
        //.then(data => {
        //  resolve({
        //    status: true,
        //  response: data
        //});
        //})
        //.catch(error => {
        //  console.error('API request failed:', error);
        //resolve({
        //  status: false,
        //response: error
        //});
        //});
        //});
        //}

        //function checkPayment(paymentId) {
        //  const apiUrl = 'https://api.monetbil.com/payment/v1/checkPayment';
        //const data = new URLSearchParams({
        //  paymentId
        //});

        //return fetch(apiUrl, {
        //      method: 'POST',
        //    headers: {
        //      'Content-Type': 'application/x-www-form-urlencoded',
        //},
        //body: data.toString(),
        //})
        //.then(response => {
        //  if (response.ok) {
        //    return response.json();
        //} else {
        //  throw new Error('Request failed');
        //}
        //})
        //.then(jsonArry => {
        //  if (jsonArry.transaction) {
        //    const status = jsonArry.transaction.status;
        //  console.log(jsonArry.transaction.status);
        //if (status == 1) {
        // Successful payment
        //  return {
        //    status: 'success'
        //};
        //} else if (status == -1) {
        //  alert('Paiement annulé');
        // Transaction cancelled
        //return {
        //  status: 'cancelled'
        //};
        //} else {
        //  alert('Echec du paiement');
        // Payment failed
        //return {
        //  status: 'failed'
        //};
        //}
        //} else {
        //  document.getElementById('paymentMessage').innerHTML = "En attente de validation....";
        // return {
        //   status: 'waiting'
        //};
        //}
        //})
        //.catch(error => {
        //  console.error('API request failed:', error);
        //return {
        //  status: 'error',
        //error
        //};
        //});
        //}

        //function pollPaymentStatus(paymentId) {
        //  const checkInterval = 5000; // 5 seconds

        //function checkAndHandleStatus() {
        //  checkPayment(paymentId)
        //    .then(result => {
        //      if (result.status == 'success' || result.status == 'cancelled' || result.status ==
        //        'failed') {


        // $(function() {
        //     // $.ajaxSetup({
        //     //     headers: {
        //     //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     //     }
        //     // });
        //     $.ajax({
        //         url: '{{ url('add-payment') }}',
        //         type: 'POST',
        //         data: $('#myForm').serialize(),
        //         success: function(response) {
        //             console.log("response", response);
        //             alert('Paiement effectué avec succès')
        //             modal.style.display = 'none';
        //             document.getElementById('myForm').reset();
        //             window.location.reload();
        //         },
        //         error: function(error) {
        //             console.log("error", error);
        //             alert('Erreur lors de l\'ajour du paiement')
        //             modal.style.display = 'none';
        //         }
        //     })
        // })


        //} else {
        // Continue polling
        //  setTimeout(checkAndHandleStatus, checkInterval);
        //}
        //});
        //}

        //checkAndHandleStatus(); // Initial check
        //}
    </script>
@endsection
