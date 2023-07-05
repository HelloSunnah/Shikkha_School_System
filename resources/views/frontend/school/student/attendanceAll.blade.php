@extends('layouts.school.master')

@section('content')
    <style>
        html,body{
            min-height: 100vh;
            min-width: 100vw;
        }
        .parent{
            height: 100vh;
        }
        .parent>.row{
            display: flex;
            align-items: center;
            height: 100%;
        }
        .col img{
            height:100px;
            width: 100%;
            cursor: pointer;
            transition: transform 1s;
            object-fit: cover;
        }
        .col label{
            overflow: hidden;
            position: relative;
        }
        .imgbgchk:checked + label>.tick_container{
            opacity: 1;
        }
        /*         aNIMATION */
        .imgbgchk:checked + label>img{
            transform: scale(1.25);
            opacity: 0.3;
        }
        .tick_container {
            transition: .5s ease;
            opacity: 0;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            cursor: pointer;
            text-align: center;
        }
        .tick {
            background-color: #7c00a7;
            color: white;
            font-size: 16px;
            padding: 6px 12px;
            height: 40px;
            width: 40px;
            border-radius: 100%;
        }
    </style>
    <!--start content-->
    <main class="page-content">
                @if(count($dataAttendance) > 0)
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card" style="box-shadow:4px 3px 13px  .7px #deaaf7;border-radius:5px">
                                <div class="card-header py-3 bg-transparent">
                                    <div class="d-sm-flex align-items-center">
                                        <h5 class="mb-2 mb-sm-0">{{$Text}}</h5>
                                        <div class="ms-auto">
                                            <button type="button" class="btn btn-secondary btn-sm" title="{{__('app.Back')}}" onclick="history.back()"><i class="bi bi-arrow-left-square"></i></button>
                                            {{-- <a href="{{route('export.pdf.attendance',['class_id' =>Request::segment(4),'section_id'=>Request::segment(5),'group_id'=>Request::segment(6),'date'=>(is_null(Request::segment(7)) ? 0 :Request::segment(7))])}}" class="btn btn-sm btn-danger"><i class="bi bi-printer-fill"></i>Export as PDF</a> --}}
                                            {{-- <a href="{{route('export.report.attendance_data',['class_id' =>Request::segment(4),'section_id'=>Request::segment(5),'group_id'=>Request::segment(6),'date'=>(is_null(Request::segment(7)) ? 0 :Request::segment(7))])}}" class="btn btn-sm btn-danger"><i class="bi bi-printer-fill"></i>Export as CSV</a> --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                                            <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Student Name</th>
                                                <th>Roll Number</th>
                                                <th>Attendance</th>
                                                @if(is_null(Request::segment(7)))
                                                <th>Action</th>
                                                @endif
                                                <th>{{__('app.class')}}</th>
                                                <th>{{__('app.section')}}</th>
                                                <th>Group</th>
                                                @if(!is_null(Request::segment(7)))
                                                <th>{{__('app.date')}}</th>
                                                @endif

                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($dataAttendance as $key => $data)
                                                <tr>
                                                    <td>{{$key++ +1}}</td>
                                                    <td>{{getUserName($data->student_id)->name}}</td>
                                                    <td>{{getUserName($data->student_id)->roll_number}}</td>
                                                    <td>{{($data->attendance == 1 ) ? 'Present' : 'Absent'}}</td>
                                                    @if(is_null(Request::segment(7)))
                                                    <td><form method="post" action="{{route('confirm.absent.present',$data->id)}}" enctype="multipart/form-data">
                                                            @csrf
                                                            @if($data->attendance == 1)
                                                                <input type="hidden" name="attendance" value="0">
                                                                <button type="submit" class="btn btn-primary">Make It Absent</button>
                                                            @else
                                                                <input type="hidden" name="attendance" value="1">
                                                                <button type="sunmit" class="btn btn-danger">Make It Present</button>
                                                            @endif
                                                        </form></td>
                                                    @endif
                                                    <td>{{ isset(getClassName(Request::segment(4))->id) ? getClassName(Request::segment(4))->class_name : 'No' }}</td>
                                                    <td>{{ isset(getSectionName(Request::segment(5))->id) ? getSectionName(Request::segment(5))->section_name : 'No' }}</td>
                                                    <td>{{isset(getGroupname(Request::segment(6))->id) ? getGroupname(Request::segment(6))->group_name : 'No'}}</td>
                                                    @if(!is_null(Request::segment(7)))
                                                    <td>{{Request::segment(7)}}</td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>                                    
                                </div>
                            </div>
                        </div>
                    </div>
                <!--end row-->

        @else
        <form class="row g-3" method="post" action="{{route('student.attendance.create.post')}}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12">

                    <div class="card" style="box-shadow:4px 3px 13px  .7px #bf52f2;border-radius:5px">                      
                        <div class="col-12">
                            <div class="card-body" id="printDiv">
                                <div class="d-flex justify-content-center">                                   
                                    @if (File::exists(public_path(Auth::user()->school_logo)) && !is_null(Auth::user()->school_logo))
                                        <img src="{{asset(Auth::user()->school_logo)}}" alt="school logo" class="img-fluid" width="80" style="width:80px; height:80px;margin-right:20px;">
                                    @endif                                                                                                                                                                 
                                    <div class="text-center text-dark">
                                        <h4 style="margin-bottom:0px;"> {{ strtoupper( Auth::user()->school_name) }} </h4>
                                        <p style="margin-bottom:0px;"> {{ (Auth::user()->slogan )}} </p> 
                                        <p style="margin-bottom:0px;">{{getClassName($class_id)->class_name}} {{ getSectionName($section_id)->section_name}}</p>   
                                        <p>Month: @if($date == "01") January
                                        @elseif($date == "02") February
                                        @elseif($date == "03") March
                                        @elseif($date == "04") April
                                        @elseif($date == "05") May
                                        @elseif($date == "06") June
                                        @elseif($date == "07") July
                                        @elseif($date == "08") August
                                        @elseif($date == "09") September
                                        @elseif($date == "10") October
                                        @elseif($date == "11") November
                                        @else December 
                                        @endif
                                    </p>                                 
                                    </div>                                  
                                </div>
    
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th style="padding: 0px;">Student</th>
                                                <th style="padding: 0px;">1</th>
                                                <th style="padding: 0px;">3</th>
                                                <th style="padding: 0px;">2</th>
                                                <th style="padding: 0px;">4</th>
                                                <th style="padding: 0px;">5</th>
                                                <th style="padding: 0px;">6</th>
                                                <th style="padding: 0px;">7</th>
                                                <th style="padding: 0px;">8</th>
                                                <th style="padding: 0px;">9</th>
                                                <th style="padding: 0px;">10</th>
                                                <th style="padding: 0px;">11</th>
                                                <th style="padding: 0px;">12</th>
                                                <th style="padding: 0px;">13</th>
                                                <th style="padding: 0px;">14</th>
                                                <th style="padding: 0px;">15</th>
                                                <th style="padding: 0px;">16</th>
                                                <th style="padding: 0px;">17</th>
                                                <th style="padding: 0px;">18</th>
                                                <th style="padding: 0px;">19</th>
                                                <th style="padding: 0px;">20</th>
                                                <th style="padding: 0px;">21</th>
                                                <th style="padding: 0px;">22</th>
                                                <th style="padding: 0px;">23</th>
                                                <th style="padding: 0px;">25</th>
                                                <th style="padding: 0px;">24</th>
                                                <th style="padding: 0px;">26</th>
                                                <th style="padding: 0px;">27</th>
                                                <th style="padding: 0px;">28</th>
                                                <th style="padding: 0px;">29</th>
                                                <th style="padding: 0px;">30</th>
                                                <th style="padding: 0px;">31</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($dataShow as $key => $data)
                                            <tr>
                                                <td style="padding: 0px;">{{$data->roll_number}} {{$data->name}}</td>
                                                <td style="padding: 0px;"> {!!getAttData($data->id,$class_id,$section_id,$group_id,$date,'01')!!}</td>
                                                <td style="padding: 0px;"> {!!getAttData($data->id,$class_id,$section_id,$group_id,$date,'02')!!}</td>
                                                <td style="padding: 0px;"> {!!getAttData($data->id,$class_id,$section_id,$group_id,$date,'03')!!}</td>
                                                <td style="padding: 0px;"> {!!getAttData($data->id,$class_id,$section_id,$group_id,$date,'04')!!}</td>
                                                <td style="padding: 0px;"> {!!getAttData($data->id,$class_id,$section_id,$group_id,$date,'05')!!}</td>
                                                <td style="padding: 0px;"> {!!getAttData($data->id,$class_id,$section_id,$group_id,$date,'06')!!}</td>
                                                <td style="padding: 0px;"> {!!getAttData($data->id,$class_id,$section_id,$group_id,$date,'07')!!}</td>
                                                <td style="padding: 0px;"> {!!getAttData($data->id,$class_id,$section_id,$group_id,$date,'08')!!}</td>
                                                <td style="padding: 0px;"> {!!getAttData($data->id,$class_id,$section_id,$group_id,$date,'09')!!}</td>
                                                <td style="padding: 0px;"> {!!getAttData($data->id,$class_id,$section_id,$group_id,$date,'10')!!}</td>
                                                <td style="padding: 0px;"> {!!getAttData($data->id,$class_id,$section_id,$group_id,$date,'11')!!}</td>
                                                <td style="padding: 0px;"> {!!getAttData($data->id,$class_id,$section_id,$group_id,$date,'12')!!}</td>
                                                <td style="padding: 0px;"> {!!getAttData($data->id,$class_id,$section_id,$group_id,$date,'13')!!}</td>
                                                <td style="padding: 0px;"> {!!getAttData($data->id,$class_id,$section_id,$group_id,$date,'14')!!}</td>
                                                <td style="padding: 0px;"> {!!getAttData($data->id,$class_id,$section_id,$group_id,$date,'15')!!}</td>
                                                <td style="padding: 0px;"> {!!getAttData($data->id,$class_id,$section_id,$group_id,$date,'16')!!}</td>
                                                <td style="padding: 0px;"> {!!getAttData($data->id,$class_id,$section_id,$group_id,$date,'17')!!}</td>
                                                <td style="padding: 0px;"> {!!getAttData($data->id,$class_id,$section_id,$group_id,$date,'18')!!}</td>
                                                <td style="padding: 0px;"> {!!getAttData($data->id,$class_id,$section_id,$group_id,$date,'19')!!}</td>
                                                <td style="padding: 0px;"> {!!getAttData($data->id,$class_id,$section_id,$group_id,$date,'20')!!}</td>
                                                <td style="padding: 0px;"> {!!getAttData($data->id,$class_id,$section_id,$group_id,$date,'21')!!}</td>
                                                <td style="padding: 0px;"> {!!getAttData($data->id,$class_id,$section_id,$group_id,$date,'22')!!}</td>
                                                <td style="padding: 0px;"> {!!getAttData($data->id,$class_id,$section_id,$group_id,$date,'23')!!}</td>
                                                <td style="padding: 0px;"> {!!getAttData($data->id,$class_id,$section_id,$group_id,$date,'24')!!}</td>
                                                <td style="padding: 0px;"> {!!getAttData($data->id,$class_id,$section_id,$group_id,$date,'25')!!}</td>
                                                <td style="padding: 0px;"> {!!getAttData($data->id,$class_id,$section_id,$group_id,$date,'26')!!}</td>
                                                <td style="padding: 0px;"> {!!getAttData($data->id,$class_id,$section_id,$group_id,$date,'27')!!}</td>
                                                <td style="padding: 0px;"> {!!getAttData($data->id,$class_id,$section_id,$group_id,$date,'28')!!}</td>
                                                <td style="padding: 0px;"> {!!getAttData($data->id,$class_id,$section_id,$group_id,$date,'29')!!}</td>
                                                <td style="padding: 0px;"> {!!getAttData($data->id,$class_id,$section_id,$group_id,$date,'30')!!}</td>
                                                <td style="padding: 0px;"> {!!getAttData($data->id,$class_id,$section_id,$group_id,$date,'31')!!}</td>    
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 d-flex justify-content-center">
                            <button class="btn btn-primary btn-sm mb-2" title="{{__('app.Print')}}" onclick="printDiv()" ><i class="bi bi-printer"></i></button>

                        </div>
                    </div>
                </div>
            </div>
            <!--end row-->
        </form>

        @endif
    </main>
@endsection

@push('js')
    <script>
        function printDiv(printDiv) {
            var printContents = document.getElementById('printDiv').innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>
@endpush