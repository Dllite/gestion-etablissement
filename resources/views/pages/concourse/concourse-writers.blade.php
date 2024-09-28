@extends('layouts.user_type.auth')

@section('content')
    <div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModalMessage" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ajouter un eleve</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form role="form" method="POST" id="myForm" action="/add-student-temp">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-6">
                                    <label>Nom</label>
                                    <input type="name" class="form-control" name="first_name" id="first_name"
                                        placeholder="Nom de l'étudiant" aria-label="name" required>
                                </div>
                                <div class="col-6">
                                    <label>Prénom</label>
                                    <input type="name" class="form-control" name="last_name" id="last_name"
                                        placeholder="Prénom de l'étudiant" aria-label="name" required>
                                </div>
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
                                    <input minlength="9" maxlength="9" class="form-control" name="contact_number"
                                        id="contact" placeholder="Contact" aria-label="number" required>
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

                            <div class="text-center">
                                <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">Ajouter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Tous les candidats au concours ( {{ count($concourseWriters) }} )</h5>
                        </div>

                        <button type="button" class="btn bg-gradient-success btn-block mb-3" data-bs-toggle="modal"
                            data-bs-target="#exampleModalMessage">
                            +&nbsp; Nouveau Student
                        </button>
                    </div>
                </div>

                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        ID
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Nom
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        adresse
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        contact
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Type
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Status
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Date de création
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($concourseWriters as $concourseWriter)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $concourseWriter->id }}
                                            </p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $concourseWriter->first_name }} {{ $concourseWriter->last_name }}
                                            </p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $concourseWriter->address }}
                                            </p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $concourseWriter->contact_number }}
                                            </p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $concourseWriter->type }}
                                            </p>
                                        </td>

                                        <td class="text-center">
                                            <span class="text-secondary text-xs font-weight-bold">
                                                {{ $concourseWriter->status }}
                                            </span>
                                        </td>

                                        <td class="text-center">
                                            <span class="text-secondary text-xs font-weight-bold">
                                                {{ $concourseWriter->created_at }}
                                            </span>
                                        </td>
                                        @if ($concourseWriter->status === 'pending')
                                            <td class="text-center">
                                                <a class="mx-3" onclick="rejectConcourse({{ $concourseWriter->id }})"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-original-title="rejetter la candidature">
                                                    <i class="fas fa-stop"></i>
                                                </a>
                                                <a class="mx-3" onclick="acceptConcourse({{ $concourseWriter->id }})"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-original-title="accepter la candidature"><i
                                                        class="fas fa-solid fa-check"></i>
                                                </a>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
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

        function acceptConcourse(id) {
            var result = window.confirm("Voulez-vous accepter ce candidat ?");
            if (result) {
                window.location.href = "/concourse-writer-status/" + id + "/accepted";
            }
        }

        function rejectConcourse(id) {
            var result = window.confirm("Voulez-vous rejetter ce candidat ?");
            if (result) {
                window.location.href = "/concourse-writer-status/" + id + "/rejected";
            }
        }
    </script>
@endsection
