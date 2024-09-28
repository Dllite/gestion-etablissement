@extends('layouts.user_type.auth')

@section('content')
    <div>
        <div class="container-fluid">
            <div class="card card-body blur shadow-blur">
                <div class="row gx-4">

                    <div class="col-auto">
                        <div class="avatar avatar-xl position-relative">
                            <div class="initials-letter">

                                <style>
                                    #letter {
                                        color: black;
                                        font-weight: bold;
                                        font-size: 40px;
                                        font-style: italic;
                                        margin: 0;
                                        padding: 0;
                                    }
                                </style>
                                <span id="letter" class="letter-{{ auth()->user()->first_name[0] }}">
                                    {{ strtoupper(auth()->user()->first_name[0]) }}
                                </span>
                                <span id="letter" class="letter-{{ auth()->user()->last_name[0] }}">
                                    {{ strtoupper(auth()->user()->last_name[0]) }}
                                </span>

                            </div>
                        </div>
                    </div>

                    <div class="col-auto my-auto">
                        <div class="h-100">
                            <h5 class="mb-1">
                                {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
                            </h5>
                            <p class="mb-0 font-weight-bold text-sm">
                                {{ auth()->user()->role->name }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid py-4">
            <div class="card">
                <div class="card-header pb-0 px-3">
                    <h6 class="mb-0">{{ __('Information du Profil') }}</h6>
                </div>
                <div class="card-body pt-4 p-3">
                    <form action="/user-profile" method="POST" role="form text-left">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="user-name" class="form-control-label">{{ __('Nom') }}</label>
                                    <div>
                                        <input class="form-control" value="{{ auth()->user()->first_name }}" type="text"
                                            placeholder="Nom de l'utilisateur" id="user-name" name="first_name">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="user-name" class="form-control-label">{{ __('Prénom') }}</label>
                                    <div>
                                        <input class="form-control" value="{{ auth()->user()->last_name }}" type="text"
                                            placeholder="Prénom de l'utilisateur" id="user-name" name="last_name">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="user-email" class="form-control-label">{{ __('Email') }}</label>
                                    <div>
                                        <input class="form-control" value="{{ auth()->user()->email }}" readonly
                                            type="email" placeholder="@example.com" id="user-email" name="email">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="user.phone" class="form-control-label">{{ __('Contact') }}</label>
                                    <div>
                                        <input class="form-control" type="tel" placeholder="40770888444" id="number"
                                            name="Votre numéro de téléphone" value="{{ auth()->user()->phone }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="user.location" class="form-control-label">{{ __('Adresse') }}</label>
                                    <div>
                                        <input class="form-control" type="text" placeholder="Location" id="name"
                                            name="Votre adresse" value="{{ auth()->user()->location }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="about">{{ 'À propos de moi' }}</label>
                            <div>
                                <textarea class="form-control" id="about" rows="3" placeholder="Parlez de vous" name="about_me">{{ auth()->user()->about_me }}</textarea>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit"
                                class="btn bg-gradient-dark btn-md mt-4 mb-4">{{ 'Enregistrer les modifications' }}</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <div class="container-fluid pb-4">
            <div class="card mt-4">
                <div class="card-header pb-0 px-3">
                    <h6 class="mb-0">{{ __('Modifier le mot de passe') }}</h6>
                </div>
                <div class="card-body pt-4 p-3">

                    <form action="/change-password" method="POST" role="form text-left">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="old-password" class="form-control-label">{{ __('Ancien mot de passe') }}</label>
                                    <div class="('old-password')border border-danger rounded-3 ">
                                        <input class="form-control" value="" type="password" required
                                            placeholder="Entrer l'ancien mot de passe" id="old-password" name="old_password">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="new-password" class="form-control-label">{{ __('Nouveau mot de passe') }}</label>
                                    <div class="('new-password')border border-danger rounded-3 ">
                                        <input class="form-control" value="" type="password" required
                                            minlength="8" placeholder="Entrer le nouveau mot de passe" id="new-password"
                                            name="new_password">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="confirm-password"
                                        class="form-control-label">{{ __('Confirmer le mot de passe') }}</label>
                                    <div class="('confirm-password')border border-danger rounded-3 ">
                                        <input class="form-control" value="" type="password" required
                                            placeholder="Confirmer le mot de passe" id="confirm-password" name="c_password">
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit"
                                class="btn bg-gradient-dark btn-md mt-4 mb-4">{{ 'Modifier le mot de passe' }}</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
