@extends('layouts.school.master')

@push('css')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
@endpush

@section('content')
    <!--start content-->
    <main class="page-content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="border p-3 rounded">
                            <h6 class="mb-0 text-uppercase">Update Question</h6>
                            <hr />
                            <div class="col-md-12">
                                @include('frontend.layouts.message')
                            </div>
                            <div class="col-md-12">
                            </div>
                            <form action="{{ route('update.question', $question->id) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" id="question_type" name="question_type" value="{{ $question->type }}">

                                {{-- <div class="col-md-12 d-flex justify-content-center">
                                    <div class="col-md-3" style="border-bottom: 2px solid black; margin-bottom: 10px;">
                                        <label>Choose Question Type</label>
                                        <select class="form-control mb-3 js-select"aria-label="Default select example"
                                            name="question_type" id="question_type" required>
                                            <option selected value="{{ $question->type }}"> {{ $question->type }}</option>
                                            <option value="MCQ">MCQ</option>
                                            <option value="Written">Written</option>
                                            <option value="Creative">Creative QN</option>
                                        </select>
                                    </div>
                                </div> --}}

                                <div class="col-md-12">
                                    <div class="row">
                                        <div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="select-form">Exam Term</label>
                                                    <select class="form-control mb-3 js-select" aria-label="Default select example"
                                                        name="exam_term" id="term_id" required>
                                                        <option selected="" value=""></option>
                                                        @foreach ($terms as $term)
                                                            <option value="{{ $term->id }}"
                                                                {{ $question->term_id == $term->id ? 'selected' : '' }}>
                                                                {{ $term->term_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-md-2">
                                                    <label class="select-form">Class</label>
                                                    <select class="form-select mb-3" aria-label="Default select example"
                                                        name="class_name" id="class_id" required>
                                                        <option selected="" value="">--Select Class Name--</option>
                                                        @foreach ($classes as $class)
                                                            <option value="{{ $class->id }}"
                                                                {{ $question->class_id == $class->id ? 'selected' : '' }}>
                                                                {{ $class->class_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="select-form">Subject</label>
                                                    <select class="form-control mb-3 js-select" aria-label="Default select example"
                                                        name="subject_name" id="subject_id" required>
                                                        @foreach ($subjects as $subject)
                                                            <option value="{{ $subject->id }}"
                                                                {{ $question->subject->id == $subject->id ? 'selected' : '' }}>
                                                                {{ $subject->subject_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-md-2">
                                                    <label class="text-center form-label">Hours/Min</label>
                                                    <div class="">
                                                        <div class="">

                                                            <input type="number" min="1" name="hours" value="{{ $question->hours }}" placeholder="Hours or Minutes" class="form-control" id="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="text-center form-label">Total Marks</label>
                                                    <div class="">
                                                        <div class="">
                                                            <input type="number" name="total_mark" value="{{ $question->total_marks }}" placeholder="Total Mark" class="form-control" id="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if ($question->type == 'Written')
                                    <div class="col-12">
                                        <div>
                                            <div id="apeandField">
                                                @foreach ($question['question_title'] as $key => $value)
                                                    <div class="row">
                                                        <div class="col-md-8 mt-3">
                                                            <label class="form-label">Question Title</label>
                                                            <input name="question_title[{{ $key }}]"
                                                                value="{{ $value }}" class="form-control"
                                                                type="text">
                                                        </div>
                                                        <div class="col-md-3 mt-3">
                                                            <label class="form-label">Mark</label>
                                                            <input name="question_mark[{{ $key }}]"
                                                                value="{{ $question['question_mark'][$key] }}"
                                                                class="form-control" type="text">
                                                        </div>

                                                        <div class="col-md-1">
                                                            <button type="button" class="btn btn-danger remove"
                                                                style="margin-top: 22px; margin-left: 27px;">-</button>
                                                        </div>

                                                        <div class="col-md-12 mt-3 mt-3">
                                                            <textarea name="questions[{{ $key }}]" id="ckeditor{{ $key }}" class="editor">{{ $question['question'][$key] }}</textarea>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <div class=" d-flex justify-content-between mt-3">
                                                <button class="btn btn-info d-block "
                                                    data-count="{{ count($question['question_title']) }}"
                                                    id="plusbtn">+</button>
                                                <button type="submit" class="btn btn-primary d-block">Update</button>
                                            </div>
                                        </div>
                                    </div>
                                @elseif ($question->type == 'Creative')
                                    <div id="creative">
                                        <div class="col-12">
                                            <div id="creativeapeandField">
                                                @foreach ($question->cre_question as $key => $creQn)
                                                    <div class="row">
                                                        <div class="col-md-12 mt-3">
                                                            <textarea name="creQuestions[{{ $key }}]" class="editor" id="ckeditor{{ $key }}">{{ $question->question[$key] }}</textarea>
                                                        </div>

                                                        @foreach ($creQn as $k => $val)
                                                            @php
                                                                $arr = [1 => 'A', 'B', 'C', 'D'];
                                                            @endphp
                                                            <div class="col-md-8 mt-3">
                                                                <label for="">{{ $arr[$loop->iteration] }}</label>
                                                                <input
                                                                    name="creQuestion_no[{{ $key }}][{{ $k }}]"
                                                                    value="{{ $val }}" class="form-control"
                                                                    type="text">
                                                            </div>

                                                            <div class="col-md-3 mt-3">
                                                                <label class="form-label">Mark</label>
                                                                <input
                                                                    name="creQuestion_mark[{{ $key }}][{{ $k }}]"
                                                                    value="{{ $question['question_mark'][$key][$k] }}"
                                                                    class="form-control" type="number">
                                                            </div>

                                                        @endforeach
                                                            <div class="col-md-1">
                                                                <button type="button" class="btn btn-danger remove"
                                                                    style="margin-top: 40px; margin-left: 27px;">-</button>
                                                            </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <div class=" d-flex justify-content-between mt-3">
                                                <button class="btn btn-info d-block "
                                                    data-count="{{ count($question['question']) }}"
                                                    id="plusbtn">+</button>
                                                <button type="submit" class="btn btn-primary d-block">Update</button>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div id="mcq">
                                        <div class="col-12">
                                            <div id="mcqapeandField">
                                                @foreach ($question->question as $key => $qn)
                                                    <div class="row">
                                                        <div class="col-md-11 mt-3">
                                                            <textarea name="mcqQuestions[{{ $key }}]" class="editor" id="ckeditor{{ $key }}">{{ $qn }}</textarea>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <button type="button" class="btn btn-danger remove"
                                                                style="margin-top: 16px; margin-left: 27px;">-</button>
                                                        </div>
                                                        @php
                                                            $arr = [1 => 'A', 'B', 'C', 'D'];
                                                        @endphp
                                                        @foreach ($question->mcq_question[$key] as $k => $mcq)
                                                            <div class="col-md-6 mt-3">
                                                                <label class="form-label">{{ $arr[$loop->iteration] }}</label>
                                                                <input
                                                                    name="mcqQuestion_no[{{ $key }}][{{ $k }}]"
                                                                    value="{{ $mcq }}" class="form-control"
                                                                    type="text">
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endforeach
                                            </div>

                                            <div class=" d-flex justify-content-between mt-3">
                                                <button class="btn btn-info d-block "
                                                    data-count="{{ count($question->question) }}"
                                                    id="plusbtn">+</button>
                                                <button type="submit" class="btn btn-primary d-block">Update</button>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>


@endsection

@push('js')
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
    {{-- <script src="{{ asset('js/ckeditor/ckeditor.js')}}"></script> --}}
    <script src="https://cdn.ckeditor.com/4.20.2/standard/ckeditor.js"></script>
    <script>
        $(document).ready(function() {
            $("#class_id").on('change', function() {
                var class_id = $(this).val();
                $.ajax({
                    type: "GET",
                    url: "{{ url('/school/student/get/subjet/') }}/" + class_id,
                    datatype: "json",
                    success: function(data) {
                        // $("#subject_id").empty();
                        $.each(data, function(key, value) {
                            $("#subject_id").append('<option value="' + value.id +
                                '"> ' + value.subject_name + ' </option>');
                        });
                    }
                });
            });

            $("#plusbtn").on('click', function(e) {
                e.preventDefault();
                var type = $("#question_type").val();
                var val = +$(this).attr('data-count') + 1;
                if (type == "Written") {
                    $("#apeandField").append(`
                        <div class="row mt-3">
                            <div class="col-md-8 mt-3">
                                <label for="">Question Name</label>
                                <input name="question_title[${val}]"  class="form-control" type="text">
                            </div>

                            <div class="col-md-3 mt-3">
                                <label for="">Mark</label>
                                <input name="question_mark[${val}]" class="form-control" type="number">
                            </div>

                            <div class="col-md-1" >
                                <button type="button" class="btn btn-danger remove" style="margin-top: 37px; margin-left: 27px;">-</button>
                            </div>

                            <div class="col-md-12 mt-3">
                                <textarea name="questions[${val}]" id="ckeditor${val}" ></textarea>
                            </div>
                        </div>
                    `);
                } else if (type == "Creative") {
                    $("#creativeapeandField").append(`
                        <div class="row">
                                                    
                            <div class="col-md-12 mt-3">
                                <textarea name="creQuestions[${val}]" id="ckeditor${val}" ></textarea>
                            </div>

                            <div class="col-md-8 mt-3">
                                <label for="">A</label>
                                <input name="creQuestion_no[${val}][1]" class="form-control" type="text">
                            </div>

                            <div class="col-md-3 mt-3">
                                <label for="">Mark</label>
                                <input name="creQuestion_mark[${val}][1]" class="form-control" type="number">
                            </div>
                            <div class="col-md-8 mt-3">
                                <label for="">B</label>
                                <input name="creQuestion_no[${val}][2]" class="form-control" type="text">
                            </div>

                            <div class="col-md-3 mt-3">
                                <label for="">Mark</label>
                                <input name="creQuestion_mark[${val}][2]" class="form-control" type="number">
                            </div>
                            <div class="col-md-8 mt-3">
                                <label for="">C</label>
                                <input name="creQuestion_no[${val}][3]" class="form-control" type="text">
                            </div>

                            <div class="col-md-3 mt-3">
                                <label for="">Mark</label>
                                <input name="creQuestion_mark[${val}][3]" class="form-control" type="number">
                            </div>
                            <div class="col-md-8 mt-3">
                                <label for="">D</label>
                                <input name="creQuestion_no[${val}][4]" class="form-control" type="text">
                            </div>

                            <div class="col-md-3 mt-3">
                                <label for="">Mark</label>
                                <input name="creQuestion_mark[${val}][4]" class="form-control" type="number">
                            </div>

                            <div class="col-md-1" >
                                <button type="button" class="btn btn-danger remove" style="margin-top: 40px; margin-left: 27px;">-</button>
                            </div>
                        </div>
                    `);
                } else if (type == "MCQ") {
                    $("#mcqapeandField").append(`
                        <div class="row">
                            <div class="col-md-11 mt-3">
                                <textarea name="mcqQuestions[${val}]" id="ckeditor${val}" ></textarea>
                            </div>
                            <div class="col-md-1" >
                                <button type="button" class="btn btn-danger remove" style="margin-top: 16px; margin-left: 27px;">-</button>
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="">A</label>
                                <input name="mcqQuestion_no[${val}][1]" class="form-control" type="text">
                            </div>
        
                            <div class="col-md-6 mt-3">
                                <label for="">B</label>
                                <input name="mcqQuestion_no[${val}][2]" class="form-control" type="text">
                            </div>
        
                            <div class="col-md-6 mt-3">
                                <label for="">C</label>
                                <input name="mcqQuestion_no[${val}][3]" class="form-control" type="text">
                            </div>
        
                            <div class="col-md-6 mt-3">
                                <label for="">D</label>
                                <input name="mcqQuestion_no[${val}][4]" class="form-control" type="text">
                            </div>
                            
                        </div>
                    `);
                }

                CKEDITOR.replace('ckeditor' + val, {
                    filebrowserUploadUrl: "{{ route('ckeditor.image.upload', ['_token' => csrf_token()]) }}",
                    filebrowserUploadMethod: 'form'
                });

                $(this).attr('data-count', val);
            });

            // $('.editor').each((k,v) => {
            //     CKEDITOR.replace($(v).attr('id'), {
            //         filebrowserUploadUrl: "{{ route('ckeditor.image.upload', ['_token' => csrf_token()]) }}",
            //         filebrowserUploadMethod: 'form'
            //     });
            // });

            $.each($('.editor'), function(key, value) {
                CKEDITOR.replace(value, {
                    filebrowserUploadUrl: "{{ route('ckeditor.image.upload', ['_token' => csrf_token()]) }}",
                    filebrowserUploadMethod: 'form'
                });
            });
        });

        $(document).on('click', '.remove', function(e) {
            e.preventDefault();
            $(this).closest('.row').remove();
        });
    </script>
@endpush
