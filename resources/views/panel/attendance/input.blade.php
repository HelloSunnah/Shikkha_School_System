@extends('layouts.school.master')

@section('content')
    <!--start content-->
    <main class="page-content">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="border p-3 rounded">
                            <h6 class="mb-0 text-uppercase">{{__('app.Student')}} {{__('app.search')}}</h6>
                            <hr/>
                            <form class="row g-3" method="get" action="">
                                {{-- @csrf --}}
                                <div class="col-md-12">
                                    @include('frontend.layouts.message')
                                </div>
                                <div class="col-md-2">

                                    <label class="form-label">{{__('app.Class')}}</label>
                                    <select class="form-control mb-3 js-select" name="class_id" id="class_id" onchange="loadSection()">
                                        <option value="" selected>Select One</option>
                                        @foreach($class as $data)
                                            <option value="{{$data->id}}" @isset(request()->class_id) @if(request()->class_id == $data->id) selected @endif @endisset>{{$data->class_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">{{__('app.Section')}}</label>
                                    <select class="form-control js-select mb-3" id="section_id" name="section_id" onchange="loadClass()">
                                        <option value="" selected>Select Class First</option>
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label">{{__('app.Shift')}}</label>
                                    <select class="form-control js-select mb-3" id="shift_id" name="shift_id">
                                        <option value="" selected>Select one</option>
                                        <option value="1" @isset(request()->class_id) @if(request()->class_id == 1) selected @endif @endisset>Morning</option>
                                        <option value="2" @isset(request()->class_id) @if(request()->class_id == 2) selected @endif @endisset>Day</option>
                                        <option value="3" @isset(request()->class_id) @if(request()->class_id == 3) selected @endif @endisset>Evening</option>
                                    </select>
                                </div>

                                <div class="col-2" id="group-select">
                                    {{-- <label class="form-label">Group Name</label>
                                    <select class="form-control mb-3 js-select" id="group_id" name="group_id">
                                        <option selected>Select one</option>
                                    </select> --}}
                                </div> 

                                <div class="col-md-2">
                                    <label class="form-label"></label>
                                    <div class="d-grid">
                                       <button title="{{__('app.Search')}}" type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search"></i>{{__('app.Search')}}</button>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label"></label>
                                    <div class="d-grid">
                                        <button title="{{__('app.Tutorial')}}" type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="lni lni-youtube"></i>{{__('app.Tutorial')}}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--end row-->

        <div class="row">
            <div class="col-xl-12">

                <div class="card">
                    <div class="card-body">
                            <h6 class="mb-0 text-uppercase">{{__('app.Student')}} {{__('app.List')}}</h6>
                            <hr/>
                            
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                <tr>
                                    <th>{{__('app.RollNumber')}}</th>
                                    <th>{{__('app.Student')}}</th>
                                    <th>{{__('app.Attendance')}}</th>
                                    <th>{{__('app.Class')}}</th>
                                    <th>{{__('app.Section')}}</th>
                                    <th>{{__('app.Shift')}}</th>
                                    <th>{{__('app.Group')}}</th>
                                    <th>{{__('app.PhoneNumber')}}</th>
                                    <th>{{__('app.Action')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $key => $data)
                                    <tr id="student_ids{{$data->id}}">
                                        <td>{{$data->roll_number}}</td>
                                        <td><div class="d-flex align-items-center gap-3 cursor-pointer">
                                                @if(File::exists($data->image))
                                                <img src="{{asset($data->image)}}" class="rounded-circle" width="44" height="44" alt="">
                                                @else
                                                <img src="{{asset('d/no-img.jpg')}}" class="rounded-circle" width="44" height="44" alt="">
                                                @endif
                                                {{-- <img src="{{asset($data->image)}}" class="rounded-circle" width="44" height="44" alt=""> --}}
                                                <a class="text-decoration-none" href="{{route('student.singleShow',$data->id)}}">
                                                    <p class="mb-0">{{ strtoupper($data->name)}}</p>
                                                </a>
                                            </div></td>
                                            <td>
                                                Working Days: <span id="workingDays{{$data->id}}">{{getWorkingDays(Auth::id(), $data->id)}}</span> <br>
                                                Present: <span id="presentDays{{$data->id}}">{{getPresentDays(Auth::id(), $data->id)}}</span> <br>
                                                Absent: <span id="absentDays{{$data->id}}">{{getAbsentDays(Auth::id(), $data->id)}}</span> <br>
                                            </td>
                                            <td>{{isset(getClassName($data->class_id)->class_name) ? getClassName($data->class_id)->class_name : 'NO'}}</td>
                                        <td>{{isset(getSectionName($data->section_id)->section_name) ? getSectionName($data->section_id)->section_name : 'NO'}}</td>
                                        <td>@if ($data->shift == 1)Morning
                                            @elseif ($data->shift == 2) Day
                                            @else Evening
                                            @endif
                                        </td>
                                        <td>
                                            @if($data->group_id == 1) Science
                                            @elseif ($data->group_id == 2) Commerce
                                            @elseif ($data->group_id == 3) Humanities
                                            @else 
                                            --
                                            @endif
                                        </td>
                                        <td>{{$data->phone}}</td>
                                        
                                        <td>
                                            <button onclick="ModalForm('{{$data->id}}')" class="btn-sm btn-primary"><i class="bi bi-pen"></i></button>
                                        </td>
                                    </tr>
                                    
                                @endforeach
                                </tbody>

                            </table>
                            {!!$users->links()!!}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php
    $tutorialShow = getTutorial('student-show');
    ?>
    @include('frontend.partials.tutorial')

    <div class="modal fade" id="modalBox">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="post" id="inputAttendanceForm">
                    @csrf
                    <input type="hidden" name="studentId" id="studentId">

                    <div class="modal-body p-5">

                        <div class="form-group mb-3">
                            <label class="fw-bolder">Select Term</label>
                            <select name="term_id" class="form-control" required>
                                @foreach ($terms as $term)
                                    <option value="{{$term->id}}">{{$term->title}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label class="fw-bolder">Working Days</label>
                            <input type="number" class="form-control" name="working_days" id="working_days" value="{{getWorkingDays(Auth::id())}}" required/>
                        </div>

                        <div class="form-group mb-3">
                            <label class="fw-bolder">Present</label>
                            <input type="number" class="form-control" name="present" id="present" onkeyup="autoFilled()" required/>
                        </div>

                        <div class="form-group mb-3">
                            <label class="fw-bolder">Absent</label>
                            <input type="number" class="form-control" name="absent" id="absent" required/>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-outline-primary">Save</button>
                            <button onclick="event.preventDefault()" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script>

        let autoFilled = () => {
            let present = $("#present").val();
            let workingDays = $("#working_days").val();

            let absent = workingDays - present;

            $("#absent").val(absent);
        }


        let ModalForm = (id) => {
            $("#studentId").val(id)

            $.ajax({
                url: "{{route('input.attendance.get')}}",
                type: "GET",
                data: {
                    studentId: id,
                    classId: ''
                },
                beforeSend: () => {

                },
                success: (resp) => {
                    $("#present").val(resp.data.present);
                    $("#absent").val(resp.data.absent);
                    $("#working_days").val(resp.data.working_days);
                    $("#modalBox").modal('show');
                },
                error: (error) => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: error.responseJSON.message,
                    });
                }
            });
        }

        $("#inputAttendanceForm").submit((e) => {
            e.preventDefault();

            $.ajax({
                "url" : "{{route('input.attendance.save')}}",
                "type"  : "POST",
                "data"  : $("#inputAttendanceForm").serialize(),
                "beforeSend" : () => {
                    $("#buttonForm").html(`<button class="btn btn-outline-primary" type="button" disabled>
                                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                            Saving ...
                                        </button>`);
                },
                "success"   : (resp) => {
                    $("#buttonForm").html(`<button class="btn btn-outline-primary">Save</button>`);
                    $("#inputAttendanceForm").trigger("reset");
                    $("#modalBox").modal('hide');

                    $("#workingDays"+resp.data.studentId).text(resp.data.working_days);
                    $("#presentDays"+resp.data.studentId).text(resp.data.present);
                    $("#absentDays"+resp.data.studentId).text(resp.data.absent);

                    Swal.fire('Great!','Record updated successfully','success');
                },
                "error" : (error) => {
                    $("#buttonForm").html(`<button class="btn btn-outline-primary">Save</button>`);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: error.responseJSON.message,
                    });
                }
            })
        })

        function loadSection() {
            let class_id = $("#class_id").val();            
             let groupElement = `<label class="form-label">Group</label>
             <select class="form-control mb-3 js-select" id="group_id" name="group_id">
                                    <option value=" " selected>Select one</option>
                                    <option value="1" > Science </option>
                                    <option value="2" > commerce </option>
                                    <option value="3" > Humanities </option>
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
                    
                    if(response.group == 1)
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

    </script>
@endpush
