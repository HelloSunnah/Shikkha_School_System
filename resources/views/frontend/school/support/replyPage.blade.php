@extends('layouts.school.master')
@section('content')
<main class="page-content">

    <div class="container mt-5">
        <div class="row  border-bottom white-bg dashboard-header">


            <div class="col-md-12">
                <div class="row">
                    <div class="col-4">


                        <div class="card text-left">
                            <img class="card-img-top" src="holder.js/100px180/" alt="">
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
                                <form action="{{route('ticket.reply.post',$data1->id)}}" method="post">
                                    @csrf
                                    <h4 class="card-title">Reply</h4>

                                    <textarea name="message" id="" cols="65" rows="5"></textarea>
                                    <input type="hidden" name="ticket_id">
                                    <label for="">Attachement</label>
                                    <input type="file" class="form-control" name="attachment" multiple>
                                    <button style="margin-left: 482px;" class="btn btn-primary">Send</button>
                                </form>



                            </div>
                        </div>

                        @foreach($data2 as $value)

                        <div id="data-container" class="card text-left">
                            <div class="card-body">
                                <div style="height:100px;width:auto;background-color:white auto;margin-top:3px">
                                    <tr>

                                        <td>
                                            <h6 style="color:purple;">{{App\Models\School::find($value->assign_id)?->school_name}}</h6>
                                        </td>
                                        <td>
                                            <h6 style="color:#7127ea;">{{$value->message}}</h6>
                                        </td>
                                        <td> {{$value->created_at}}</td>
                                    </tr>
                                </div>
                            </div>
                        </div>

                        @endforeach

                    </div>

                </div>

            </div>

        </div>


        @endsection
        <script>
           $(document).ready(function() {
    function loadData() {
        
        
        $.ajax({
            url: '/ticket/reply/' + id,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#data-container').empty();

                $.each(data, function(index, item) {
                    $('#data-container').append('<p>' + item.name + '</p>');
                });
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    }

    setInterval(loadData, 100);
});

        </script>