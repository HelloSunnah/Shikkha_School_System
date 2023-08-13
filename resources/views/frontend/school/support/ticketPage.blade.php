@extends('layouts.school.master')
@section('content')
<main class="page-content">

    <div class="container mt-5">
        <form action="{{route('ticketmessage.create.post')}}" method="post" enctype="multipart/form-data">
            @csrf
            <h4 style="text-align: center;">Ticket information
            </h4>
            <div class=" card" style="width:700px;height:258px;border-radius:10px;background-color: #9E00DE;margin-left:65px">
                <div class="card-body" style="color: #ffffff;">

                    <div>
                        <div class="row">
                            <div class="col-6">
                                <label style="margin-left: 22px; margin-top:18px" for="">Name</label> <div readonly style="width:296px; height: 45px;margin-left:22px;" class="form-control" name="subject" type="text"> {{$data1->school_name}}
                                </div>  </div>
                            <div class="col-6">
                            <label style="margin-left: 22px; margin-top:18px" for="">Email</label> <div readonly style="width:296px; height: 45px;margin-left:22px;" class="form-control" name="subject" type="text"> {{$data1->email}}
                            </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label style="margin-top: 18px;margin-left:22px" for="">Department</label> 
                              

                                <select style="width:296px;height: 45px;margin-left:22px" class="form-control" name="department" id="">
                                <option value="">Select</option>
                                @foreach($data as $dept)
                                    <option value="{{$dept->id}}">{{$dept->department}}</option>
                                    @endforeach
                                </select>
                              
                            </div>
                            <div class="col-6">
                                <label style="margin-top: 18px;margin-left:22px" for="">Priority</label>
                                <select style="width:296px;height: 45px;margin-left:22px" class="form-control" name="priority" id="">
                                    <option value="high">High</option>
                                    <option value="medium">Medium</option>
                                    <option value="low">Low</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <h4 style="text-align: center; margin-top:50px">Message</h4>

                <div class=" card" style="width:860px;height:400px;border-radius:10px;background-color: #9E00DE;margin-right:15px;margin-top:20px">
                    <div class="card-body" style="color: #ffffff;">
                        <input style="width:750px; height: 51px;margin-left:36px; margin-top:20px" class="form-control" placeholder="Subject" name="subject" type="text">

                        <label style="margin-left:30px;  margin-top:20px"" for="">Message</label>
                        <textarea name=" message" id="" style="width:750px; height:230px;margin-left:36px; margin-top:10px" class="form-control" cols="30" rows="10"></textarea>
                    </div>
                </div>

            </div>


            <div class=" card" style="width:860px;height:136px;border-radius:10px;background-color: #9E00DE;margin-right:15px;margin-top:20px">
                <div class="card-body" style="color: #ffffff;">
                    <div class="row">
                        <div class="col-10">
                            <label for="">Attachement</label>
                            <input type="file" style="width: 599px;" class="form-control" name="attachment" multiple>
                        </div>
                        <div class="col-2"> <button style="margin-top:20px;width:100px" class="btn btn-white" type="submit">Send</button>
                        </div>
                    </div>
                    <p style="margin-top: 10px;">Allowed File Extensions: .jpg, .gif, .jpeg, .png (Max file size: 128MB)</p>

                </div>
            </div>
    </div>
    </div>
    </div>
    <center>

        </form>


        </div>


        </div>


        @endsection