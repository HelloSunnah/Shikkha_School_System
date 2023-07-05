@extends('layouts.school.master')

@section('content')
    <!--start content-->
    <style>
        .lala{
            position: relative;
            animation: myfirst 12s 20;
         animation-direction:alternate-reverse;
         transition: 0.5s;
        }
        @keyframes myfirst {
            from {left:-300px;}
            to {left: 300px;}

        }
        .card-hover {
            background-color:#7500a7;  
            transition: 0.5s;
            
        }
        .card-hover:hover {
            background-color: #ffff;
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
    <main class="page-content">

        <div class="row">
            <div class=" mb-4" style="background-color: #ffffff;padding:10px;color:#000000;box-shadow:4px 3px 13px  .7px #deaaf7;border-radius:5px">
                <h3 class="text-center lala" >Setting Your Result System</h3>
            </div>
            
            <div class="col-md-4">
                <div class="col-lg-4 ">
                    <a href="{{ route("syllabus.create") }}">
                        <div class="card rounded card-hover" style="width: 17rem; height:220px; color: #ffffff;">
                            <div class="card-body text-center hover-overlay" style="padding-top:60px">
                                <div > <i class="bi bi-cloud-upload white" style="font-size:65px;padding-top:-10px !important;"></i></div>
                                <div>
                                <h6 class="white ">Input Your Result Information</h6>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>




            @foreach ($syllabus as $resultSetting)

            <div class="col-md-4">
                <div class="col-lg-4 ">
                    <a href="{{ route('syllabus.form.show')}}">
                        <div class="card rounded card-hover" style="width: 17rem; height:220px; color: #ffffff;">
                            <div class="card-body text-center hover-overlay" style="padding-top:60px">
                                <div > <i class="bi bi-cloud-upload white" style="font-size:65px;padding-top:-10px !important;"></i></div>
                                <div>
                                <h6 class="white ">Input Your Result Information</h6>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            @endforeach



        </div>
    </main>
@endsection
@push('js')
    <script>
        function termOffAnchorTag(id)
        {
            var myLink = document.getElementById('termEditLink' + id);
            myLink.addEventListener('click', function(event) {
            event.preventDefault();  // Prevent the default click action
            });
        };

        function termDuplicate(id)
        {
            var myLink = document.getElementById('termEditLink' + id);
            myLink.addEventListener('click', function(event) {
            event.preventDefault();  // Prevent the default click action
            });

            var url = "/school/student/result/setting/duplicate/" + id;
            window.location.replace(url);
        };

        function termEdit(id)
        {
            var myLink = document.getElementById('termEditLink' + id);
            myLink.addEventListener('click', function(event) {
            event.preventDefault();  // Prevent the default click action
            });

            var url = "/school/student/just/result/setting/edit/" + id;
            window.location.replace(url);
        };


    </script>
@endpush
