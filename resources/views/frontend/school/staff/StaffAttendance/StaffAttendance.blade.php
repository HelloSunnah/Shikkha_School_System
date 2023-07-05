@extends('layouts.school.master')
@push('css')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">

@endpush
@section('content')



<main class="page-content">

    @if(count($dataAttendance))
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header py-3 bg-transparent">
                    <div class="d-sm-flex align-items-center">
                        <h5 class="mb-2 mb-sm-0">{{__('app.Stuff')}} {{__('app.Attendance')}} ({{$formattedDate}})</h5>
                        <div class="ms-auto">
                            <button type="button" class="btn btn-secondary btn-sm" title="{{__('app.Back')}}" onclick="history.back()"><i class="bi bi-arrow-left-square"></i></button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>{{__('app.Stuff')}} {{__('app.Name')}}</th>
                                    <th>{{__('app.UniqueId')}}</th>
                                    <th>{{__('app.Attendance')}}</th>
                                    <th>{{__('app.Comment')}}</th>
                                    <th>{{__('app.Action')}}</th>
                                    <th>{{__('app.date')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dataAttendance as $key => $data)
                                <tr>
                                    <td>{{getStaffName($data->employee_id)->employee_name}}</td>
                                    <td>{{getStaffName($data->employee_id)->employee_id}}</td>
                                    <td>@if($data->attendance == 1 ) Present @elseif($data->attendance == 2) Late @else Absent @endif</td>
                                    <td>{{ is_null($data->comment) ? 'No comment' : $data->comment}}</td>
                                    <td>
                                        <form method="post" action="{{route('Staff.confirmabsentpresent',$data->id)}}" enctype="multipart/form-data">
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
                                    
                                    @if(!is_null(Request::segment(5)))
                                        <td>{{Request::segment(5)}}</td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row my-3 float-right">
            <div class="col-12 d-flex justify-content-cemter">
                <div class="col-12 d-flex justify-content-cemter">
                    <button class="btn btn-primary btn-sm mb-2" title="{{__('app.Print')}}" onclick="printDiv()" ><i class="bi bi-printer"></i></button>
                </div>           
            </div>
        </div>

    </div>

    <!--end row-->
    <div class="col-12" style="display:none;">
        <div class="col-12" id="printDiv">
            <div class="row">
                <div class="col-md-12">
                    <div class="card" style="box-shadow:4px 3px 13px  .7px #deaaf7;border-radius:5px">

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
                                    <p>@if(!is_null(Request::segment(5)))
                                        <p>Date: {{Request::segment(5)}}</p>
                                    @endif</p>
                                <div class="row text-center">
                                    <h5 style="margin-top:5px !important;font-size:22px;margin-bottom:10px;">{{__('app.Stuff')}} {{__('app.Attendance')}}</h5>
                                </div>                                
                            </div>                                        
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th style="padding: 0px;">{{__('app.UniqueId')}}</th>
                                            <th style="padding: 0px;">{{__('app.Stuff')}} {{__('app.Name')}}</th>                                            
                                            <th style="padding: 0px;">{{__('app.Attendance')}}</th>
                                            <th style="padding: 0px;">{{__('app.Comment')}}</th>         
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($dataAttendance as $key => $data)
                                        <tr>
                                            <td style="padding: 0px;">{{getStaffName($data->employee_id)->employee_id}}</td>
                                            <td style="padding: 0px;">{{getStaffName($data->employee_id)->employee_name}}</td>
                                            <td style="padding: 0px;">@if($data->attendance == 1 ) Present @elseif($data->attendance == 2) Late @else Absent @endif</td>
                                            <td style="padding: 0px;">{{ is_null($data->comment) ? 'No comment' : $data->comment}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @else
    <form class="row g-3" method="post" action="{{route('StaffAttendance.post')}}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="segment_date" value="{{ Request::segment(5) }}">
        @if(Request::segment(5) <= date("Y-m-d"))
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>{{__('app.Stuff')}} {{__('app.Name')}}</th>
                                        <th>{{__('app.UniqueId')}}</th>
                                        <th>{{__('app.Action')}}</th>
                                        <th>{{__('app.Comment')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($dataShow as $key => $data)
                                    @php
                                    $attendance = getStaffAttendance($data->id, Request::segment(7));
                                    @endphp
                                    <tr>
                                        <td>{{$data->employee_name}}</td>
                                        <td>{{$data->employee_id}}</td>
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

                                            <input type="hidden" name="employee_id[]" value="{{$data->id}}">
                                        </td>
                                        <td><input class="form-control" name="comment[]" placeholder="Give a Comment"></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-sm">Submit</button>
            </div>
        </div>
        <!--end row-->
        @else
        <p>Upcoming date attendance you can not uploaded</p>
        @endif
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