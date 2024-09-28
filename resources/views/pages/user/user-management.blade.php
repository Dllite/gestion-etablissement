@extends('layouts.user_type.auth')

@section('content')
    <div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModalMessage" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ajouter un nouvel utilisateur</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="/add-user" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Nom:</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" required>
                            </div>


                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Prénom:</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" required>
                            </div>

                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Email:</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>

                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Rôle:</label>
                                <select class="form-control" id="role_id" name="role_id" required>
                                    <option></option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Sexe:</label>
                                <select class="form-control" id="gender" name="gender" required>
                                    <option></option>
                                        <option value="male">Masculin</option>
                                        <option value="female">Féminin</option>
                                </select>
                            </div>


                            <div class="modal-footer">
                                <button type="submit" class="btn bg-gradient-primary">Ajouter</button>
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
                            <h5 class="mb-0">Tous les Utilisateurs ( {{ count($users) }} )</h5>
                        </div>

                        <button type="button" class="btn bg-gradient-success btn-block mb-3" data-bs-toggle="modal"
                            data-bs-target="#exampleModalMessage">
                            +&nbsp; Nouvel Utilisateur
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
                                        Email
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        rôle
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        sexe
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Status
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Date de Création
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $user->id }}
                                            </p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $user->first_name }} {{ $user->last_name }}
                                            </p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $user->email }}
                                            </p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $user->role->name }}
                                            </p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $user->gender }}
                                            </p>
                                        </td>

                                        <td class="text-center">
                                            <span class="text-secondary text-xs font-weight-bold">
                                                {{ $user->status }}
                                            </span>
                                        </td>

                                        <td class="text-center">
                                            <span class="text-secondary text-xs font-weight-bold">
                                                {{ $user->created_at }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if ($user->status === 'active')
                                                <a href="/user-status/{{ $user->id }}/suspended" class="mx-3"
                                                    data-bs-toggle="tooltip" data-bs-original-title="susoendre l'utilisateur">
                                                    <i class="fas fa-stop"></i>
                                                </a>
                                            @else
                                                <a href="/user-status/{{ $user->id }}/active" class="mx-3"
                                                    data-bs-toggle="tooltip" data-bs-original-title="activer l'utilisateur"><i
                                                        class="fas fa-solid fa-check"></i>
                                                </a>
                                            @endif
                                            <span>
                                                <a class="mx-3" data-bs-toggle="tooltip"
                                                    onclick="deleteUser({{ $user->id }})"
                                                    data-bs-original-title="supprimer l'utilisateur">
                                                    <i class="cursor-pointer fas fa-trash text-secondary"></i>
                                                </a>
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
    <script>
        function deleteUser(id) {
            var result = window.confirm("Voulez-vous supprimer cet utilisateur ??");
            if (result) {
                window.location.href = "/delete-user/" + id;
            }
        }
    </script>
@endsection
