@extends('layouts.school.master')

@section('content')
<!--start content-->

<main class="page-content">
    <div class="row">
        <div class="col-10"></div>
        <div class="col-2"><a class="btn btn-primary" style="margin-bottom:10px;" href="{{route('ticketmessage.list')}}">Ticket List</a>
        </div>
    </div>
    <div class="row">

        @foreach ($dept as $data)
        <div class="col-md-6">

            <div class="card" style="width:400px;height:190px;border-radius:10px;background-color: #7a00a7">
                <a id="" href="{{ route('ticketmessage.create',$data->id)}}">
                    <div class="card-body" style="color: #ffffff;">

                        <h4 style="border-radius:2px ; margin-left:10px" class="white mt-4">{{ $data->department }}</h4>
                    </div>
                    <div class="row">
                    <p style="color: #ffffff;margin-top:-20px; margin-left:23px">{{ $data->department }} department-Online Now</p>

                    </div>

                    <div style="background-color: #ffffff;height:40px;width:320px;margin-left:37px;border-radius:2px;margin-top:22px">
                        <h6 style="text-align: center;padding:2%;color:#A300F0">Open Ticket</h6>
                    </div>
                </a>

            </div>
        </div>

        @endforeach
    </div>

</main>
@endsection