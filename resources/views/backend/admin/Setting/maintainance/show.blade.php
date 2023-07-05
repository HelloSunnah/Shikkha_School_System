@extends('layouts.master')

@section('content')
    <div class="container mt-5">
        <div class="row  border-bottom white-bg dashboard-header">
            <div class="col-md-12">

                <div class="row wrapper border-bottom white-bg page-heading">
                    <div class="col-md-10">

                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin') }}">Admin</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <strong>Panel</strong>
                            </li>
                        </ol>
                    </div>                    
                </div>

                <div class="col-md-12 d-flex justify-content-center" style="margin-top:20px;">
                    <div class="col-md-8">

                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4">
                                        <h3 style="white-space: nowrap;">Set Under Maintainance:</h3>
                                    </div>
                                    <div class="col-8">
                                        <a href="{{Route('admin.maintenance.set')}}"><button type="submit" class="btn btn-secondary" >Site Down Except Test</button></a>
                                        <a href="{{Route('admin.maintenance.reset')}}"><button type="submit" class="btn btn-primary" > Full Site Up</button></a>
                                        <a href="{{Route('server.down')}}"><button type="submit" class="btn btn-danger" > Full Site Down</button></a>                                       
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>  
        
    @endsection
