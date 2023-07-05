@extends('layouts.school.master')

@section('content')
    <!--start content-->
    <main class="page-content">
        <div class="row">
            <div class="col-xl-6 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <div class="border p-3 rounded">
                            <h6 class="mb-0 text-uppercase"> {{__('app.Assign')}} {{__('app.Class')}} {{__('app.Teacher')}}</h6>
                            <hr/>
                            <form class="row g-3" method="post" action="{{route('assign.teacher.create.show.post')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-12">
                                    @include('frontend.layouts.message')
                                </div>
                                <div class="col-12">
                                    <label for="Select Class">{{__('app.select')}} {{__('app.class')}}</label>
                                    <select class="form-control mb-3 js-select" aria-label="Default select example" name="class_id" id="class_id" onchange="loadSection()" required>
                                        <option value="" selected>Class Name</option>
                                        @foreach($class as $data)
                                            <option value="{{$data->id}}">{{$data->class_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">{{__('app.Section')}} {{__('app.Name')}}</label>
                                    <select class="form-control mb-3 js-select" id="section_id" name="section_id" onchange="loadGroup()" required>
                                        <option selected>Select one</option>
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">{{__('app.Subject')}}</label>
                                    <select class="form-control mb-3 js-select" id="subject_id" name="subject_id" onchange="loadTeacher()" required>
                                        <option value="" selected >Select Subject</option>
                                        @foreach ($subjects as $item)
                                            <option value="{{ $item->id }}">{{$item->subject_name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">{{__('app.Teacher')}}</label>
                                    <select class="form-control mb-3 js-select" name="teacher_id" id="teacher_id" required>
                                        <option value=" " selected >Select Teacher</option>
                                        @foreach ($teachers as $teacher )
                                            <option value="{{ $teacher->id }}" >{{ $teacher->full_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12" id="group-select">
                                    {{-- <label class="form-label">Group Name</label>
                                    <select class="form-control mb-3 js-select" id="group_id" name="group_id">
                                        <option selected>Select one</option>
                                    </select> --}}
                                </div>
                                <div class="col-12">
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary">{{__('app.Assign')}}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>



            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                <tr>
                                    <th>{{__('app.nong')}}</th>
                                    <th>{{__('app.Subject')}} {{__('app.Name')}}</th>
                                    <th>{{__('app.Teacher')}} {{__('app.Name')}}</th>
                                    <th>{{__('app.Class')}} {{__('app.Name')}}</th>
                                    <th>{{__('app.Section')}} {{__('app.Name')}}</th>
                                    {{-- <th>Group Name</th> --}}
                                    {{-- <th>Class Teacher</th> --}}
                                    <th>{{__('app.Online')}} {{__('app.Class')}}</th>
                                    {{-- <th>{{__('app.Action')}}</th> --}}
                                    <th>{{__('app.Action')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach(\App\Models\AssignTeacher::where('school_id',auth()->id())->get() as $key => $data)
                                        <tr>
                                            <td>{{$key++ +1}}</td>
                                            <td>{{\App\Models\Subject::find($data->subject_id)->subject_name}}</td>
                                            {{-- <td>{{isset(getSubjectName($data->subject_id)->subject_name) ? getSubjectName($data->subject_id)->subject_name : 'NO'}}</td> --}}
                                            <td>{{isset(getTeacherName($data->teacher_id)->full_name) ? strtoupper(getTeacherName($data->teacher_id)->full_name) : 'NO'}}</td>
                                            <td>{{isset(getClassName($data->class_id)->class_name) ? getClassName($data->class_id)->class_name : 'NO'}}</td>
                                            <td>{{isset(getSectionName($data->section_id)->section_name) ? getSectionName($data->section_id)->section_name : 'NO'}}</td>
                                            {{-- <td>{{isset(getGroupname($data->group_id)->group_name) ? getGroupname($data->group_id)->group_name : 'NO'}}</td> --}}
                                            {{-- <td>{{($data->class_teacher == 1) ? 'Yes' : 'No'}}</td> --}}
                                            <td><a href="{{route('online.class.join',$data->teacher_id)}}" class="btn btn-outline-success">{{__('app.Join')}} {{__('app.Class')}}</a> </td>

                                            {{-- <td><a href="{{route('edit.assign.teacher',$data->id)}}" class="btn btn-success">{{__('app.Edit')}}</a> --}}
                                            </td>
                                            <td>
                                                <div class="btn-group mr-2" role="group" aria-label="First group">
                                                {{-- <a  href="{{route('subject.edit',$data->id)}}" class="btn btn-success">Edit</a>
                                                <a href="{{route('assign.subject.delete',['id'=>$data->id])}}" class="btn btn-danger">Delete</a> --}}
                                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{$data->id}}">{{__('app.Delete')}}</button>
                                                </div>
                                            </td>




                                            
                                            <div class="modal fade" id="deleteModal{{$data->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">{{__('app.Delete')}} {{__('app.Class')}}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form method="get" action="{{route('assign.subject.delete',['id'=>$data->id])}}">
                                                            <div class="modal-body">
                                                                {{__('app.surecall')}} ?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">{{__('app.no')}}</button>
                                                                <button type="submit" class="btn btn-primary">{{__('app.yes')}}</button>
                                                            </div>
                                                        </form>

                                                    </div>
                                                </div>
                                            </div>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
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
        function loadSection() {
            let class_id = $("#class_id").val();
            // let groupElement = `<label class="form-label">Group Name</label>
            //                     <select class="form-select mb-3" id="group_id" name="group_id">
            //                         <option selected>Select one</option>
            //                     </select>`;

            $.ajax({
                url:'{{route('admin.show.section')}}',
                method:'POST',
                data:{
                    '_token':'{{csrf_token()}}',
                    class_id:class_id
                },

                success: function (response) {
                    $('#section_id').html(response.html);

                    // if(response.class > 8)
                    // {
                    //     $("#group-select").html(groupElement);
                    // }
                    // else
                    // {
                    //     $("#group-select").html('');
                    // }
                }
            });

            $.ajax({
                url:'{{route('admin.show.subjects')}}',
                method:'POST',
                data:{
                    '_token':'{{csrf_token()}}',
                    class_id:class_id
                },

                success: function (response) {
                    $('#subject_id').html(response.html);

                }
            });

        }

        // function loadGroup() {
        //     let class_id = $("#class_id").val();
        //     let section_id = $("#section_id").val();
        //     console.log(section_id,'sports-section');
        //     $.ajax({
        //         url:'{{route('admin.show.group')}}',
        //         method:'POST',
        //         data:{
        //             '_token':'{{csrf_token()}}',
        //             class_id:class_id,
        //             section_id:section_id,
        //         },

        //         success: function (response) {
        //             $('#group_id').html(response);
        //         }
        //     });

        // }


        function loadTeacher() {
            let subjectId = $("#subject_id").val();
            // alert(subjectId);

            $.ajax({
                url:'{{route('subject.teacher.show')}}',
                method:'POST',
                data:{
                    '_token':'{{csrf_token()}}',
                    subject_id:subjectId,
                },

                success: function (response) {
                    $('#teacher_id').html(response);
                }
            });

        }

    </script>
@endpush
