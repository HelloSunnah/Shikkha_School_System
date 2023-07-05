@extends('layouts.school.master')

@section('content')
    <!--start content-->
    <main class="page-content">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div style="background-color:#ae12e2; color:white;" class="card-header">
                        <div class="row">
                            <div class="col-lg-2">
                                <img src="{{ asset($school->school_logo) }}" width="120" height="120" name="school_logo"
                                    class="rounded-circle shadow-8-strong"
                                    style="margin-left:50px; margin-top:10px; margin-bottom:8px;" alt="">
                            </div>
                            <div class="col-lg-10">
                                @if (app()->getLocale() === 'en')
                                    <center>
                                        <h3 style="margin-top:40px;font-size:40px">{{ $school->school_name }}</h3>
                                    </center>
                                @else
                                    <center>
                                        <h3 style="margin-top:40px;font-size:40px">{{ $school->school_name_bn }}</h3>
                                    </center>
                                @endif
                                @if (app()->getLocale() === 'en')
                                    <center>
                                        <p style="margin-top:5px;font-size:15px">{{ $school->slogan }}</p>
                                    </center>
                                @else
                                    <center>
                                        <p style="margin-top:5px;font-size:15px">{{ $school->slogan_bn }}</p>
                                    </center>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="margin-top:20px ; padding-bottom:30px">
                        <div class="row">
                            <div class="col-lg-12">
                                <table class="table table-striped ">
                                    <tbody>
                                        <form class="form-group-lg"
                                            action="{{ route('school.profile.Update', $school->id) }}" method="post"
                                            enctype="multipart/form-data">
                                            @method('PUT')
                                            @csrf
                                            <tr>
                                                <th>School Name</th>
                                                <td> <input value="{{ $school->school_name }}" name="school_name"
                                                        style="border:none;background:none;" class="form-control w-75"
                                                        type="text" placeholder="Please Input School Name"></td>
                                            </tr>
                                            <tr>
                                                <th>School Name Bangla</th>
                                                <td> <input
                                                        value="{{ $school->school_name_bn ? $school->school_name_bn : '' }}"
                                                        name="school_name_bn" style="border:none;background:none;"
                                                        class="form-control w-75" type="text"
                                                        placeholder="Please Input School Name Bangla"></td>
                                            </tr>

                                            <tr>
                                                <th>Email Address</th>
                                                <td><input name="email" name="school_name" value="{{ $school->email }}"
                                                        style="border:none;background:none;" class="form-control w-75 "
                                                        type="text" placeholder="Please Input Email Address"></td>
                                            </tr>

                                            <tr>
                                                <th>Phone Number</th>
                                                <td><input name="phone_number" value="{{ $school->phone_number }}"
                                                        style="border:none;background:none;" class="form-control w-75 "
                                                        type="text" placeholder="Please Input phone number"></td>
                                            </tr>
                                            <tr>
                                                <th>Ein Number</th>
                                                <td><input name="ein_number" value="{{ $school->ein_number }}"
                                                        style="border:none;background:none;" class="form-control w-75 "
                                                        type="number" placeholder="Please Input Ein Number"></td>
                                            </tr>

                                            <tr>
                                                <th>State</th>
                                                <td><input name="state" value="{{ $school->state }}"
                                                        style="border:none;background:none;" class="form-control w-75 "
                                                        type="text" placeholder="Please Input State"></td>
                                            </tr>

                                            <tr>
                                                <th>City</th>
                                                <td><input name="city" value="{{ $school->city }}"
                                                        style="border:none;background:none;" class="form-control w-75 "
                                                        type="text" placeholder="Please Input City"></td>
                                            </tr>

                                            <tr>
                                                <th>Postcode</th>
                                                <td><input name="postcode" value="{{ $school->postcode }}"
                                                        style="border:none;background:none;" class="form-control w-75 "
                                                        type="text" placeholder="Please Input postcode"></td>
                                            </tr>

                                            <tr>
                                                <th>Address</th>
                                                <td> <input name="address" value="{{ $school->address }}"
                                                        style="border:none;background:none;" class="form-control w-75 "
                                                        type="text" placeholder="Please Input Address"></td>
                                            </tr>
                                            <tr>
                                                <th>Address</th>
                                                <td> <input name="address_bn" value="{{ $school->address_bn }}"
                                                        style="border:none;background:none;" class="form-control w-75 "
                                                        type="text" placeholder="Please Input Address In Bangla"></td>
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
                                                <th>Slogan</th>
                                                <td> <input name="slogan" value="{{ $school->slogan }}"
                                                        style="border:none;background:none;" class="form-control w-100 "
                                                        type="text" placeholder="Please Input Slogan"></td>
                                            </tr>
                                            <tr>
                                                <th>Slogan Bangla</th>
                                                <td> <input name="slogan_bn" value="{{ $school->slogan_bn }}"
                                                        style="border:none;background:none;" class="form-control w-100 "
                                                        type="text" placeholder="Please Input Slogan"></td>
                                            </tr>

                                            <tr>
                                                <th>Action</th>
                                                <td><button type="submit" class="btn btn-primary btn-sm">Update</button>
                                                </td>
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
