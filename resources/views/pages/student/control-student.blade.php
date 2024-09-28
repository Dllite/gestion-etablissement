@extends('layouts.user_type.auth')

@section('content')
    <style>
        .loader {
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top: 4px solid #333;
            width: 100px;
            height: 100px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 2000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 30%;
            text-align: center;
        }

        .modal-content img {
            width: 100px;
            height: 100px;
        }
    </style>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-body">
                        <div class="body">
                            <img src="" id="studentImage" alt="Sample Image" width="200">
                            <h3 class="mt-3">Name: <span  id="studentName"></span></h3>
                            <h4 class="mt-3" >Email: <span id="studentEmail"></span></h4>
                        </div>
                        <div class="footer" id="studentFooter">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 mt-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Pass the card to scan</h4>
                        <div class=" d-flex align-items-center flex-column">
                            <div class="loader" id="circle"></div>
                            <h3 class="mt-4">Waiting.......</h3>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function deleteUser(id) {
            var result = window.confirm("Do you want to delete this user?");
            if (result) {
                window.location.href = "/delete-user/" + id;
            }
        }
    </script>
@endsection
