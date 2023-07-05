@extends('layouts.master')

@section('content')
    <div class="container mt-5">
        <div class="row  border-bottom white-bg dashboard-header">
            <div class="col-md-12">

                <div class="row wrapper border-bottom white-bg page-heading">
                    <div class="col-md-10">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin') }}">Admin</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <strong>Form</strong>
                            </li>
                        </ol>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('seo.tool') }}" class="btn btn-secondary">Back</a>
                    </div>
                </div>

                <div class="wrapper wrapper-content animated fadeInRight">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="ibox ">
                                <div class="ibox-content">

                                    <div class="row justify-content-center">
                                        <div class="col-md-6 b-r border">
                                            <center>
                                                <h2 class="m-t-none m-b">SEO input Form </h2>
                                            </center>
                                            @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                            @if (!isset($editseo))
                                                <form action="{{ route('SEO.create') }}" method="POST">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label>SEO Title</label>
                                                        <div class=" mb-3 ">
                                                            <input type="text" class="form-control input-sm"
                                                                name="title" required>
                                                                
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Keywords</label>
                                                        <div class=" mb-3 ">
                                                            <input type="text" class="form-control input-sm"
                                                                name="keyword" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Select Page</label>
                                                        <select name="page_no" id="" class="form-control js-select">
                                                            <option value="">Select One</option>
                                                            <option value="1">Home Page</option>
                                                            <option value="2">User Page</option>
                                                            <option value="3">Assignment Page</option>
                                                            <option value="4">Student Page</option>
                                                            <option value="5">SMS/ PayRoll Page</option>
                                                            <option value="6">Task Management Page</option>
                                                            <option value="7">Online Benefit</option>
                                                            <option value="8">Priceing Page</option>
                                                            <option value="9">Sign Up Otp Page</option>
                                                            <option value="10">Demo</option>
                                                            <option value="11">Blog</option>
                                                            <option value="12">Video</option>
                                                            <option value="13">Terms and Conditions</option>
                                                            <option value="14">Contact</option>
                                                            <option value="15">Online Admission</option>
                                                            <option value="16">Log in</option>
                                                            <option value="17">Sign up</option>
                                                            <option value="18">Acquisition Page</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Description</label>
                                                        <div class="input-group mb-3">
                                                            <textarea class="ckeditor" name="description" id="note" cols="60" rows="10"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="text-center">
                                                        <button class="btn btn-sm btn-primary mb-5" type="submit">
                                                            <strong>Create</strong>
                                                        </button>
                                                    </div>

                                        </div>
                                        </form>
                                    @else
                                        <form action="{{ route('SEO.Update', $editseo->id) }}" method="POST">
                                            @csrf
                                            @method('put')
                                            <div class="form-group">
                                                <label>Title</label>
                                                <div class=" mb-3 ">
                                                    <input value="{{ $editseo->title }}" type="text"
                                                        class="form-control input-sm" name="title" required>
                                                        
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Keywords</label>
                                                <div class=" mb-3 ">
                                                    <input value="{{ $editseo->keyword }}" type="text"
                                                        class="form-control input-sm" name="keyword" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Select Page</label>
                                                <select name="page_no" id="" class="form-control js-select">
                                                    <option value="">Select One</option>
                                                    <option {{($editseo->page_no == 1 )? 'selected' : ''}} value="1">Home Page</option>
                                                    <option {{($editseo->page_no == 2 )? 'selected' : ''}} value="2">User Page</option>
                                                    <option {{($editseo->page_no == 3 )? 'selected' : ''}} value="3">Assignment Page</option>
                                                    <option {{($editseo->page_no == 4 )? 'selected' : ''}} value="4">Student Page</option>
                                                    <option {{($editseo->page_no == 5 )? 'selected' : ''}} value="5">SMS/ PayRoll Page</option>
                                                    <option {{($editseo->page_no == 6 )? 'selected' : ''}} value="6">Task Management Page</option>
                                                    <option {{($editseo->page_no == 7 )? 'selected' : ''}} value="7">Online Benefit</option>
                                                    <option {{($editseo->page_no == 8 )? 'selected' : ''}} value="8">Priceing Page</option>
                                                    <option {{($editseo->page_no == 9 )? 'selected' : ''}} value="9">Sign Up Otp Page</option>
                                                    <option {{($editseo->page_no == 10) ? 'selected' : ''}} value="10">Demo</option>
                                                    <option {{($editseo->page_no == 11) ? 'selected' : ''}} value="11">Blog</option>
                                                    <option {{($editseo->page_no == 12) ? 'selected' : ''}} value="12">Video</option>
                                                    <option {{($editseo->page_no == 13) ? 'selected' : ''}} value="13">Terms and Conditions</option>
                                                    <option {{($editseo->page_no == 14) ? 'selected' : ''}} value="14">Contact</option>
                                                    <option {{($editseo->page_no == 15) ? 'selected' : ''}} value="15">Online Admission</option>
                                                    <option {{($editseo->page_no == 16) ? 'selected' : ''}} value="16">Log in</option>
                                                    <option {{($editseo->page_no == 17) ? 'selected' : ''}} value="17">Sign up</option>
                                                    <option {{($editseo->page_no == 18) ? 'selected' : ''}} value="18">Acquisition page</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Description</label>
                                                <div class="input-group mb-3">
                                                    <textarea class="ckeditor" name="description"id="note" cols="60" rows="10">{{ $editseo->description }}
                                                </textarea>
                                                </div>
                                            </div>
                                            <div class="text-center">
                                                <button class="btn btn-sm btn-primary mb-5" type="submit">
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
@push('js')
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>

    <script>
        CKEDITOR.replace('note');
    </script>
@endpush
