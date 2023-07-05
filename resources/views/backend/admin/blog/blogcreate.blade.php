@extends('layouts.master')
<script src="https://cdn.ckeditor.com/ckeditor5/38.0.1/classic/ckeditor.js"></script>

@section('content')

<div class="container mt-5">
    <div class="row  border-bottom white-bg dashboard-header">
        <div class="col-md-12">

            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-md-10">
                    <h2>Blog</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.html">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Blog</strong>
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
                                        <h3 class="m-t-none m-b">Blog Create</h3>
                                        @if(!isset($blogEdit))
                                        <form role="form" action="{{route('blog.create.post')}}" method="POST" enctype="multipart/form-data">
                                            @csrf

                                            <div class="form-group">
                                                <label>Title</label>
                                                <input type="text" name="title" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Image</label>
                                                <input type="file" name="image" class="form-control">
                                            </div>


                                            <div class="form-group">
                                                <label for="inputMessage">Content</label>

                                                <textarea class="form-control" id="content" name="content" rows="3"></textarea>
                                                @error('content')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror

                                            </div>

                                            <div>
                                                <button class="btn btn-sm btn-primary float-right m-t-n-xs" type="submit">
                                                    <strong>Create</strong>
                                                </button>
                                            </div>
                                        </form>
                                        @else
                                        <form role="form" action="{{route('blog.edit.post',$blogEdit->id)}}" method="POST" enctype="multipart/form-data">
                                            @csrf

                                            <div class="form-group">
                                                <label>Title</label>
                                                <input type="text" name="title" value="{{$blogEdit->title}}" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Image</label>
                                                <input type="file" name="image" class="form-control">
                                                <img style="margin-left: 5px;" src="{{ asset($blogEdit->image ??'d/no-img.jpg') }}" alt="" width="100">

                                            </div>

                                             <div class="form-group">
                                                <label>Content</label>
                                                <input type="text"  name="content" value="{{$blogEdit->content}}" class="form-control">
                                            </div>


                                            <div>
                                                <button class="btn btn-sm btn-primary float-right m-t-n-xs" type="submit">
                                                    <strong>Update</strong>
                                                </button>
                                            </div>
                                        </form>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('editor1');
    </script>