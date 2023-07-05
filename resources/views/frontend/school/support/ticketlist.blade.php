@extends('layouts.school.master')
@section('content')
<main class="page-content">

    <div class="container mt-5">
        <div class="row  border-bottom white-bg dashboard-header">


            <div class="col-md-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Token</th>
                            @if(Auth::user()->school)
                            <th scope="col">Created By</th>

                            @endif
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

                            <td>{{$data->created_at->format('Y-m-d') }}</td>
                            <td>
                            <a href="{{route('ticket.reply',$data->id)}}" class="btn btn-primary btn-sm"><i class="bi bi-reply"></i></a>
                            <a href="" class="btn btn-secondary btn-sm"><i class="bi bi-pencil-fill"></i></a>
                            @if(Auth::user()->school)
                            <a href="{{route('ticket.reply',$data->id)}}" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></a>

                            @endif


                        </td>

                     
                         
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>


        @endsection