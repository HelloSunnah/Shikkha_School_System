@extends('layouts.master')
@section('content')
<main class="page-content">

    <div class="container mt-5">
        <div class="row  border-bottom white-bg dashboard-header">


            <div class="col-md-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Token</th>
                            <th scope="col">Created By</th>

                 
                            <th scope="col">Created At</th>

                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($ticket as $data)
                        <tr>
                            <td>{{$data->token}}</td>
                            <td>{{$data->name}}</td>

                            <td>{{$data->created_at->format('Y-m-d') }}</td>
                            <td>
                            <a href="{{route('ticket.reply.admin',$data->id)}}" class="btn btn-primary btn-sm"><i class="bi bi-reply"></i></a>
                            <a href="" class="btn btn-danger btn-sm" onclick="if(confirm('Are You sure?')){ location.replace('{{route('ticket.delete',$data->id)}}') }"><i class="bi bi-trash"></i></a>

                         


                        </td>

                     
                         
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>


        @endsection