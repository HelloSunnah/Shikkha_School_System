<!doctype html>
<?php use Illuminate\Support\Carbon;$i= 1; ?>
<html lang="en" class=" {{  (Auth::user()->color == 0) ? 'light-theme' : 'dark-theme'  }}">


<!-- Mirrored from codervent.com/skodash/demo/tabular-menu/ltr/table-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 12 Nov 2021 20:17:08 GMT -->
<head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{asset('schools/assets/images/favicon-32x32.png')}}" type="image/png" />
    <link href="{{ asset('schools/assets/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <!--plugins-->
    <link href="{{asset('schools/assets/plugins/simplebar/css/simplebar.css')}}" rel="stylesheet" />
    <link href="{{asset('schools/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css')}}" rel="stylesheet" />
    <link href="{{asset('schools/assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />

    <!-- Toastr style -->
    <link href="{{ asset('assets/admin/css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
    <!-- Bootstrap CSS -->
    <link href="{{asset('schools/assets/css/bootstrap.min.css')}}" rel="stylesheet" />
    <link href="{{asset('schools/assets/css/bootstrap-extended.css')}}" rel="stylesheet" />

    <link href="{{asset('schools/assets/css/icons.css')}}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
    <link rel="{{asset('schools/')}}stylesheet" href="../../../../../cdn.jsdelivr.net/npm/bootstrap-icons%401.5.0/font/bootstrap-icons.css">

    <!-- loader-->
    <link href="{{asset('schools/assets/css/pace.min.css')}}" rel="stylesheet" />


    <!--Theme Styles-->
    <link href="{{asset('schools/assets/css/dark-theme.css')}}" rel="stylesheet" />
    <link href="{{asset('schools/assets/css/light-theme.css')}}" rel="stylesheet" />
    <link href="{{asset('schools/assets/css/semi-dark.css')}}" rel="stylesheet" />
    <link href="{{asset('schools/assets/css/header-colors.css')}}" rel="stylesheet" />
    <link href="{{asset('schools/assets/css/style.css')}}" rel="stylesheet" />

    <title>{{isset($seo_array['seoTitle']) ? $seo_array['seoTitle'] : "Shikkha - ".App\Models\School::where('id',Auth::user()->school_id)->first()->school_name }}</title>
    <meta name="description" content="{{isset($seo_array['seoDescription']) ? $seo_array['seoDescription'] : "Shikkha - ".App\Models\School::where('id',Auth::user()->school_id)->first()->school_name }}">
    <meta name="keywords" content="{{isset($seo_array['seoKeyword']) ? $seo_array['seoKeyword'] : "Shikkha - ".App\Models\School::where('id',Auth::user()->school_id)->first()->school_name }}">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @stack('css')


</head>

