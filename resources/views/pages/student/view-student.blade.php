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
                                <div class="form-group col-12">
                                    <label>Montant du paiement</label>
                                    <input name="amount_paid" id="amount_paid" placeholder="amuont paied" type="number"
                                        max="{{ $max }}" class="form-control" required readonly />
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
                                <button type="submit" class="btn bg-gradient-success" id="payButton">Effectuer le
                                    paiment</button>
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

        // Ajouter un écouteur d'événement pour détecter les changements dans le champ de sélection 'tranche'
        document.getElementById('tranche').addEventListener('change', updateAmount);

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('myForm').addEventListener('submit', function(e) {
                e.preventDefault();
                // Fermer le modal
                var modal = new bootstrap.Modal(document.getElementById('exampleModalMessage'));
                modal.hide();

                // Récupérer les valeurs du formulaire et inclure le montant dans formData2
                var tranche = document.getElementById('tranche').value;
                var first_name = "{{ $student->first_name }}";

                var formData2 = {
                    first_name: "{{ $student->first_name }}",
                    last_name: "{{ $student->last_name }}",
                    tranche: tranche,
                    libelle: 'Paiement ' + tranche + ' pour l\'etudiant ' + first_name,
                    payment_mode: document.getElementById('payment_mode').value,
                    total_amount: document.getElementById('amount_paid').value,
                    anciennete: "{{ $student->anciennete }}",
                    cycle: "{{ $student->classe->cycle }}",
                    classe_id: "{{ $student->classe->id }}",
                    type: tranche,
                    address: "{{ $student->address }}",
                    contact: "{{ $student->contact_number }}",
                    concourse_writer_id: "{{ $student->id }}"
                };

                // Intégration de Campay
                campay.options({
                    payButtonId: "payButton",
                    description: formData2.libelle,
                    amount: formData2.total_amount,
                    currency: "XAF",
                    externalReference: 'INV-' + new Date().getTime(),
                    redirectUrl: "" // Redirige après le paiement si nécessaire
                });

                // Gestion du succès du paiement
                campay.onSuccess = function(data) {

                    fetch("{{ route('recu') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify(formData2)
                        })
                        .then(response => response.json())
                        .then(data => {
                            Swal.fire({
                                title: 'Paiement Terminé!',
                                text: 'Votre paiement a été validé et les données ont été enregistrées.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href =
                                    "/generate-invoice"; // Redirige après succès
                            });
                        })
                        .catch(error => {
                            Swal.fire({
                                title: 'Erreur!',
                                text: 'Erreur lors de la soumission des données après le paiement : ' +
                                    error.message,
                                icon: 'error',
                                confirmButtonText: 'Réessayer'
                            });
                        });
                };

                // Gestion de l'échec du paiement
                campay.onFail = function(data) {
                    Swal.fire({
                        title: 'Erreur!',
                        text: 'Le paiement a échoué. Veuillez réessayer.',
                        icon: 'error',
                        confirmButtonText: 'Réessayer'
                    });
                };

                // Gestion de la fermeture du modal
                campay.onModalClose = function(data) {
                    console.log('Modal fermé avec statut: ' + data.status);

                };

            });

        });
    </script>
@endsection
