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
                        <a href="{{ route('AddonList') }}" class="btn btn-secondary">Back</a>
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
                                                <h2 class="m-t-none m-b">Addon Form </h2>
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
                                            @if (!isset($editAddon))
                                                <form action="{{ route('Addon.create') }}" method="POST">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label>Title</label>
                                                        <div class=" mb-3 ">
                                                            <input type="text" class="form-control input-sm"
                                                                name="title" required>
                                                                <p>The title must be at  18-25 characters.</p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Price</label>
                                                        <div class=" mb-3 ">
                                                            <input type="number" class="form-control input-sm"
                                                                name="price" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Month</label>
                                                        <div class=" mb-3 ">
                                                            <input type="number" class="form-control input-sm"
                                                                name="month" required>
                                                        </div>
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
                                        <form action="{{ route('Addon.Update', $editAddon->id) }}" method="POST">
                                            @csrf
                                            @method('put')
                                            <div class="form-group">
                                                <label>Title</label>
                                                <div class=" mb-3 ">
                                                    <input value="{{ $editAddon->title }}" type="text"
                                                        class="form-control input-sm" name="title" required>
                                                        <p>The title must be at  18-25 characters.</p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Price</label>
                                                <div class=" mb-3 ">
                                                    <input value="{{ $editAddon->price }}" type="number"
                                                        class="form-control input-sm" name="price" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Month</label>
                                                <div class=" mb-3 ">
                                                    <input value="{{ $editAddon->month }}" type="text"
                                                        class="form-control input-sm" name="month" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Description</label>
                                                <div class="input-group mb-3">
                                                    <textarea class="ckeditor" name="description"id="note" cols="60" rows="10">{{ $editAddon->description }}
                                                </textarea>
                                                </div>
                                            </div>
                                            <div class="text-center">
                                                <button class="btn btn-sm btn-primary mb-5" type="submit">
                                                    <strong>Update</strong>
                                                </button>
                                            </div>

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
@endsection
@push('js')
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>

    <script>
        CKEDITOR.replace('note');
    </script>
@endpush
