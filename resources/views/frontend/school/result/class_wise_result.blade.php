@extends('layouts.school.master')

@section('content')

    <!--start content-->
    <main class="page-content">
        <h3 class="mt-5 mb-3 text-center text-primary">See Result</h3>
        <div class="row">
            <div class="col-xl-6 mx-auto">
                <div class="card" style="box-shadow:4px 3px 13px  .7px #bc53ed;border-radius:5px">
                    <div class="card-body">
                        <div class="border p-3 rounded">
                            <form class="row g-3" method="post" action="{{route('show.class.wise.result')}}" target="_blank" enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-12">
                                    @include('frontend.layouts.message')
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="select-form">Select Result Type</label>
                                    <select class="form-control js-select" name="resultType" id="resultType" onchange="showResultForm()" >
                                        <option value="" selected>Select Result Type</option>
                                        <option value="classWise">Class Wise Result</option>
                                        <option value="studentWise">Student Wise Result</option>
                                        <option value="yearlyFinalResult">Annual Result</option>
                                    </select>
                                </div>

                                <div class="d-none" id="showClassWiseForm">
                                    <div class="col-12 mb-3">
                                        <label class="select-form">{{__('app.class')}}</label>
                                        <select class="form-control mb-3 js-select" name="class_wise_class_id" id="class_wise_class_id">
                                            <option value="" selected>Select Class</option>
                                            @foreach($class as $data)
                                                <option value="{{$data->id}}">{{$data->class_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label class="select-form">Term Name</label>
                                        <select class="form-control mb-3 js-select" id="class_wise_term_id" name="class_wise_term_id">
                                            <option value="" selected>Select Term</option>
                                            @foreach($terms as $term)
                                                {{-- <option value="{{$term->id}}">{{$term->term_name}}</option> --}}
                                                <option value="{{$term->id}}">{{$term->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="d-none" id="showstudentWiseForm">
                                    <div class="col-12 mb-3">
                                        <label class="select-form">Term Name</label>
                                        <select class="form-control mb-3 js-select" id="student_wise_term_id" name="student_wise_term_id">
                                            <option value="" selected>Select Term</option>
                                            @foreach($terms as $term)
                                                {{-- <option value="{{$term->id}}">{{$term->term_name}}</option> --}}
                                                <option value="{{$term->id}}">{{$term->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label class="select-form">{{__('app.class')}}</label>
                                        <select class="form-control mb-3 js-select" name="student_wise_class_id" id="student_wise_class_id" onchange="classLoadSection()">
                                            <option value="" selected>Select Class</option>
                                            @foreach($class as $data)
                                                <option value="{{$data->id}}">{{$data->class_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- <div class="col-12 mb-3">
                                        <label>{{__('app.Section')}} {{__('app.Name')}} <span style="color:red;"></span></label>
                                        <select class="form-control mb-3 js-select"id="student_wise_section_id" name="section_id">
                                            <option selected>Select one</option>
                                         </select>
                                    </div> --}}

                                    <div class="col-12 mb-3">
                                        <label class="select-form">Student Name</label>
                                        <select class="form-control js-select" id="student_wise_student_id" name="student_wise_student_id" >
                                            <option value="" selected>Select Student</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="d-none" id="showFinalResultForm">
                                    <div class="col-12 mb-3">
                                        <label class="select-form">Class Name</label>
                                        <select class="form-control js-select" name="final_wise_class_id" id="final_wise_class_id" onchange="finalclassLoadSection()">
                                            <option value="" selected>Select Class</option>
                                            @foreach($class as $data)
                                                <option value="{{$data->id}}">{{$data->class_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label class="select-form">Select Term</label> <br>
                                        @foreach ($terms as $term)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="resultSetting[]" id="resultSetting{{ $term->id }}" value="{{ $term->id }}">
                                            <label class="form-check-label" for="resultSetting{{ $term->id }}">{{ $term->title }}</label>
                                        </div>
                                        @endforeach
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label class="select-form">Student Name</label>
                                        <select class="form-control js-select" id="final_student_wise_student_id" name="final_student_wise_student_id">
                                            <option value="" selected>Select Student</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary">Show Result</button>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="d-grid">
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="lni lni-youtube"></i> Tutorial</button>
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
    $tutorialShow = getTutorial('assign-teacher');
    ?>
    @include('frontend.partials.tutorial')

@endsection

@push('js')
     <script>
        function showResultForm()
        {   
           var formType = $("#resultType").val();
           if (formType == "classWise") {
            $("#showClassWiseForm").removeClass('d-none');
            $("#showstudentWiseForm").addClass('d-none');
            $("#showFinalResultForm").addClass('d-none');
        } else if (formType == 'yearlyFinalResult') {
            $("#showClassWiseForm").addClass('d-none');
               $("#showFinalResultForm").removeClass('d-none');
                $("#showstudentWiseForm").addClass('d-none');
        }
        else {
               $("#showClassWiseForm").addClass('d-none');
               $("#showFinalResultForm").addClass('d-none');
                $("#showstudentWiseForm").removeClass('d-none');
           }
        }

        function classLoadSection()
        {
            var class_id = $("#student_wise_class_id").val();

            $.ajax({
                url:'{{route('class.wise.user')}}',
                method:'POST',
                data:{
                    '_token':'{{csrf_token()}}',
                    class_id:class_id
                },

                success: function (data) {
                    $("#student_wise_student_id").empty();
                    $.each(data, function (section_name, students) {
                        var option = `<optgroup label="${section_name}">`;
                            $.each(students, function (student_id, student_name){
                                option += `<option value="${student_id}">${student_name}</option>`;
                            });
                         $("#student_wise_student_id").append(option);
                            option += "</optgroup>";
                    });
                }
            });

            $.ajax({
                url:'{{route('admin.show.section')}}',
                method:'POST',
                data:{
                    '_token':'{{csrf_token()}}',
                    class_id:class_id
                },

                success: function (response) {

                    $('#section_id').html(response.html);

                }
            });

        }
        function finalclassLoadSection()
        {
            var class_id = $("#final_wise_class_id").val();

            $.ajax({
                url:'{{route('class.wise.user')}}',
                method:'POST',
                data:{
                    '_token':'{{csrf_token()}}',
                    class_id:class_id
                },

                success: function (data) {
                    $("#final_student_wise_student_id").empty();
                    $.each(data, function (section_name, students) {
                        var option = `<optgroup label="${section_name}">`;
                            $.each(students, function(student_id, student_name){
                                option += `<option value="${student_id}">${student_name}</option>`;
                            });
                         $("#final_student_wise_student_id").append(option);
                            option += "</optgroup>";
                    });
                }
            });
        }

        // function loadSection() {
        //     let class_id = $("#class_id").val();

        //     $.ajax({
        //         url:'{{route('admin.show.section')}}',
        //         method:'POST',
        //         data:{
        //             '_token':'{{csrf_token()}}',
        //             class_id:class_id
        //         },

        //         success: function (response) {

        //             $('#section_id').html(response.html);

        //         }
        //     });

        // }
    </script>
@endpush
