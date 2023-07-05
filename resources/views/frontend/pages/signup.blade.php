@extends('frontend.layouts.app')
@section('main')
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
                            {{--                            <div class="" style="text-align: center;padding-bottom:5px;"> --}}
                            {{--                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="height: 50px;"> --}}
                            {{--                                <path d="M243.4 2.587C251.4-.8625 260.6-.8625 268.6 2.587L492.6 98.59C506.6 104.6 514.4 119.6 511.3 134.4C508.3 149.3 495.2 159.1 479.1 160V168C479.1 181.3 469.3 192 455.1 192H55.1C42.74 192 31.1 181.3 31.1 168V160C16.81 159.1 3.708 149.3 .6528 134.4C-2.402 119.6 5.429 104.6 19.39 98.59L243.4 2.587zM256 128C273.7 128 288 113.7 288 96C288 78.33 273.7 64 256 64C238.3 64 224 78.33 224 96C224 113.7 238.3 128 256 128zM127.1 416H167.1V224H231.1V416H280V224H344V416H384V224H448V420.3C448.6 420.6 449.2 420.1 449.8 421.4L497.8 453.4C509.5 461.2 514.7 475.8 510.6 489.3C506.5 502.8 494.1 512 480 512H31.1C17.9 512 5.458 502.8 1.372 489.3C-2.715 475.8 2.515 461.2 14.25 453.4L62.25 421.4C62.82 420.1 63.41 420.6 63.1 420.3V224H127.1V416z"/></svg> --}}

                            {{--                            </div> --}}
                            <h3 class="page__title-2 text-center mb-25">{{ __('app.signheader') }}</h3>
                            @include('frontend.layouts.message')
                            <div class="sign__form">
                                <form method="post" action="{{ route('signup.post') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="sign__input-wrapper mb-25">
                                        <h5>{{ __('app.sign1') }}</h5>
                                        <div class="sign__input">
                                            <input type="text" placeholder="{{ __('app.sign1') }}" name="school_name"
                                                value="{{ old('school_name') }}" required>
                                            <i class="fal fa-building"></i>
                                        </div>
                                    </div>
                                    <div class="sign__input-wrapper mb-25">
                                        <h5>{{ __('app.sign1') }}({{ __('app.bangla') }})</h5>
                                        <div class="sign__input">
                                            <input type="text" placeholder="{{ __('app.sign1') }}" name="school_name_bn"
                                                value="{{ old('school_name_bn') }}" required>
                                            <i class="fal fa-building"></i>
                                        </div>
                                    </div>
                                    <div class="sign__input-wrapper mb-25">
                                        <h5>{{ __('app.sign2') }}</h5>
                                        <div class="sign__input">
                                            <input type="email" placeholder="{{ __('app.sign2') }}" name="email"
                                                value="{{ isset($email) ? $email : '' }}">
                                            <i class="fal fa-envelope"></i>
                                        </div>
                                    </div>
                                    <div class="sign__input-wrapper mb-25">
                                        <h5>{{ __('app.sign3') }}</h5>
                                        <div class="sign__input">
                                            <input type="text" placeholder="{{ __('app.sign3') }}" name="phone_number"
                                                min="11" max="11" value="{{ old('phone_number') }}" required>
                                            <i class="fal fa-phone"></i>
                                        </div>
                                    </div>
                                    <div class="sign__input-wrapper ">

                                        <div class="sign__input">
                                            <input type="hidden" name="trial_end_date">
                                            <input type="hidden" name="subscription_status" value="0">

                                        </div>
                                    </div>
                                    {{-- <div class="sign__input-wrapper mb-25">
                                        <h5>Address</h5>
                                        <div class="sign__input">
                                            <input type="text" placeholder="Address" name="address" required>
                                            <i class="fal fa-address-book"></i>
                                        </div>
                                    </div> --}}
                                    <div class="sign__input-wrapper mb-25">
                                        <h5>{{ __('app.sign5') }}</h5>
                                        <div class="sign__input">
                                            <input type="password" placeholder="{{ __('app.sign5') }}" name="password">
                                            <i class="fal fa-lock"></i>
                                        </div>
                                    </div>

                                    <button class="w-btn w-btn-11 w-100" type="submit">
                                        <span></span>{{ __('app.sign') }}</button>
                                    <div class="sign__new text-center mt-20">
                                        <p>{{ __('app.Already') }} <a href="sign-in.html"> {{ __('app.signin') }}</a></p>
                                    </div>
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
