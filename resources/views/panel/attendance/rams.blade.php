@extends('layouts.school.master')
@section('content')
<style>
    .btn1:hover{
        background-color: blueviolet;
        color: white !important;
    }
</style>
    <!--start content-->
    <main class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">{{__('app.dashboard')}}</div>
            {{-- <div class="ms-auto">
                <div class="btn-group">
                   <form class="row g-3" method="post" action="{{route('send.fees.due.sms')}}" enctype="multipart/form-data">
                       @csrf
                       <button type="submit" class="btn btn-primary">{{__('app.dashboard1btn')}}</button>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#deleteModal">{{__('app.dashboard1btn')}}</button>
                   </form>
                </div>
            </div> --}}
        </div>
        <!--end breadcrumb-->

        <div>
            <div class="row mb-5">
                <div class="col-md-4 mb-2 ">
                    <a href="{{route('student.teacher.create.show')}}">
                        <div class="card  bg-white mb-0" style="border-radius:18px;">
                            <h3 class="mb-0 text-center" style="color: blueviolet;margin-top:20px">{{__('app.Student')}}</h3>
                            <div class="card-body text-center p-4">
                                <h3 style="color:rgb(2, 2, 2);">{{CountUser()}}</h3>
                                <div class="d-flex justify-content-center gap-3 pt-4">
                                    <h6 style="color:#30d915"><i class="bi bi-graph-up-arrow"></i> 17% </h6>
                                    <p style="color:rgb(36, 36, 36)">{{__('app.sincelastweek')}}</p>
                                 </div>
                            </div>
                        </div>
                   </a>
                </div>
                <div class="col-md-4 mb-2">
                    <a href="{{route('teacher.Show')}}">
                        <div class="card  bg-white mb-0" style="border-radius:18px;">
                            <h3 class="mb-0 text-center" style="color: blueviolet;margin-top:20px">{{__('app.teacher')}}</h3>
                            <div class="card-body text-center p-4">
                                <h3 style="color: rgb(0, 0, 0)" >{{CountTeacher()}}</h3>
                                <div class="d-flex justify-content-center gap-3 pt-4" >
                                    <h6 style="color:#30d915;"><i class="bi bi-graph-up-arrow"></i> 17% </h6>
                                    <p style="color:rgb(36, 36, 36);">{{__('app.sincelastweek')}}</p>
                                 </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 mb-2">
                        <div class="card  bg-white mb-0" style="border-radius:18px;">
                            <h3 class="mb-0 text-center" style="color: blueviolet;margin-top:20px">{{__('app.t3')}}</h3>
                            <div class="card-body text-center p-4">
                                <h3 style="color: rgb(0, 0, 0)" >{{totalDuefeature()}}</h3>
                                <div class="d-flex justify-content-center gap-3 pt-4">
                                    <h6 style="color:#30d915;"><i class="bi bi-graph-up-arrow"></i> 17% </h6>
                                    <p style="color:rgb(36, 36, 36);">{{__('app.sincelastweek')}}</p>
                                 </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="row mb-5">
                <div class="col-md-4 mb-2">
                        <div class="card  bg-white mb-0" style="border-radius:18px;">
                            <h3 class="mb-0 text-center" style="color: blueviolet;margin-top:20px">{{__('app.t4')}}</h3>
                            <div class="card-body text-center p-4">
                                <h3 style="color: rgb(0, 0, 0)" >{{MonthlyIncome()}}</h3>
                                <div class="d-flex justify-content-center gap-3 pt-4" >
                                    <h6 style="color:#30d915;"><i class="bi bi-graph-up-arrow"></i> 17% </h6>
                                    <p style="color:rgb(36, 36, 36);">{{__('app.sincelastweek')}}</p>
                                    
                                 </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 mb-2">
                        <div class="card  bg-white mb-0" style="border-radius:18px;">
                            <h3 class="mb-0 text-center" style="color: blueviolet;margin-top:20px">{{__('app.t5')}}</h3>
                            <br>
                            <div class="card-body text-center p-4">
                                <h3 style="color: rgb(0, 0, 0)" >0</h3>
                                <div class="d-flex justify-content-center gap-3 pt-4" >
                                    <h6 style="color:#30d915;"><i class="bi bi-graph-up-arrow"></i> 17% </h6>
                                    <p style="color:rgb(36, 36, 36);">{{__('app.sincelastweek')}}</p>
                                    
                                 </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 mb-2">
                        <div class="card  bg-white mb-0" style="border-radius:18px;">
                            <h4 class="mb-0 p-2 text-center" style="color: blueviolet;margin-top:15px;padding-bottom:0px !important">{{__('app.t6')}}</h4>
                            
                            <div class="card-body text-center p-4">
                                <h3 style="color: rgb(0, 0, 0)" >{{DailyAttendence()}}</h3>
                                <div class="d-flex justify-content-center gap-3 pt-4" >
                                    <h6 style="color:#30d915;padding-left:14px"><i class="bi bi-graph-up-arrow"></i> 17% </h6>
                                    <p style="color:rgb(36, 36, 36);">{{__('app.sincelastweek')}}</p>
                                    
                                 </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card radius-10 w-100">
                        {{-- <div class="card-header bg-transparent p-3">
                            
                        </div> --}}
                        <div class="card-body">
                            <div class="row row-cols-1 row-cols-lg-2 g-3 align-items-center">
                                <div class="col">
                                    <h5 class="mb-0" style="color:blueviolet">{{__('app.Status2')}}</h5>
                                </div>
                                <div class="col">
                                    <div class="d-flex align-items-center justify-content-sm-end gap-3 cursor-pointer">
                                        <div class="font-13" style="color: blueviolet"><i class="bi bi-circle-fill text-info" style="color:blueviolet !important"></i><span class="ms-2">{{__('app.Status3')}}</span></div>
                                        <div class="font-13"><i class="bi bi-circle-fill" style="color:rgb(250, 154, 65)"></i><span class="ms-2">{{__('app.Status4')}}</span></div>
                                    </div>
                                </div>
                            </div>
                            <div id="chart5"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card radius-10 w-100">
                        <div class="card-body">
                            <h5 class="mb-0" style="color:blueviolet">{{__('app.Status1')}}</h5>
                            <div id="chart1">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card radius-10 w-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="project-date">
                                <strong class="mb-0 font-13">{{$defaultDate}}</strong>
                            </div>

                        </div>
                        <div class="text-center my-3">
                            <h6 style="color:blueviolet" class="mb-0">{{__('app.Status5')}} </h6>
                        </div>
                        <?php
                        $messageAccount =  getMessageAccount();
                        ?>
                        <div class="my-2">
                            <p class="mb-1 font-13">{{__('app.Usages')}}<strong style="color: red">({{$messageAccount['dataProcessBar']}} / {{$messageAccount['total']}})</strong> </p>
                            <div class="progress radius-10" style="height:25px;">
                                <div class="progress-bar radius-10" role="progressbar" style="width:{{$messageAccount['cssProcessBar']}}%;background-color:blueviolet !important;"></div>
                            </div>
                            {{-- <div class="progress radius-10" style="height:5px;">
                                <div class="progress-bar" role="progressbar" style="width: {{$messageAccount['cssProcessBar']}}%"></div>
                            </div> --}}
                            <p class="mb-0 mt-1 font-13 text-end"></p>
                        </div>
                        <div class="d-flex align-items-center mt-5">
                            <div class="project-user-groups">
                                <a href="{{route('school.message.post.checkout.show')}}" class="btn btn-outline-primary btn1" style="border-color:blueviolet !important;color:blueviolet">{{__('app.Status7')}} </a>
                            </div>
                            <a href="{{route('school.message')}}" class="btn btn-primary radius-30 btn2 ms-auto" style="background-color:blueviolet !important;color:white;border-color:blueviolet;">{{__('app.Status8')}}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card radius-10 w-100">
                    <div class="card-body">
                        <h5 class="mb-0" style="color: blueviolet;">{{__('app.Statistics')}}</h5>
                        <div id="chart2"></div>
                    </div>
                </div>
            </div>
        </div>
        <!--end row-->

        


    </main>
    <!--end page main-->

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{__('app.SendSms')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="{{route('send.fees.due.sms')}}">
                    @csrf
                    <div class="modal-body">
                    {{__('app.sure')}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">{{__('app.no')}}</button>
                        <button type="submit" class="btn btn-primary">{{__('app.yes')}}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>


@endsection
