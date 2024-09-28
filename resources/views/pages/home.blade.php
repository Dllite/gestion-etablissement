@extends('layouts.user_type.guest')

@section('content')
    <style>
        /* Add your custom styles here */
        body {
            background-color: #f0f0f0;
        }

        .navbar {
            background-color: #C8AD7F !important;
        }

        .navbar-brand {
            margin-right: auto;
        }

        .navbar-nav {
            margin: 0 auto;
        }

        .navbar-nav .nav-item {
            margin-right: 15px;
        }

        .banner {
            background: url('{{asset('assets/img/col1.jpeg')}}') center center;
            background-size: cover;
            color: #fff;
            text-align: center;
            padding: 150px 0;
        }

        .banner h1 {
            font-size: 3em;
        }

        .stats {
            background-color: #c8ad7f38;
            text-align: center;
            padding: 40px 0;
        }

        .about-us {
            background-color: #c8ad7f8f;
            text-align: center;
            padding: 40px 0;
        }

        .contact-us {
            background-color: #c8ad7f38;
            text-align: center;
            padding: 40px 0;
        }

        .footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 20px 0;
        }

        .contact-form-card {
            background: #e4d2b438;
            padding: 20px;
            margin-top: 20px;
        }

        .contact-form .form-row {
            display: flex;
            flex-wrap: wrap;
        }

        .contact-form .form-group {
            flex: 1;
            margin-right: 10px;
        }

        .contact-form .form-group:last-child {
            margin-right: 0;
        }

        .contact-form .btn {
            align-self: flex-end;
        }

        .google-map {
            height: 300px;
        }
    </style>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="#">Collège Saint Charles LWANGA</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Acceuil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#about">A propos de nous</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contact">Contactez nous</a>
                </li>
            </ul>
        </div>
        <a class="navbar-brand mx-5" href="/pay-concourse">Payer un Concours</a>
        <a class="navbar-brand ml-5" href="/login">Se Connecter</a>
    </nav>

    <!-- Banner Section -->
    <div class="banner">
        <h1>Bienvenue au collège saint Charles LWANGA D'AMBAM</h1>
        <p>Votre chemin vers un avenir radieux</p>
    </div>

    <!-- Statistics Section -->
    <div class="stats">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h2>500+</h2>
                    <p>Elèves</p>
                </div>
                <div class="col-md-4">
                    <h2>30+</h2>
                    <p>Enseignants</p>
                </div>
                <div class="col-md-4">
                    <h2>20+</h2>
                    <p>Cours</p>
                </div>
            </div>
        </div>
    </div>

    <!-- About Us Section with Cards -->
    <div class="about-us" id="about">
        <div class="container">
            <h2>A propos de nous</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <img src="assets/img/col4.jpeg" class="card-img-top" alt="Image 1">
                        <div class="card-body">
                            <h5 class="card-title">Collège catholique d'enseignement général</h5>
                            <p class="card-text">Le collège saint Charles LWANGA a deux cycle d'enseignement général le 1er et le 2nd cycle.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <img src="assets/img/admin.jpeg" class="card-img-top" alt="Image 2">
                        <div class="card-body">
                            <h5 class="card-title">Condition d'admission</h5>
                            <p class="card-text">Les élèves sont admis sous concours de la 6ième en 1ère, seul les élèves de la Tle sont admis sur étude de dossier .</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <img src="assets/img/col6.jpeg" class="card-img-top" alt="Image 3">
                        <div class="card-body">
                            <h5 class="card-title">Droit Scolaire</h5>
                            <p class="card-text">Concours 2000FCFA
                                <br/> Etude de dossier 2000 FCFA
                                <br> La scolarité varie suivant le cycle, la nationalité et la classe
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Us Section with Form inside a Card -->
    <div class="contact-us" id="contact">
        <div class="container">
            <h2>Contactez-nous</h2>
            <div class="contact-form-card">
                <form class="contact-form">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <input type="text" class="form-control" id="firstName" placeholder="Nom" required>
                        </div>
                        <div class="form-group col-md-6">
                            <input type="text" class="form-control" id="lastName" placeholder="Prénom" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <input type="email" class="form-control" id="email" placeholder="Email" required>
                        </div>
                        <div class="form-group col-md-6">
                            <input type="tel" class="form-control" id="contact" placeholder="Numéro de téléphone" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <textarea class="form-control" id="message" rows="4" placeholder="Votre Message" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Soumettre</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Google Map Section -->
    <div class="google-map" style=" height: 60vh;">
        <iframe
            src="https://www.google.com/maps/embed"
            width="100%" height="100%" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false"
            tabindex="0"></iframe>
    </div>

    <!-- Footer Section -->
    <div class="footer">
        <p>&copy; 2024 Collège Saint Charles LWANGA d'AMBAM</p>
    </div>
@endsection
