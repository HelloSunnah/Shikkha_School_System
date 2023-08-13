@extends('layouts.master')
<script src="https://cdn.ckeditor.com/ckeditor5/38.0.1/classic/ckeditor.js"></script>
@section('content')
<div class="container mt-5">
    <div class="row  border-bottom white-bg dashboard-header">
        <div class="col-md-12">
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-md-10">
                    <h2>Support Department</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.html">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Support</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-md-2">
                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox ">
                            <div class="ibox-content">

                                <div class="row justify-content-center">
                                    <div class="col-md-12 b-r">
                                        <h3 class="m-t-none m-b">Support Department Create</h3>
                                        <form role="form" action="{{route('support.create.post')}}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label>Department</label>
                                                <input type="text" name="department" class="form-control">
                                            </div>
                                    </div>
                                    <div>
                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs" style="margin-left: 800px;" type="submit">
                                            <strong>Create</strong>
                                        </button>
                                    </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <center>
                    <div style="width: 800px;" class="tab-pane" id="">

                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>{{__('app.department')}}</th>
                                    <th>{{__('app.action')}}</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dept as $data)
                                <tr>
                                    <td>{{$data->department}}</td>
                                    <td>
                                        <a href="javascript::" onclick="if(confirm('Are your sure? Do you want to delete?')){ location.replace('{{ route('support.dept.delete', $data->id) }}') }" class="btn btn-danger"><i class="bi bi-trash3"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </center>

            </div>
</div>
</div>
@endsection