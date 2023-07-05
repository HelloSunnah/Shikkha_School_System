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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

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
                    {{-- <li class="nav-item dropdown dropdown-large">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="messages">
                                <span class="notify-badge">5</span>
                                <i class="fadeIn animated bx bx-notification"></i>
                            </div>
                        </a>
                         <div class="dropdown-menu dropdown-menu-end p-0">
                            <div class="p-2 border-bottom m-2">
                                <h5 class="h5 mb-0">Messages</h5>
                            </div>
                            <div class="header-message-list p-2 ps">
                                <div class="dropdown-item bg-light radius-10 mb-1">
                                    <form class="dropdown-searchbar position-relative full-searchbar">
                                        <div class="position-absolute top-50 start-0 translate-middle-y px-3 search-icon"><i class="bi bi-search"></i></div>
                                        <input class="form-control" type="search" placeholder="Search Messages">
                                    </form>
                                </div>
                                <a class="dropdown-item" href="#">
                                    <div class="d-flex align-items-center">
                                        <img src="assets/images/avatars/avatar-1.png" alt="" class="rounded-circle" width="52" height="52">
                                        <div class="ms-3 flex-grow-1">
                                            <h6 class="mb-0 dropdown-msg-user">Amelio Joly <span class="msg-time float-end text-secondary">1 m</span></h6>
                                            <small class="mb-0 dropdown-msg-text text-secondary d-flex align-items-center">The standard chunk of lorem...</small>
                                        </div>
                                    </div>
                                </a>
                                <a class="dropdown-item" href="#">
                                    <div class="d-flex align-items-center">
                                        <img src="assets/images/avatars/avatar-2.png" alt="" class="rounded-circle" width="52" height="52">
                                        <div class="ms-3 flex-grow-1">
                                            <h6 class="mb-0 dropdown-msg-user">Althea Cabardo <span class="msg-time float-end text-secondary">7 m</span></h6>
                                            <small class="mb-0 dropdown-msg-text text-secondary d-flex align-items-center">Many desktop publishing</small>
                                        </div>
                                    </div>
                                </a>
                                <a class="dropdown-item" href="#">
                                    <div class="d-flex align-items-center">
                                        <img src="assets/images/avatars/avatar-3.png" alt="" class="rounded-circle" width="52" height="52">
                                        <div class="ms-3 flex-grow-1">
                                            <h6 class="mb-0 dropdown-msg-user">Katherine Pechon <span class="msg-time float-end text-secondary">2 h</span></h6>
                                            <small class="mb-0 dropdown-msg-text text-secondary d-flex align-items-center">Making this the first true</small>
                                        </div>
                                    </div>
                                </a>
                                <a class="dropdown-item" href="#">
                                    <div class="d-flex align-items-center">
                                        <img src="assets/images/avatars/avatar-4.png" alt="" class="rounded-circle" width="52" height="52">
                                        <div class="ms-3 flex-grow-1">
                                            <h6 class="mb-0 dropdown-msg-user">Peter Costanzo <span class="msg-time float-end text-secondary">3 h</span></h6>
                                            <small class="mb-0 dropdown-msg-text text-secondary d-flex align-items-center">It was popularised in the 1960</small>
                                        </div>
                                    </div>
                                </a>
                                <a class="dropdown-item" href="#">
                                    <div class="d-flex align-items-center">
                                        <img src="assets/images/avatars/avatar-5.png" alt="" class="rounded-circle" width="52" height="52">
                                        <div class="ms-3 flex-grow-1">
                                            <h6 class="mb-0 dropdown-msg-user">Thomas Wheeler <span class="msg-time float-end text-secondary">1 d</span></h6>
                                            <small class="mb-0 dropdown-msg-text text-secondary d-flex align-items-center">If you are going to use a passage</small>
                                        </div>
                                    </div>
                                </a>
                                <a class="dropdown-item" href="#">
                                    <div class="d-flex align-items-center">
                                        <img src="assets/images/avatars/avatar-6.png" alt="" class="rounded-circle" width="52" height="52">
                                        <div class="ms-3 flex-grow-1">
                                            <h6 class="mb-0 dropdown-msg-user">Johnny Seitz <span class="msg-time float-end text-secondary">2 w</span></h6>
                                            <small class="mb-0 dropdown-msg-text text-secondary d-flex align-items-center">All the Lorem Ipsum generators</small>
                                        </div>
                                    </div>
                                </a>
                                <a class="dropdown-item" href="#">
                                    <div class="d-flex align-items-center">
                                        <img src="assets/images/avatars/avatar-1.png" alt="" class="rounded-circle" width="52" height="52">
                                        <div class="ms-3 flex-grow-1">
                                            <h6 class="mb-0 dropdown-msg-user">Amelio Joly <span class="msg-time float-end text-secondary">1 m</span></h6>
                                            <small class="mb-0 dropdown-msg-text text-secondary d-flex align-items-center">The standard chunk of lorem...</small>
                                        </div>
                                    </div>
                                </a>
                                <a class="dropdown-item" href="#">
                                    <div class="d-flex align-items-center">
                                        <img src="assets/images/avatars/avatar-2.png" alt="" class="rounded-circle" width="52" height="52">
                                        <div class="ms-3 flex-grow-1">
                                            <h6 class="mb-0 dropdown-msg-user">Althea Cabardo <span class="msg-time float-end text-secondary">7 m</span></h6>
                                            <small class="mb-0 dropdown-msg-text text-secondary d-flex align-items-center">Many desktop publishing</small>
                                        </div>
                                    </div>
                                </a>
                                <a class="dropdown-item" href="#">
                                    <div class="d-flex align-items-center">
                                        <img src="assets/images/avatars/avatar-3.png" alt="" class="rounded-circle" width="52" height="52">
                                        <div class="ms-3 flex-grow-1">
                                            <h6 class="mb-0 dropdown-msg-user">Katherine Pechon <span class="msg-time float-end text-secondary">2 h</span></h6>
                                            <small class="mb-0 dropdown-msg-text text-secondary d-flex align-items-center">Making this the first true</small>
                                        </div>
                                    </div>
                                </a>
                                <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></div>
                            <div class="p-2">
                                <div><hr class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">
                                    <div class="text-center">View All Messages</div>
                                </a>
                            </div>
                        </div> 
                    </li> --}}
                    <li class="nav-item dropdown dropdown-large">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown">
                            <div class="user-setting d-flex align-items-center" style="padding: 0 10px;">
                                <div class="user-name d-none d-sm-block mt-50" style="margin-top: 9px;">
                                    {{-- <h5 style="background-color:#3361FF;color: #f1f1f1;border-radius: 50%; height: 25px;
                                          width: 25px;text-align: center;"> {{Auth::user()->full_name}} </h5> --}}
                                </div>

                                <div class="">{{strtoupper(Auth::user()->full_name)}}</div>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{route('teacher.account.Information')}}">                                    
                                    <div class="d-flex align-items-center">
                                            <div class="ms-3">
                                                {{-- <h6 class="mb-0 dropdown-user-name">{{strtoupper(Auth::user()->full_name)}}</h6> --}}
                                                <h6 class="mb-0 dropdown-user-name">{{strtoupper(Auth::user()->full_name)}}</h6>
                                                <small class="mb-0 dropdown-user-designation text-secondary">{{strtoupper(Auth::user()->designation)}}</small>
                                            </div>
                                    </div>
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>

                                    <a class="dropdown-item" href="{{route('teacher.panel.salary.show')}}">
                                        <div class="d-flex align-items-center">
                                            <div class="setting-icon"><i class="fadeIn animated bx bx-money"></i></div>
                                            <div class="setting-text ms-3"><span>Salary Information</span></div>
                                        </div>
                                    </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{route('teacher.account.vaccine')}}">
                                    <div class="d-flex align-items-center">
                                        <div class="setting-icon"><i class="lni lni-capsule"></i></div>
                                        <div class="setting-text ms-3"><span>Vaccine Status</span></div>
                                    </div>
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{route('teacher.account.Information')}}">
                                    <div class="d-flex align-items-center">
                                        <div class="setting-icon"><i class="bi bi-person-fill"></i></div>
                                        <div class="setting-text ms-3"><span>Account Status</span></div>
                                    </div>
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="">
                                    <div class="d-flex align-items-center">
                                        <a href="{{ route('logout') }}" class="btn btn-light" onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
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
                    <button class="nav-link {{( (Request::segment(1) == 'teachers') and (is_null(Request::segment(2))) ) ? 'active' : ''  }}" data-bs-toggle="pill" data-bs-target="#pills-mdashboards" type="button"><i class="bi bi-house-door-fill"></i></button>
                </li>
{{--                <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Class/Section..etc">--}}
{{--                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-dashboards" type="button"><i class="bi bi-collection"></i></button>--}}
{{--                </li>--}}
{{--                <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Teacher">--}}
{{--                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-teacher" type="button"><i class="bi bi-person-check-fill"></i></button>--}}
{{--                </li>--}}
{{--                <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Student">--}}
{{--                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-student" type="button"><i class="bi bi-people-fill"></i></button>--}}
{{--                </li>--}}
{{--                <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Attendance">--}}
{{--                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-attentdance" type="button"><i class="bi bi-house-door-fill"></i></button>--}}
{{--                </li>--}}
{{--                <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Finance">--}}
{{--                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-finance" type="button"><i class="bi bi-app-indicator"></i></button>--}}
{{--                </li>--}}
{{--                <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Staff">--}}
{{--                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-application" type="button"><i class="bi bi-person-bounding-box"></i></button>--}}
{{--                </li>--}}
{{--                <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Sms">--}}
{{--                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-application2" type="button"><i class="fadeIn animated bx bx-comment-detail"></i></button>--}}
{{--                </li>--}}

                <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Assignment">
                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-result" type="button"><i class="fadeIn animated bx bx-comment-detail"></i></button>
                </li>
            </ul>
        </div>
        <div class="textmenu">
            <div class="brand-logo">
                <a>{{getSchoolDataUser(Auth::user()->school_id)->school_name}}<br>
                </a>
            </div>
            <div class="tab-content ">
                <div class="tab-pane fade {{(( (Request::segment(1) == 'teachers') and (is_null(Request::segment(2)))) or 
                ((Request::segment(1) == 'teachers') and (Request::segment(2) == 'attendance') and (Request::segment(3) == 'show') and (Request::segment(4) == 'class')) or
                ((Request::segment(1) == 'teachers') and (Request::segment(2) == 'result') and (Request::segment(3) == 'show') and (Request::segment(4) == 'class')))
                 ? 'active show' : ''  }}" id="pills-mdashboards">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-0">All Menu</h5>
                            </div>
                            <small class="mb-0">Get a quick view</small>
                        </div>
                        <a href="{{url('/teachers')}}" class="list-group-item"><i class="fadeIn animated bx bx-home-circle"></i>Dashboard</a>
                        <a href="{{route('teacher.myClass.show')}}" class="list-group-item"><i class="fadeIn animated bx bx-chalkboard"></i>My Classes</a>
                        <a href="{{route('all.teachers.attendance.show')}}" class="list-group-item"><i class="fadeIn animated bx bx-folder-open"></i>All Attendance Show</a>
                        {{-- <a href="{{route('all.teachers.result.show')}}" class="list-group-item"><i class="fadeIn animated bx bx-message-alt-edit"></i>Result</a>
                        <a href="{{route('all.teachers.student.show')}}" class="list-group-item"><i class="fadeIn animated bx bx-user-check"></i>Student Show</a> --}}
                        {{-- <a href="{{route('all.teachers.routine.show')}}" class="list-group-item"><i class="fadeIn animated bx bx-chalkboard"></i>Routine</a> --}}



                    </div>
                </div>
                <div class="tab-pane fade {{( ((Request::segment(1) == 'teachers') and (Request::segment(2) == 'assignment')) 
                or ((Request::segment(1) == 'teachers') and (Request::segment(2) == 'details') and (Request::segment(3) == 'assignment'))  ) ? 'active show' : '' }}" id="pills-result">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-0">Assignment</h5>
                            </div>
                            <small class="mb-0">Get  A Quick View</small>
                        </div>
                        {{-- <a href="{{route('all.assignment.student.show')}}" class="list-group-item"><i class="fadeIn animated bx bx-calendar-check"></i>Assignment</a> --}}
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
{{--<!--app-->--}}
{{--<script src="{{ asset('schools/assets/js/app.js')}}"></script>--}}
@stack('js')
@include('sweetalert::alert')

</body>


<!-- Mirrored from codervent.com/skodash/demo/tabular-menu/ltr/table-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 12 Nov 2021 20:17:08 GMT -->
</html>
