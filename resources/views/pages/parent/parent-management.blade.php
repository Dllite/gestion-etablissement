@extends('layouts.user_type.auth')

@section('content')
    <div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModalMessage" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ajouter un nouveau parent</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="/add-parent" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label"> Nom:</label>
                                <input type="text" class="form-control" id="name" name="first_name" required>
                            </div>

                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label"> Prénom:</label>
                                <input type="text" class="form-control" id="name" name="last_name" required>
                            </div>

                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label"> Email:</label>
                                <input type="email" class="form-control" id="name" name="email" required>
                            </div>

                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Sexe:</label>
                                <select class="form-control" id="gender" name="gender" required>
                                    <option></option>
                                    <option value="male">Masculin</option>
                                    <option value="female">Féminin</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label"> Elève:</label>
                                <select class="form-control" name="student_id" id="student_id" required>
                                    <option></option>
                                    @foreach ($concourseWriters as $student)
                                        <option value="{{ $student->id }}">{{ $student->first_name }}
                                            {{ $student->last_name }} </option>
                                    @endforeach
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


    <div>
        <!-- Modal -->
        @foreach ($parents as $parent)
            <div class="modal fade" id="exampleModalMessage{{ $parent->id }}" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Ajouter un nouveau parent</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="/add-student-parent" method="POST">
                                @csrf

                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label"> Parent:</label>
                                    <input type="text" class="form-control" id="name" value="{{$parent->first_name}} {{$parent->last_name}}" readonly required>
                                </div>
                                <input type="text" value="{{$parent->id}}" name="parent_id" required hidden>
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label"> Elève:</label>
                                    <select class="form-control" name="student_id" id="student_id" required>
                                        <option></option>
                                        @foreach ($concourseWriters as $student)
                                            <option value="{{ $student->id }}">{{ $student->first_name }}
                                                {{ $student->last_name }} </option>
                                        @endforeach
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
        @endforeach
    </div>


    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">tous les Parents ( {{ count($parents) }} )</h5>
                        </div>

                        <button type="button" class="btn bg-gradient-success btn-block mb-3" data-bs-toggle="modal"
                            data-bs-target="#exampleModalMessage">
                            +&nbsp; Nouveau Parent
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
                                        Adresse
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        contact
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Nombre d'élève
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
                                @foreach ($parents as $parent)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $parent->id }}
                                            </p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $parent->first_name }} {{ $parent->last_name }}
                                            </p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $parent->email }}
                                            </p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $parent->location }}
                                            </p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $parent->phone }}
                                            </p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ count($parent->concourse_writer) }}
                                            </p>
                                        </td>

                                        <td class="text-center">
                                            <span class="text-secondary text-xs font-weight-bold">
                                                {{ $parent->status }}
                                            </span>
                                        </td>

                                        <td class="text-center">
                                            <span class="text-secondary text-xs font-weight-bold">
                                                {{ $parent->created_at }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <a class="mx-3" data-bs-toggle="modal"
                                                data-bs-target="#exampleModalMessage{{$parent->id}}"
                                                data-bs-original-title="ajouter un élève au parent">
                                                <i class="fas fa-user"></i>
                                            </a>
                                            @if ($parent->status === 'active')
                                                <a href="/user-status/{{ $parent->id }}/suspended" class="mx-3"
                                                    data-bs-toggle="tooltip" data-bs-original-title="suspendre un parent">
                                                    <i class="fas fa-stop"></i>
                                                </a>
                                            @else
                                                <a href="/user-status/{{ $parent->id }}/active" class="mx-3"
                                                    data-bs-toggle="tooltip" data-bs-original-title="activer un parent"><i
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
        function deleteConcourse(id) {
            var result = window.confirm("Voulez-vous supprimer ce parent ?");
            if (result) {
                window.location.href = "/delete-concourse/" + id;
            }
        }
    </script>
@endsection
