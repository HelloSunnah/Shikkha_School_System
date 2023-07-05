@extends('layouts.school.master')

@section('content')
    <main class="page-content">
        <div class="row">
            <div class="col-lg-9 mx-auto">
                <hr style="width:100%;text-align:left;margin-left:0;margin-bottom:0;height:5px;background-color:#7c00a7">

                <div class="card">


                    <table class="table table-hover table-bordered">

                        <tbody>
                            <tr>
                                <td>{{ __('app.Id') }}</td>
                                <td>{{ $data->employee_id}} </td>
                            </tr>
                            <tr>
                                <td>{{ __('app.Name') }} </td>
                                <td>{{ $data->employee_name }} </td>
                            </tr>
                            <tr>
                                <td>{{ __('app.Phone') }} </td>
                                <td>{{ $data->phone_number }}</td>
                            </tr>

                            <tr>
                                <td>{{ __('app.Gender') }} </td>
                                <td>{{ $data->gender }}</td>
                            </tr>

                            <tr>
                                <td>{{ __('app.Address') }} </td>
                                <td>{{ $data->address }}</td>
                            </tr>

                            <tr>
                                <td>{{ __('app.Salary') }} </td>
                                <td>{{ $data->salary }}</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class=" col-xl-3 mx-auto">
                <hr style="width:100%;text-align:left;margin-left:0;margin-bottom:0;height:5px;background-color:#7c00a7">
                <div class="card">
                    <div class="mt-10">
                        <div style="margin-left:15px; margin-top:10px;">
                            <center>
                                <img src="{{ asset($data->image ?? 'd/no-img.png') }}" alt="" style="width:300px;height:300px; ">
                            </center>
                            <br>
                            <h6><strong>{{ __('app.Name') }}: {{ $data->employee_name }} </strong></h6>
                            <h6><strong>{{ __('app.Id') }}: {{ $data->employee_id }} </strong></h6>
                            <h6><strong>{{ __('app.Shift') }}: {{ $data->shift }}</strong></h6>
                            <h6><strong>{{ __('app.PositionName') }}: {{ $data->position }}</strong></h6>


                        </div>
                    </div>
                </div>
            </div>
        @endsection