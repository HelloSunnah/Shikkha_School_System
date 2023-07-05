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
                @if(count($dataAttendance) > 0)
                <div class="row">
                    <div class="col-md-12">
                        <div class="card" style="box-shadow:4px 3px 13px  .7px #deaaf7;border-radius:5px">
                            <div class="card-header py-3 bg-transparent">
                                <div class="d-sm-flex align-items-center">
                                    <h5 class="mb-2 mb-sm-0">{{$Text}}</h5>
                                    <div class="ms-auto">
                                        <button type="button" class="btn btn-secondary" onclick="history.back()">{{__('app.Back')}}</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                        <tr>
                                            <th>{{__('app.Stuff')}} {{__('app.Name')}} </th>
                                            <th>{{__('app.UniqueId')}}</th>
                                            <th>{{__('app.Attendance')}}</th>
                                            @if(is_null(Request::segment(7)))
                                            <th>{{__('app.Action')}}</th>
                                            @endif
                                            @if(!is_null(Request::segment(7)))
                                            <th>{{__('app.date')}}</th>
                                            @endif

                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($dataAttendance as $key => $data)
                                            <tr>
                                                <td>{{getStaffName($data->employee_id)->employee_name}}</td>
                                                <td>{{getStaffName($data->employee_id)->employee_id}}</td>
                                                <td>{{($data->attendance == 1 ) ? 'Present' : 'Absent'}}</td>
                                                @if(is_null(Request::segment(7)))
                                                <td><form method="post" action="" enctype="multipart/form-data">
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
        <form class="row g-3" method="post" action="" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12">

                    <div class="card" id="printDiv" style="box-shadow:4px 3px 13px  .7px #deaaf7;border-radius:5px">
                        <div class="card-body">

                            <div class="d-flex justify-content-center">
                                @if (File::exists(public_path(Auth::user()->school_logo)) && !is_null(Auth::user()->school_logo))
                                    <img src="{{asset(Auth::user()->school_logo)}}" alt="school logo" class="img-fluid" width="80" style="width:80px; height:80px;margin-right:20px;">
                                @endif                                                                                                                                                                 
                                <div class="text-center text-dark">
                                    @if( app()->getLocale() === 'en')
                                    <h4>{{$school->school_name}}</h4>
                                    <p style="margin-top:-5px !important;font-size:12px">{{$school->slogan}}</p>
                                    <p style="margin-top:-5px !important;font-size:14px">{{$school->address}}</p>
                                    @else
                                        <h4>{{$school->school_name_bn}}</h4>
                                        <p style="margin-top:-5px !important;font-size:12px">{{$school->slogan_bn}}</p>
                                        <p style="margin-top:-5px !important;font-size:14px">{{$school->address_bn}}</p>
                                    @endif                                
                                        
                                    <div class="row text-center">
                                        <h5 style="margin-top:5px !important;font-size:22px;margin-bottom:10px;">{{__('app.Stuff')}} {{__('app.Attendance')}}</h5>
                                    </div>                                
                                </div>                                        
                            </div>

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th style="padding: 0px;">{{__('app.Stuff')}}</th>
                                        <th style="padding: 0px;" >1</th>
                                        <th style="padding: 0px;" >2</th>
                                        <th style="padding: 0px;" >3</th>
                                        <th style="padding: 0px;" >4</th>
                                        <th style="padding: 0px;" >5</th>
                                        <th style="padding: 0px;" >6</th>
                                        <th style="padding: 0px;" >7</th>
                                        <th style="padding: 0px;" >8</th>
                                        <th style="padding: 0px;" >9</th>
                                        <th style="padding: 0px;" >10</th>
                                        <th style="padding: 0px;" >11</th>
                                        <th style="padding: 0px;" >12</th>
                                        <th style="padding: 0px;" >13</th>
                                        <th style="padding: 0px;" >14</th>
                                        <th style="padding: 0px;" >15</th>
                                        <th style="padding: 0px;" >16</th>
                                        <th style="padding: 0px;" >17</th>
                                        <th style="padding: 0px;" >18</th>
                                        <th style="padding: 0px;" >19</th>
                                        <th style="padding: 0px;" >20</th>
                                        <th style="padding: 0px;" >21</th>
                                        <th style="padding: 0px;" >22</th>
                                        <th style="padding: 0px;" >23</th>
                                        <th style="padding: 0px;" >24</th>
                                        <th style="padding: 0px;" >25</th>
                                        <th style="padding: 0px;" >26</th>
                                        <th style="padding: 0px;" >27</th>
                                        <th style="padding: 0px;" >28</th>
                                        <th style="padding: 0px;" >29</th>
                                        <th style="padding: 0px;" >30</th>
                                        <th style="padding: 0px;">31</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($dataShow as $key => $data)
                                        <tr>
                                            <td style="padding: 0px;">{{$data->employee_id}} {{strToUpper($data->employee_name)}}</td>
                                            <td style="padding: 0px;"> {!!getStaffData($data->id,$date,'01')!!}</td>
                                            <td style="padding: 0px;"> {!!getStaffData($data->id,$date,'02')!!}</td>
                                            <td style="padding: 0px;"> {!!getStaffData($data->id,$date,'03')!!}</td>
                                            <td style="padding: 0px;"> {!!getStaffData($data->id,$date,'04')!!}</td>
                                            <td style="padding: 0px;"> {!!getStaffData($data->id,$date,'05')!!}</td>
                                            <td style="padding: 0px;"> {!!getStaffData($data->id,$date,'06')!!}</td>
                                            <td style="padding: 0px;"> {!!getStaffData($data->id,$date,'07')!!}</td>
                                            <td style="padding: 0px;"> {!!getStaffData($data->id,$date,'08')!!}</td>
                                            <td style="padding: 0px;"> {!!getStaffData($data->id,$date,'09')!!}</td>
                                            <td style="padding: 0px;"> {!!getStaffData($data->id,$date,'10')!!}</td>
                                            <td style="padding: 0px;"> {!!getStaffData($data->id,$date,'11')!!}</td>
                                            <td style="padding: 0px;"> {!!getStaffData($data->id,$date,'12')!!}</td>
                                            <td style="padding: 0px;"> {!!getStaffData($data->id,$date,'13')!!}</td>
                                            <td style="padding: 0px;"> {!!getStaffData($data->id,$date,'14')!!}</td>
                                            <td style="padding: 0px;"> {!!getStaffData($data->id,$date,'15')!!}</td>
                                            <td style="padding: 0px;"> {!!getStaffData($data->id,$date,'16')!!}</td>
                                            <td style="padding: 0px;"> {!!getStaffData($data->id,$date,'17')!!}</td>
                                            <td style="padding: 0px;"> {!!getStaffData($data->id,$date,'18')!!}</td>
                                            <td style="padding: 0px;"> {!!getStaffData($data->id,$date,'19')!!}</td>
                                            <td style="padding: 0px;"> {!!getStaffData($data->id,$date,'20')!!}</td>
                                            <td style="padding: 0px;"> {!!getStaffData($data->id,$date,'21')!!}</td>
                                            <td style="padding: 0px;"> {!!getStaffData($data->id,$date,'22')!!}</td>
                                            <td style="padding: 0px;"> {!!getStaffData($data->id,$date,'23')!!}</td>
                                            <td style="padding: 0px;"> {!!getStaffData($data->id,$date,'24')!!}</td>
                                            <td style="padding: 0px;"> {!!getStaffData($data->id,$date,'25')!!}</td>
                                            <td style="padding: 0px;"> {!!getStaffData($data->id,$date,'26')!!}</td>
                                            <td style="padding: 0px;"> {!!getStaffData($data->id,$date,'27')!!}</td>
                                            <td style="padding: 0px;"> {!!getStaffData($data->id,$date,'28')!!}</td>
                                            <td style="padding: 0px;"> {!!getStaffData($data->id,$date,'29')!!}</td>
                                            <td style="padding: 0px;"> {!!getStaffData($data->id,$date,'30')!!}</td>
                                            <td style="padding: 0px;"> {!!getStaffData($data->id,$date,'31')!!}</td>

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row my-3 float-right">
                        <div class="col-12 d-flex justify-content-cemter">
                            <div class="col-12 d-flex justify-content-cemter">
                                <button class="btn btn-primary btn-sm mb-2" title="{{__('app.Print')}}" onclick="printDiv()" ><i class="bi bi-printer"></i></button>
                            </div>                        </div>
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
