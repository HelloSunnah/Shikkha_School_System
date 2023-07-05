@push('css')
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">

@endpush
@section('content')
<!--start content-->
<main class="page-content">
    <div class="row">
        <div class="col-md-8 mx-auto mt-5">
            <h3 class="text-center mt-3 mb-3 text-primary"></h3>
            <div class="card " style="box-shadow:4px 3px 13px  .13px #bf52f2;border-radius:5px">
                <div class="card-head">
                    <center>
                        <h1><a  style="color: purple;" href="https://shikkha.one/">Shikkha</a></h1>
                    </center>
                    <h3>Hello!</h3>
                </div>
                <div class="card-body">
                    <div class="border p-3 rounded">
                        <p>You are receiving this email because we received a password reset request for your account</p>

                        <div class="div">
                            <p>Please click the below link to reset your password</p>
                            <a class="btn btn-success" href="{{route('user.reset.password',$token)}}">Reset Password</a>
                        </div>
                        <p style="color: red;">This password will expire in 60 miniute</p>
                        <p>If you did not request a password reset,no further action is required.</p>
                        <p>
                            Regards,
                        </p>
                        <p><a  style="color: purple;"  href="https://shikkha.one/">Shikkha</a></p>

                    </div>
                </div>
            </div>
        </div>
    </div>