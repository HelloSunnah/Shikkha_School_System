@extends('layouts.school.master')
<style>
    .underline {
        text-decoration: underline;
    }

    .row {
        margin-bottom: 10px;
    }

    .table-container {
        width: 800px;
        margin: 0 auto;
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 10px;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table th,
    .table td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .table th {
        background-color: #f2f2f2;
    }

    .table td:first-child {
        border-left: 1px solid #ddd;
    }

    .table td:last-child {
        border-right: 1px solid #ddd;
    }

    .box {
        width: 100%;
        padding: 10px;
        background-color: #f2f2f2;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
</style>
@section('content')
<main class="page-content">

    <section class="mt-3">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="row">
                    <div class="col-6">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Search" aria-label="Recipient's username" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button">Search</button>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h4>User List</h4>
                            <div class="table-container">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Unique Id</th>
                                            <th>Name </th>
                                            <th>Designation </th>
                                            <th>Role </th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($teacher as $key=>$data)
                                        <tr>
                                            <td>{{$data->unique_id}}</td>
                                            <td>{{$data->full_name}}</td>
                                            <td>{{$data->designation}}</td>
                                            <td>{{App\Models\Role::find($data->role)?->role}}</td>
                                            <td>

                                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#add{{$key}}">
                                                    <i class="bi bi-file-plus"></i>Add Role</button>
                                            </td>
                                            <!-- Modal for add -->
                                            <div class="modal fade" id="add{{$key}}" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel"> Add User Role </h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{route('assign.post',$data->id)}}" method="post">
                                                                @csrf
                                                                <div class="" style="background-color:#7100a7; margin-bottom:5px;color:white">

                                                                    <div class="row">
                                                                        <div class="col-4">
                                                                            <img class=" shadow-4-strong" style="margin-left:15px; margin-top:15px; border-radius:10px" src="{{ asset($data->image ?? 'd/no-img.jpg') }}" width="150px" alt="img not found">

                                                                        </div>

                                                                        <div class="col-8">
                                                                            <h6><strong>{{__('app.Name')}}:</strong> {{ $data->full_name }} </h6>
                                                                            <h6><strong>{{__('app.ID')}}:</strong> {{ $data->unique_id }} </h6>
                                                                            <h6><strong>{{__('app.Designation')}}:</strong> {{ $data->designation }} </h6>
                                                                            <h6><strong>{{__('app.Department')}}:</strong> {{ $data->department_name }} </h6>
                                                                            <div class="row">
                                                                                <div class="col-8">
                                                                                    <h6>Assign Role:</h6> <select class="form-control" id="role" name="role">
                                                                                        <option value="" selected>Select One</option>
                                                                                        @foreach($role as $rolee)
                                                                                        <option value="{{$rolee->id}}">{{$rolee->role}}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </div>


                                                                </div>

                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-primary sm">Save changes</button>
                                                                </div>

                                                            </form>
                                                        </div>
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

        </div>


    </section>

</main>
@endsection