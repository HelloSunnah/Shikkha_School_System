@extends('layouts.user.master')

@section('content')

    <main class="page-content">

        {{-- <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center">
            <div class="breadcrumb-title pe-3 text-white">{{__('app.Pages')}}</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt text-white"></i></a>
                        </li>
                        <li class="breadcrumb-item active text-white" aria-current="page">{{__('app.User Profile')}}</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="profile-cover bg-dark"></div> --}}

        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="mb-0">{{__('app.My Account')}}</h5>
                        <hr>

                        <div class="card shadow-none border">
                            <div class="card-header">
                                <h6 class="mb-0">{{__('app.USER INFORMATION')}}</h6>
                            </div>

                            <div class="card-body">
                                <form class="row g-3" action="{{route('user.account.update',Auth::user()->id)}}" method="post">
                                    @csrf
                                    <div class="col-6">
                                        <label class="form-label">{{__('app.name')}}</label>
                                        <input type="text" class="form-control" value="{{Auth::user()->name}}" name="name">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">{{__('app.roll')}}</label>
                                        <input type="text" class="form-control" value="{{Auth::user()->roll_number}}"  disabled>
                                        <input type="hidden" class="form-control" value="{{Auth::user()->roll_number}}" name="roll_number">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">{{__('app.email')}}</label>
                                        <input type="text" class="form-control" name="email" value="{{Auth::user()->email}}">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">{{__('app.phone')}}</label>
                                        <input type="text" class="form-control" name="phone" value="{{Auth::user()->phone}}">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">{{__('app.address')}}</label>
                                        <textarea type="text" class="form-control" name="address">{{Auth::user()->address}}</textarea>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">{{__('app.Date of Birth')}}</label>
                                        <input type="date" class="form-control" name="dob" value="{{ Auth::user()->dob }}">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">{{__('app.gname')}}</label>
                                        <input type="text" class="form-control" name="parents_name" value="{{Auth::user()->parents_name}}">
                                    </div>
                                    <div class="text-start text-center">
                                        <button type="submit" class="btn btn-primary px-4">{{__('app.Save Changes')}}</button>
                                    </div>
                                </form>
                            </div>

                        </div>

                    </div>
                </div>
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="mb-0">{{__('app.Change Password')}}</h5>
                        <hr>
                        <form class="row g-3" method="post" action="{{route('user.change password')}}">
                            @csrf
                        <div class="card shadow-none border">
                            <div class="card-header">
                                <h6 class="mb-0">{{__('app.USER Password')}}</h6>
                            </div>

                            <div class="card-body">

                                    <div class="col-6">
                                        <label class="form-label">{{__('app.Old Password')}}</label>
                                        <input type="text" class="form-control"  name="password" required>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">{{__('app.New Password')}}</label>
                                        <input type="text" class="form-control"  name="new_password" required>
                                    </div>
                            </div>
                        </div>
                        <div class="text-start">
                            <button type="submit" class="btn btn-primary px-4">{{__('app.Save Changes')}}</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="card shadow-sm border-0 overflow-hidden">
                    <div class="card-body">
                        <div class="profile-avatar text-center">
                            <img src="{{asset(Auth::user()->image)}}" class="rounded-circle shadow" width="120" height="120" alt="">
                        </div>
                        <div class="d-flex align-items-center justify-content-around mt-5 gap-3">
                            <div class="text-center">
                                <h6 class="mb-0">{{getClassNameUser(Auth::user()->class_id)->class_name}}</h6>
                            </div>
                            <div class="text-center">
                                <h6 class="mb-0">{{getSectionNameUser(Auth::user()->section_id)->section_name }}</h6>
                            </div>
                            <div class="text-center">
                                <h6 class="mb-0">Group 
                                    @if((Auth::user()->group_id) == 1) Science
                                    @elseif ((Auth::user()->group_id) == 2) Commerce
                                    @elseif ((Auth::user()->group_id) == 3) Humanities
                                    @else General
                                    @endif
                                </h6>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <?php
                            $dateOfBirth = date('Y-m-d',strtotime(Auth::user()->dob)) ;
                            $today = date("Y-m-d");
                            $diffAge = date_diff(date_create($dateOfBirth), date_create($today));
                            ?>
                            <h4 class="mb-1">{{Auth::user()->name}}, {{$diffAge->format('%y')}} years</h4>
                            {{-- <p class="mb-0 text-secondary">dhaka, Bangladesh</p> --}}
                            <div class="mt-4"></div>
                            <h6 class="mb-1">{{__('app.Student Status')}}</h6>
                            <p class="mb-0 text-secondary">{{getSchoolDataUser(Auth::user()->school_id)->school_name}}</p>
                        </div>
                        <hr>
                        <div class="text-start">
                            <h5 class="">{{__('app.Address')}}</h5>
                            <p class="mb-0"><p>{{Auth::user()->address}}</p>
                        </div>
                    </div>
                    <ul class="list-group list-group-flush">
{{--                        <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent border-top">--}}
{{--                            Assignment--}}
{{--                            <span class="badge bg-primary rounded-pill">10</span>--}}
{{--                        </li>--}}
{{--                        <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent">--}}
{{--                            School Notice--}}
{{--                            <span class="badge bg-primary rounded-pill">3</span>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
                </div>
            </div>
        </div><!--end row-->

    </main>

@endsection