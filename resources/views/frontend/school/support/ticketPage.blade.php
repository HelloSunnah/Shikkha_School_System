@extends('layouts.school.master')
@section('content')
<main class="page-content">

    <div class="container mt-5">
        <div class="row  border-bottom white-bg dashboard-header">

            <head>

                <h3>Create new Support Request
                </h3>
            </head>

            <div class="col-md-12">
                <form action="{{route('ticketmessage.create.post')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <label for="">Subject</label> <input class="form-control" name="subject" type="text">
                        </div>
                        <input type="hidden" name="department_id" value="">
                        <div class="col-6">
                            <label for="">Priority</label>
                            <select class="form-control" name="priority" id="">
                                <option value="high">High</option>
                                <option value="medium">Medium</option>
                                <option value="low">Low</option>
                            </select>
                        </div>
                    </div>
                    
                    <label for="">Message</label>
                    <textarea name="message" id="" class="form-control" cols="30" rows="10"></textarea>
                    <label for="">Attachement</label>
                    <input type="hidden" name="department_id">
                    <input type="file" class="form-control" name="attachment" multiple>
                    <center> <button style="margin-top:5px; " class="btn btn-success" type="submit">Send</button>
                    </center>
                </form>

            </div>

        </div>


        @endsection