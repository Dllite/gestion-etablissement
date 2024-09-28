@extends('layouts.user_type.auth')

@section('content')
    <div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModalMessage" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ajouter une classe</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="/add-classe" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Nom de la classe:</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>

                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Cycle:</label>
                                <select name="cycle" id="" class="form-control" required>
                                    <option></option>
                                    <option value="1">cycle 1</option>
                                    <option value="2">cycle 2</option>
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
                            <h5 class="mb-0">Toutes les classes ( {{ count($classes) }} )</h5>
                        </div>

                        <button type="button" class="btn bg-gradient-success btn-block mb-3" data-bs-toggle="modal"
                            data-bs-target="#exampleModalMessage">
                            +&nbsp; Nouvelle classe
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
                                        Cycle
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Effectif
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
                                @foreach ($classes as $classe)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $classe->id }}
                                            </p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $classe->name }}
                                            </p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $classe->cycle }}
                                            </p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ count($classe->concourse_writer) }}
                                            </p>
                                        </td>

                                        <td class="text-center">
                                            <span class="text-secondary text-xs font-weight-bold">
                                                {{ $classe->status }}
                                            </span>
                                        </td>

                                        <td class="text-center">
                                            <span class="text-secondary text-xs font-weight-bold">
                                                {{ $classe->created_at }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if ($classe->status === 'active')
                                                <a href="/classe-status/{{ $classe->id }}/suspended" class="mx-3"
                                                    data-bs-toggle="tooltip" data-bs-original-title="suspendre la classe">
                                                    <i class="fas fa-stop"></i>
                                                </a>
                                            @else
                                                <a href="/classe-status/{{ $classe->id }}/active" class="mx-3"
                                                    data-bs-toggle="tooltip" data-bs-original-title="activer la classe"><i
                                                        class="fas fa-solid fa-check"></i>
                                                </a>
                                            @endif
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
        function deleteFormation(id) {
            var result = window.confirm("Voulez vous supprimer cette classe?");
            if (result) {
                window.location.href = "/delete-formation/" + id;
            }
        }
    </script>
@endsection
