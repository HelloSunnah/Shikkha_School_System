@extends('layouts.master')

@section('content')

<!--start content-->
<main class="page-content">
    <div class="row">
        <div class="col">
            <div class="card">
                <div style="background-color:#19aa8d; color:white;" class="card-header">
                    <div class="row">
                      <div class="col-lg-12">
                      <center><h3 style="margin-top:10px;font-size:50px">SCHOOL REGISTER</h3></center>
                      </div>
                    </div>
                  </div>
                <div class="card-body" style="margin-top:20px ; padding-bottom:30px">
                     <div class="row">
                        <div class="col-lg-12">
                    <table class="table table-striped table-bordered" >
                            <tbody>
                                <form class="form-control" action="{{route('Schools.Register')}}" method="post" enctype="multipart/form-data" >
                                    @csrf
                            <tr>
                            <th>school name</th>
                            <td> <input value="" name="school_name" style="border:none;background:none;" class="form-control w-75" type="text" placeholder="Please Input School Name" required></td>
                            </tr>
                           
                            <tr>
                            <th>Email Address</th>
                            <td><input name="email"  value="" style="border:none;background:none;" class="form-control w-75 " type="text" placeholder="Please Input Email Address" required></td>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </tr>
                            <tr>
                            <tr>
                            <th>Password</th>
                            <td><input  name="password" value="" style="border:none;background:none;" class="form-control w-75 " type="password" placeholder="Please Input password" required></td>
                            </tr>
                            <tr>
                            <th>Phone Number</th>
                            <td><input name="phone_number" value="" style="border:none;background:none;" class="form-control w-75 " type="text" placeholder="Please Input phone number"></td>
                            </tr>
                            
                            <tr>
                            <th >State</th>
                            <td><input name="state" value="" style="border:none;background:none;" class="form-control w-75 " type="text" placeholder="Please Input State"></td>
                            </tr>
                            <tr>
                            <th >city</th>
                            <td><input name="city" value="" style="border:none;background:none;" class="form-control w-75 " type="text" placeholder="Please Input City"></td>
                            </tr>
                            <tr>
                            <th >Postcode</th>
                            <td><input name="postcode" value="" style="border:none;background:none;" class="form-control w-75 " type="text" placeholder="Please Input postcode"></td>
                            </tr>
                            <tr>
                            <th >Address</th>
                            <td> <input name="address" value="" style="border:none;background:none;" class="form-control w-75 " type="text" placeholder="Please Input Address"></td>
                            </tr>
                            <tr>
                                <th>School Logo</th>
                                <td><input type="file" name="school_logo" class="form-control">
                                @error('school_logo')<div class="alert alert-danger">{{$message}}</div>
                            @enderror
                            </td>
                            </tr>
                            <tr>
                            <th >Action</th>
                            <td><button type="submit" class="btn btn-success btn-sm">Submit</button></td>
                            </tr>
                            </form>
                            </tbody>
                    </table>
                        </div>
                       
                     </div>
                </div>
            </div>
        </div>
    </div>
    
</main>
@endsection   