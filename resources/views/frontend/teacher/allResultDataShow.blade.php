@extends('layouts.teacher.master')

@section('content')
    <style>
        html,body{
            min-height: 100vh;
            min-width: 100vw;
        }
        .parent{
            height: 100vh;
        }
        .parent>.row{
            display: flex;
            align-items: center;
            height: 100%;
        }
        .col img{
            height:100px;
            width: 100%;
            cursor: pointer;
            transition: transform 1s;
            object-fit: cover;
        }
        .col label{
            overflow: hidden;
            position: relative;
        }
        .imgbgchk:checked + label>.tick_container{
            opacity: 1;
        }
        /*         aNIMATION */
        .imgbgchk:checked + label>img{
            transform: scale(1.25);
            opacity: 0.3;
        }
        .tick_container {
            transition: .5s ease;
            opacity: 0;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            cursor: pointer;
            text-align: center;
        }
        .tick {
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            padding: 6px 12px;
            height: 40px;
            width: 40px;
            border-radius: 100%;
        }
    </style>
    <!--start content-->
    <main class="page-content">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-7">
                <form method="get" action="{{route('allResult.show.all.teacher',$subject_id)}}" enctype="multipart/form-data">
                    <div class="input-group">
                        <select  class="form-control mb-3 js-select" name="term">
                            <option selected>Choose a term</option>
                             @foreach($dataTermAll as $term)
                            <option value="{{$term->id}}">{{$term->term_name}}</option>
                            @endforeach
                        </select>
                        <div class="input-group-append" style="margin-left: 10px">
                            <button type="submit" class="btn btn-outline-secondary">Search</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
       <div class="row mt-3">
                    <div class="col-md-12">

                        <div class="card">
                            <div class="card-body">
                                <h5>{{getSubjectNameAll($subject_id)}}</h5>
                                @if(count($dataResult) == 0)
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered" style="width:100%">
                                            <thead>
                                            <tr>
                                                <th style="color: #ff0000;">No Data Found</th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                @else
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Student</th>
                                            <th >Roll Number</th>
                                            <th >Written</th>
                                            <th >Mcq</th>
                                            <th >Practical</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($dataResult as $key => $data)
                                            <tr>
                                                <td>{{$key++ +1}}</td>
                                                <td>{{getUserNameForAll($data->student_id)->name}}</td>
                                                <td>{{getUserNameForAll($data->student_id)->roll_number}}</td>
                                                <td>{{$data->written}}</td>
                                                <td>{{$data->mcq}}</td>
                                                <td>{{$data->practical}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
    </main>

@endsection


