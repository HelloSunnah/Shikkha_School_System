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
    <main class="page-content">

        <div class="row">
            <div class=" mb-4" style="background-color: #ffffff;padding:10px;color:#000000;box-shadow:4px 3px 13px  .7px #deaaf7;border-radius:5px">
                <h3 class="text-center lala" >Setting Your Result System</h3>
            </div>
            
            <div class="col-md-4">
                <div class="col-lg-4 ">
                    <a href="{{ route("show.create.setting") }}">
                        <div class="card  card-hover" style="width: 17rem; height:220px; color: #ffffff;">
                            <div class="card-body text-center hover-overlay" style="padding-top:60px">
                                <div > <img src="{{ asset('schools/assets/images/icons/vector.png')}}" alt=""></div>
                                <div>
                                <h6 class="white mt-4 ">Input Your Result Information</h6>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            @foreach ($resultSettings as $resultSetting)
                <div class="col-md-4">
                    <div class="card  card-hover" style="width:17rem;height:220px;border-radious:20px">
                        <a id="termEditLink{{ $resultSetting->id }}" href="{{ route("edit.result.setting",[ "id" => $resultSetting->id]) }}">
                            <div class="card-body text-center hover-overlay" style="color: #ffffff;">
                                <div style="margin-right: -180px;">
                                    <div class="dropdown">
                                        <button class="btn" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: none; border:none;">
                                            <i class="bi bi-three-dots white" style="font-size: 20px;"></i>
                                        </button>
                                        <ul class="dropdown-menu " aria-labelledby="dropdownMenuButton1">
                                            <li><button onclick="termDuplicate({{ $resultSetting->id }});" class="dropdown-item duplicate" >Duplicate</button></li>
                                            <li><button onclick="termEdit({{ $resultSetting->id }});" class="dropdown-item edit" >Edit</button></li>
                                            <li><button  onclick="termOffAnchorTag({{ $resultSetting->id }});"  class="dropdown-item delete" data-bs-toggle="modal" data-bs-target="#resultSetting{{ $resultSetting->id }}">Delete</button></li>
                                        </ul>
                                    </div>
                                </div>
                                <div ><img src="{{ asset('schools/assets/images/icons/vector 2.png')}}" alt="" width="65" height="80"></div>
                                <div>
                                    <h5 class="white mt-4">{{ $resultSetting->title }}</h5>
                                    <p class="white">{{ $resultSetting->created_at->format('d/m/Y') }}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="resultSetting{{ $resultSetting->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered text-center">
                        <div class="modal-content">
                        <div class="modal-header" style="background-color:blueviolet;">
                            <h5 class="modal-title text-white" id="exampleModalLabel">Delete Result Setting</h5>
                            <button type="button" class="btn-close btn-white" style="color:white;" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <h5>Are you sure? You want to delete this settings!!</h5>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <a class="btn btn-danger" style="background-color:blueviolet !important;border-color:blueviolet !important;" href="{{ route("delete.result.setting", ['id' => $resultSetting->id]) }}">Delete</a>
                            {{-- <a type="button" class="btn btn-primary">Save changes</a> --}}
                        </div>
                        </div>
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
    
        function latestResultSetting()
        {   
            $.ajax({
                type: "GET",
                url: "{{ url('school/student/show/latest/result/setting') }}",
                success: function (data) {
                    
                }
            });
        }

    </script>
@endpush
