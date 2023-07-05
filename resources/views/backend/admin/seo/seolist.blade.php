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
                                <strong>List</strong>
                            </li>
                        </ol>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('SEO.form') }}" class="btn btn-primary">Create</a>
                    </div>
                </div>

                <div class="wrapper wrapper-content animated fadeInRight">
                    <div class="row">
                        <div class="col-lg-12">
                            <center>
                                <h1>SEO Tool List</h1>
                            </center>
                        </div>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="col-lg-12">
                            <div class="ibox ">

                                <div class="ibox-content">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover dataTables-example">
                                            <thead>
                                                <tr>
                                                    
                                                    <th>Page Title</th>
                                                    <th>SEO Title</th>
                                                    <th>SEO Keyword</th>
                                                    <th>SEO Description</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($seo as $key=>$data)
                                                    <tr>
                                                        <td>@if($data->page_no == 1) Home Page
                                                            @elseif ($data->page_no == 2) User Page
                                                            @elseif ($data->page_no == 3) Assignment Page
                                                            @elseif ($data->page_no == 4) Student Page
                                                            @elseif ($data->page_no == 5) SMS/ PayRoll Page
                                                            @elseif ($data->page_no == 6)Task Management Page
                                                            @elseif ($data->page_no == 7)Online Benefit
                                                            @elseif ($data->page_no == 8)Priceing Page
                                                            @elseif ($data->page_no == 9)Sign Up OTP Page
                                                            @elseif ($data->page_no == 10)Demo
                                                            @elseif ($data->page_no == 11)Blog
                                                            @elseif ($data->page_no == 12)Video
                                                            @elseif ($data->page_no == 13)Terms and Conditions
                                                            @elseif ($data->page_no == 14)Contact
                                                            @elseif ($data->page_no == 15)Online Admission
                                                            @elseif ($data->page_no == 16)Log in
                                                            @elseif ($data->page_no == 17)Sign up
                                                            @elseif ($data->page_no == 18)Acquisition Page
                                                            @endif                                                        
                                                        </td> 
                                                        <td>{{ $data->title }}</td>
                                                        <td>{{ $data->keyword }}</td>
                                                        <td>{!! $data->description !!}</td>
                                                        <td style="white-space: nowrap;">
                                                            <a href="{{ route('SEO.Edit', $data->id) }}" onclick=""
                                                                class="btn btn-primary"><i class="bi bi-pencil-square"></i>
                                                            </a>

                                                            {{-- <button class="btn btn-primary btn-sm mb-3" data-bs-target="#editModal{{$key}}" data-bs-toggle="modal"><i class="bi bi-pencil-square">edit</i></button>&nbsp; --}}

                                                            {{-- <a href="javascript::"
                                                                onclick="if(confirm('Are your sure? Do you want to delete?')){ location.replace('{{ route('SEO.Delete', $data->id) }}') }"
                                                                class="btn btn-danger"><i class="bi bi-trash3"></i>
                                                            </a> --}}

                                                            
                                                        </td>                                                       
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
            </div>
        </div>

        <script>
            // When the user clicks on <div>, open the popup
            function myFunction() {
                var popup = document.getElementById("myPopup");
                popup.classList.toggle("show");
            }
        </script>
    @endsection
