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

    @if(count($dataAttendance) == count($dataShow))
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header py-3 bg-transparent">
                    <div class="d-sm-flex align-items-center">
                        <h5 class="mb-2 mb-sm-0">{{$Text}}</h5>
                        <div class="ms-auto">
                            <button type="button" class="btn btn-secondary" onclick="history.back()">Back</button>
                            <a href="{{route('export.pdf.attendance',['class_id' =>Request::segment(4),'section_id'=>Request::segment(5),'group_id'=>Request::segment(6),'date'=>(is_null(Request::segment(7)) ? 0 :Request::segment(7))])}}" class="btn btn-sm btn-danger"><i class="bi bi-printer-fill"></i>Export as PDF</a>
                            <a href="{{route('export.report.attendance_data',['class_id' =>Request::segment(4),'section_id'=>Request::segment(5),'group_id'=>Request::segment(6),'date'=>(is_null(Request::segment(7)) ? 0 :Request::segment(7))])}}" class="btn btn-sm btn-danger"><i class="bi bi-printer-fill"></i>Export as CSV</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Teacher Name</th>
                                    <th>Teacher Id</th>
                                    <th>Attendance</th>
                                    <th>Comment</th>
                                    <th>Action</th>
                              
                                    <th>{{__('app.date')}}</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dataAttendance as $key => $data)
                                <tr>
                                    <td>{{$key++ +1}}</td>
                                    <td>{{getUserName($data->teacher_id)->full_name}}</td>
                                    <td>{{getUserName($data->student_id)->unique_id}}</td>
                                    <td>@if($data->attendance == 1 ) Present @elseif($data->attendance == 2) Late @else Absent @endif</td>
                                    <td>{{ is_null($data->comment) ? 'No comment' : $data->comment}}</td>
                                    <td>
                                        <form method="post" action="{{route('confirm.absent.present',$data->id)}}" enctype="multipart/form-data">
                                            @csrf
                                            @if($data->attendance == 1)
                                            <input type="hidden" name="attendance" value="0">
                                            <button type="submit" class="btn btn-primary">Make It Absent</button>
                                            @else
                                            <input type="hidden" name="attendance" value="1">
                                            <button type="sunmit" class="btn btn-danger">Make It Present</button>
                                            @endif
                                        </form>
                                    </td>
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
        <input type="hidden" name="segment_date" value="{{ Request::segment(7) }}">
        @if(Request::segment(7) == date("Y-m-d") or Request::segment(7) != date("Y-m-d") )
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Student Name</th>
                                        <th>Student Roll Number</th>
                                        <th>Action</th>
                                        <th>Remarks/Comment</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($dataShow as $key => $data)
                                    @php
                                    $attendance = getAttendance($data->id,Request::segment(7));
                                    @endphp
                                    <tr>
                                        <td>{{$key++ +1}}</td>
                                        <td>{{$data->name}}</td>
                                        <td>{{$data->roll_number}}</td>
                                        <td>
                                        <input class="form-check-input" type="radio" id="gridCheck{{$data->id}}" {{ $attendance == 0 ? "checked" : " " }} name="attendance[{{$data->id}}][]" value="1">
                                            <label class="form-check-label" for="gridCheck{{$data->id}}">
                                                Present
                                            </label>
                                            <input class="form-check-input" type="radio" id="gridCheck{{$data->id}}" {{ $attendance == 1 ? "checked" : " " }} name="attendance[{{$data->id}}][]" value="0">
                                            <label class="form-check-label" for="gridCheck{{$data->id}}">
                                                Absent
                                            </label>

                                           

                                            <input class="form-check-input" type="radio" id="gridCheck{{$data->id}}" name="attendance[{{$data->id}}][]" value="2">
                                            <label class="form-check-label" for="gridCheck{{$data->id}}">
                                                late
                                            </label>

                                            <input type="hidden" name="student_id[]" value="{{$data->id}}">
                                        </td>
                                        <td><input class="form-control" name="comment[]" placeholder="Give a Comment"></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn-primary">Submit</button>
            </div>
        </div>
        <!--end row-->
        @else
        @if(Request::segment(7) < date("Y-m-d")) <p>Previous date attendance you can not uploaded</p>
            @else
            <p>Upcoming date attendance you can not uploaded</p>
            @endif
            @endif
    </form>
    @endif
</main>

@endsection