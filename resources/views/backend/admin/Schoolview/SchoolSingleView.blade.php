@extends('layouts.master')

@section('content')
    <!--start content-->
    <main class="page-content">

        <div class="row mt-3 mb-5">
            <div class="col">

                <div class="card">

                    <div style="background-color:#19aa8d; color:white;" class="card-header">
                        <div class="row">
                          <div class="col-lg-2">
                            <img src="{{ asset($school->school_logo) }}" width="120" height="120" name="school_logo"
                                class="rounded-circle shadow-8-strong"
                                style="margin-left:50px; margin-top:10px; margin-bottom:8px;" alt="">
                        </div>
                            <div class="col-lg-10">
                                <center>
                                    <h3 style="margin-top:10px;font-size:50px">{{ $school->school_name }}</h3>
                                </center>
                            </div>
                        </div>

                    </div>
                    <div class="card-body" style="margin-top:20px ; padding-bottom:30px">
                        <div class="row">
                          @if (!isset($SchoolEdit))
                            <div class="col-lg-12">
                                <table class="table table-striped table-bordered  ">
                                    <tbody>
                                        <tr>
                                            <th>school name</th>
                                            <td>{{ $school->school_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Ein Number</th>
                                            <td>{{ $school->id }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email Address</th>
                                            <td>{{ $school->email }}</td>
                                        </tr>
                                        <tr>
                                            <th>Phone Number</th>
                                            <td>{{ $school->phone_number }}</td>
                                        </tr>
                                        <tr>
                                            <th>Bill </th>
                                            <td>{{ $school->billing_add }} $</td>
                                        </tr>
                                        <tr>
                                            <th>Number of Student</th>
                                            <td>{{ CountUser($school->id) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Teacher</th>
                                            <td>{{ CountTeacher($school->id) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Staff</th>
                                            <td>{{ CountStuff($school->id) }}</td>
                                        </tr>
                                        <tr>
                                          <th>School Slogan</th>
                                          <td>{{ $school->slogan }}</td>
                                      </tr>
                                          <th>School Slogan In Bangla</th>
                                          <td>{{ $school->slogan_bn ? $school->slogan_bn : '' }}</td>
                                      </tr>
                                        <tr>
                                            <th>State</th>
                                            <td>{{ $school->state }}</td>
                                        </tr>
                                        <tr>
                                            <th>city</th>
                                            <td>{{ $school->city }}</td>
                                        </tr>
                                        <tr>
                                            <th>Postcode</th>
                                            <td>{{ $school->postcode }}</td>
                                        </tr>
                                        <tr>
                                            <th>Country</th>
                                            <td>Bangladesh</td>
                                        </tr>
                                        <tr>
                                            <th>Address</th>
                                            <td>{{ $school->address }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <a href="{{ route('School.edit', $school->id) }}" class="btn btn-primary">Edit</a>
                            </div>
                            @else
                            <div class="col-lg-12">
                              <table class="table table-striped table-bordered  ">
                                  <tbody>
                                    <form class="form-group-lg"
                                    action="{{route('School.update', $SchoolEdit->id) }}" method="post"
                                    enctype="multipart/form-data">
                                    @method('PUT')
                                    @csrf
                                      <tr>
                                          <th>school name</th>
                                          <td>
                                            <input value="{{ $SchoolEdit->school_name }}" name="school_name"
                                            style="border:none;background:none;" class="form-control w-75"
                                            type="text" placeholder="Please Input School Name">
                                          </td>
                                      </tr>
                                      <tr>
                                          <th>school name Bn</th>
                                          <td>
                                            <input value="{{ $SchoolEdit->school_name_bn ? $school->school_name_bn : '' }}"
                                                name="school_name_bn" style="border:none;background:none;"
                                                class="form-control w-75" type="text"
                                                placeholder="Please Input School Name Bangla">
                                          </td>
                                      </tr>
                                      <tr>
                                          <th>Email Address</th>
                                          <td><input name="email" name="school_name" value="{{ $SchoolEdit->email }}"
                                            style="border:none;background:none;" class="form-control w-75 "
                                            type="text" placeholder="Please Input Email Address"></td>
                                      </tr>
                                      <tr>
                                          <th>Phone Number</th>
                                          <td><input name="phone_number" value="{{ $SchoolEdit->phone_number }}"
                                            style="border:none;background:none;" class="form-control w-75 "
                                            type="text" placeholder="Please Input phone number"></td>
                                      </tr>
                                      <tr>
                                          <th>Billing</th>
                                          <td><input name="billing_add" value="{{ $SchoolEdit->billing_add }}"
                                            style="border:none;background:none;" class="form-control w-75 "
                                            type="number" placeholder=""></td>
                                      </tr>
                                      <tr>
                                          <th>Number of Student</th>
                                          <td>{{ CountUser($SchoolEdit->id) }}</td>
                                      </tr>
                                      <tr>
                                          <th>Teacher</th>
                                          <td>{{ CountTeacher($SchoolEdit->id) }}</td>
                                      </tr>
                                      <tr>
                                          <th>Staff</th>
                                          <td>{{ CountStuff($SchoolEdit->id) }}</td>
                                      </tr>
                                      <tr>
                                        <th>School Logo</th>
                                        <td>
                                            <input type="file" name="school_logo" class="form-control">
                                            <p style="font-size: 12px">image size 640px (width & height)</p>
                                            @error('school_logo')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </td>
                                    </tr>
                                      <tr>
                                          <th>State</th>
                                          <td><input name="state" value="{{ $SchoolEdit->state }}"
                                            style="border:none;background:none;" class="form-control w-75 "
                                            type="text" placeholder="Please Input State"></td>
                                      </tr>
                                      <tr>
                                          <th>city</th>
                                          <td><input name="city" value="{{ $SchoolEdit->city }}"
                                            style="border:none;background:none;" class="form-control w-75 "
                                            type="text" placeholder="Please Input City">
                                          </td>
                                      </tr>
                                      <tr>
                                          <th>Postcode</th>
                                          <td><input name="postcode" value="{{ $SchoolEdit->postcode }}"
                                            style="border:none;background:none;" class="form-control w-75 "
                                            type="text" placeholder="Please Input postcode"></td>
                                      </tr>
                                      <tr>
                                          <th>Country</th>
                                          <td>Bangladesh</td>
                                      </tr>
                                      <tr>
                                          <th>Address</th>
                                          <td><input name="address" value="{{ $SchoolEdit->address }}"
                                            style="border:none;background:none;" class="form-control w-75 "
                                            type="text" placeholder="Please Input Address"></td>
                                      </tr>
                                      <tr>
                                        <th>Slogan</th>
                                        <td> <input name="slogan" value="{{ $SchoolEdit->slogan }}"
                                                style="border:none;background:none;" class="form-control w-100 "
                                                type="text" placeholder="Please Input Slogan"></td>
                                    </tr>
                                    <tr>
                                        <th>Slogan Bangla</th>
                                        <td> <input name="slogan_bn" value="{{ $SchoolEdit->slogan_bn }}"
                                                style="border:none;background:none;" class="form-control w-100 "
                                                type="text" placeholder="Please Input Slogan"></td>
                                    </tr>
                                  </tbody>
                              </table>
                              <button class="btn btn-primary">Update</button>
                            </form>
                          </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </main>

    <!-- Modal -->
    {{-- <div class="modal fade" id="loginPassword" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
  <h5 class="modal-title" id="exampleModalLabel">Student login </h5>
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
<form action="{{route('school.Password',$school->id)}}" method="post">
  @method('PUT')
  @csrf
    <div class="mb-3">
      <label for="password" class="col-form-label">New Password</label>
      <input type="text" name="password" class="form-control" id="password">
    </div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Back</button>
  <button type="submit" class="btn btn-success">Save</button>
</div>
</form>
</div>
</div>
</div> --}}
@endsection
