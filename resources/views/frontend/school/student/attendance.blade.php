@extends('layouts.school.master')

@section('content')
@push('css')
<style>
    html,
    body {
        min-height: 100vh;
        min-width: 100vw;
    }

    .parent {
        height: 100vh;
    }

    .parent>.row {
        display: flex;
        align-items: center;
        height: 100%;
    }

    .col img {
        height: 100px;
        width: 100%;
        cursor: pointer;
        transition: transform 1s;
        object-fit: cover;
    }

    .col label {
        overflow: hidden;
        position: relative;
    }

    .imgbgchk:checked+label>.tick_container {
        opacity: 1;
    }

    /*         aNIMATION */
    .imgbgchk:checked+label>img {
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
        background-color: #4CAF50;
        color: white;
        font-size: 16px;
        padding: 6px 12px;
        height: 40px;
        width: 40px;
        border-radius: 100%;
    }
</style>

@endpush
<!--start content-->
<main class="page-content">

        {{-- @if(count($dataAttendance) == count($dataShow)) --}}
        @if(count($dataAttendance) > 0)

                <div class="row" >
                    <div class="col-md-12">
                        <div class="card" style="box-shadow:4px 3px 13px  .7px #bf52f2;border-radius:5px">
                            {{-- heading --}}
                            <div class="card-header py-3 bg-transparent">
                                <div class="d-sm-flex align-items-center">
                                    <h5 class="mb-2 mb-sm-0">{{__('app.Attendance')}} {{__('app.List')}}</h5>
                                    <div class="ms-auto">
                                        <button type="button" class="btn btn-secondary btn-sm" title="{{__('app.Back')}}" onclick="history.back()"><i class="bi bi-arrow-left-square"></i></button>
                                        {{-- <a href="{{route('export.pdf.attendance',['class_id' =>Request::segment(4),'section_id'=>Request::segment(5),'group_id'=>Request::segment(6),'date'=>(is_null(Request::segment(7)) ? 0 :Request::segment(7))])}}" class="btn btn-sm btn-danger"><i class="bi bi-printer-fill"></i>Export as PDF</a> --}}
                                        {{-- <a href="{{route('export.report.attendance_data',['class_id' =>Request::segment(4),'section_id'=>Request::segment(5),'group_id'=>Request::segment(6),'date'=>(is_null(Request::segment(7)) ? 0 :Request::segment(7))])}}" class="btn btn-sm btn-danger"><i class="bi bi-printer-fill"></i>Export as CSV</a> --}}
                                    </div>
                                </div>
                            </div>
                            {{-- School Info and Class Info --}}
                            <div class="card-body">
                                <div class="d-flex justify-content-center">
                                    
                                    @if(!is_null(Request::segment(7)))
                                        @if (File::exists(public_path(Auth::user()->school_logo)) && !is_null(Auth::user()->school_logo))
                                            <img src="{{asset(Auth::user()->school_logo)}}" alt="school logo" class="img-fluid" width="80" style="width:80px; height:80px;margin-right:20px;">
                                        @endif                                                                                                                                                                 
                                        <div class="text-center text-dark">
                                            <h4 style="margin-bottom:0px;"> {{ strtoupper( Auth::user()->school_name) }} </h4>
                                            <p style="margin-bottom:0px;"> {{ (Auth::user()->slogan )}} </p> 
                                            <p style="margin-bottom:0px;">{{ isset(getClassName(Request::segment(4))->id) ? getClassName(Request::segment(4))->class_name : 'No' }} {{ isset(getSectionName(Request::segment(5))->id) ? getSectionName(Request::segment(5))->section_name : 'No' }}<p>
                                            <p>Date: {{Request::segment(7)}}</p>                                       
                                        </div>                                                                             
                                    @endif
                                </div>
                                {{-- Attendance List --}}
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                        <tr>
                                            <th>{{__('app.Roll')}} </th>
                                            <th>{{__('app.Student')}} {{__('app.Name')}} </th>
                                            <th>{{__('app.entry_time')}} </th>
                                            <th>{{__('app.Attendance')}}</th>
                                            <th>{{__('app.Action')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($dataAttendance as $key => $data)
                                            <tr>
                                                <td style="padding:0px; padding-left:5px;">{{getUserName($data->student_id)->roll_number}} </td>
                                                <td style="padding:0px; padding-left:5px;">{{getUserName($data->student_id)->name}}</td>                                               
                                                <td>{{ (is_null($data->access_time)) ? '' : date("g:i:s A", strtotime($data->access_time)) }}</td>
                                                <td style="padding:0px; padding-left:5px;">
                                                    @if($data->attendance == 1 ) 
                                                        <span class="badge bg-success">Present</span>
                                                    @elseif($data->attendance == 2)  
                                                    <span class="badge bg-warning">Late</span>
                                                    @else 
                                                    <span class="badge bg-danger">Absent</span> 
                                                    @endif
                                                </td>
                                                <td style="padding:0px; padding-left:5px;">
                                                    <form method="post" action="{{route('confirm.absent.present',$data->id)}}" enctype="multipart/form-data">
                                                        @csrf
                                                        @if($data->attendance == 1)
                                                            <input type="hidden" name="attendance" value="0">
                                                            <button type="submit" class="btn btn-primary btn-sm mt-2">Make It Absent</button>
                                                        @else
                                                            <input type="hidden" name="attendance" value="1">
                                                            <button type="sunmit" class="btn btn-danger btn-sm mt-2">Make It Present</button>
                                                        @endif
                                                    </form>
                                                </td>                                                
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>  
                            
                            <div class="col-12" style="display:none">
                                <div class="card-body" id="printDiv">
                                    <div class="d-flex justify-content-center">
                                        @if (File::exists(public_path(Auth::user()->school_logo)) && !is_null(Auth::user()->school_logo))
                                            <img src="{{asset(Auth::user()->school_logo)}}" alt="school logo" class="img-fluid" width="80" style="width:80px; height:80px;margin-right:20px;">
                                        @endif                                                                                                                                                                 
                                        <div class="text-center text-dark">
                                            <h4 style="margin-bottom:0px;"> {{ strtoupper( Auth::user()->school_name) }} </h4>
                                            <p style="margin-bottom:0px;"> {{ (Auth::user()->slogan )}} </p> 
                                            <p style="margin-bottom:0px;">{{ isset(getClassName(Request::segment(4))->id) ? getClassName(Request::segment(4))->class_name : 'No' }} {{ isset(getSectionName(Request::segment(5))->id) ? getSectionName(Request::segment(5))->section_name : 'No' }}<p>
                                            <p>Date: {{Request::segment(7)}}</p>
                                        </div>                                        
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>{{__('app.Roll')}} </th>
                                                    <th>{{__('app.Student')}} {{__('app.Name')}} </th>
                                                    <th>{{__('app.Group')}}</th>
                                                    <th>{{__('app.Attendance')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($dataAttendance as $key => $data)
                                                <tr>
                                                    <td style="padding:0px; padding-left:5px;">{{getUserName($data->student_id)->roll_number}} </td>
                                                    <td style="padding:0px; padding-left:5px;">{{getUserName($data->student_id)->name}}</td>                                               
                                                    <td style="padding:0px; padding-left:5px;">{{isset(getGroupname(Request::segment(6))->id) ? getGroupname(Request::segment(6))->group_name : 'No'}}</td>
                                                    <td style="padding:0px; padding-left:5px;">@if($data->attendance == 1 ) Present @elseif($data->attendance == 2) Late @else Absent @endif</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div> 

                            {{-- Print Button --}}
                            <div class="col-12 d-flex justify-content-center">
                                <button class="btn btn-primary btn-sm mb-2" title="{{__('app.Print')}}" onclick="printDiv()"><i class="bi bi-printer"></i></button>
                            </div> 
                        </div>
                    </div>
                </div>                
                <!--end row-->
        @else

            @if(Request::segment(7) == date("Y-m-d") or Request::segment(7) != date("Y-m-d") )
                <form class="row g-3" method="post" action="{{route('student.attendance.create.post')}}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="segment_date" value="{{ Request::segment(7) }}">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card" style="box-shadow:4px 3px 13px  .7px #deaaf7;border-radius:5px">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered" style="width:100%">
                                            <thead>
                                            <tr>
                                                <th>{{__('app.Student')}} {{__('app.Roll')}}</th>
                                                <th>{{__('app.Student')}} {{__('app.Name')}}</th>
                                                <th>{{__('app.Action')}}</th>
                                                <th>{{__('app.Comment')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($dataShow as $key => $data)
                                                @php
                                                    $attendance = getAttendance($data->id, $data->class_id, $data->section_id, Request::segment(7));
                                                @endphp
                                                <tr>
                                                    <td>{{$data->roll_number}}</td>
                                                    <td>{{$data->name}}</td>
                                                    <td>
                                                        <input class="form-check-input" type="radio" id="gridCheck{{$data->id}}" {{ $attendance == 1 ? "checked" : " " }}  name="attendance[{{$data->id}}][]" value="1" >
                                                        <label class="form-check-label" for="gridCheck{{$data->id}}">
                                                            Present
                                                        </label>
                                                        <input class="form-check-input" type="radio" id="gridCheck{{$data->id}}" {{ $attendance == 0 ? "checked" : " " }} name="attendance[{{$data->id}}][]" value="0" >
                                                        <label class="form-check-label" for="gridCheck{{$data->id}}">
                                                            Absent
                                                        </label>
                                                        <input class="form-check-input" type="radio" id="gridCheck{{$data->id}}" name="attendance[{{$data->id}}][]" value="2">
                                                        <label class="form-check-label" for="gridCheck{{$data->id}}">
                                                            late
                                                        </label>
                                                        <input type="hidden" name="student_id[]" value="{{$data->id}}">
                                                    </td>
                                                    <td><input class="form-control" name="comment[]" placeholder="{{__('app.Any')}} {{__('app.Comment')}}"></td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <button type="submit"class="btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            @else
                @if(Request::segment(7) < date("Y-m-d")) 
                <p>Previous date attendance you can not uploaded</p>
                @else
                <p>Upcoming date attendance you can not uploaded</p>
                @endif
            @endif
    
        @endif
</main>

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
