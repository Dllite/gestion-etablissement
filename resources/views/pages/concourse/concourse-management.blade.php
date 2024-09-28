@extends('layouts.user_type.auth')

@section('content')
    <div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModalMessage" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ajouter un nouveau concours</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="/add-concourse" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label"> Nom:</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label"> Prix:</label>
                                <input type="number" class="form-control" id="price" name="price" required>
                            </div>

                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Description:</label>
                                <textarea name="description" id="" cols="30" rows="5" class="form-control" required></textarea>
                            </div>

                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Date du concours:</label>
                                <input type="date" class="form-control" id="email" name="writing_date" required>
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Date de début:</label>
                                <input type="date" class="form-control" id="email" name="starting_date" required>
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Date de Fin:</label>
                                <input type="date" class="form-control" id="email" name="ending_date" required>
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
                            <h5 class="mb-0">Tous les concours ( {{ count($concourses) }} )</h5>
                        </div>

                        <button type="button" class="btn bg-gradient-success btn-block mb-3" data-bs-toggle="modal"
                            data-bs-target="#exampleModalMessage">
                            +&nbsp; Nouveau concours
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
                                        prix
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        description
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Date du concours
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Date de début
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Date de fin
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
                                @foreach ($concourses as $concourse)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $concourse->id }}
                                            </p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $concourse->name }}
                                            </p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $concourse->price }}
                                            </p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $concourse->description }}
                                            </p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $concourse->writing_date }}
                                            </p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $concourse->starting_date }}
                                            </p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $concourse->ending_date }}
                                            </p>
                                        </td>

                                        <td class="text-center">
                                            <span class="text-secondary text-xs font-weight-bold">
                                                {{ $concourse->status }}
                                            </span>
                                        </td>

                                        <td class="text-center">
                                            <span class="text-secondary text-xs font-weight-bold">
                                                {{ $concourse->created_at }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if ($concourse->status === 'active')
                                                <a href="/concourse-status/{{ $concourse->id }}/suspended" class="mx-3"
                                                    data-bs-toggle="tooltip" data-bs-original-title="suspendre le concours">
                                                    <i class="fas fa-stop"></i>
                                                </a>
                                            @else
                                                <a href="/concourse-status/{{ $concourse->id }}/active" class="mx-3"
                                                    data-bs-toggle="tooltip" data-bs-original-title="activer le concours"><i
                                                        class="fas fa-solid fa-check"></i>
                                                </a>
                                            @endif
                                            <span>
                                                <a class="mx-3" data-bs-toggle="tooltip"
                                                    onclick="deleteConcourse({{ $concourse->id }})"
                                                    data-bs-original-title="supprimer le concours">
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
        function deleteConcourse(id) {
            var result = window.confirm("Voulez-vous supprimer ceci ?");
            if (result) {
                window.location.href = "/delete-concourse/" + id;
            }
        }
    </script>
@endsection
