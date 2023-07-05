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
            background-color: #4CAF50;
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
            <x-page-title title="{{getClassName($class_id)->class_name}} {{ getSectionName($section_id)->section_name}}"/>
                @if(count($dataAttendance) > 0)
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

                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>Student</th>
                                        <th >1</th>
                                        <th >2</th>
                                        <th >3</th>
                                        <th >4</th>
                                        <th >5</th>
                                        <th >6</th>
                                        <th >7</th>
                                        <th >8</th>
                                        <th >9</th>
                                        <th >10</th>
                                        <th >11</th>
                                        <th >12</th>
                                        <th >13</th>
                                        <th >14</th>
                                        <th >15</th>
                                        <th >16</th>
                                        <th >17</th>
                                        <th >18</th>
                                        <th >19</th>
                                        <th >20</th>
                                        <th >21</th>
                                        <th >22</th>
                                        <th >23</th>
                                        <th >24</th>
                                        <th >25</th>
                                        <th >26</th>
                                        <th >27</th>
                                        <th >28</th>
                                        <th >29</th>
                                        <th >30</th>
                                        <th>31</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($dataShow as $key => $data)
                                        <tr>
                                            <td>{{$data->name}}</td>
                                            <td> {{getAttData($data->id,$class_id,$section_id,$group_id,$date,'01')}}</td>
                                            <td> {{getAttData($data->id,$class_id,$section_id,$group_id,$date,'02')}}</td>
                                            <td> {{getAttData($data->id,$class_id,$section_id,$group_id,$date,'03')}}</td>
                                            <td> {{getAttData($data->id,$class_id,$section_id,$group_id,$date,'04')}}</td>
                                            <td> {{getAttData($data->id,$class_id,$section_id,$group_id,$date,'05')}}</td>
                                            <td> {{getAttData($data->id,$class_id,$section_id,$group_id,$date,'06')}}</td>
                                            <td> {{getAttData($data->id,$class_id,$section_id,$group_id,$date,'07')}}</td>
                                            <td> {{getAttData($data->id,$class_id,$section_id,$group_id,$date,'08')}}</td>
                                            <td> {{getAttData($data->id,$class_id,$section_id,$group_id,$date,'09')}}</td>
                                            <td> {{getAttData($data->id,$class_id,$section_id,$group_id,$date,'10')}}</td>
                                            <td> {{getAttData($data->id,$class_id,$section_id,$group_id,$date,'11')}}</td>
                                            <td> {{getAttData($data->id,$class_id,$section_id,$group_id,$date,'12')}}</td>
                                            <td> {{getAttData($data->id,$class_id,$section_id,$group_id,$date,'13')}}</td>
                                            <td> {{getAttData($data->id,$class_id,$section_id,$group_id,$date,'14')}}</td>
                                            <td> {{getAttData($data->id,$class_id,$section_id,$group_id,$date,'15')}}</td>
                                            <td> {{getAttData($data->id,$class_id,$section_id,$group_id,$date,'16')}}</td>
                                            <td> {{getAttData($data->id,$class_id,$section_id,$group_id,$date,'17')}}</td>
                                            <td> {{getAttData($data->id,$class_id,$section_id,$group_id,$date,'18')}}</td>
                                            <td> {{getAttData($data->id,$class_id,$section_id,$group_id,$date,'19')}}</td>
                                            <td> {{getAttData($data->id,$class_id,$section_id,$group_id,$date,'20')}}</td>
                                            <td> {{getAttData($data->id,$class_id,$section_id,$group_id,$date,'21')}}</td>
                                            <td> {{getAttData($data->id,$class_id,$section_id,$group_id,$date,'22')}}</td>
                                            <td> {{getAttData($data->id,$class_id,$section_id,$group_id,$date,'23')}}</td>
                                            <td> {{getAttData($data->id,$class_id,$section_id,$group_id,$date,'24')}}</td>
                                            <td> {{getAttData($data->id,$class_id,$section_id,$group_id,$date,'25')}}</td>
                                            <td> {{getAttData($data->id,$class_id,$section_id,$group_id,$date,'26')}}</td>
                                            <td> {{getAttData($data->id,$class_id,$section_id,$group_id,$date,'27')}}</td>
                                            <td> {{getAttData($data->id,$class_id,$section_id,$group_id,$date,'28')}}</td>
                                            <td> {{getAttData($data->id,$class_id,$section_id,$group_id,$date,'29')}}</td>
                                            <td> {{getAttData($data->id,$class_id,$section_id,$group_id,$date,'30')}}</td>
                                            <td> {{getAttData($data->id,$class_id,$section_id,$group_id,$date,'31')}}</td>

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
        </form>

        @endif
    </main>

@endsection


