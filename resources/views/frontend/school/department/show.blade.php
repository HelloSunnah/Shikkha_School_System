@extends('layouts.school.master')

@section('content')
    <!--start content-->
    <!--start content-->
    <main class="page-content">
        <div class="row">
            <div class="col-xl-12">
               <div class="card">
                   <div class="card-header py-3 bg-transparent">
                       <div class="d-sm-flex align-items-center">
                           <h5 class="mb-2 mb-sm-0">{{$classText}}</h5>
                           <div class="ms-auto">
                               <button type="button" class="btn btn-secondary" onclick="history.back()">Back</button>
                               <a href="{{route('department.create')}}" class="btn btn-primary">Department Create</a>
                               <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="lni lni-youtube"></i> Tutorial</button>
                           </div>
                       </div>
                   </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Class Name</th>
                                    <th>Active</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($class as $key => $data)
                                <tr>
                                    <td>{{$key++ +1}}</td>
                                    <td>{{$data->department_name}}</td>
                                    <td>{{($data->active == 1) ? 'ON' : 'OFF'}}</td>
                                    <td>
                                        <div class="btn-group mr-2" role="group" aria-label="First group">
                                            <a  href="{{route('department.edit',$data->id)}}" class="btn btn-primary">Edit</a>
{{--                                            <a href="{{route('department.delete',$data->id)}}" class="btn btn-danger">Delete</a>--}}
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{$key}}">Delete</button>

                                        </div>
                                    </td>
                                    <div class="modal fade" id="deleteModal{{$key}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Delete Class</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form method="get" action="{{route('department.delete',$data->id)}}">
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
    </main>
    <?php
    $tutorialShow = getTutorial('department-show');
    ?>
    @include('frontend.partials.tutorial')
@endsection
