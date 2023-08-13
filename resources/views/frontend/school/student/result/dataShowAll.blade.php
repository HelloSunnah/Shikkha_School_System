@extends('layouts.school.master')
@section('content')
<style>
    .list-group-item-action.active{
        background-color: #7500a7 !important;
        border-color: #7500a7
    }
    </style>
    <main class="page-content">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row">
            <div class="col-xl-12">
                <div class="">
                    <div class=" pt-4">
                        <div class="row">
                            <div class="col-md-2">
                                <h4 style="padding-left:22px;padding-top:10px;padding-bottom:10px;background-color:rgb(255, 255, 255)"><strong>{{__('app.Subject')}}</strong></h4>
                                <div class="list-group" id="list-tab" role="tablist">
                                    @foreach ($subjectName as $key => $tabName)
                                        <a class="list-group-item list-group-item-action {{ $key == 0 ? 'active' : '' }}"
                                            id="list-home-list" data-bs-toggle="list" href="#list-home{{ $tabName->id }}"
                                            role="tab" aria-controls="list-home">{{ $tabName->subject_name }}</a>
                                    @endforeach
                                </div>
                            </div>
                            
                            <div class="col-md-10">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="tab-content" id="nav-tabContent">
                                            @foreach ($subjectName as $key => $tabName)
                                                @php
                                                   $dataShow =  getStudent($class_id, $section_id, $tabName->group_id, $tabName->subject_code);
                                                @endphp
                                                
                                                <div class="tab-pane fade {{ $key == 0 ? 'show active' : '' }}"
                                                    id="list-home{{ $tabName->id }}" role="tabpanel"
                                                    aria-labelledby="list-home-list">
                                                    <div class="card">
                                                        <form method="post" action="{{ route('result.create.post') }}"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="card-body">
                                                                <div class="table-responsive" id="aaa">
                                                                    <table id="example" class="table table-striped table-bordered"
                                                                        style="width:100%">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Roll</th>
                                                                                <th>Student Name</th>
                                                                                @foreach ($markTypes as $markType)
                                                                                    <th style="text-align: center;">
                                                                                        <div class="row">
                                                                                            <div class="col-md-4">
                                                                                                <label
                                                                                                    for="">{{ $markType->mark_type == 'Class_Test' ? 'Class Test' : $markType->mark_type }}</label>
                                                                                            </div>
                                                                                        </div>
                                                                                    </th>
                                                                                @endforeach
                                                                                <th>Total</th>
                                                                                <th>Grade</th>
                                                                                <th>GPA</th>
                                                                                <th>Action</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            
                                                                            @if (count($markTypes) > 0)
                                                                                @foreach ($dataShow as $key => $data)
                                                                                    <tr id="result{{ $data->id }}">
                                                                                        <td>{{ $data->roll_number }}</td> 
                                                                                        <td>
                                                                                            <div class="cursor-pointer">
                                                                                                @if ($data->image != null && file_exists($data->image))
                                                                                                    <img src="{{ asset($data->image) }}"
                                                                                                        class="rounded-circle"
                                                                                                        width="44"
                                                                                                        height="44"
                                                                                                        alt=" "> <br>
                                                                                                @else
                                                                                                    @if ($data->gender == 'Female')
                                                                                                        <img src="{{ asset('d/no-img-female.png') }}"
                                                                                                            class="rounded-circle"
                                                                                                            width="44"
                                                                                                            height="44"
                                                                                                            alt=" "> <br>
                                                                                                    @else
                                                                                                        <img src="{{ asset('d/no-img.png') }}"
                                                                                                            class="rounded-circle"
                                                                                                            width="44"
                                                                                                            height="44"
                                                                                                            alt=" "> <br>
                                                                                                    @endif
                                                                                                @endif
                                                                                                <div class="">
                                                                                                    <p class="mb-0">
                                                                                                        {{ $data->name }}
                                                                                                    </p>
                                                                                                </div>
                                                                                            </div>
                                                                                        </td>
                                                                                        <?php
                                                                                            $resultHaveorNot = getResultHaveorNot($data->id, $tabName->id, $termName->id);
                                                                                            $resultHaveorNotById = getResultHaveorNotById($data->id, $tabName->id, $termName->id);
                                                                                            $subjectTotalMark = 0;
                                                                                        ?>
                                                                                        <input type="hidden" class="form-control"
                                                                                            name="student_id[]"
                                                                                            value="{{ $data->id }}">
                                                                                        <input type="hidden" class="form-control"
                                                                                            name="student_roll_number[]"
                                                                                            value="{{ $data->roll_number }}">
                                                                                        <input type="hidden" class="form-control"
                                                                                            name="subject_id"
                                                                                            value="{{ $tabName->id }}">
                                                                                        <input type="hidden" class="form-control"
                                                                                            name="term_id"
                                                                                            value="{{ $termName->id }}">
                                                                                        <input type="hidden" class="form-control"
                                                                                            name="class_id"
                                                                                            value="{{ $data->class_id }}">
                                                                                        <input type="hidden" class="form-control"
                                                                                            name="section_id"
                                                                                            value="{{ $section_id }}">

                                                                                        @foreach ($markTypes as $markType)
                                                                                            <td>
                                                                                                <div class="col-md-12">
                                                                                                    <input type="number"
                                                                                                        step="0.01"
                                                                                                        class="form-control input-mark{{ $data->id }}{{ $tabName->id }}"
                                                                                                        onkeyup="markValidation('{{ $data->id }}', '{{ $tabName->id }}', '{{ subjectMark($termName->id, $data->class_id, $tabName->id) }}');"
                                                                                                        name="{{ $markType->mark_type }}[]"
                                                                                                        value="{{ getResultMarks($data->id, $tabName->id, $termName->id, $markType->mark_type) == null ? ' ' : getResultMarks($data->id, $tabName->id, $termName->id, $markType->mark_type) }}">
                                                                                                </div>
                                                                                            </td>
                                                                                            @php
                                                                                                $subjectTotalMark += getResultMarks($data->id, $tabName->id, $termName->id, $markType->mark_type);
                                                                                            @endphp
                                                                                        @endforeach

                                                                                        @php
                                                                                            // $totalMark = ($subjectTotalMark * 100) / $termName->total_mark;
                                                                                            if(subjectMark($termName->id, $data->class_id, $tabName->id) == 350) {
                                                                                                $modal = '<div id="myModal" class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                                                                                <div class="modal-dialog modal-dialog-centered">
                                                                                                                    <div class="modal-content">
                                                                                                                        <div class="modal-header">
                                                                                                                            <h5 class="modal-title text-warning">Attention: Save Subject Marks!!</h5>
                                                                                                                        </div>
                                                                                                                        <div class="modal-body">
                                                                                                                            <h3 class="text-info">Please ensure to save the <br> subject marks before input result.</h3>
                                                                                                                        </div>
                                                                                                                        <div class="modal-footer">
                                                                                                                            <button id="subjectMark" class="btn btn-secondary">Input Mark</button>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>';
                                                                                                echo $modal;
                                                                                            }
                                                                                            
                                                                                            $current_pass_mark = ($termName->pass_mark / 100) * subjectMark($termName->id, $data->class_id, $tabName->id);
                                                                                            $pass_mark  = ($current_pass_mark * 100) / subjectMark($termName->id, $data->class_id, $tabName->id);
                                                                                            $totalMark = ($subjectTotalMark * 100) / subjectMark($termName->id, $data->class_id, $tabName->id);

                                                                                            $grading_scale = [
                                                                                                'A+' => 80,
                                                                                                'A' => 70,
                                                                                                'A-' => 60,
                                                                                                'B' => 50,
                                                                                                'C' => 40,
                                                                                                'D' => 33,
                                                                                                'F' => 0,
                                                                                            ];

                                                                                            $grading_point = [
                                                                                                '5' => 80,
                                                                                                '4' => 70,
                                                                                                '3.5' => 60,
                                                                                                '3' => 50,
                                                                                                '2' => 40,
                                                                                                '1' => 33,
                                                                                                '0' => 0,
                                                                                            ];

                                                                                            $markInvalid = $totalMark > 100 || $totalMark < 0;
                                                                                            if ($markInvalid) {
                                                                                                $invalidMsg = 'Mark is invalid';
                                                                                            } else {
                                                                                                if($totalMark < $pass_mark){
                                                                                                    $final_grade = "F";
                                                                                                } else{
                                                                                                    foreach ($grading_scale as $grade => $minimum_score) {
                                                                                                        if ($totalMark >= $minimum_score) {
                                                                                                            $final_grade = $grade;
                                                                                                            break;
                                                                                                        }
                                                                                                    }
                                                                                                }

                                                                                                if($totalMark < $pass_mark){
                                                                                                    $gpa_point = "0";
                                                                                                } else{
                                                                                                    foreach ($grading_point as $gpa => $minimum_score) {
                                                                                                        if ($totalMark >= $minimum_score) {
                                                                                                            $gpa_point = $gpa;
                                                                                                            break;
                                                                                                        }
                                                                                                    }
                                                                                                }
                                                                                            }
                                                                                        @endphp

                                                                                        <td>
                                                                                            <h5 style="margin-top: 5px;">
                                                                                                {{ $subjectTotalMark }}</h5>
                                                                                        </td>
                                                                                        <td>
                                                                                            <h5 style="margin-top: 5px;">
                                                                                                {{ $markInvalid ? $invalidMsg : $final_grade }}
                                                                                            </h5>
                                                                                        </td>
                                                                                        <td>
                                                                                            <h5 style="margin-top: 5px;">
                                                                                                {{ $markInvalid ? $invalidMsg : $gpa_point }}
                                                                                            </h5>
                                                                                        </td>

                                                                                        <td>
                                                                                            <button onclick="studentResultAbsent(event, '{{ $data->id }}', '{{ $data->roll_number }}', '{{ $data->class_id }}', '{{ $section_id }}', '{{ $tabName->id }}', '{{ $termName->id }}');" class="btn btn-primary btn-sm">Absent</button>
                                                                                        </td>
                                                                                    </tr>
                                                                                @endforeach
                                                                            @else
                                                                                <h4 class="text-center text-danger">First create
                                                                                    mark types
                                                                                    in this subject</h4>
                                                                            @endif
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex justify-content-between mb-2" role="group" aria-label="First group">
                                                                <a href="{{ route("result.school.admin.create.show.all") }}" class="btn btn-info text-white ms-2">Back</a>
                                                                <button type="submit" id="resultUpdate{{ $tabName->id }}" class="btn btn-success primary-btn me-2">Update</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@push('js')
