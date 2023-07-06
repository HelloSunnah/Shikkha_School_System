<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans:wght@700&family=Poppins:wght@400;500;600&display=swap');

        * {
            /* margin: 0;
            padding: 0; */
            font-family: "Poppins", sans-serif;
        }

        .col-5 {
            background: linear-gradient(120deg, #7302a7, #8e44ad);
            height: 100vh;
            padding-top: 110px;
            /* overflow: hidden; */
        }

        .col-7 {
            background: white;
            height: 100vh;
            padding-top: 120px;
            padding-left: 100px;
            /* overflow: hidden; */
        }

        input#exampleInputEmail1 {
            border-bottom: 1px solid #a861c8;
            border-top: none;
            border-left: none;
            border-right: none;
            width: 460px;
            border-radius: 0px;
        }

        input#exampleInputEmail1:focus {
            box-shadow: none;
        }

        .btn-primary {
            background: #8e44ad;
            border-color: #8e44ad;
        }

        .btn-primary:hover {
            background: #7b1fa2;
            border-color: #7716a1;
        }
    </style>
</head>

<body>
    <div class="row">
        <div class="col-5 text-center ">
            <img src="{{ asset('schools\assets\images\icons\undraw_forgot_password_re_hxwm 1.svg') }}" alt=""
                style="">
            <h3 class="text-white pt-4">Forget your password?</h3>
            <h5 class="text-white pl-5 pt-2">Don’t worry we are here to <br> save you.</h5>
        </div>
        <div class="col-7 ">
            <h3 style="color:#a861c8" class="fw-bolder mb-5">Please give the details <br> asked below.</h3>
            <form method="post" action="{{ route('user.forgot.password.post') }}">
                @csrf
                <div class="mb-3 mt-5">
                    <input type="email" required name="email" class="form-control" id="exampleInputEmail1"
                        placeholder="Your email">
                </div>
                <center>
                    <strong>
                        @if (session('status'))
                            <div style="color: red" class="alert alert-danger">
                                {{ session('status') }}
                            </div>
                    </strong>
                    @endif
                </center>
                <div class="mt-5" style="padding-left:120px;">
                    <button type="submit" value="Send Link" class="btn btn-primary" style="width:40%">Next</button>
                </div>
                <div class="signup_link mt-5 pl-5">
                    Not a member?
                    <a href="{{ route('getStarted.post') }}" style="color: #a861c8">Signup</a>
                </div>
            </form>



        </div>
    </div>
</body>

</html>
