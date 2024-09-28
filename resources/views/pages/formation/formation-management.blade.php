@extends('layouts.user_type.auth')

@section('content')
    <div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModalMessage" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add a new formation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="/add-formation" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Name:</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>

                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Price:</label>
                                <input type="number" class="form-control" id="price" name="price" required>
                            </div>

                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Installment Date 1:</label>
                                <input type="date" class="form-control" name="installment_date_one" required>
                            </div>

                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Installment Date 2:</label>
                                <input type="date" class="form-control" name="installment_date_two" required>
                            </div>

                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Installment Date 3:</label>
                                <input type="date" class="form-control" name="installment_date_three" required>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn bg-gradient-primary">Add</button>
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
                            <h5 class="mb-0">All Formation ( {{ count($formations) }} )</h5>
                        </div>

                        <button type="button" class="btn bg-gradient-success btn-block mb-3" data-bs-toggle="modal"
                            data-bs-target="#exampleModalMessage">
                            +&nbsp; New Formation
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
                                        Name
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Price
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Installment 1
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Installment 2
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Installment 3
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Status
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Creator
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Creation Date
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($formations as $formation)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $formation->id }}
                                            </p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $formation->name }}
                                            </p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $formation->price }} Fcfa
                                            </p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $formation->installment_one }} Fcfa / {{ $formation->installment_date_one }}
                                            </p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $formation->installment_two }} Fcfa / {{ $formation->installment_date_two }}
                                            </p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $formation->installment_three }} Fcfa / {{ $formation->installment_date_three }}
                                            </p>
                                        </td>

                                        <td class="text-center">
                                            <span class="text-secondary text-xs font-weight-bold">
                                                {{ $formation->status }}
                                            </span>
                                        </td>

                                        <td class="text-center">
                                            <span class="text-secondary text-xs font-weight-bold">
                                                {{ $formation->user->first_name }}  {{ $formation->user->last_name }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="text-secondary text-xs font-weight-bold">
                                                {{ $formation->created_at }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if ($formation->status === 'active')
                                                <a href="/formation-status/{{ $formation->id }}/suspended" class="mx-3"
                                                    data-bs-toggle="tooltip" data-bs-original-title="suspend formation">
                                                    <i class="fas fa-stop"></i>
                                                </a>
                                            @else
                                                <a href="/formation-status/{{ $formation->id }}/active" class="mx-3"
                                                    data-bs-toggle="tooltip" data-bs-original-title="activate formation"><i
                                                        class="fas fa-solid fa-check"></i>
                                                </a>
                                            @endif
                                            <span>
                                                <a class="mx-3" data-bs-toggle="tooltip"
                                                    onclick="deleteFormation({{ $formation->id }})"
                                                    data-bs-original-title="delete formation">
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
        function deleteFormation(id) {
            var result = window.confirm("Do you want to delete this formation?");
            if (result) {
                window.location.href = "/delete-formation/"+id;
            }
        }
    </script>
@endsection
