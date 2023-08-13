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

        @keyframes blink {
            50% {
            opacity: 0.0;
            }
        }
        .blink {
            animation: blink 0.5s step-start 0s;
            animation-iteration-count: 3;
        }
    </style>
    <main class="page-content">

        <div class="row">
            <div class=" mb-4">
                <h3>Setting Your Result System</h3>
            </div>

            <div class="col-md-4">
                <a href="{{ route("show.create.setting") }}">
                    <div class="card card-hover" style="height:250px; color: #ffffff;">
                        <div class="card-body justify-content-center hover-overlay d-flex align-items-center">
                            <div class="text-center">
                                <img src="{{ asset('schools/assets/images/icons/vector.png')}}" alt="" class="img-fluid">
                                <h6 class="white mt-4 ">Input Your Result Information</h6>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            @foreach ($resultSettings as $resultSetting)
                <div class="col-md-4" id="addDuplicate{{ $resultSetting->id }}">
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

                                <div class="text-center">
                                    <img src="{{ asset('schools/assets/images/icons/vector 2.png')}}" alt="" width="65" height="80">
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
                            <h5 class="modal-title text-white" id="exampleModalLabel">Alert!</h5>
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
            $.ajax({
                type: "get",
                url: url,
                success: function (data) {
                    if(data.status == "success") {
                        showLastSetting(id);
                    }
                }
            });
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

    <script>
        function showLastSetting(id)
        {   
            $.ajax({
                type: "get",
                url: "{{ route('show.last.result.setting') }}",
                success: function (data) {
                    
                    var created_at = new Date(data.created_at);
                    var day = created_at.getDate();
                    var month = created_at.getMonth() + 1;
                    var year = created_at.getFullYear();
                    var created = day + "/" + month + "/" + year;

                    var edit = "{{ url('school/student/result/setting/edit') }}/" + data.id
                    var dlt  = "{{ url('school/student/result/setting/delete') }}/" + data.id

                    var duplicate = ` 
                            <div class="col-md-4" id="addDuplicate${ data.id }">
                                <div class="card  card-hover" style="width:17rem;height:220px;border-radious:20px">
                                    <a id="termEditLink${ data.id }" href="${edit}">
                                        <div class="card-body text-center hover-overlay" style="color: #ffffff;">
                                            <div style="margin-right: -180px;">
                                                <div class="dropdown">
                                                    <button class="btn" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: none; border:none;">
                                                        <i class="bi bi-three-dots white" style="font-size: 20px;"></i>
                                                    </button>
                                                    <ul class="dropdown-menu " aria-labelledby="dropdownMenuButton1">
                                                        <li><button onclick="termDuplicate(${ data.id });" class="dropdown-item duplicate" >Duplicate</button></li>
                                                        <li><button onclick="termEdit(${ data.id });" class="dropdown-item edit" >Edit</button></li>
                                                        <li><button  onclick="termOffAnchorTag(${ data.id });"  class="dropdown-item delete" data-bs-toggle="modal" data-bs-target="#resultSetting${ data.id }">Delete</button></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div ><img src="{{ asset('schools/assets/images/icons/vector 2.png')}}" alt="" width="65" height="80"></div>
                                            <div>
                                                <h5 class="white mt-4">${ data.title }</h5>
                                                <p class="white">${ created }</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>

                            <div class="modal fade" id="resultSetting${ data.id }" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                            <a class="btn btn-danger" style="background-color:blueviolet !important;border-color:blueviolet !important;" href="${dlt}">Delete</a>
                                            {{-- <a type="button" class="btn btn-primary">Save changes</a> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    $(`#addDuplicate${id}`).after(duplicate);
                    $(`#addDuplicate${ data.id }`).addClass('blink');
                }
            });
        }
    </script>
@endpush
