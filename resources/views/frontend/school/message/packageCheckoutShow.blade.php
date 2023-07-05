<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sikkha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
    <link href="{{ asset('schools/assets/css/payment.css') }}" rel="stylesheet" />
    <style>
        
        
        input[type=radio] {
                -webkit-appearance: none;
                -moz-appearance: none;
                appearance: none;
                border: 2px solid #8a2be2; 
                background: #ffff;
                padding: 6px;
                border-radius:8px ;
                cursor: pointer;
                margin-top: 4px !important;
                position: absolute;

            }
            input[type="radio"]:checked {
                background: #8a2be2 !important;
                cursor: pointer;
                color:rgb(255, 255, 255) !important;
            }
            .form-control-radio{
                margin-left: -22px;
            }
            .btn-primary{
            background: #7a00a7 !important;
            color: white !important;
            border-color: #7a00a7;
             }
            .amarPay__right_radio{

            }
    </style>
</head>

<body>
    <section>
        <div class="" style=" background: #f1f1f1;  box-shadow: 1px 0px 4px 0px ;">
            <form method="post" action="{{ route('school.message.post.checkout') }}" enctype="multipart/form-data">
                @csrf
                <div class="row no-gutters">
                    <div class="col-lg-5 col-xxl-5 col-sm-12 col-md-12">
                        <div class="amarPay__left" style="background: #7800a7">
                            <div class="amarPay__amarPay__img text-center">
                                <img src="{{ asset('frontend/assets/img/logo/logo.webp') }}" alt="" />
                                <div class="mt-3">
                                    <h4 class="text-light fw-bold">Payment Summary</h4>
                                    <p class="text-light">
                                        Please review the following detail for this <br />
                                        transaction
                                    </p>
                                </div>
                            </div>
                            <ul class="pt-4">
                                <li class="d-flex justify-content-between text-light my-4">
                                    <span>Amount</span> <span class="fw-bolder">{{ $messagePackageInfo->price }}
                                        BDT</span>
                                    <input type="hidden" name="package_price" value="{{ $messagePackageInfo->price }}">
                                    <input type="hidden" name="package_quantity"
                                        value="{{ $messagePackageInfo->quantity }}">
                                    <input type="hidden" name="package_name"
                                        value="{{ $messagePackageInfo->package_name }}">
                                </li>
                                <li class="d-flex justify-content-between text-light my-4">
                                    <span>Package Name</span> <span
                                        class="fw-bolder">{{ $messagePackageInfo->package_name }}</span>
                                </li>
                                <li class="d-flex justify-content-between text-light my-4">
                                    <span>Message Quantity</span>
                                    <span class="fw-bolder">{{ $messagePackageInfo->quantity }}</span>
                                </li>
                                <li class="d-flex justify-content-between text-light my-4">
                                    <span>School Name.</span>
                                    <span class="fw-bolder">{{ Auth::user()->school_name }}</span>
                                </li>
                                <li class="d-flex justify-content-between text-light my-4">
                                    <span>School Number.</span>
                                    <span class="fw-bolder">{{ Auth::user()->phone_number }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xxl-6 col-sm-12 col-md-12">
                        <div class="row mt-3 mb-0 pb-0" style="margin-right:-80px !important " >
                            <div class="col-lg-11"></div>
                            <div class="col-lg-1 ">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                        </div>
                        <div class="amarPay__right">
                            
                            <div class="amarPay__right__text text-center">
                                
                                <h2 class="text-uppercase fw-bold"> Select Your Payment Method</h2>

                                <p style="color: darkgray">
                                    Do not press browser back or forward button while you are on a
                                    payment page
                                </p>
                            </div>
                            <div class="text-center">
                                <div class="d-flex justify-content-center">
                                    <div class="amarPay__right_img-radio">
                                        <img class="amarPay__right__payImg"
                                            src="{{ asset('schools/assets/images/payment/bkash.png') }}"
                                            alt="" />
                                        <input class="form-control-radio text-primary" type="radio" id="control_01"
                                            name="select" value="bkash" checked />
                                    </div>
                                    <div class="amarPay__right_img-radio">
                                        <img class="amarPay__right__payImg"
                                            src="{{ asset('schools/assets/images/payment/rsz_rocket.png') }}"
                                            alt="" />
                                        <input class="form-control-radio " type="radio" id="control_01"
                                            name="select" value="rocket" />
                                    </div>
                                    <div class="amarPay__right_img-radio">
                                        <img class="amarPay__right__payImg"
                                            src="{{ asset('schools/assets/images/payment/nagad.png') }}"
                                            alt="" />
                                        <input class="form-control-radio" type="radio" id="control_01"
                                            name="select" value="nagad" />
                                    </div>
                                    <div class="amarPay__right_img-radio">
                                        <img class="amarPay__right__payImg"
                                            src="{{ asset('schools/assets/images/payment/upay.jpeg') }}"
                                            alt="" />
                                        <input class="form-control-radio" type="radio" id="control_01"
                                            name="select" value="upay" />
                                    </div>
                                </div>

                                {{-- <br />
                            <input
                                placeholder="Transaction Number"
                                class="amarPay__right__input"
                                type="text"
                                name="transaction_number"
                            />

                            <br />
                            <input
                                placeholder="Sending Number"
                                class="amarPay__right__input"
                                type="text"
                                name="gateway_number"
                            /> --}}

                                <label>Payable Amount : </label>
                                <input placeholder="Pay Amount" class="amarPay__right__input" type="text"
                                    name="pay_amount" value="{{ $messagePackageInfo->price }}" readonly />

                                <br />
                                <div class="mt-4">
                                    <button class="amarPay__right__button btn btn-primary mx-3" style="background: #7800a7;border-color:#7800a7">
                                        Checkout
                                    </button>
                                </div>
                            </div>
                            <h3>Note:</h3>
                            <ul>
                                <li style="list-style: disc outside none" class="text-muted my-3">
                                    For VISA and MC, look at the back side of your card to
                                    find-3-digit CVV2/CVC2. For AMEX look at the upper right
                                    corner of the front side of you card to find 4-digit CSC.
                                </li>
                                <li style="list-style: disc outside none" class="text-muted my-3">
                                    The cardholder's name should be entered just as it's written
                                    on the card.
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </section>

    <script src="https://kit.fontawesome.com/03e39c9aff.js" crossorigin="anonymous"></script>
</body>

</html>