<body>
{{--style="background-color: red;color: black;"--}}
<!--start wrapper-->
<div class="wrapper">
    <!--start top header-->
    <header class="top-header">
        <nav class="navbar navbar-expand">
            <div class="mobile-toggle-icon d-xl-none">
                <i class="bi bi-list"></i>
            </div>
            <div class="top-navbar d-none d-xl-block">
                <ul class="navbar-nav align-items-center">
                </ul>
            </div>
            <div class="search-toggle-icon d-xl-none ms-auto">
                <i class="bi bi-search"></i>
            </div>
            <div class="searchbar d-none d-xl-flex ms-auto">
                <div class="position-absolute top-50 translate-middle-y search-icon ms-3"></div>
                <?php
                $date = Carbon::parse(Auth::user()->created_at);
                $now = Carbon::now();

                $diff = $date->diffInDays($now);


                ?>
            </div>
            <div class="top-navbar-right ms-3">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item dropdown dropdown-large">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="messages">
                                <span class="notify-badge">5</span>
                                <i class="fadeIn animated bx bx-notification"></i>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end p-0">
                            <div class="p-2 border-bottom m-2">
                                <h5 class="h5 mb-0">{{__('app.message')}}</h5>
                            </div>
                            <div class="header-message-list p-2 ps">
                               <div id="post-comments">
                               </div>

                                <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></div>
                            <div class="p-2">
                                <div><hr class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">
                                    <div class="text-center">{{__('app.ViewMessage')}}</div>
                                </a>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item dropdown dropdown-large">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown">
                            <div class="user-setting d-flex align-items-center" style="padding: 0 10px;">
                                <div class="user-name d-none d-sm-block mt-50" style="margin-top: 9px;">
                                    <h5 style="background-color:#3361FF;color: #f1f1f1;border-radius: 50%; height: 25px;
                                          width: 25px;text-align: center;"{{Auth::user()->name}} </h5>
                                </div>

                                <div class="">{{Auth::user()->name}}</div>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="">
                                    <div class="d-flex align-items-center">
                                        <div class="ms-3">
                                            <h6 class="mb-0 dropdown-user-name">{{Auth::user()->name}}</h6>
                                            <small class="mb-0 dropdown-user-designation text-secondary">{{__('app.Profile')}}</small>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>

                                    <a class="dropdown-item" href="{{route('student.panel.salary.show')}}">
                                        <div class="d-flex align-items-center">
                                            <div class="setting-icon"><i class="bi bi-person-fill"></i></div>
                                            <div class="setting-text ms-3"><span>{{__('app.paymentInformation')}}</span></div>
                                        </div>
                                    </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{route('user.account.vaccine')}}">
                                    <div class="d-flex align-items-center">
                                        <div class="setting-icon"><i class="lni lni-capsule"></i></div>
                                        <div class="setting-text ms-3"><span>{{__('app.vaccineStatus')}}</span></div>
                                    </div>
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{route('user.account.Information')}}">
                                    <div class="d-flex align-items-center">
                                        <div class="setting-icon"><i class="bi bi-person-fill"></i></div>
                                        <div class="setting-text ms-3"><span>{{__('app.accountStatus')}}</span></div>
                                    </div>
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="">
                                    <div class="d-flex align-items-center">
                                        <a href="{{ route('logout') }}" class="btn btn-light" onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">{{ __('app.Logout') }}</a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                        <div class="setting-text ms-3">

                                        </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!--end top header-->

    <!--start sidebar -->
    <aside class="sidebar-wrapper">
        <div class="iconmenu">
            <div class="nav-toggle-box">
                <div class="nav-toggle-icon"><i class="bi bi-list"></i></div>
            </div>
            <ul class="nav nav-pills flex-column">
                <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Dashboards">
                    <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#pills-mdashboards" type="button"><i class="bi bi-house-door-fill"></i></button>
                </li>
            </ul>
        </div>
        <div class="textmenu">
            <div class="brand-logo">
                <h6>{{getSchoolDataUser(Auth::user()->school_id)->school_name   }}<br>
                </h6>
            </div>
            <div class="tab-content ">
                <div class="tab-pane fade active show" id="pills-mdashboards">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-0">{{__('app.dashboard')}}</h5>
                            </div>
                            <small class="mb-0">{{__('app.Get Your All Content At a Glance')}}</small>
                        </div>
                        <a href="{{url('/home')}}" class="list-group-item"><i class="bi bi-box"></i>{{__('app.dashboard')}}</a>
                        <a href="{{ route('show.student.payment') }}" class="list-group-item"><i class="bi bi-box"></i>{{__('app.Payment')}}</a>
                        <a href="{{route('allAttendance.show.all.user',['class_id'=>Auth::user()->class_id,'section_id'=>Auth::user()->section_id,'group_id'=>is_null(Auth::user()->group_id) ? 0 :Auth::user()->group_id])}}" class="list-group-item"><i class="bi bi-box"></i>{{__('app.Attendance Show')}}</a>
                        <a href="{{route('allSubject.show.all.user')}}" class="list-group-item"><i class="bi bi-box"></i>{{__('app.Subject Show')}}</a>
                        <a href="{{route('allResult.show.all.user')}}" class="list-group-item"><i class="bi bi-box"></i>{{__('app.Result Show')}}</a>
                        <a href="{{route('user.show.notice')}}" class="list-group-item"><i class="bi bi-box"></i>{{__('app.Notice')}}</a>
                        <a href="{{ route('student.show.routine') }}" class="list-group-item"><i class="bi bi-box"></i>{{__('app.Routine')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </aside>


@yield('content')


<!--start overlay-->
    <div class="overlay nav-toggle-icon"></div>
    <!--end overlay-->

    <!--Start Back To Top Button-->
    <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
    <!--End Back To Top Button-->

    <!--start switcher-->
    <div class="switcher-body">
        <form method="post" action="{{route('user.update.post.color')}}" enctype="multipart/form-data">
            @csrf
            @if(Auth::user()->color == 0)
                <input type="hidden" name="color" value="1">
                <button class="btn btn-dark btn-switcher shadow-sm" type="submit" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling"><i class="lni lni-night"></i> <br><span>Dark</span>   </button>
            @else
                <input type="hidden" name="color" value="0">
                <button class="btn btn-light btn-switcher" type="submit" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling" style="background-color: #f1f1f1;color: black;"><i class="lni lni-sun"></i><br><span>light</span></button>
            @endif
        </form>
    </div>
    <!--end switcher-->

</div>
<!--end wrapper-->


<!-- Bootstrap bundle JS -->
<script src="http://cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
<!-- Bootstrap bundle JS -->
<script src="{{ asset('schools/assets/js/bootstrap.bundle.min.js')}}"></script>
<!--plugins-->
<script src="{{ asset('schools/assets/js/jquery.min.js')}}"></script>
<script src="{{ asset('schools/assets/plugins/simplebar/js/simplebar.min.js')}}"></script>
<script src="{{ asset('schools/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js')}}"></script>
<script src="{{ asset('schools/assets/js/pace.min.js')}}"></script>
<script src="{{ asset('schools/assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('schools/assets/plugins/datatable/js/dataTables.bootstrap5.min.js')}}"></script>
<script src="{{ asset('schools/assets/js/table-datatable.js')}}"></script>




<script src="{{ asset('schools/assets/plugins/apexcharts-bundle/js/apexcharts.min.js')}}"></script>
<!--app-->
<script src="{{ asset('schools/assets/js/app.js')}}"></script>
<script src="{{ asset('schools/assets/js/index5.js')}}"></script>
<script src="{{ asset('js/main.js')}}"></script>
{{--<!--app-->--}}
{{--<script src="{{ asset('schools/assets/js/app.js')}}"></script>--}}
@stack('js')
@include('sweetalert::alert')

</body>


<!-- Mirrored from codervent.com/skodash/demo/tabular-menu/ltr/table-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 12 Nov 2021 20:17:08 GMT -->
</html>