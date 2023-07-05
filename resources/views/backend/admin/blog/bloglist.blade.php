@extends('layouts.master')

@section('content')

<!--start content-->
<main class="page-content">

    <div class="row mb-5 ">
        <div class="col">
            <div class="card">
                <div style="background-color:#19aa8d;height:50px; color:white;" class="card-header">
                    <div class="row">
                        <div class="col-lg-12">
                            <center>
                                <h3>Blog List</h3>
                            </center>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="margin-top:20px ; padding-bottom:30px">
                    <div class="container">
                        <div class="row  mb-5">
                            <div class="col-5 ">

                            </div>
                            <div class="col-7">
                                <div class="text-right">
                                    <div class="btn btn-success  btn-lg"><a style="color: white" href="{{route('blog.create')}}">Add Blog</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table id="example" class="table table-striped table-bordered " style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col">no</th>
                                            <th scope="col">Image</th>
                                            <th scope="col">Title</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($blog as $key=>$data)
                                        <tr>
                                            <td>{{$key}}</td>
                                            <td> <img src="{{ asset($data->image ??'d/no-img.jpg') }}" alt="" width="100">
                                            </td>

                                            <td>{!! substr(strip_tags($data->title), 0, 100) !!}</td>
                                            <td>{{$data->created_at->format('M d, Y')}}</td>
                                            <td>
                                                <a  href="{{route('blog.edit',$data->id)}}" class="btn btn-primary"><i class="bi bi-pencil-square"></i></a>
                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModalCenter{{$data->id}}">
                                                    <i class="bi bi-trash"></i> </button>
                                            </td>         <!-- Modal -->
                                            <div class="modal fade" id="exampleModalCenter{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLongTitle">Blog Delete</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="get" action="{{route('blog.delete',['id'=>$data->id])}}">
                                                                <div class="modal-body">
                                                                <h1 style="color: red
                                                                ;">Are you Sure To Delete ?</h1>    
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button>
                                                                    <button type="submit" class="btn btn-primary">Yes</button>
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
    </div>
</main>
@endsection