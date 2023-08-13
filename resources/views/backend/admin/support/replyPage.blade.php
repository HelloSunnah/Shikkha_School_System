@extends('layouts.master')
@section('content')
<main class="page-content">

    <div class="container mt-5">
        <div class="row  border-bottom white-bg dashboard-header">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-4">
                        <div class="card text-left">
                            <img class="card-img-top">
                            <div class="card-body">
                                <h4 class="card-title">Finance</h4>

                                <div class="card text-left">
                                    <div class="card-body">
                                        <strong>Token: </strong>{{$data->token}}
                                    </div>
                                </div>
                                <div class="card text-left">
                                    <div class="card-body"><strong>Token By: </strong>{{$data->name}} </div>
                                </div>
                                <div class="card text-left">
                                    <div class="card-body"><strong> Created at: </strong>{{$data->created_at}} </div>
                                </div>
                                <div class="card text-left">
                                    <div class="card-body"><strong> Priority: </strong>
                                        <butto style="height: 30px; text-align:center" class="btn btn-primary">{{$data->priority}}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="card text-left">
                            <div class="card-body">
                                <form action="{{route('ticket.reply.post.admin',$data->id)}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div>
                                        <h4 class="card-title">Reply</h4>
                                        <textarea name="message" id="" cols="65" rows="5"></textarea>
                                    </div>
                                    <input type="hidden" name="ticket_id">
                                    <div>
                                        <label for="">Attachement</label>
                                        <input type="file" class="form-control" name="attachment" multiple>
                                    </div>
                                    <button style="margin-left: 482px;margin-top:10px" class="btn btn-primary">Send</button>
                                </form>
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
                        url: '{{route('ticketmessage.show.admin',$data->id)}}',
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            console.log(response);
                            var html = '';
                            response.forEach(function(item) {
                                if (item.assign_id_user == null) {
                                    var createdAt = new Date(item.created_at);
                                    var formattedDate = createdAt.toLocaleString();
                                    html += '<div class="card"><div class="card-body">' +
                                        '<div style = "height:100px;width:auto;background-color:white auto;margin-top:3px" >' +
                                        '<p style="color:blue;margin-left:380px">' + formattedDate + '</p>' + '<h6>' +
                                        item.message + '</h6>' + "<img src='/uploads/support/" + item.attachment + "'>" +
                                        '<p style="margin-left:500px;">' + item.assign_admin.name +
                                        '</p>' + '</div>' + '</div></div>';
                                } else {
                                    var createdAt = new Date(item.created_at);
                                    var formattedDate = createdAt.toLocaleString();
                                    html += '<div class="card"><div class="card-body">' +
                                        '<div style = "height:100px;width:auto;background-color:white auto;margin-top:3px" >' +
                                        '<p style="color:blue;margin-left:380px">' + formattedDate + '</p>' + '<h6>' +
                                        item.message + '<br>' + "<img src='/uploads/support" + item.attachment + "' >" + '</h6>' + '<p style="margin-left:380px;">' + item.assign_user.school_name +
                                        '</p>' + '</div>' + '</div></div>';

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