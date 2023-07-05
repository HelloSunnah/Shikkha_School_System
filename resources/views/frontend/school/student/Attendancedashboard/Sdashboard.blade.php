@extends('layouts.school.master')
@section('content')
    <style>
        .center {
            align-items: center;
            text-align: center;
        }

        .item {
            margin-right: 20px;
        }

        .card:hover {
            background: #7b00a7;
            color: white;

        }

        .solid {
            border-right: 2px solid #cdcbcb;
            height: 46px;

        }

        .btn-outline-primary {
            color: #7b00a7;
            font-weight: bold;
            border-color: #7b00a7;
            background: #ffffff;
            box-shadow: 5px 6px 8px #d4d3d4;
        }

        .card:hover .btn-outline-primary {
            background: #7b00a7;
            border-color: #ffffff;
            color: #ffffff;
            box-shadow: 0px 3px 3px #c444f3;
            cursor: pointer;
        }

        .select11 {
            border: none !important;
            box-shadow: none;
        }

        .btn2 {
            background: #7b00a7 !important;
            color: #ffffff;
        }

        .btnview {
            box-shadow: none !important;
        }

        .btnview:hover {
            background: #7b00a7 !important;
            color: #ffffff !important;
            border-color: #7b00a7 !important;
            box-shadow: none !important;
        }

        select.selectpicker {
            background-color: #7b00a7;
            border-radius: 40px;
            font-size: 18px;
            border: none;
            color: white;
            padding-left: 10px;
            padding-right: 10px;
            padding-top: -7px;
            padding-bottom: -5px;
            margin-top: 10px;
        }
    </style>
    <main class="page-content">

        <div class="header">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12 mx-auto mt-1">
                    <div class="d-flex justify-content-center ">
                        <select class="form-select select11 " aria-label="Default select example">
                            <option selected>Month</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                        <div class="solid"></div>
                        <select class="form-select select11" aria-label="Default select example">
                            <option selected>Year</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>

                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 mx-auto mt-1">
                    <div class="d-flex justify-content-center gap-3 ">
                        <h6 class="mt-3">Class</h6>
                        <select class="selectpicker" aria-label="Default select example">
                            <option selected>Class One</option>
                            <option value="1">class two</option>
                            <option value="2">Three</option>
                        </select>
                        <div class="solid"></div>
                        <h6 class="mt-3">Shift</h6>
                        <select class="selectpicker" aria-label="Default select example">
                            <option selected>Morning</option>
                            <option value="1">Day</option>
                            <option value="2">Night</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-2 mx-auto"></div>
            </div>
        </div>
        <div class="owl-carousel owl-theme mt-5">
            <div class="item">
                <div class="card" style="width: 270px;height:300px;border-radius:20px;box-shadow:5px 10px 14px #cacaca">
                    <div class="row pt-3">
                        <div class="col-lg-4  col-md-3 col-sm-2 mx-auto"></div>
                        <div class="col-lg-4  col-md-6 col-sm-8 mx-auto">
                            <div>
                                <img src="{{ asset('d/no-img.jpg') }}" class="rounded-circle" width="46" height="70"
                                    alt="">
                            </div>
                        </div>
                        <div class="col-lg-4  col-md-3 col-sm-2 mx-auto"></div>
                    </div>
                    <div class="card-body text-center ">
                        <h5 class="card-title">Alice Liddel</h5>
                        <p class="card-text">Class 1 / Day Shift</p>
                        <div class="d-flex justify-content-center gap-3 ">
                            <h6 class=""
                                style="background:#ececec;color:rgb(9, 9, 9);border-radius: 50%;padding:14px"> 27% </h6>
                            <div class="solid"></div>
                            <h6 style="background:#f0cbff;color:rgb(8, 8, 8);border-radius: 50%;padding:14px">85%</h6>
                        </div>
                        <a href="#" class="btn btn-outline-primary mt-2 ">View Profile</a>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="card" style="width: 270px;height:300px;border-radius:20px;box-shadow:5px 10px 14px #cacaca">
                    <div class="row pt-3">
                        <div class="col-lg-4  col-md-3 col-sm-2 mx-auto"></div>
                        <div class="col-lg-4  col-md-6 col-sm-8 mx-auto">
                            <div>
                                <img src="{{ asset('d/no-img.jpg') }}" class="rounded-circle" width="46" height="70"
                                    alt="">
                            </div>
                        </div>
                        <div class="col-lg-4  col-md-3 col-sm-2 mx-auto"></div>
                    </div>
                    <div class="card-body text-center ">
                        <h5 class="card-title">Alice Liddel</h5>
                        <p class="card-text">Class 1 / Day Shift</p>
                        <div class="d-flex justify-content-center gap-3 ">
                            <h6 class=""
                                style="background:#ececec;color:rgb(9, 9, 9);border-radius: 50%;padding:14px"> 27% </h6>
                            <div class="solid"></div>
                            <h6 style="background:#f0cbff;color:rgb(8, 8, 8);border-radius: 50%;padding:14px">85%</h6>
                        </div>
                        <a href="#" class="btn btn-outline-primary mt-2 ">View Profile</a>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="card" style="width: 270px;height:300px;border-radius:20px;box-shadow:5px 10px 14px #cacaca">
                    <div class="row pt-3">
                        <div class="col-lg-4  col-md-3 col-sm-2 mx-auto"></div>
                        <div class="col-lg-4  col-md-6 col-sm-8 mx-auto">
                            <div>
                                <img src="{{ asset('d/no-img.jpg') }}" class="rounded-circle" width="46" height="70"
                                    alt="">
                            </div>
                        </div>
                        <div class="col-lg-4  col-md-3 col-sm-2 mx-auto"></div>
                    </div>
                    <div class="card-body text-center ">
                        <h5 class="card-title">Alice Liddel</h5>
                        <p class="card-text">Class 1 / Day Shift</p>
                        <div class="d-flex justify-content-center gap-3 ">
                            <h6 class=""
                                style="background:#ececec;color:rgb(9, 9, 9);border-radius: 50%;padding:14px"> 27% </h6>
                            <div class="solid"></div>
                            <h6 style="background:#f0cbff;color:rgb(8, 8, 8);border-radius: 50%;padding:14px">85%</h6>
                        </div>
                        <a href="#" class="btn btn-outline-primary mt-2 ">View Profile</a>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="card" style="width: 270px;height:300px;border-radius:20px;box-shadow:5px 10px 14px #cacaca">
                    <div class="row pt-3">
                        <div class="col-lg-4  col-md-3 col-sm-2 mx-auto"></div>
                        <div class="col-lg-4  col-md-6 col-sm-8 mx-auto">
                            <div>
                                <img src="{{ asset('d/no-img.jpg') }}" class="rounded-circle" width="46"
                                    height="70" alt="">
                            </div>
                        </div>
                        <div class="col-lg-4  col-md-3 col-sm-2 mx-auto"></div>
                    </div>
                    <div class="card-body text-center ">
                        <h5 class="card-title">Alice Liddel</h5>
                        <p class="card-text">Class 1 / Day Shift</p>
                        <div class="d-flex justify-content-center gap-3 ">
                            <h6 class=""
                                style="background:#ececec;color:rgb(9, 9, 9);border-radius: 50%;padding:14px"> 27% </h6>
                            <div class="solid"></div>
                            <h6 style="background:#f0cbff;color:rgb(8, 8, 8);border-radius: 50%;padding:14px">85%</h6>
                        </div>
                        <a href="#" class="btn btn-outline-primary mt-2 ">View Profile</a>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="card" style="width: 270px;height:300px;border-radius:20px;box-shadow:5px 10px 14px #cacaca">
                    <div class="row pt-3">
                        <div class="col-lg-4  col-md-3 col-sm-2 mx-auto"></div>
                        <div class="col-lg-4  col-md-6 col-sm-8 mx-auto">
                            <div>
                                <img src="{{ asset('d/no-img.jpg') }}" class="rounded-circle" width="46"
                                    height="70" alt="">
                            </div>
                        </div>
                        <div class="col-lg-4  col-md-3 col-sm-2 mx-auto"></div>
                    </div>
                    <div class="card-body text-center ">
                        <h5 class="card-title">Alice Liddel</h5>
                        <p class="card-text">Class 1 / Day Shift</p>
                        <div class="d-flex justify-content-center gap-3 ">
                            <h6 class=""
                                style="background:#ececec;color:rgb(9, 9, 9);border-radius: 50%;padding:14px"> 27% </h6>
                            <div class="solid"></div>
                            <h6 style="background:#f0cbff;color:rgb(8, 8, 8);border-radius: 50%;padding:14px">85%</h6>
                        </div>
                        <a href="#" class="btn btn-outline-primary mt-2 ">View Profile</a>
                    </div>
                </div>
            </div>


        </div>


        <div class="table-responsive p-3" style="background: #ffffff">
            <table id="example" class="table " style="width:100%;background:#ffffff">

                <thead>
                    <tr>
                        <th>{{ __('app.Id') }}</th>
                        <th>{{ __('app.Name') }}</th>
                        <th>{{ __('app.shift') }}</th>
                        <th>{{ __('app.Class') }}</th>
                        <th>{{ __('app.Date') }}</th>
                        <th>{{ __('app.EntryTime') }}</th>
                        <th>{{ __('app.Details') }}</th>
                        <th>{{ __('app.Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>dshakj</td>
                        <td>dsf</td>
                        <td>sdf</td>
                        <td>ds</td>
                        <td>dsa</td>
                        <td>dsfa </td>
                        <td>fsda</td>
                        <td><a href="{{ route('Attendance.profile') }}" class="btn btn-outline-primary btn-sm btnview"><i
                                    class="bi bi-eye-fill"></i></a></td>

                    </tr>
                    <tr>
                        <td>dshakj</td>
                        <td>dsf</td>
                        <td>sdf</td>
                        <td>ds</td>
                        <td>dsa</td>
                        <td>dsfa </td>
                        <td>fsda</td>
                        <td><a href="{{ route('Attendance.profile') }}" class="btn btn-outline-primary btn-sm btnview"><i
                                    class="bi bi-eye-fill"></i></a></td>

                    </tr>
                </tbody>

            </table>

        </div>

    </main>
@endsection
@push('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $(".owl-carousel").owlCarousel();
        });

        $('.owl-carousel').owlCarousel({
            loop: true,
            margin: 10,
            nav: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 3
                },
                1000: {
                    items: 5
                }
            }
            // responsive: {0:{"item":1},768:{"item":2},992:{"item":4}}
        });
    </script>
@endpush
