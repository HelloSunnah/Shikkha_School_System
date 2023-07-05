@extends('layouts.school.master')

@section('content')
<!--start content-->
<main class="page-content">
    <div class="row mt-5">
        <div class="col-xl-6 mx-auto">

            <div class="card" style="box-shadow:4px 3px 13px  .13px #cf74f9;">
                <div class="card-body">
                    <div class="border p-3 rounded">
                        <h6 class="mb-0 text-uppercase text-primary">{{$sectionText}} </h6>
                        <hr />
                        @if(!isset($sectionEdit))
                        <form class="row g-3 " method="post" action="{{route('section.create.post')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="col-12 mt-5">
                                <label class="select-form">Class Name <span style="color: red;"> *</span></label>
                                <div class="input-group mb-4">
                                    <select class="form-control mb-3 js-select" required aria-label="Default select example" name="class_id" id="class_id" onchange="game_chf()" required>
                                        @if(count($class) > 0)
                                            <option value="" selected>Class Name </option>
                                        @else
                                            <option value="" selected>No Class Name Selected</option>
                                        @endif

                                        @foreach($class as $data)
                                            <option value="{{$data->id}}">{{$data->class_name}}</option>
                                        @endforeach
                                    </select>
                                    @if(count($class) > 0)
                                    @else
                                    <label class="input-group-text" for="inputGroupSelect02" style="margin-left: 5px;background-color: transparent;border-color: transparent;text-decoration: underline;">
                                        <span class="badge bg-primary">
                                            <input type="hidden" name="url_check_section" value="{{Request::segment(2).'/'.Request::segment(3)}}">
                                            <button type="submit" style="background-color: transparent;color: #f1f1f1;border-color: transparent;">click here</button>
                                        </span>
                                    </label @endif </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Section Name <span style="color: red;"> *</span></label>
                                    <input type="hidden" required class="form-control" name="url_check" value="{{$seo_array['urlTeacher']}}">
                                        <input type="text" class="form-control" name="section_name" required>
                                    
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