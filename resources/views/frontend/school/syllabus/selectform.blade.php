@extends('layouts.school.master')

@section('content')





<main class="page-content">
    <div class="row">
        <div class=" col-xl-7 mt-5 mx-auto">
            <div class="card "style="box-shadow:4px 3px 13px  .7px #deaaf7;border-radius:5px">
                <div class="card-head">
                    <div class=" mb-4">
                        <h4 class="text-center text-uppercase text-primary"style="box-shadow:4px 3px 13px  .7px #f3ecfa;padding:10px;" >{{__('app.Syllabus')}} {{__('app.List')}}</h4>
                    </div>
                </div>
            {{-- <center>
                    <h3>{{__('app.Syllabus')}} {{__('app.List')}}</h3>
                </center> --}}
                <div class="ms-auto">
                    <a href="{{route('syllabus.create')}}" class="btn btn-primary me-5" title="{{__('app.Syllabus')}} {{__('app.Create')}}"><i class="bi bi-plus-square"></i> </a>

                </div>
                <div class="card-body">
                    <div class="border p-3 rounded">
                        <form class="row g-3 p-4" method="post" action="{{route('syllabus.form.post')}}">
                            @csrf
                            
                            <div class="col-12">
                              <label class="select-form">{{__('app.Class')}} {{__('app.Name')}}</label>
                                <select class="form-control mb-3 js-select" aria-label="Default select example" name="select_class" id="select_class">
                                    <option value="">Select Class</option>
                                    @foreach($class as $data)
                                    <option value="{{$data->id}}">{{$data->class_name}}</option>
                                    @endforeach
                                </select>
                                @error('select_form')<div class="alert alert-danger">{{$message}}</div>@enderror

                            </div>
                       

                            <button class="btn btn-primary"> {{__('app.Syllabus')}}</button>
                       

                        </form>

                </div>
            </div>
        </div>
    </div>
    </div>
    <!--end row-->
</main>


@endsection