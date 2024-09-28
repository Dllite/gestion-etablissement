@extends('layouts.app')

@section('auth')
<div style="background-color: #e2dfda; padding: 0px; height: 100vh;">
    @include('layouts.navbars.auth.sidebar')

    <main
        class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg {{ Request::is('rtl') ? 'overflow-hidden' : '' }} " >
        @include('layouts.navbars.auth.nav')
        <div class="container-fluid py-4">
            @yield('content')
        </div>
    </main>
</div>
@endsection
