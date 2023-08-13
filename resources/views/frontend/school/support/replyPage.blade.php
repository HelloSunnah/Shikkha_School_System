@extends('layouts.school.master')
@section('content')
<script src="../ckeditor.js"></script>

<main class="page-content">

    <div class="container mt-5">
        <div class="row  border-bottom white-bg dashboard-header">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-4">
                        <div class="card text-left" style="height: 400px;border-radius:20px;box-shadow: 3px 3px white, -1em 0 .6em #dcdaf7;">
                            <img class="card-img-top">
                            <div class="card-body">

                                <div style="  border-bottom: 1px solid gray; margin-top:10px">
                                    <p>Token</p>
                                    <h6>{{$data->token}}</h6>


                                </div>
                                <div style="  border-bottom: 1px solid gray; margin-top:10px">
                                    <p>Created by</p>
                                    <h6>{{$data->name}}</h6>


                                </div>
                                <div style="  border-bottom: 1px solid gray; margin-top:10px">
                                    <p>Department </p>
                                    <h6>{{$data->department_id}}</h6>


                                </div>

                                <div style="  border-bottom: 1px solid gray; margin-top:10px">
                                    <p>Submitted Date</p>
                                    <h6>{{$data->created_at}}</h6>


                                </div>
                                <div style="margin-top:10px">
                                    <p>Priority</p>
                                    <butto style="height: 40px; text-align:center" class="btn btn-primary">{{$data->priority}}</button>


                                </div>
                            </div>


                        </div>
                    </div>
                    <div class="col-8">
                        <div class="card text-left">
                            <div class="card-body">

                                <div class="accordion" id="accordionExample">

                                    <div class="btn btn-primary accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" style="background-color: #ffffff;height:40px;width:500px;border-radius:2px;margin-top:22px" aria-controls="collapseThree">
                                        <h6 style="text-align:left;color:black">Reply</h6>
                                    </div><!-- Modal -->

                                    <div class="accordion-item">
                                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <form action="{{route('ticket.reply.post',$data->id)}}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label><strong>Message :</strong></label>
                                                        <textarea class="ckeditor form-control" id="editor1" name="message"></textarea>
                                                    </div>
                                                    <input type="hidden" name="ticket_id">
                                                    <label for="">Attachement</label>
                                                    <input type="file" class="form-control" name="attachment" multiple>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="dataLoad">
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
    @push('js')
    <script>
        $(document).ready(function() {
            function loadData() {
                $.ajax({
                    url: '{{route('ticketmessage.show',$data->id)}}',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        var html = '';
                        response.forEach(function(item) {
                            if (item.attachment == null) {

                                if (item.assign_id_user == null) {

                                    var createdAt = new Date(item.created_at);
                                    var formattedDate = createdAt.toLocaleString();
                                    html += '<div class="card mb-3">' +
                                        '<div class="card-body">' +
                                        '<div style = "height:80px;width:auto;background-color:white auto;margin-top:3px" >' +
                                        '<div style="border-bottom: 1px solid gray;" class="row">' +
                                        '<div class="col-md-6">' + '<h6>' + item.assign_admin.name + '</h56' + '</div>' +
                                        '<div class="col-md-6">' + '<h6 style="margin-left:80px">' + formattedDate + '</h6>' + '</div>' +
                                        '</div>' +
                                        '<p>' + item.message + '</p>' +
                                        '</div>' +
                                        '</div>' +
                                        '</div>';
                                } else {
                                    var createdAt = new Date(item.created_at);
                                    var formattedDate = createdAt.toLocaleString();
                                    html += '<div class="card mb-3">' +
                                        '<div class="card-body">' +
                                        '<div style = "height:80px;width:auto;background-color:white auto;margin-top:3px" >' +
                                        '<div style="border-bottom: 1px solid gray;" class="row">' +
                                        '<div class="col-md-6">' + '<h6>' + item.assign_user.school_name + '</h6>' + '</div>' +
                                        '<div class="col-md-6">' + '<h6 style="margin-left:80px">' + formattedDate + '</h6>' + '</div>' +
                                        '</div>' +
                                        '<p>' + item.message + '</p>' +
                                        '</div>' +
                                        '</div>' +
                                        '</div>';

                                }
                            } else {
                                if (item.assign_id_user == null) {

                                    var createdAt = new Date(item.created_at);
                                    var formattedDate = createdAt.toLocaleString();
                                    html +=
                                        '<div class="card">' +
                                        '<div class="card-body">' +
                                        '<div style = "height:150px;width:auto;background-color:white auto;margin-top:3px" >'

                                        +
                                        '<div style="border-bottom: 1px solid gray;" class="row">' +
                                        '<div class="col-md-6">' + '<h6>' + item.assign_admin.name + '</h6>' + '</div>' +
                                        '<div class="col-md-6">' + '<h6 style="margin-left:80px">' + formattedDate + '</h6>' + '</div>' +
                                        '</div>' +

                                        '<div class="row" style="margin-top:6px">' +
                                        '<div class="col-md-4">' + '<img style="width:120px; height:100px" src=" ' + item.attachment + '">' + '</div>' +
                                        '<div class="col-md-8">' + '<p>' + item.message + '</p>' + '</div>' +
                                        '</div>' +
                                        '</div>' +
                                        '</div>' +
                                        '</div>';
                                } else {
                                    var createdAt = new Date(item.created_at);
                                    var formattedDate = createdAt.toLocaleString();
                                    html +=
                                        '<div class="card">' +
                                        '<div class="card-body">' +
                                        '<div style = "height:150px;width:auto;background-color:white auto;margin-top:3px" >' +

                                        '<div style="border-bottom: 1px solid gray;" class="row">' +
                                        '<div class="col-md-6">' + '<h6>' + item.assign_user.school_name + '</h6>' + '</div>' +
                                        '<div class="col-md-6">' + '<h6 style="margin-left:80px">' + formattedDate + '</h6>' + '</div>' +
                                        '</div>' +
                                        '<div class="row" style="margin-top:6px">' +
                                        '<div class="col-md-4">' + '<img style="width:120px; height:100px" src=" ' + item.attachment + '">' + '</div>' +
                                        '<div class="col-md-8">' + '<p>' + item.message + '</p>' + '</div>' +
                                        '</div>' +
                                        '</div>' +
                                        '</div>' +
                                        '</div>';
                                }

                            }






                        });
                        $('#dataLoad').html(html);
                    }
                });
            }
            setInterval(loadData, 1000);
        });
    </script>

    @endpush