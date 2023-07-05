@extends('layouts.school.master')

@section('content')
    <!--start content-->
    <style>
        .lala{
            position: relative;
            animation: myfirst 5s 200;
         animation-direction:alternate-reverse;
         transition: 0.8s;
        }
        @keyframes myfirst {
            from {left:-200px;}
            to {left: 200px;}

        }
        .card {
            border-radius:20px;  
            
            
        }
        .card-hover {
            background-color:#7500a7;  
            transition: 0.5s;
            
        }
        .card-hover:hover {
            background-color: rgb(229, 134, 253);
            cursor: pointer;
            color:#7a00a7;
        }
        .card-hover:hover .white{
            color: #000000;
        }
        .dropdown i{
            color:#ffffff;
        }
        .delete:hover{
            background-color: red;
            border-radius: 9%;
            color: white;
            margin-left: 5px;
            width: 85%;
        }
        .duplicate:hover{
            background-color: #7a00a7;
            border-radius: 9%;
            color: white;
            margin-left: 5px;
            width: 85%;
        }
    </style>
    <main class="page-content">  @foreach ($dept as $data)
                <div class="col-md-4">
                    <div class="card  card-hover" style="width:17rem;height:100px;border-radious:20px">
                        <a id="" href="{{ route('ticketmessage.create',$data->id)}}">
                            <div class="card-body text-center hover-overlay" style="color: #ffffff;">
                             
                                    <h5 class="white mt-4">{{ $data->department }}</h5>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

            @endforeach
        </div>
    </main>
@endsection

