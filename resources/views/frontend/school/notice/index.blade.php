@extends('layouts.school.master')

@section('content')
    <!--start content-->
    <main class="page-content">
        <div class="row">
            <div class="col-xl-6 mx-auto">

                <div class="card" style="box-shadow:4px 3px 13px  .7px #deaaf7;border-radius:5px">
                    <div class="card-body">
                        <div class="border p-3 rounded">
                            <h6 class="mb-0 text-uppercase">{{$teacherText}} Form</h6>
                            <hr/>
                            @if(!isset($teacherEdit))
                                <form class="row g-3" method="post" action="{{route('notice.school.admin.create.post')}}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="col-md-12">
                                        @include('frontend.layouts.message')
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Notice Topic <span style="color:red;">*</span></label>
                                            <input type="text" class="form-control" name="topic" required>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Notice Description <span style="color:red;">*</span></label>
                                            <textarea type="text" class="form-control" name="description" rows="10" required></textarea>
                                    </div>

                                    <div class="col-12">
                                        <label class="select-form">Class Name</label>
                                        <select class="form-control mb-3 js-select"aria-label="Default select example" name="class_id" required>
                                            {{-- <option selected="">Class Name</option> --}}
                                            <option value="0" selected>Notice for all</option>
                                            @foreach(\App\Models\InstituteClass::where('school_id',Auth::user()->id)->get() as $data)
                                                <option value="{{$data->id}}">{{$data->class_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-12">
                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            @else
                                <form class="row g-3" method="post" action="{{route('teacher.update',$teacherEdit->id)}}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="col-md-12">
                                        @include('frontend.layouts.message')
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Full Name</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Full name" name="full_name" value="{{$teacherEdit->full_name}}">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Email</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Email" name="email" value="{{$teacherEdit->email}}">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Phone Number</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Phone Number" name="phone" value="{{$teacherEdit->phone}}">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="input-group mb-3">
                                            <select class="form-control mb-3 js-select" aria-label="Default select example" name="department_name">
                                                <option value="{{$teacherEdit->department_name}}" selected>{{$teacherEdit->department_name}}</option>
                                                @foreach($department as $data)
                                                    <option value="{{$data->department_name}}">{{$data->department_name}}</option>
                                                @endforeach
                                            </select>
                                            @if(count($department) > 0)
                                            @else
                                                <label class="input-group-text" for="inputGroupSelect02" style="margin-left: 5px;background-color: transparent;border-color: transparent;text-decoration: underline;">
                                                    <span class="badge bg-primary">
                                                        <input type="hidden" name="url_check" value="{{Request::segment(2).'/'.Request::segment(3)}}">
                                                        <button type="submit" style="background-color: transparent;color: #f1f1f1;border-color: transparent;">click here</button>
                                                    </span>
                                                </label
                                            @endif

                                        </div>

                                    </div>
                                    <div class="col-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="gridCheck1" name="active" value="1" {{($teacherEdit->active == 1) ? 'checked': ''}}>
                                            <label class="form-check-label" for="gridCheck1" >
                                                Check me out
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end row-->
    </main>

@endsection
