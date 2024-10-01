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
                                    <input type="hidden" name="amount_paid" id="amount_paid" value="">
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
                                        <button type="submit" id="payButton"
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        // Fonction pour mettre à jour le montant en fonction du type de paiement sélectionné
        function updateAmount() {
            // Déterminer le montant en fonction du type de paiement sélectionné
            var typeValue = document.getElementById('type').value;
            var amount = typeValue === 'concourse' ? 500 : 1000;

            // Modifier la valeur du champ 'amount_paid' avec le montant correspondant
            document.getElementById('amount_paid').value = amount;
        }

        // Ajouter un écouteur d'événement pour détecter les changements dans le champ de sélection 'type'
        document.getElementById('type').addEventListener('change', updateAmount);

        // Ajouter un écouteur d'événement pour soumettre le formulaire
        document.getElementById('myForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Empêche le rechargement de la page

            // Appeler la fonction updateAmount() pour s'assurer que le montant est bien calculé
            updateAmount();

            // Récupérer le montant mis à jour
            var typeValue = document.getElementById('type').value;

            // Récupérer les valeurs du formulaire et inclure le montant dans formData2
            var formData2 = {
                first_name: document.getElementById('first_name').value,
                last_name: document.getElementById('last_name').value,
                anciennete: document.getElementById('anciennete').value,
                cycle: document.getElementById('cycle').value,
                classe_id: document.getElementById('classe_id').value,
                type: typeValue,
                address: document.getElementById('address').value,
                contact: document.getElementById('contact').value,
                libelle: document.getElementById('libelle').value,
                payment_mode: document.getElementById('payment_mode').value,
                total_amount: document.getElementById('amount_paid').value, // Ajout du montant calculé
            };

            // Configuration des options pour l'intégration Campay
            campay.options({
                payButtonId: "payButton",
                description: formData2.libelle,
                amount: formData2.total_amount,
                currency: "XAF",
                externalReference: 'INV-' + new Date().getTime(), // Génère une référence unique
                redirectUrl: "" // Redirige après le paiement si nécessaire
            });

            // Gestion du succès du paiement
            campay.onSuccess = function(data) {
                // Soumettre les données au backend après succès du paiement
                fetch("{{ route('add-concourse-writer') }}", {
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
                            window.location.href = "/generate-invoice"; // Redirige après succès
                        });
                    })
                    .catch(error => {
                        console.error('Erreur lors de la soumission des données :', error);
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
                console.log('Le modal de paiement a été fermé sans finaliser la transaction.');
            };
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
    </script>
@endsection
