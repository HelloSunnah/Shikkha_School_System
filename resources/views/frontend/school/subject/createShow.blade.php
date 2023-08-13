@extends('layouts.school.master')

@section('content')
    <!--start content-->
    <main class="page-content">
        <div class="row">
            <div class="col-12 text-center">
                <h5 class="mb-0 text-uppercase text-primary">{{__('app.Subject')}}</h5>
            </div>
            <div class="col-xl-6 mx-auto mt-5">
                <div class="card" style="box-shadow:4px 3px 13px  .7px #deaaf7;border-radius:5px">
                    <div class="card-body">
                        <div class="border p-3 rounded">
                            <form class="row g-3" method="get" action="{{route('subject.create.show.post')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-12">
                                    @include('frontend.layouts.message')
                                </div>
                                <div class="col-12">
                                    <label class="select-form" for="Select Class">{{__('app.select')}} {{__('app.class')}}</label>
                                    @if(count($classes) > 0)
                                        <select class="form-control mb-3 js-select"aria-label="Default select example" name="class_id" id="class_id">
                                            <option value="" selected>Select a Class</option>
                                            @foreach($classes as $data)
                                                <option value="{{$data->id}}">{{$data->class_name}}</option>
                                            @endforeach
                                        </select>
                                    @else
                                        <p>Create Class --->  <a href="{{route('class.create')}}">{{__('app.Clickhere')}}</a></p>
                                    @endif
                                </div>

                                <div class="col-12">
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary">{{__('app.Subject')}} {{__('app.Show')}}</button>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-grid">
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="lni lni-youtube"></i> {{__('app.Tutorial')}}</button>
                                </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end row-->
    </main>
    <?php
    $tutorialShow = getTutorial('subject-show');
    ?>
    @include('frontend.partials.tutorial')
@endsection