<script>
    $(document).ready(function(){
        $("#myModal").modal('show');
    });

    $(document).ready(function(){
        $("#subjectMark").click(function (e) {
            e.preventDefault();
            var term_id = $("input[name='term_id']").val();

            var url = "/school/student/result/mark/" + term_id;
            window.location.replace(url);
        });
    });
</script>

<script>
    function studentResultAbsent(event, student_id, student_roll_number, class_id, section_id, subject_id, term_id)
    {
        event.preventDefault();
        var data = {
            'student_id'    : student_id,
            'roll_number'   : student_roll_number,
            'class_id'      : class_id,
            'section_id'    : section_id,
            'subject_id'    : subject_id,
            'term_id'       : term_id
        };

        $.ajax({
            type: "get",
            url: "{{ route('student.result.absent') }}",
            data: data,
            success: function (response) {
                if(response.status == 'success') {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'This student is absent in this subject.',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            }
        });
    }
</script>

<script>
     function markValidation(studentId, subjectId, subjectMark) 
    {   
        var total = [];
        var studentId = ".input-mark" + studentId.toString() + subjectId.toString();

        $(studentId).each(function() {
            var mark =  parseFloat($(this).val());
            total.push(mark);
        });

        let filteredArray = total.filter(function(num) {
            return !isNaN(num);
        });

        var sum = 0;
        for (let i = 0; i < filteredArray.length; i++) {
            sum += filteredArray[i];
        }
        
        if(sum > subjectMark || sum < 0) {
            $(`#resultUpdate${subjectId}`).addClass('disabled');
            Swal.fire({
                icon: 'info',
                title: 'Please kindly input the accurate mark for your record.',
                text: `The mark obtained, ${sum}, exceeds the maximum and minimum possible score of ${subjectMark} and  0.`,
            })
        }else{
            $(`#resultUpdate${subjectId}`).removeClass('disabled');
        }
    }
</script>

@endpush
