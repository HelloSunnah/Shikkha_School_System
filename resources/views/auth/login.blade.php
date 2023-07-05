@extends('frontend.layouts.app')
@section('main')
@push('css')
<style>
    div.radio-with-Icon {
        display: block;
    }

    div.radio-with-Icon p.radioOption-Item {
        display: inline-block;
        width: 100px;
        height: 100px;
        box-sizing: border-box;
        margin: 5px 15px;
        border: none;
    }

    div.radio-with-Icon p.radioOption-Item label {
        display: block;
        height: 100%;
        width: 100%;
        padding: 10px;
        border-radius: 10px;
        border: 1px solid #d579d2;
        color: #7455F6;
        cursor: pointer;
        opacity: .8;
        transition: none;
        font-size: 13px;
        padding-top: 25px;
        text-align: center;
        margin: 0 !important;
    }

    div.radio-with-Icon p.radioOption-Item label:hover,
    div.radio-with-Icon p.radioOption-Item label:focus,
    div.radio-with-Icon p.radioOption-Item label:active {
        opacity: .5;
        background: linear-gradient(180deg, #DEA5E2, #A89AEA);
        color: #fff;
        margin: 0 !important;
    }

    div.radio-with-Icon p.radioOption-Item label::after,
    div.radio-with-Icon p.radioOption-Item label:after,
    div.radio-with-Icon p.radioOption-Item label::before,
    div.radio-with-Icon p.radioOption-Item label:before {
        opacity: 0 !important;
        width: 0 !important;
        height: 0 !important;
        margin: 0 !important;
    }

    div.radio-with-Icon p.radioOption-Item label i.fa {
        display: block;
        font-size: 50px;
    }

    div.radio-with-Icon p.radioOption-Item input[type="radio"] {
        opacity: 0 !important;
        width: 0 !important;
        height: 0 !important;
    }

    div.radio-with-Icon p.radioOption-Item input[type="radio"]:active~label {
        opacity: 1;
    }

    div.radio-with-Icon p.radioOption-Item input[type="radio"]:checked~label {
        opacity: 1;
        border: none;
        background: linear-gradient(180deg, #DEA5E2, #A89AEA);
        ;
        color: #fff;
    }

    div.radio-with-Icon p.radioOption-Item input[type="radio"]:hover,
    div.radio-with-Icon p.radioOption-Item input[type="radio"]:focus,
    div.radio-with-Icon p.radioOption-Item input[type="radio"]:active {
        margin: 0 !important;
    }

    div.radio-with-Icon p.radioOption-Item input[type="radio"]+label:before,
    div.radio-with-Icon p.radioOption-Item input[type="radio"]+label:after {
        margin: 0 !important;
    }
</style>
@endpush
<main>


    <!-- sign up area start -->
    <section class="signup_area po-rel-z1 pt-100 pb-145 bg_otp">
        <div class="sign__shape">
            <img class="man-1" src="assets/img/icon/sign/man-3.png" alt="">
            <img class="man-2 man-22" src="assets/img/icon/sign/man-2.png" alt="">
            <img class="circle" src="assets/img/icon/sign/circle.png" alt="">
            <img class="zigzag" src="assets/img/icon/sign/zigzag.png" alt="">
            <img class="dot" src="assets/img/icon/sign/dot.png" alt="">
            <img class="bg" src="assets/img/icon/sign/sign-up.png" alt="">
            <img class="flower" src="assets/img/icon/sign/flower.png" alt="">
        </div>
        <div class="container">
            <div class="row">
                <div class="col-xxl-8 offset-xxl-2 col-xl-8 offset-xl-2">
                    <div class="page__title-wrapper">


                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xxl-6 offset-xxl-3 col-xl-6 offset-xl-3 col-lg-8 offset-lg-2">
                    <div class="sign__wrapper white-bg">
                        <h1 class="text-center fw-bold">{{__('app.signinhead')}}</h1>

                        <div class="sign__form">
                            @isset($url)
                            <form method="POST" action='{{ url("login/$url") }}' aria-label="{{ __('Login') }}">
                                @else
                                <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                                    @endisset
                                    @csrf
                                    <div class="sign__input-wrapper mb-25">
                                        @include('layouts.school.message')
                                    </div>
                                    @if (session('status'))
                                    <div class="alert alert-success">
                                        {{ session('status')}}
                                    </div>
                                    @endif
                                    <div class="sign__input-wrapper mb-25">
                                        <h5>{{__('app.Email')}}</h5>
                                        <div class="sign__input">
                                            <input type="text" placeholder="{{__('app.signpopup2')}}" name="email" value="{{ (isset($email)) ? $email : old('email') }}">
                                            <i class="fal fa-envelope"></i>
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="sign__input-wrapper mb-5">
                                        <h5>{{__('app.sign5')}}</h5>
                                        <div class="sign__input">
                                            <input type="password" placeholder="{{__('app.sign5')}}" name="password" value="{{ old('password') }}">
                                            <i class="fal fa-lock"></i>
                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="radio-with-Icon mb-25">
                                        <div class="">
                                            <div class="row justify-content-center">
                                                <div class="col-4">
                                                    <p class="radioOption-Item">
                                                        <input type="radio" name="BannerTypes" id="BannerType1" value="student" class="ng-valid ng-dirty ng-touched ng-empty" aria-invalid="false">
                                                        <label for="BannerType1">
                                                            <img src="{{asset('frontend/assets/img/logo/st.png')}}" alt="logo"><br>
                                                            {{__('app.Student')}}
                                                        </label>
                                                    </p>
                                                </div>
                                                <div class="col-4">
                                                    <p class="radioOption-Item">
                                                        <input type="radio" name="BannerTypes" id="BannerType2" value="teacher" class="ng-valid ng-dirty ng-touched ng-empty" aria-invalid="false">
                                                        <label for="BannerType2">
                                                            <img src="{{asset('frontend/assets/img/logo/t.png')}}" alt="logo"><br>
                                                            {{__('app.Teacher')}}
                                                        </label>
                                                    </p>
                                                </div>
                                                <div class="col-4">
                                                    <p class="radioOption-Item">
                                                        <input type="radio" name="BannerTypes" id="BannerType3" value="school" class="ng-valid ng-dirty ng-touched ng-empty" aria-invalid="false">
                                                        <label for="BannerType3">
                                                            <img src="{{asset('frontend/assets/img/logo/sc.png')}}" alt="logo"><br>
                                                            {{__('app.School')}}
                                                        </label>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                    <button class="w-btn w-btn-11 w-100 mt-5" type="submit"> <span></span>{{__('app.signin')}}</button>
                                    <div class="sign__new text-center mt-20">
                                    </div>
                                    <center> <a style="color: #7455F6;" href="{{route('user.forgot.password')}}"><strong>Forgot Password</strong></a></center>

                                </form>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- sign up area end -->
</main>
@endsection
{{--<div class="container">--}}
{{-- <div class="row justify-content-center">--}}
{{-- <div class="col-md-8">--}}
{{-- <div class="card">--}}
{{-- <div class="card-header"> {{ isset($url) ? ucwords($url) : ""}} {{ __('Login') }}</div>--}}

{{-- <div class="card-body">--}}
{{-- @isset($url)--}}
{{-- <form method="POST" action='{{ url("login/$url") }}' aria-label="{{ __('Login') }}">--}}
{{-- @else--}}
{{-- <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">--}}
{{-- @endisset--}}
{{-- @csrf--}}

{{-- <div class="form-group row">--}}
{{-- <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>--}}

{{-- <div class="col-md-6">--}}
{{-- <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>--}}

{{-- @error('email')--}}
{{-- <span class="invalid-feedback" role="alert">--}}
{{-- <strong>{{ $message }}</strong>--}}
{{-- </span>--}}
{{-- @enderror--}}
{{-- </div>--}}
{{-- </div>--}}

{{-- <div class="form-group row">--}}
{{-- <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>--}}

{{-- <div class="col-md-6">--}}
{{-- <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">--}}

{{-- @error('password')--}}
{{-- <span class="invalid-feedback" role="alert">--}}
{{-- <strong>{{ $message }}</strong>--}}
{{-- </span>--}}
{{-- @enderror--}}
{{-- </div>--}}
{{-- </div>--}}

{{-- <div class="form-group row">--}}
{{-- <div class="col-md-6 offset-md-4">--}}
{{-- <div class="form-check">--}}
{{-- <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>--}}

{{-- <label class="form-check-label" for="remember">--}}
{{-- {{ __('Remember Me') }}--}}
{{-- </label>--}}
{{-- </div>--}}
{{-- </div>--}}
{{-- </div>--}}

{{-- <div class="form-group row mb-0">--}}
{{-- <div class="col-md-8 offset-md-4">--}}
{{-- <button type="submit" class="btn btn-primary">--}}
{{-- {{ __('Login') }}--}}
{{-- </button>--}}

{{-- @if (Route::has('password.request'))--}}
{{-- <a class="btn btn-link" href="{{ route('password.request') }}">--}}
{{-- {{ __('Forgot Your Password?') }}--}}
{{-- </a>--}}
{{-- @endif--}}
{{-- </div>--}}
{{-- </div>--}}
{{-- </form>--}}
{{-- </div>--}}
{{-- </div>--}}
{{-- </div>--}}
{{-- </div>--}}
{{--</div>--}}