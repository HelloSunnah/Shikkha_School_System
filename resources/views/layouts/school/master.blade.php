<!doctype html>
<?php

use Illuminate\Support\Carbon;

$i = 1;
?>
<html lang="en" class=" {{ Auth::user()->color == 0 ? 'light-theme' : 'dark-theme' }}">

<head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('images/favicon.svg') }}" type="image/svg" />
    <link href="{{ asset('schools/assets/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <!--plugins-->
    <link href="{{ asset('schools/assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
    <link href="{{ asset('schools/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />


    <!-- Toastr style -->
    <link href="{{ asset('assets/admin/css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
    <!-- Bootstrap CSS -->
    <link href="{{ asset('schools/assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> --}}
    <link href="{{ asset('schools/assets/css/bootstrap-extended.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />
    <link href="{{ asset('schools/assets/css/icons.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">

    <!-- loader-->
    <link href="{{ asset('schools/assets/css/pace.min.css') }}" rel="stylesheet" />

    <!--Theme Styles-->
    <link href="{{ asset('schools/assets/css/dark-theme.css') }}" rel="stylesheet" />
    <link href="{{ asset('schools/assets/css/light-theme.css') }}" rel="stylesheet" />
    <link href="{{ asset('schools/assets/css/semi-dark.css') }}" rel="stylesheet" />
    <link href="{{ asset('schools/assets/css/header-colors.css') }}" rel="stylesheet" />
    <link href="{{ asset('schools/assets/css/style.css') }}" rel="stylesheet" />

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

    <title>{{ isset($seo_array['seoTitle']) ? $seo_array['seoTitle'] : 'Shikkha - ' . Auth::user()->school_name }}</title>
    <meta name="description"
        content="{{ isset($seo_array['seoDescription']) ? $seo_array['seoDescription'] : 'Shikkha - ' . Auth::user()->school_name }}">
    <meta name="keywords"
        content="{{ isset($seo_array['seoKeyword']) ? $seo_array['seoKeyword'] : 'Shikkha' . Auth::user()->school_name }}">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    {{-- Select2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    {{-- OwlCarousel css --}}

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"
        integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g=="
        crossorigin="anonymous" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css"
        integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw=="
        crossorigin="anonymous" />
    {{-- OwlCarousel css --}}

    <link href="{{ asset('schools/assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />

    @stack('css')
    @include('layouts.school.schoolStyle')
    <style>
        .pace-done {
            background: #eef1f2 !important;
        }

        button.btn.btn-dark.btn-switcher.shadow-sm {
            z-index: 1000;
        }

        .nav-link {
            display: inline;
        }

        .icon-purple {
            color: #7100A7;
            border: 1.5px solid #7100A7;
        }

        @media print {
            .graph-img img {
                display: inline;
            }
        }

        @media print {
            * {
                -webkit-print-color-adjust: exact;
            }
        }

        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

        .primary-btn {
            background-color: blueviolet !important;
            border-color: blueviolet !important;
        }
    </style>

</head>

<body>
    <!--start wrapper-->
    <?php
    
    use Illuminate\Support\Facades\Request;
    
    $date = Carbon::parse(Auth::user()->created_at);
    $now = Carbon::now();
    
    $diff = $date->diffInDays($now);
    $data = 38 - $diff;
    ?>

    <!-- modal -->

    <div class="wrapper">
        <!--start top header-->
        <header class="top-header">
            <nav class="navbar navbar-expand">
                <div class="mobile-toggle-icon d-xl-none">
                    <i class="bi bi-list" style="color: #000"></i>
                </div>
                <div class="top-navbar d-none d-xl-block">
                    <ul class="navbar-nav align-items-center">

                    </ul>
                </div>
                {{-- <div class="search-toggle-icon d-xl-none ms-auto">
                    <i class="bi bi-search"></i>
                </div> --}}
                <div class="searchbar d-none d-xl-flex ms-auto">
                    <div class="position-absolute top-50 translate-middle-y search-icon ms-3"></div>

                    @if (workPlace(Auth::user()->id)->price_id == 0)
                        {{-- <h5 style="color:red;">{{$diff}} DAYS FREE TRIAL</h5> --}}
                    @else
                    @endif

                </div>

                <div class="toggle-ln">
                    <input type="checkbox" id="switch" {{ App::getLocale() === 'bn' ? 'checked' : '' }}
                        name="language">
                    <label for=""class="onbtn">En</label>
                    <label for=""class="offbtn">Bn</label>
                </div>



                {{-- <div class="dropdown bg-primary rounded ms-auto" style="background-color: #7b00a7 !important">
                    <a class="btn btn-sm dropdown-toggle text-light" href="#" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        EN/বাং
                    </a>

                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('change.language', 'bn') }}">Bangla</a></li>
                        <li><a class="dropdown-item" href="{{ route('change.language', 'en') }}">English</a></li>
                    </ul>
                </div> --}}

                <div class="top-navbar-right ms-3">
                    <ul class="navbar-nav align-items-center">
                        <li class="nav-item dropdown dropdown-large">
                            <a class="nav-link  dropdown-toggle-nocaret" data-bs-toggle="dropdown">
                                <div class="user-setting d-flex align-items-center" style="border: none !important;">
                                    <div class="user-name d-none d-sm-block mt-50">
                                        <img src="{{ asset(Auth::user()->school_logo) }}" alt="" width="32px"
                                            height="32px" class="rounded-circle">
                                    </div>

                                    <div class="d-flex pt-3 font-weight-bold text-primary">
                                        <strong>
                                            <p class="pe-1 ">{{ Auth::user()->school_name }}</p>
                                        </strong>
                                        <i class="bi bi-chevron-down" style="font-size:15px;"></i>
                                    </div>

                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">

                                <li>
                                    <a class="dropdown-item" href="{{ route('school.profile') }}">
                                        <div class="d-flex align-items-center">
                                            <div class="ms-3 text-center">
                                                <h6 class="mb-0 dropdown-user-name text-center">{{ __('app.School') }}
                                                    {{ __('app.Profile') }}</h6>
                                                <small
                                                    class="mb-0 dropdown-user-designation text-left">{{ Auth::user()->school_name }}</small>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                {{-- <li><hr class="dropdown-divider"></li>
                                <li>
                                    @if (workPlace()->price_id == 0)
                                    <a class="dropdown-item" href="{{route('school.package.after')}}">
                                <div class="d-flex align-items-center">
                                    <div class="setting-icon" style="background-color:#7b00a7;color:white"><i class="bi bi-person-fill"></i></div>
                                    <div class="setting-text ms-3"><span>{{__('app.All')}} {{__('app.Package')}}</span></div>
                                </div>
                                </a>
                                @else
                                <a class="dropdown-item" href="{{route('school.payment.info')}}">
                                    <div class="d-flex align-items-center">
                                        <div class="setting-icon" style="background-color:#7b00a7;color:white"><i class="fadeIn animated bx bx-money"></i></div>
                                        <div class="setting-text ms-3"><span>{{__('app.Paynow')}}</span></div>
                                    </div>
                                </a>
                                @endif
                        </li> --}}
                                {{-- <li><hr class="dropdown-divider"></li> --}}
                                {{-- <li>
                                    <a class="dropdown-item" href="{{route('school.payment.status')}}">
                        <div class="d-flex align-items-center">
                            <div class="setting-icon" style="background-color:#7b00a7;color:white"><i class="bi bi-person-fill"></i></div>
                            <div class="setting-text ms-3"><span>{{__('app.Account')}} {{__('app.Status')}}</span></div>
                        </div>
                        </a>
                        </li> --}}
                                {{-- <li><hr class="dropdown-divider"></li> --}}
                                {{-- <li>
                                    <a class="dropdown-item" target="_blank" href="{{route('show.notice')}}">
                        <div class="d-flex align-items-center">
                            <div class="setting-icon" style="background-color:#7b00a7;color:white"><i class="bi bi-bell"></i></div>
                            <div class="setting-text ms-3"><span>{{__('app.Notice')}}</span></div>
                        </div>
                        </a>
                        </li> --}}
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('school.billing') }}">
                                        <div class="d-flex align-items-center">
                                            <div class="setting-icon" style="background-color:#7b00a7;color:white"><i
                                                    class="bi bi-cash"></i></div>
                                            <div class="setting-text ms-3"><span>{{ __('app.billing') }}</span></div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item" target="_blank" href="{{ route('Recyclepage') }}">
                                        <div class="d-flex align-items-center">
                                            <div class="setting-icon" style="background-color:#7b00a7;color:white"><i
                                                    class="bi bi-trash3"></i></div>
                                            <div class="setting-text ms-3"><span>Recycle bin</span></div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" target="_blank"
                                        href="{{ route('support.ticket.create') }}">
                                        <div class="d-flex align-items-center">
                                            <div class="setting-icon" style="background-color:#7b00a7;color:white"><i
                                                    class="bi bi-briefcase-fill"></i></div>
                                            <div class="setting-text ms-3"><span>Support</span></div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>

                                    <div class="d-flex align-items-center" style="margin-left:250px">
                                        <a href="{{ route('logout') }}" class="btn btn-primary"
                                            onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">{{ __('app.Logout') }}</a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                        </form>
                                        <div class="setting-text ms-3">

                                        </div>
                                    </div>

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
                    <div class="nav-toggle-icon"><i class="bi bi-list text-white"></i></div>
                </div>
                <ul class="nav nav-pills flex-column" style="align-items: center">
                    <li class="nav-item mb-2 text-center" data-bs-toggle="tooltip" data-bs-placement="right"
                        title="{{ __('app.dashboard') }}">
                        <a href="{{ route('school.dashboard') }}"><button class="nav-link mb-0"
                                data-bs-toggle="pill" data-bs-target="#pills-mdashboards" type="button"> <img
                                    src="{{ asset('assets/nav-icons-white/dashboard.svg') }}" alt="dashboard"
                                    width="20"> </button></a>
                        <br> {{ __('app.dashboard') }}
                    </li>
                    <li class="nav-item mb-2 text-center" data-bs-toggle="tooltip" data-bs-placement="right"
                        title="{{ __('app.Class') }}">
                        <a href="{{ route('class.show') }}"><button class="nav-link mb-0" data-bs-toggle="pill"
                                data-bs-target="#pills-class" type="button"><img
                                    src="{{ asset('assets/nav-icons-white/class.svg') }}" alt="class"
                                    width="20"></button></a>
                        <br> {{ __('app.Class') }}
                    </li>
                    <li class="nav-item mb-2 text-center" data-bs-toggle="tooltip" data-bs-placement="right"
                        title="{{ __('app.Student') }}">
                        <a href="{{ route('student.teacher.create.show') }}"><button class="nav-link mb-0"
                                data-bs-toggle="pill" data-bs-target="#pills-student" type="button"><img
                                    src="{{ asset('assets/nav-icons-white/student.svg') }}" alt="student"
                                    width="20"></button></a>
                        <br> {{ __('app.Student') }}
                    </li>
                    {{-- <li class="nav-item mb-2 text-center" data-bs-toggle="tooltip" data-bs-placement="right" title="{{__('app.Student')}}">
                        <a href="{{route('user.role.show')}}"><button class="nav-link mb-0" data-bs-toggle="pill" data-bs-target="#pills-user_role" type="button"><img src="{{asset('assets/nav-icons-white/student.svg')}}" alt="user_role" width="20"></button></a>
                        <br> {{__('app.User_role')}}
                    </li> --}}
                    
                    <li class="nav-item mb-2 text-center" data-bs-toggle="tooltip" data-bs-placement="right"
                        title="{{ __('app.Teacher') }}">
                        <a href="{{ route('teacher.Show') }}"><button class="nav-link mb-0" data-bs-toggle="pill"
                                data-bs-target="#pills-teacher" type="button"><img
                                    src="{{ asset('assets/nav-icons-white/teacher.svg') }}" alt="teacher"
                                    width="20"></button></a>
                        <br> {{ __('app.Teacher') }}
                    </li>
                    <li class="nav-item mb-2 text-center" data-bs-toggle="tooltip" data-bs-placement="right"
                        title="{{ __('app.Stuff') }}">
                        <a href="{{ route('school.staff.List') }}"><button class="nav-link mb-0"
                                data-bs-toggle="pill" data-bs-target="#pills-staff" type="button"><img
                                    src="{{ asset('assets/nav-icons-white/staff.svg') }}" alt="staff"
                                    width="20"></button></a>
                        <br>{{ __('app.Stuff') }}
                    </li>
                    <li class="nav-item mb-2 text-center" data-bs-toggle="tooltip" data-bs-placement="right"
                        title="{{ __('app.Attendance') }}">
                        <a href="{{ route('student.attendance.show') }}"><button class="nav-link mb-0"
                                data-bs-toggle="pill" data-bs-target="#pills-attentdance" type="button"><img
                                    src="{{ asset('assets/nav-icons-white/attendence.svg') }}" alt="attendence"
                                    width="20"></button></a>
                        <br>{{ __('app.Attendance') }}
                    </li>
                    <li class="nav-item mb-2 text-center" data-bs-toggle="tooltip" data-bs-placement="right"
                        title="{{ __('app.Finance') }}">
                        <a href="{{ route('school.finance.dashoboard') }}"><button class="nav-link mb-0"
                                data-bs-toggle="pill" data-bs-target="#pills-finance" type="button"><img
                                    src="{{ asset('assets/nav-icons-white/finance.svg') }}" alt="finance"
                                    width="20"></button></a>
                        <br>{{ __('app.Finance') }}
                    </li>

                    @if (Auth::user()->subscription_status != 0)
                        <li class="nav-item mb-2 text-center" data-bs-toggle="tooltip" data-bs-placement="right"
                            title="{{ __('app.SMS') }}">
                            <a href="{{ route('send.sms.student') }}"><button class="nav-link mb-0"
                                    data-bs-toggle="pill" data-bs-target="#pills-sms" type="button"><img
                                        src="{{ asset('assets/nav-icons-white/sms.svg') }}" alt="sms"
                                        width="20"></button></a>
                            <br>{{ __('app.SMS') }}
                        </li>
                    @endif
                    
                    <li class="nav-item mb-2 text-center" data-bs-toggle="tooltip" data-bs-placement="right"
                        title="{{ __('app.Exam') }}">
                        <a href="{{ route('term.index') }}"><button class="nav-link mb-0" data-bs-toggle="pill"
                                data-bs-target="#pills-exam" type="button"><img
                                    src="{{ asset('assets/nav-icons-white/exam.svg') }}" alt="exam"
                                    width="20"></button></a>
                        <br>{{ __('app.Exam') }}
                    </li>
                    <li class="nav-item mb-2 text-center" data-bs-toggle="tooltip" data-bs-placement="right"
                        title="{{ __('app.Result') }}">
                        <a href="{{ route('result.school.admin.create.show.all') }}"><button class="nav-link mb-0"
                                data-bs-toggle="pill" data-bs-target="#pills-result" type="button"><img
                                    src="{{ asset('assets/nav-icons-white/result.svg') }}" alt="result"
                                    width="20"></button></a>
                        <br>{{ __('app.Result') }}
                    </li>
                    <li class="nav-item mb-2 text-center" data-bs-toggle="tooltip" data-bs-placement="right"
                        title="{{ __('app.Notice') }}">
                        <a href="{{ route('notice.school.admin.create.show') }}"><button class="nav-link mb-0"
                                data-bs-toggle="pill" data-bs-target="#pills-notice" type="button"><img
                                    src="{{ asset('assets/nav-icons-white/notice.svg') }}" alt="notice"
                                    width="20"></button></a>
                        <br>{{ __('app.Notice') }}
                    </li>
                    <li class="nav-item mb-2 text-center" data-bs-toggle="tooltip" data-bs-placement="right"
                        title="{{ __('app.Library') }}">
                        <a href="{{ route('borrowerinfo') }}"><button class="nav-link mb-0" data-bs-toggle="pill"
                                data-bs-target="#pills-library" type="button"><img
                                    src="{{ asset('assets/nav-icons-white/library.svg') }}" alt="library"
                                    width="20"></button></a>
                        <br>{{ __('app.Library') }}
                    </li>
                    <li class="nav-item mb-2 text-center" data-bs-toggle="tooltip" data-bs-placement="right"
                        title="{{ __('app.Setting') }}">
                        <a href="{{ route('settings') }}"><button class="nav-link mb-0" data-bs-toggle="pill"
                                data-bs-target="#pills-settings" type="button"><img
                                    src="{{ asset('assets/nav-icons-white/settings.svg') }}" alt="settings"
                                    width="20"></button></a>
                        <br>{{ __('app.Setting') }}
                    </li>
                    <li class="nav-item mb-2 text-center" data-bs-toggle="tooltip" data-bs-placement="right"
                        title="{{ __('app.Addon') }}">
                        <a href="{{ route('SchoolAddon') }}"><button class="nav-link mb-0" data-bs-toggle="pill"
                                data-bs-target="#pills-SchoolAddon" type="button"><img
                                    src="{{ asset('assets/nav-icons-white/addons.svg') }}" alt="addons"
                                    width="20"></button></a>
                        <br>{{ __('app.Addon') }}
                    </li>
                </ul>
            </div>
            <div class="textmenu">
                <div class="brand-logo">
                    {{-- <h6>{{Auth::user()->school_name}}<br>
                    <button class="btn btn-danger btn-sm" style="font-size: 12px;">
                        {{90-$diff}} days left
                    </button>
                    </h6> --}}
                </div>
                <div class="tab-content">

                    {{-- Dashboard --}}
                    <div class="tab-pane fade <?php if (Request::segment(1) == 'school' and Request::segment(2) == 'dashboard' or Request::segment(2) == 'online' and Request::segment(3) == 'admission' or Request::segment(1) == 'school' and Request::segment(2) == 'profile') {
                        echo 'active show';
                    } ?>" id="pills-mdashboards">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item sidebar2 ">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-0">{{ __('app.dashboard') }}</h5>
                                </div>
                                {{-- <small class="mb-0">{{__('app.dashboard1')}}</small> --}}
                            </div>
                            <div>
                                <a href="{{ route('school.dashboard') }}" class="list-group-item ">
                                    <div class="imgbox"><i class="bi bi-chevron-double-right "></i></div>
                                    {{ __('app.dashboard') }}
                                </a>
                                    class="list-group-item ">
                                    <div class="imgbox"><i class="bi bi-chevron-double-right"></i></div>
                                    {{ __('app.feater1a') }} {{ __('app.Admission') }}
                                </a>
                                <a href="{{ route('online.Admission.Form.list') }}" class="list-group-item ">
                                    <div class="imgbox"><i class="bi bi-chevron-double-right"></i></div>
                                    {{ __('app.Admission') }} {{ __('app.Request') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Class / Section / Group / Period / routine / syllabus / subject --}}
                    <div class="tab-pane fade <?php if (Request::segment(1) == 'school' and (Request::segment(2) == 'class' or Request::segment(2) == 'section' or Request::segment(2) == 'group' or Request::segment(2) == 'subject' or Request::segment(2) == 'department' or Request::segment(2) == 'routine' or Request::segment(2) == 'period' or Request::segment(2) == 'syllabus' or Request::segment(2) == 'FormShowPost')) {
                        echo 'active show';
                    } ?>" id="pills-class">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-0">{{ __('app.Class') }}</h5>
                                </div>
                                {{-- <small class="mb-0">{{__('app.dashboard1')}}</small> --}}
                            </div>
                            <div>
                                <a href="{{ route('class.show') }}" class="list-group-item ">
                                    <div class="imgbox"><i class="bi bi-chevron-double-right"></i></div>
                                    {{ __('app.Class') }} {{ __('app.Show') }}
                                </a>
                                <a href="{{ route('section.show') }}" class="list-group-item ">
                                    <div class="imgbox"><i class="bi bi-chevron-double-right"></i></div>
                                    {{ __('app.Section') }} {{ __('app.Show') }}
                                </a>
                                {{-- <a href="{{route('group.show')}}" class="list-group-item"><i class="fadeIn animated bx bx-network-chart"></i>{{__('app.Group')}} {{__('app.Show')}}</a> --}}
                                {{-- <a href="{{route('department.show')}}" class="list-group-item"><i class="lni lni-control-panel"></i>Show Department</a> --}}
                                <a href="{{ route('syllabus.form.show') }}" class="list-group-item ">
                                    <div class="imgbox"><i class="bi bi-chevron-double-right"></i></div>
                                    {{ __('app.Class') }} {{ __('app.Syllabus') }}
                                </a>
                                <a href="{{ route('subject.index') }}" class="list-group-item ">
                                    <div class="imgbox"><i class="bi bi-chevron-double-right"></i></div>
                                    {{ __('app.Subject') }} {{ __('app.Show') }}
                                </a>
                                <a href="{{ route('period.index') }}" class="list-group-item ">
                                    <div class="imgbox"><i class="bi bi-chevron-double-right"></i></div>
                                    {{ __('app.Class') }} {{ __('app.Period') }}
                                </a>
                                <a href="{{ route('routine.index') }}" class="list-group-item ">
                                    <div class="imgbox"><i class="bi bi-chevron-double-right"></i></div>
                                    {{ __('app.Class') }} {{ __('app.Routine') }}
                                </a>
                                <a href="{{ route('school.Routine.view') }}" class="list-group-item ">
                                    <div class="imgbox"><i class="bi bi-chevron-double-right"></i></div>
                                    {{ __('app.School') }} {{ __('app.Routine') }} {{ __('app.Show') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Student --}}
                    <div class="tab-pane fade <?php if (Request::segment(1) == 'school' and Request::segment(2) == 'student' and (Request::segment(3) == 'show' or Request::segment(3) == 'create' or Request::segment(3) == 'edit' or Request::segment(3) == 'studentshow' or Request::segment(3) == 'student' and Request::segment(4) == 'singleShow') or Request::route()->getName() == 'student.find') {
                        echo 'active show';
                    } ?>" id="pills-student">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-0">{{ __('app.Student') }}</h5>
                                </div>
                                {{-- <small class="mb-0">{{__('app.dashboard1')}}</small> --}}
                            </div>
                            <div>
                                <a href="{{ route('student.teacher.create.show') }}" class="list-group-item ">
                                    <div class="imgbox"><i class="bi bi-chevron-double-right"></i></div>
                                    {{ __('app.Student') }} {{ __('app.Show') }}
                                </a>
                                <a href="{{ route('student.create') }}" class="list-group-item ">
                                    <div class="imgbox"><i class="bi bi-chevron-double-right"></i></div>
                                    {{ __('app.Student') }} {{ __('app.Create') }}
                                </a>

                                {{-- <a href="{{route('student.upload')}}" class="list-group-item"><i class="fadeIn animated bx bx-user-plus"></i>{{__('app.Student')}} {{__('app.Upload')}}</a> --}}
                                {{-- <a href="{{route('id.Card')}}" class="list-group-item"><i class="fadeIn animated bx bx-credit-card-alt"></i>Student Id Card</a> --}}
                            </div>

                        </div>
                    </div>

                    {{-- Teacher --}}
                    <div class="tab-pane fade <?php if (Request::segment(1) == 'school' and Request::segment(2) == 'teacher') {
                        echo 'active show';
                    } ?>" id="pills-teacher">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-0">{{ __('app.Teacher') }}</h5>
                                </div>
                                {{-- <small class="mb-0">{{__('app.dashboard1')}}</small> --}}
                            </div>
                            <div>
                                <a href="{{ route('teacher.Show') }}" class="list-group-item ">
                                    <div class="imgbox"><i class="bi bi-chevron-double-right"></i></div>
                                    {{ __('app.Teacher') }} {{ __('app.Show') }}
                                </a>
                                <a href="{{ route('assign.teacher.create.show') }}" class="list-group-item ">
                                    <div class="imgbox"><i class="bi bi-chevron-double-right"></i></div>
                                    {{ __('app.Assign') }} {{ __('app.Class') }} {{ __('app.Teacher') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Staff --}}
                    <div class="tab-pane fade @if (Request::segment(1) == 'school' and Request::segment(2) == 'staff') active show @endif " id="pills-staff">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-0">{{ __('app.Stuff') }} </h5>
                                </div>
                                {{-- <small class="mb-0">{{__('app.dashboard1')}} </small> --}}
                            </div>
                            <div>
                                <a href="{{ route('school.staff.List') }}" class="list-group-item ">
                                    <div class="imgbox"><i class="bi bi-chevron-double-right"></i></div>
                                    {{ __('app.Stuff') }} {{ __('app.List') }}
                                </a>
                                <a href="{{ route('school.staff.show') }}" class="list-group-item ">
                                    <div class="imgbox"><i class="bi bi-chevron-double-right"></i></div>
                                    {{ __('app.Stuff') }} {{ __('app.Type') }}
                                </a>
                                {{-- <a href="{{route('school.staff.create')}}" class="list-group-item"><i class="bi bi-cast"></i>Staff Type create</a> --}}
                                {{-- <a href="{{route('school.staff.List.create')}}" class="list-group-item"><i class="bi bi-cast"></i>Staff Create</a> --}}
                            </div>

                        </div>
                    </div>

                    {{-- Attendance --}}
                    <div class="tab-pane fade <?php if (Request::segment(1) == 'school' and Request::segment(2) == 'student' and (Request::segment(3) == 'attendanceshow' or Request::segment(3) == 'all' and Request::segment(4) == 'attendanceshow' or Request::segment(3) == 'attendance' and Request::segment(4) == 'attendanceshow' or Request::segment(3) == 'attendance' and Request::segment(4) == 'show' or Request::segment(3) == 'attendance' and Request::segment(4) == 'dashboard' or Request::segment(3) == 'attendance' and Request::segment(4) == 'profile' or Request::segment(3) == 'attendance' and Request::segment(4) == 'list') or Request::segment(3) == 'datepage' or Request::segment(3) == 'datepage' or Request::segment(3) == 'StaffAttendancePage' or Request::segment(3) == 'TeacherAttendance' or Request::segment(3) == 'TeacherView' or Request::segment(3) == 'Teacher-Attendance-Month' or Request::segment(2) == 'Staff' and Request::segment(3) == 'Staff' and Request::segment(4) == 'Attendance' or Request::segment(3) == 'StaffAttendance') {
                        echo 'active show';
                    } ?>" id="pills-attentdance">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-0">{{ __('app.Student') }}</h5>
                                </div>
                                {{-- <small class="mb-0">{{__('app.dashboard1')}}</small> --}}
                            </div>
                            <div>
                                <a href="{{ route('Studentdetailsdashboard') }}" class="list-group-item ">
                                    <div class="imgbox"><i class="bi bi-chevron-double-right"></i></div>
                                    {{ __('app.dashboard') }}
                                </a>
                                <a href="{{ route('student.attendance.show') }}" class="list-group-item ">
                                    <div class="imgbox"><i class="bi bi-chevron-double-right"></i></div>
                                    {{ __('app.Student') }} {{ __('app.Attendance') }}
                                </a>
                                {{-- @if (!is_null(Auth::user()->zk_ip_address))
                            <a href="javascript::" onclick="if(confirm('*** Please, Ensure that your fingerprint device is running! ***')){ location.replace('{{route('get.attendance.device')}}') }" class="list-group-item"><i class="fadeIn animated bi bi-hdd-rack"></i> {{__('app.Attendance')}} {{__('app.Get')}}</a>
                                @endif --}}
                                {{-- <a href="{{route('student.attendance.show.date')}}" class="list-group-item"><i class="fadeIn animated bx bx-food-menu"></i>{{__('app.Show Attendance')}}</a> --}}
                                <a href="{{ route('student.attendance.show.date.all') }}" class="list-group-item ">
                                    <div class="imgbox"><i class="bi bi-chevron-double-right"></i></div>
                                    {{ __('app.All') }} {{ __('app.Attendance') }}
                                </a>
                                <a href="javascript::" data-bs-target="#attendance-upload-modal"
                                    data-bs-toggle="modal" class="list-group-item ">
                                    <div class="imgbox"><i class="bi bi-chevron-double-right"></i></div>
                                    {{ __('app.All') }} {{ __('app.upload_attendance') }}
                                </a>
                                <a href="javascript::" data-bs-target="#get_attendance" data-bs-toggle="modal"
                                    class="list-group-item ">
                                    <div class="imgbox"><i class="bi bi-chevron-double-right"></i></div>
                                    {{ __('app.All') }} {{ __('app.Get Attendance') }}
                                </a>
                                @if (Auth::user()->subscription_status != 0)
                                    <a href="{{ route('auto.attendance') }}" class="list-group-item ">
                                        <div class="imgbox"><i class="bi bi-chevron-double-right"></i></div>
                                        {{ __('app.Auto') }} {{ __('app.Attendance') }}
                                    </a>
                                @endif
                                
                                {{-- <a href="{{route('new.user.fingerprint')}}" class="list-group-item"> <i class="fadeIn animated fa fa-caret-right"></i> Add Fingerprint </a> --}}
                            </div>
                            <br>
                            <div class="list-group list-group-flush">
                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-0" style="margin-top:-22px">{{ __('app.Teacher') }}</h5>
                                    </div>
                                </div>
                                <div>
                                    <a href="{{ route('Teacher.datepage') }}" class="list-group-item ">
                                        <div class="imgbox"><i class="bi bi-chevron-double-right"></i></div>
                                        {{ __('app.TakeAttendance') }}
                                    </a>
                                    <a href="{{ route('TeacherAttendance.AllView') }}" class="list-group-item ">
                                        <div class="imgbox"><i class="bi bi-chevron-double-right"></i></div>
                                        {{ __('app.ViewAttendance') }}
                                    </a>
                                </div>
                            </div>
                            <br>
                            <div class="list-group list-group-flush">
                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-0" style="margin-top:-22px">{{ __('app.Stuff') }}</h5>
                                    </div>
                                </div>
                                <div>
                                    <a href="{{ route('StaffAttendancePage') }}" class="list-group-item ">
                                        <div class="imgbox"><i class="bi bi-chevron-double-right"></i></div>
                                        {{ __('app.TakeAttendance') }}
                                    </a>
                                    <a href="{{ route('StaffAttendance.AllView') }}" class="list-group-item ">
                                        <div class="imgbox"><i class="bi bi-chevron-double-right"></i></div>
                                        {{ __('app.ViewAttendance') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>


                    {{-- =================  Finance 
                        =================================================   --}}
                    <div class="tab-pane fade @if((request()->segment(1) == " school" && request()->segment(2) == "finance") || Request::route()->getName() == "school.finance.dashoboard" || Request::route()->getName() == "school.finance.schoolFees" || Request::route()->getName() == "school.finance.assign.fees.index" || Request::route()->getName() == "school.finance.userlist" || Request::route()->getName() == "school.staff.salary.List" || Request::route()->getName() == "teacher.salary.Show" || Request::route()->getName() == "bankadd" || Request::route()->getName() == "expense.show" || Request::route()->getName() == "expense.list" || Request::route()->getName() == "fund.show" || Request::route()->getName() == "fund.list" || Request::route()->getName() == "reciept.create" || Request::route()->getName() == "bankadd.create" || Request::route()->getName() == "bankadd.edit") active show @endif" id="pills-finance">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-0">{{ __('app.Finance') }}</h5>
                                </div>
                                {{-- <small class="mb-0">{{__('app.dashboard1')}}</small> --}}
                                {{-- <small>{{Request::route()->getName()}}</small> --}}
                            </div>
                            <div>
                                {{-- <a href="{{route('student.fees.create')}}" class="list-group-item"><i class="bi bi-cast"></i>Student Fees Create</a> --}}
                                <a href="{{ route('school.finance.dashoboard') }}" class="list-group-item ">
                                    <div class="imgbox"><i class="bi bi-box-arrow-in-right"></i></div>
                                    {{ __('app.dashboard') }}
                                </a>
                                <a href="{{ route('school.finance.schoolFees') }}" class="list-group-item ">
                                    <div class="imgbox"><i class="bi bi-box-arrow-in-right"></i></div>
                                    {{ __('app.School') }} {{ __('app.Fees') }}
                                </a>
                                <a href="{{ route('school.finance.assign.fees.index') }}" class="list-group-item ">
                                    <div class="imgbox"><i class="bi bi-box-arrow-in-right"></i></div>
                                    {{ __('app.Assign') }} {{ __('app.Fees') }}
                                </a>
                                <a href="{{ route('school.finance.userlist') }}" class="list-group-item ">
                                    <div class="imgbox"><i class="bi bi-box-arrow-in-right"></i></div>
                                    {{ __('app.collect_fees') }}
                                </a>
                                <a href="{{ route('school.staff.salary.List') }}" class="list-group-item ">
                                    <div class="imgbox"><i class="bi bi-box-arrow-in-right"></i></div>
                                    {{ __('app.Stuff') }} {{ __('app.Salery') }}
                                </a>
                                <a href="{{ route('teacher.salary.Show') }}" class="list-group-item ">
                                    <div class="imgbox"><i class="bi bi-box-arrow-in-right"></i></div>
                                    {{ __('app.Teacher') }} {{ __('app.Salery') }}
                                </a>
                                <a href="{{ route('bankadd') }}" class="list-group-item ">
                                    <div class="imgbox"><i class="bi bi-box-arrow-in-right"></i></div>
                                    {{ __('app.BankAccount') }}
                                </a>
                                <a href="{{ route('expense.show') }}" class="list-group-item ">
                                    <div class="imgbox"><i class="bi bi-box-arrow-in-right"></i></div>
                                    {{ __('app.Expenses') }}
                                </a>
                                <a href="{{ route('expense.list') }}" class="list-group-item ">
                                    <div class="imgbox"><i class="bi bi-box-arrow-in-right"></i></div>
                                    {{ __('app.Expenses') }} {{ __('app.List') }}
                                </a>
                                <a href="{{ route('fund.show') }}" class="list-group-item ">
                                    <div class="imgbox"><i class="bi bi-box-arrow-in-right"></i></div>
                                    {{ __('app.Funds') }}
                                </a>
                                <a href="{{ route('fund.list') }}" class="list-group-item ">
                                    <div class="imgbox"><i class="bi bi-box-arrow-in-right"></i></div>
                                    {{ __('app.Funds') }} {{ __('app.List') }}
                                </a>
                                <a href="{{ route('reciept.create') }}" class="list-group-item ">
                                    <div class="imgbox"><i class="bi bi-box-arrow-in-right"></i></div>
                                    {{ __('app.Accessories') }} {{ __('app.Receipt') }}
                                </a>
                            </div>


                        </div>
                    </div>

                    {{-- SMS --}}
                    <div class="tab-pane fade <?php if (Request::segment(1) == 'school' and Request::segment(2) == 'send' and Request::segment(3) == 'sms' and (Request::segment(4) == 'teacher' or Request::segment(4) == 'student')) {
                        echo 'active show';
                    } ?>" id="pills-sms">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-0">{{ __('app.SMS') }} </h5>
                                </div>
                                {{-- <small class="mb-0">{{__('app.dashboard1')}} </small> --}}
                            </div>
                            <div>
                                <a href="{{ route('send.sms.student') }}" class="list-group-item ">
                                    <div class="imgbox"><i class="bi bi-chevron-double-right"></i></div>
                                    {{ __('app.SMS') }} {{ __('app.Student') }}
                                </a>

                                <a href="{{ route('send.sms.teacher') }}" class="list-group-item ">
                                    <div class="imgbox"><i class="bi bi-chevron-double-right"></i></div>
                                    {{ __('app.SMS') }} {{ __('app.Teacher') }}
                                </a>
                                <a href="{{ route('send.sms.employee') }}" class="list-group-item ">
                                    <div class="imgbox"><i class="bi bi-chevron-double-right"></i></div>
                                    {{ __('app.SMS') }} {{ __('app.Employee') }}
                                </a>
                                <a href="{{ route('school.message') }}" class="list-group-item ">
                                    <div class="imgbox"><i class="bi bi-chevron-double-right"></i></div>
                                    {{ __('app.SMS') }} {{ __('app.Purchase') }}
                                </a>
                            </div>

                        </div>
                    </div>

                    {{-- Exams --}}
                    <div class="tab-pane fade <?php if (Request::segment(1) == 'school' and Request::segment(2) == 'term' or (Request::segment(3) == 'exam' or Request::segment(3) == 'create/question' or Request::segment(3) == 'admit' and Request::segment(4) == 'card' or Request::segment(3) == 'sit' and Request::segment(4) == 'plan')) {
                        echo 'active show';
                    } ?>" id="pills-exam">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-0">{{ __('app.Exam') }}</h5>
                                </div>
                                {{-- <small class="mb-0">{{__('app.dashboard1')}}</small> --}}
                            </div>
                            <div>

                                <a href="{{ route('term.index') }}" class="list-group-item ">
                                    <div class="imgbox"><i class="bi bi-box-arrow-in-right"></i></div>
                                    {{ __('app.Exam') }} {{ __('app.Terms') }}
                                </a>
                                <a href="{{ route('exam.routine.create') }}" class="list-group-item ">
                                    <div class="imgbox"><i class="bi bi-box-arrow-in-right"></i></div>
                                    {{ __('app.Exam') }} {{ __('app.Routine') }} {{ __('app.Create') }}
                                </a>
                                <a href="{{ route('create.question.show') }}" class="list-group-item ">
                                    <div class="imgbox"><i class="bi bi-box-arrow-in-right"></i></div>
                                    {{ __('app.Question') }} {{ __('app.Create') }}
                                </a>
                                <a href="{{ route('show.question') }}" class="list-group-item ">
                                    <div class="imgbox"><i class="bi bi-box-arrow-in-right"></i></div>
                                    {{ __('app.Question') }} {{ __('app.Show') }}
                                </a>
                                <a href="{{ route('show.admit.card') }}" class="list-group-item ">
                                    <div class="imgbox"><i class="bi bi-box-arrow-in-right"></i></div>
                                    {{ __('app.Admit Card') }}
                                </a>
                                <a href="{{ route('show.sit.plan') }}" class="list-group-item ">
                                    <div class="imgbox"><i class="bi bi-box-arrow-in-right"></i></div>
                                    {{ __('app.Sit Plan') }}
                                </a>
                            </div>

                        </div>
                    </div>

                    {{-- Result --}}
                    <div class="tab-pane fade <?php if (Request::segment(1) == 'school' and (Request::segment(2) == 'student' or Request::segment(2) == 'sms') and (Request::segment(3) == 'result' or Request::segment(3) == 'mark' or Request::segment(3) == 'class' or Request::segment(3) == 'show' and Request::segment(4) == 'class' and Request::segment(5) == 'wise' and Request::segment(6) == 'result' or Request::segment(3) == 'all' and Request::segment(4) == 'result' and Request::segment(5) == 'data' and Request::segment(6) == 'show')) {
                        echo 'active show';
                    } ?>" id="pills-result">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-0">{{ __('app.Result') }}</h5>
                                </div>
                                {{-- <small class="mb-0">{{__('app.dashboard1')}}</small> --}}
                            </div>
                            <div>
                                <a href="{{ route('result.school.admin.create.show.all') }}"
                                    class="list-group-item ">
                                    <div class="imgbox"><i class="bi bi-chevron-double-right"></i></div>
                                    {{ __('app.Result Upload') }}
                                </a>
                                @if (Auth::user()-> subscription_status != 0)
                                    <a href="{{ route('sms.result') }}" class="list-group-item ">
                                        <div class="imgbox"><i class="bi bi-chevron-double-right"></i></div>
                                        {{ __('app.Result') }} {{ __('app.SMS') }}
                                    </a>
                                @endif
                                
                                <a href="{{ route('class.wise.result') }}" class="list-group-item ">
                                    <div class="imgbox"><i class="bi bi-chevron-double-right"></i></div>
                                    {{ __('app.Result_Show') }}
                                </a>
                                
                                <a href="{{ route('result.pdf') }}" class="list-group-item">
                                    <div class="imgbox"><i class="bi bi-box-arrow-in-right"></i></div>Result Pdf
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Library --}}
                    <div class="tab-pane fade <?php if (Request::segment(1) == 'school' and Request::segment(2) == 'library' or Request::segment(2) == 'borrowerinfo' or Request::segment(2) == 'borrowerCreate' or Request::segment(2) == 'borrowerEdit') {
                        echo 'active show';
                    } ?>" id="pills-library">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-0">{{ __('app.Library') }}</h5>
                                </div>
                                {{-- <small class="mb-0">{{__('app.dashboard1')}}</small> --}}
                            </div>
                            <div>
                                <a href="{{ route('borrowerinfo') }}" class="list-group-item ">
                                    <div class="imgbox"><i class="bi bi-chevron-double-right"></i></div>
                                    {{ __('app.Borrower') }} {{ __('app.Info') }}
                                </a>
                                <a href="{{ route('books.create') }}" class="list-group-item ">
                                    <div class="imgbox"><i class="bi bi-chevron-double-right"></i></div>
                                    {{ __('app.Book') }} {{ __('app.Info') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Notice --}}
                    <div class="tab-pane fade <?php if (Request::segment(1) == 'school' and Request::segment(2) == 'student' and Request::segment(3) == 'notice') {
                        echo 'active show';
                    } ?>" id="pills-notice">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-0">{{ __('app.Notice') }}</h5>
                                </div>
                                {{-- <small class="mb-0">{{__('app.dashboard1')}}</small> --}}
                            </div>
                            <div>
                                <a href="{{ route('notice.school.admin.create.show') }}" class="list-group-item ">
                                    <div class="imgbox"><i class="bi bi-chevron-double-right"></i></div>
                                    {{ __('app.Notice') }}
                                </a>
                            </div>

                        </div>
                    </div>

                    {{-- Settings --}}
                    <div class="tab-pane fade @if (Request::segment(1) == ' school' and Request::segment(2) == 'settings') active show @endif"
                        id="pills-settings">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-0">{{ __('app.Setting') }}</h5>
                                </div>
                                {{-- <small class="mb-0">{{__('app.dashboard1')}}</small> --}}
                            </div>
                            <div>
                                <a href="{{ route('settings') }}" class="list-group-item ">
                                    <div class="imgbox"><i class="bi bi-chevron-double-right"></i></div>
                                    {{ __('app.Class') }}
                                </a>
                                <a href="{{ route('device.index') }}" class="list-group-item ">
                                    <div class="imgbox"><i class="bi bi-chevron-double-right"></i></div>
                                    {{ __('app.FingerprintDevice') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Addon --}}
                    <div class="tab-pane fade <?php if (Request::segment(1) == 'school' and Request::segment(2) == 'SchoolAddon') {
                        echo 'active show';
                    } ?>" id="pills-SchoolAddon">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-0">{{ __('app.Addon') }}</h5>
                                </div>
                                {{-- <small class="mb-0">{{__('app.dashboard1')}}</small> --}}
                            </div>
                            <div>
                                <a href="{{ route('SchoolAddon') }}" class="list-group-item ">
                                    <div class="imgbox"><i class="bi bi-chevron-double-right"></i></div>
                                    {{ __('app.Addon') }}
                                </a>
                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </aside>


        @yield('content')
        @include('modals.attendance_form')
        @include('modals.get_attendance')

        <!--start overlay-->
        <div class="overlay nav-toggle-icon"></div>
        <!--end overlay-->

        <!--Start Back To Top Button-->
        <a href="#" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
        <!--End Back To Top Button-->

        <!--start switcher-->
        <div class="switcher-body">
            <form method="post" action="{{ route('user.update.post.color') }}" enctype="multipart/form-data">
                @csrf
                @if (Auth::user()->color == 0)
                    <input type="hidden" name="color" value="1">
                    <button class="btn btn-dark btn-switcher shadow-sm" type="submit" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling"><i
                            class="lni lni-night"></i> <br><span>Dark</span> </button>
                @else
                    <input type="hidden" name="color" value="0">
                    <button class="btn btn-light btn-switcher" type="submit" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling"
                        style="background-color: #f1f1f1;color: black;"><i
                            class="lni lni-sun"></i><br><span>light</span></button>
                @endif
            </form>
        </div>
        <!--end switcher-->

    </div>
    <!--end wrapper-->

    <!-- Bootstrap bundle JS -->
    {{-- <script src="http://cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script> --}}
    <script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Bootstrap bundle JS -->
    <script src="{{ asset('schools/assets/js/bootstrap.bundle.min.js') }}"></script>

    <!--plugins-->
    <script src="{{ asset('schools/assets/js/jquery.min.js') }}"></script>

    {{-- This is web language change jquery function --}}
    {{-- <script>
        $(document).ready(function() {
            $('#switch').on('click', function() {
                var isChecked = $(this).is(':checked');
                var locale = isChecked ? 'bn' : 'en';
                console.log(locale)
                var url = '{{ route('change.language', ':local') }}';
                url = url.replace(':local', locale);
                window.location.href = url;
            });
        });
    </script> --}}

    <script>
        const toggleSwitch = document.querySelector('#switch');

        toggleSwitch.addEventListener('change', function() {
            const locale = toggleSwitch.checked ? 'bn' : 'en'; // Switch to 'bn' and 'en' for Bengali and English
            const url = '{{ route('change.language', ':locale') }}'.replace(':locale', locale);

            window.location.href = url;
        });
    </script>



    {{-- This is web language change jquery function --}}

    <script src="{{ asset('schools/assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('schools/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('schools/assets/js/pace.min.js') }}"></script>

    <script src="{{ asset('schools/assets/js/table-datatable.js') }}"></script>
    <!-- Bootstrap bundle JS -->
    <script src="http://cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>
    <script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
    {!! Toastr::message() !!}

    {{-- Select2 js --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(".js-select").select2({
            placeholder: "Select One",
            allowClear: true,
            width: "100%"
        });
    </script>

    @stack('js')
    <script src="{{ asset('schools/assets/plugins/apexcharts-bundle/js/apexcharts.min.js') }}"></script>
    <!--app-->
    <script src="{{ asset('schools/assets/js/app.js') }}"></script>
    <script src="{{ asset('schools/assets/js/index5.js') }}"></script>

    @include('sweetalert::alert')
    <style>
        function toggle-status(id) {}
    </style>


    @include('sweetalert::alert')
    <style>
        function toggle-status(id) {}
    </style>

    <!--for owl-carousel -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <!--for owl-carousel -->
    <script src="{{ asset('schools/assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('schools/assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                "language": {
                    "paginate": {
                        "previous": '<i class="bi bi-chevron-left"></i>',
                        "next": '<i class="bi bi-chevron-right"></i>'
                    }
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Change the width of the search input field
            $('div.dataTables_filter input').addClass('custom-search-input');
            $('div.dataTables_filter').append('<i class="fas fa-search search-icon"></i>');
            $('div.dataTables_filter input').attr('placeholder', 'Search here...');

            $('#myTable').DataTable();
        });
    </script>

</body>

</html>
