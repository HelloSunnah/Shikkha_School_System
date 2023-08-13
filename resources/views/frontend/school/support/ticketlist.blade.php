@extends('layouts.school.master')
@section('content')
<main class="page-content">

    <div class="container mt-5">
        <div class="row  border-bottom white-bg dashboard-header">


            <div class=" card" style="width:700px;box-shadow: 10px 5px 5px gray;height:550px;border-radius:10px;background-color:none;margin-left:65px">
                <div class="card-body" style="color: #ffffff;">
                    <div class="col-md-12">
                        <table class="table">
                            <thead>
                             
                                <tr>

                                    <th scope="col">Token</th>
                                    @if(Auth::user()->school)
                                    <th scope="col">Created By</th>

                                    @endif
                                    <th scope="col">Department</th>

                                    <th scope="col">Created At</th>


                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($ticket as $data)
                                <tr>
                                    <td>{{$data->token}}</td>
                                    @if(Auth::user()->school)
                                    <td>{{$data->name}}</td>

                                    @endif
                                    <td>{{$data->department_id}}</td>


                                    <td>{{$data->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <a href="{{route('ticket.reply',$data->id)}}" style="width:60px" class="btn btn-primary btn-sm"><i class="bi bi-arrow-right"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>


            @endsection