@extends('layouts.school.master')
@push('css')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">

@endpush
@section('content')
    <!--start content-->
    <main class="page-content">
        <x-page-title title='Take Attendance'/>
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <div class="border p-3 rounded">
                            <form class="row g-3" method="get" action="{{route('student.attendance.create.show.post.date')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-12">
                                    @include('frontend.layouts.message')
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">{{__('app.class')}}</label>
                                    <select class="form-select js-select" aria-label="Default select example" required name="class_id" id="class_id" onchange="game_chf()">
                                        <option value="" >Class Name</option>
                                        @foreach($class as $data)
                                            <option value="{{$data->id}}">{{$data->class_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">{{__('app.section')}}</label>
                                    <select class="form-select js-select" id="section_id" name="section_id" onchange="group_chf()" required>
                                        <option>Select one</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">{{__('app.date')}} </label>                                               
                                    <input type="text" id="datepicker" class="form-control"  name="date" value="{{ $defaultDate }}" required>
                                </div>

                                
                                <div class="col-md-6" id="group-select">
                                    {{-- <label class="form-label">Group Name</label>
                                    <select class="form-select mb-3" id="group_id" name="group_id">
                                        <option selected>Select one</option>
                                    </select> --}}
                                </div>
                                
                                
                                <div class="row">
                                    <div class="col">
                                        <button type="submit" class="btn btn-primary w-100">{{__('app.Show Attendance')}}</button>
                                    </div>
                                    <div class="col">
                                        <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="lni lni-youtube"></i> Tutorial</button>
                                    </div>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end row-->
    </main>

    <?php
    $tutorialShow = getTutorial('student-attendance-show');
    ?>
    @include('frontend.partials.tutorial')

@endsection

@push('js')

    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
    <script>
        $(document).ready(function(){
            $("#datepicker").datepicker({
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true,
            });
        })
    </script>

    <script>
        function game_chf() {
            let class_id = $("#class_id").val();
            let groupElement = `<label class="form-label">Group Name</label>
                                <select class="form-select mb-3" id="group_id" name="group_id">
                                    <option selected>Select one</option>
                                </select>`;
            

            $.ajax({
                url:'{{route('admin.show.section')}}',
                method:'POST',
                data:{
                    '_token':'{{csrf_token()}}',
                    class_id:class_id
                },

                success: function (response) {
                    $('#section_id').html(response.html);
                    
                    if(response.class > 8)
                    {
                        $("#group-select").html(groupElement);
                    }
                    else
                    {
                        $("#group-select").html('');
                    }
                }
            });

        }

        function group_chf() {
            let class_id = $("#class_id").val();
            let section_id = $("#section_id").val();
            console.log(section_id,'sports-section');
            $.ajax({
                url:'{{route('admin.show.group')}}',
                method:'POST',
                data:{
                    '_token':'{{csrf_token()}}',
                    class_id:class_id,
                    section_id:section_id,
                },

                success: function (response) {
                    $('#group_id').html(response);
                }
            });

        }

    </script>
@endpush
