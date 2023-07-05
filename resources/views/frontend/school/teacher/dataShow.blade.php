@extends('layouts.school.master')

@section('content')
    <!--start content-->
    <main class="page-content">
        <div class="row">
            <div class="col-xl-6 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <div class="border p-3 rounded">
                            <h6 class="mb-0 text-uppercase">{{$teacherText}} Form</h6>
                            <hr/>
                                <form class="row g-3" method="post" action="{{route('assign.teacher.create.show.post.data')}}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="col-md-12">
                                        @include('frontend.layouts.message')
                                    </div>
                                    <div class="col-12">
                                        <div class="col-12">
                                            <label class="form-label">Subject Name</label>
                                            <select  class="form-control mb-3 js-select" aria-label="Default select example" name="subject_id" id="subject_id" required>
                                                <option value="" selected>Subject Name</option>
                                                @foreach($dataSubject as $data)
                                                    <option value="{{$data->id}}">{{$data->subject_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Teacher Name</label>
                                            <select  class="form-control mb-3 js-select" aria-label="Default select example" name="teacher_id" id="teacher_id" required>
                                                <option value="" selected>Teacher Name</option>
                                                @foreach($dataTeacher as $data)
                                                    <option value="{{$data->id}}">{{$data->full_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="input-group mb-3">
                                            <input type="hidden" class="form-control"   name="class_id" value="{{$class_id}}">
                                            <input type="hidden" class="form-control"  name="section_id" value="{{$section_id}}">
                                            <input type="hidden" class="form-control"   name="group_id" value="{{$group_id}}">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="gridCheck1" name="active" value="1">
                                            <label class="form-check-label" for="gridCheck1">
                                                Class Teacher
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">

                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table" style="width:100%">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Subject Name</th>
                                    <th>Teacher Name</th>
                                    <th>Class Name</th>
                                    <th>Section Name</th>
                                    <th>Group Name</th>
                                    <th>Class Teacher</th>
                                    <th>online Class</th>
                                    <th>Action</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($dataShow as $key => $data)
                                        <tr>
                                            <td>{{$key++ +1}}</td>
                                            <td>{{isset(getSubjectName($data->subject_id)->subject_name) ? getSubjectName($data->subject_id)->subject_name : 'NO'}}</td>
                                            <td>{{isset(getTeacherName($data->teacher_id)->full_name) ? getTeacherName($data->teacher_id)->full_name : 'NO'}}</td>
                                            <td>{{isset(getClassName($data->class_id)->class_name) ? getClassName($data->class_id)->class_name : 'NO'}}</td>
                                            <td>{{isset(getSectionName($data->section_id)->section_name) ? getSectionName($data->section_id)->section_name : 'NO'}}</td>
                                            <td>{{isset(getGroupname($data->group_id)->group_name) ? getGroupname($data->group_id)->group_name : 'NO'}}</td>
                                            <td>{{($data->class_teacher == 1) ? 'Yes' : 'No'}}</td>
                                            <td><a href="{{route('online.class.join',$data->teacher_id)}}" class="btn btn-outline-success">Join Class</a> </td>

                                            <td><a href="{{route('edit.assign.teacher',$data->id)}}" class="btn btn-success">Edit</a>
                                            </td>
                                            <td>
                                                <div class="btn-group mr-2" role="group" aria-label="First group">
                                                {{-- <a  href="{{route('subject.edit',$data->id)}}" class="btn btn-success">Edit</a>
                                                <a href="{{route('assign.subject.delete',['id'=>$data->id])}}" class="btn btn-danger">Delete</a> --}}
                                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{$data->id}}">Delete</button>
                                                </div>
                                            </td>
                                            <div class="modal fade" id="deleteModal{{$data->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Delete Class</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form method="get" action="{{route('assign.subject.delete',['id'=>$data->id])}}">
                                                            <div class="modal-body">
                                                                Are you Sure To Delete ?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button>
                                                                <button type="submit" class="btn btn-primary">Yes</button>
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

@endsection
