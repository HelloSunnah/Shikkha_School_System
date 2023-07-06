@extends('layouts.school.master')
@section('content')
    <style>
        .card-head {
            padding: 16px;
        }
    </style>

    <main class="page-content">

        <div class="container">
            <div class="row">
                <div class="col-7">
                    <div class="card mb-3">
                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <p class="alert alert-danger">{{ $error }}</p>
                            @endforeach
                        @endif
                        <div class="card-body text-center pb-4">
                            <h5 class="text-center">Choose a payment methode</h5>
                            <hr>
                            <a href="javascript::" data-bs-toggle="modal" data-bs-target="#bkashmodal">
                                <img src="{{ asset('schools\assets\images\icons\bkash.png') }}" alt=""
                                    width="70" height="70" style="border-radius:20px; margin-right:12px">
                            </a>
                            <a href="javascript::" data-bs-toggle="modal" data-bs-target="#nogodmodal">
                                <img src="{{ asset('schools\assets\images\icons\nogod.png') }}" alt=""
                                    width="70" height="70" style="border-radius:20px; margin-right:12px">
                            </a>
                            <a href="javascript::" data-bs-toggle="modal" data-bs-target="#rocketmodal">
                                <img src="{{ asset('schools\assets\images\icons\rocket.png') }}" alt=""
                                    width="70" height="70" style="border-radius:20px; margin-right:12px">
                            </a>
                            <a href="javascript::" data-bs-toggle="modal" data-bs-target="#bankmodal">
                                <img src="{{ asset('schools\assets\images\icons\nexus.png') }}" alt=""
                                    width="70" height="70" style="border-radius:20px">
                            </a>
                        </div>
                    </div>

                    <div class="card p-3">
                        <div class="d-flex justify-content-center gap-3 text-center">
                            <p><i class="bi bi-circle-fill pe-1" style="font-size: 10px;"></i>B-kash number:23456782342</p>
                            <p><i class="bi bi-circle-fill pe-1" style="font-size: 10px;"></i>Nogod number:23456782342</p>
                        </div>
                        <div class="d-flex justify-content-center gap-3 text-center">
                            <p><i class="bi bi-circle-fill pe-1" style="font-size: 10px;"></i>Rocket number:23456784323</p>
                            <p><i class="bi bi-circle-fill pe-1" style="font-size: 10px;"></i>Bank number:2345678233413</p>
                        </div>
                    </div>
                </div>
                <div class="col-5">
                    <div class="card">
                        <div class="card-body p-4 ">
                            <h5 class="ps-2 fw-bold ">Order Summary</h5>
                            <hr>
                            <h6 class="ps-2 ">School monthly payment {{ $school->billing_add }} ৳</h6>
                            <br>
                            <hr>
                            <h5 class="ps-2 ">Total {{ $school->billing_add }} ৳</h5>

                            <div style="padding:32px">
                                <button class="btn btn-primary btn-sm w-100 ">pay</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>


    <!-- Modal of bkash-->
    <div class="modal fade" id="bkashmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#9604d9;">
                    <h4 class="modal-title text-white text-center" id="exampleModalLabel">Pay Now
                    </h4>
                    <button type="button" class="btn-close btn-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body border ms-5 me-5 mt-5 mb-5 ">
                    <form action="{{ route('school.billingtransaction.Store') }}" method="post">
                        @csrf
                        <input type="hidden" name="school_id" value="{{ $school->id }}">
                        <input type="hidden" name="payment_method" value="bkash">
                        <div class="mb-3">
                            <label for="">Transaction ID</label>
                            <input type="text" required class="form-control" name="transaction_id"
                                placeholder="XAS7GC565C">
                        </div>
                        <div class="mb-3">
                            <label for="">Sending Number</label>
                            <input type="number" required class="form-control" name="sending_number"
                                placeholder="017XXXXXXXX">
                        </div>
                        <div class="mb-3">
                            <label for="">Amount</label>
                            <input type="number" class="form-control" name="amount" value="{{ $school->billing_add }}"
                                readonly>
                        </div>

                        <div class="mb-3 mt-3">
                            <button type="submit" class="btn btn-primary btn-sm w-100">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal of nogod-->
    <div class="modal fade" id="nogodmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#9604d9;">
                    <h4 class="modal-title text-white text-center" id="exampleModalLabel">Pay Now
                    </h4>
                    <button type="button" class="btn-close btn-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body border ms-5 me-5 mt-5 mb-5 ">
                    <form action="{{ route('school.billingtransaction.Store') }}" method="post">
                        @csrf
                        <input type="hidden" name="school_id" value="{{ $school->id }}">
                        <input type="hidden" name="payment_method" value="nogod">
                        <div class="mb-3">
                            <label for="">Transaction ID</label>
                            <input type="text" required class="form-control" name="transaction_id"
                                placeholder="XAS7GC565C">
                        </div>
                        <div class="mb-3">
                            <label for="">Sending Number</label>
                            <input type="number" required class="form-control" name="sending_number"
                                placeholder="017XXXXXXXX">
                        </div>
                        <div class="mb-3">
                            <label for="">Amount</label>
                            <input type="number" class="form-control" name="amount"
                                value="{{ $school->billing_add }}" readonly>
                        </div>

                        <div class="mb-3 mt-3">
                            <button type="submit" class="btn btn-primary btn-sm w-100">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal of rocket-->
    <div class="modal fade" id="rocketmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#9604d9;">
                    <h4 class="modal-title text-white text-center" id="exampleModalLabel">Pay Now
                    </h4>
                    <button type="button" class="btn-close btn-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body border ms-5 me-5 mt-5 mb-5 ">
                    <form action="{{ route('school.billingtransaction.Store') }}" method="post">
                        @csrf
                        <input type="hidden" name="school_id" value="{{ $school->id }}">
                        <input type="hidden" name="payment_method" value="rocket">
                        <div class="mb-3">
                            <label for="">Transaction ID</label>
                            <input type="text" required class="form-control" name="transaction_id"
                                placeholder="XAS7GC565C">
                        </div>
                        <div class="mb-3">
                            <label for="">Sending Number</label>
                            <input type="number" required class="form-control" name="sending_number"
                                placeholder="017XXXXXXXX">
                        </div>
                        <div class="mb-3">
                            <label for="">Amount</label>
                            <input type="number" class="form-control" name="amount"
                                value="{{ $school->billing_add }}" readonly>
                        </div>

                        <div class="mb-3 mt-3">
                            <button type="submit" class="btn btn-primary btn-sm w-100">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal of bank-->
    <div class="modal fade" id="bankmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#9604d9;">
                    <h4 class="modal-title text-white text-center" id="exampleModalLabel">Pay Now
                    </h4>
                    <button type="button" class="btn-close btn-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body border ms-5 me-5 mt-5 mb-5 ">
                    <form action="{{ route('school.billingtransaction.Store') }}" method="post">
                        @csrf
                        <input type="hidden" name="school_id" value="{{ $school->id }}">
                        <input type="hidden" name="payment_method" value="bank">
                        <div class="mb-3">
                        </div>
                        <div class="mb-3">
                            <label for="">Sending Account Number</label>
                            <input type="number" required class="form-control" name="sending_number"
                                placeholder="017XXXXXXXX">
                        </div>
                        <div class="mb-3">
                            <label for="">Amount</label>
                            <input type="number" class="form-control" name="amount"
                                value="{{ $school->billing_add }}" readonly>
                        </div>

                        <div class="mb-3 mt-3">
                            <button type="submit" class="btn btn-primary btn-sm w-100">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
