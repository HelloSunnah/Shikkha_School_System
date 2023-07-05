@extends('layouts.school.master')

@section('content')
    <!--start content-->
    <main class="page-content">
        <x-page-title title='All Student Result Print'/>
        <div class="row">
            <div class="col-xl-6 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <div class="border p-3 rounded">
                            <form class="row g-3" method="post" action="{{route('result.pdf.download')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-12">
                                    @include('frontend.layouts.message')
                                </div>

                                <div  id="showstudentWiseForm">
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

                                    <div class="col-12 mb-3 d-none" id="sectionCol">
                                        <label class="select-form" for="">Select Section</label> <br>
                                        <div class="form-check form-check-inline" id="sectionDiv">
                                            
                                            
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary">Get Result Pdf</button>
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
        function classLoadSection()
        {
            var class_id = $("#student_wise_class_id").val();
            $.ajax({
                type:'GET',
                url:"{{ url('school/student/get/section/ajax/') }}/" + class_id,
                dataType: 'json',
                success: function (data) {
                    $("#sectionCol").removeClass('d-none');
                    $("#sectionDiv").empty();
                   $.each(data, function (key, section) { 
                       $("#sectionDiv").append(`
                           <input class="ms-1" type="checkbox" name="section_name[]" id="section_name${section.id}" value="${section.id}">
                           <label class="form-check-label" for="section_name${section.id}">${section.section_name}</label>
                       `);
                   }); 
                }
            });
        }
    </script>
@endpush
