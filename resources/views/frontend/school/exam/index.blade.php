@extends('layouts.school.master')

@push('css')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    
@endpush

@section('content')
    <!--start content-->
    <main class="page-content">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card" style="box-shadow:4px 3px 13px  .7px #deaaf7;border-radius:5px">
                    <div class="card-body">
                        <div class="border p-3 rounded">
                            
                            <div class="p-3 text-center">
                                <table class="table d-none" id="tableShow">
                                    <thead>
                                      <tr>
                                        <th scope="col">{{__('app.shift')}}</th>
                                        <th scope="col">{{__('app.class')}}</th>
                                        <th scope="col">{{__('app.t')}}</th>
                                        <th scope="col">{{__('app.subject')}}</th>
                                        <th scope="col">{{__('app.date')}}</th>
                                        <th scope="col">{{__('app.day')}}</th>
                                        <th scope="col">{{__('app.time')}}</th>
                                        <th scope="col">{{__('app.action')}}</th>
                                      </tr>
                                    </thead>
                                    <tbody id="show_routine">
                                          
                                    </tbody>
                                </table>
                            </div>
                            
                            <h3 class="mb-0 text-uppercase text-center">{{__('app.E1')}}</h3>
                            <hr/>
                            <div class="text-danger list">
                            </div>
                            <div class="col-md-12">
                                @include('frontend.layouts.message')
                            </div>
                            
                            <div class="col-12">
                                <div class="row">
                                    <div id="term_class">
                                        <div class="row">
                                            <div class="col-md">
                                                <label class="select-form">{{__('app.t')}}</label>
                                                <select class="form-control mb-3 js-select" aria-label="Default select example"  id="term_id" required>
                                                    <option selected="" value="">--{{__('app.select')}}--</option>
                                                    @foreach($terms as $term)
                                                        <option value="{{ $term->id }}" >{{ $term->term_name }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger text-error exam_term_error"></span>
                                            </div>

                                            <div class="col-md">
                                                <label class="select-form">{{__('app.shift')}}</label>
                                                <select class="form-control mb-3 js-select" id="shift_id" required>
                                                    <option selected="" value="">--{{__('app.select')}}--</option>
                                                    @foreach([1 => "Morning", 2=>"Day", 3=>"Evening"] as $key => $shift)
                                                        <option value="{{ $key }}" >{{ $shift }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger text-error exam_term_error"></span>
                                            </div>
                                            
                                            <div class="col-md" id="class">
                                                <label class="select-form">{{__('app.class')}}</label>
                                                <select class="form-control mb-3 js-select"aria-label="Default select example"  onchange="showExamRoutine()"  id="class_id"  required>
                                                    <option selected="" value="">--{{__('app.select')}}--</option>
                                                    @foreach($classes as $class)
                                                        <option value="{{ $class->id }}" >{{ $class->class_name }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger text-error class_id_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <form class="row g-3" id="formReset">

                                <div class="col-12 d-none" id="class2">
                                    <div class="row">

                                        <div class="col-md-6">
                                            <label>{{__('app.subject')}}</label>
                                            <select class="form-control mb-3 js-select" aria-label="Default select example" name="subject_name" id="subject_id"  required>
                                                <option selected="" value="">--{{__('app.select')}}--</option>
                                            </select>
                                            <span class="text-danger text-error subject_id_error"></span>
                                        </div>

                                        <div class="col-md-6">
                                            <label>{{__('app.date')}}</label>                                               
                                            <input type="text" id="datepicker" class="form-control" placeholder="YYYY-MM-DD"
                                                name="exam_date"  value="">
                                                
                                                <span class="text-danger text-error date_error"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="text-center">{{__('app.start_time')}} :</label>
                                            <div class="">
                                                <div class="mt-1">
                                                    <input type="time" name="start_time" class="form-control" id="start_time">
                                                </div>
                                            </div>
                                            <span class="text-danger text-error start_time_error"></span>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="text-center">{{__('app.end_time')}}:</label>
                                            <div class="">
                                                <div class="mt-1">
                                                    <input type="time" name="end_time" class="form-control" id="end_time">
                                                </div>
                                            </div>
                                            <span class="text-danger text-error end_time_error"></span>
                                        </div>
                                        
                                    </div>

                                </div>
                                <div class="col-12 py-4">
                                    <div class="d-grid">
                                        <button type="submit" id="save" onclick="hello();" class="btn btn-primary">{{__('app.Submit')}}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Modal Result Preview Start --}}
            <div class="modal fade" id="resultModal" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div style="text-align: center; line-height: 20px; margin-top: 25px; margin-bottom: 25px;">
                            <h1 style="font-size: 30px;">{{ Auth::user()->school_name }}</h1>
                            {{-- <h2 class="termName" style="font-size: 35px;">{{ $term->term_name }} Routine</h2> --}}
                            <h2 class="termName" style="font-size: 35px;"></h2>
                            {{-- <h1 class="className" style="font-size: 30px;">{{ $class->class_name }}</h1> --}}
                            <h1 class="className" style="font-size: 30px;"></h1>
                        </div>
                        <table class="text-center">
                            <thead style="background-color: #FFED86; height: 75px; font-size: 20px;">
                                <tr>
                                    <th>Subject</th>
                                    <th>{{__('app.date')}}</th>
                                    <th>Day</th>
                                    <th>Time</th>
                                </tr>
                            </thead>
                            <tbody id="resultDataWithModal" style="font-size: 20px;">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        {{-- Modal Result Preview End --}}
    </main>

@endsection

@push('js')

    {{-- <script src="https://code.jquery.com/jquery-3.6.0.js"></script> --}}
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


    {{-- Exam Routine Jquery code --}}
    <script>
        
        $(document).ready(function() {
            $("#class").on("change", function () {
                $("#term_class").hide();
                $("#class2").removeClass('d-none');
                $("#tableShow").removeClass('d-none');
                $(".text-error").empty();
            });

            // Get Subject with Ajax
            $("#class_id").on('change', function () {
                var class_id = $(this).val();
                $.ajax({
                    type: "GET",
                    url: "{{ url('/school/student/get/subjet/') }}/" + class_id,
                    datatype: "json",
                    success: function(data) {
                        // $("#subject_id").empty();
                        $.each(data, function (key, value) { 
                             $("#subject_id").append('<option value="'+value.id+'"> '+value.subject_name+' </option>');
                             
                        });
                    }
                });
            });

           //Store data in ExamRoutine Table with ajax  
            $("#save").on("click", function (e) {
                
                $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                        }
                    });
                e.preventDefault();
                var class_id = $("#class_id").val();
                var shift_id = $("#shift_id").val();
                var subject_id = $("#subject_id").val();
                var date = $("#datepicker").val();
                var start_time = $("#start_time").val();
                var end_time = $("#end_time").val();
                var exam_term = $("#term_id").val();
                
                $.ajax({
                    type: "POST",
                    url: "{{ url('school/student/store/exam/routine') }}",
                    datatype: "json",
                    data: {class_id: class_id, subject_id: subject_id, date: date, start_time: start_time, end_time: end_time, exam_term: exam_term, shift_id: shift_id},
                    beforeSend:function () {
                        $(".text-error").text('');
                    },
                    success: function (data) {
                        if(data.status == 'fail') {
                            $.each(data.error, function(key, value){
                                // $("#error").append(`<li>${value}</li>`)
                                // console.log(key, value[0])
                                $('.'+key+'_error').text(value[0]);
                            })
                        }
                        $("#show_routine").empty();
                        $("#formReset").trigger('reset');
                        showExamRoutine();
                        
                    }
                });
            });
               

        });

        //Show Exam Routine with ajax
        function showExamRoutine(e)
        {
            event.preventDefault();
            var class_id = $("#class_id").val();
            var term_id  = $("#term_id").val();
            var shift_id  = $("#shift_id").val();
            $.ajax({
                    type: "GET",
                    url: "{{ url('/school/student/get/routine/') }}/" + class_id +"/"+ term_id +"/"+ shift_id,
                    datatype: "json",
                    success: function(data) {
                        $("#show_routine").append(`
                            <tr class:"text-center">
                                <td colspan="6"> 
                                    <a href="{{ url('school/student/create/exam/routine/pdf/${class_id}/${term_id}') }}" class="btn btn-primary btn-sm" ><i class="fas fa-file-pdf"></i></a> 
                                      <a class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#resultModal"><i class="bi bi-eye-fill"></i></a> 
                                </td>
                            </tr> 
                        `);

                        var shift = "Day";

                        $.each(data, function (key, value) {
                            
                            if(value.shift_id == 1){
                                shift = "Morning";
                            }else if(value.shift_id == 3)
                            {
                                shift = "Evening";
                            }

                            $("#show_routine").prepend(`<tr>
                                    <td> <span class="badge bg-primary">${shift}</span> </td>
                                    <td> ${value.class.class_name} </td>
                                    <td> ${value.term.term_name} </td>
                                    <td> ${value.subject.subject_name} </td>
                                    <td> ${value.date} </td>
                                    <td> ${value.day} </td>
                                    <td> ${value.start_time} - ${value.end_time} </td>
                                    <td onclick="deleteExam(${value.id})">
                                        <button id="xmdlt" class="btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                    </td>
                                    
                                </tr>
                            `);
                            $("#resultDataWithModal").append(`
                                <tr style="height: 75px;">
                                    <td>${value.subject.subject_name}</td>
                                    <td>${value.date}</td>
                                    <td>${value.day}</td>
                                    <td>${value.start_time} - ${value.end_time}</td>
                                </tr>
                            `);
                        });

                        var term = data[0].term.term_name;
                        var cls = data[0].class.class_name;

                        $(".termName").append(`${term}`);
                        $(".className").append(`${cls} - (${shift})`);
                    }
                });
        }

        //Delete Exam Routine in Exam
        function deleteExam($id)
        {
            Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#7c00a7',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "GET",
                        url: "{{ url('/school/student/delete/exam/routine/') }}/" + $id,
                        datatype: "json",
                        success: function (data) {
                            $("#show_routine").empty();
                                showExamRoutine();
                            }
                    });
                    
                }
            });
        }
       
    </script>
    {{-- Exam Routine Jquery code --}}
    <script>
        @if(old('class_id'))
            loadSection();
        @endif

        @if (isset($studentEdit))
            loadSection();
        @endif

        function loadSection() {
            let class_id = $("#class_id").val();
            let groupElement = `<label class="form-label">Group Name</label>
                                <select class="form-control mb-3 js-select"  id="group_id" name="group_id">
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

        @if(old('section_id'))
            loadGroup();
        @endif

        @if (isset($studentEdit))
            loadGroup();
        @endif

        function loadGroup() {
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
                    // console.log(response);
                    $('#group_id').html(response);
                }
            });

        }

    </script>

@endpush