@extends('layouts.school.master')

@section('content')
    <!--start content-->
    <main class="page-content">

        <div class="row">
            <div class="col-xl-6 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <x-page-title title='Result Input'/>
                        <div class="border p-3 rounded">

                            <form class="row g-3" method="get" action="{{route('result.school.create.show.post')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-12">
                                    @include('frontend.layouts.message')
                                </div>
                                <input type="hidden" name="resultSettingId" value="{{ $resultSettingId }}">
                                <div class="col-12 mb-3">
                                    <label for="">{{__('app.select_class')}}</label>
                                    <select class="form-control mb-3 js-select" name="class_id" id="class_id" required onchange="loadSection()">
                                        <option value="" selected>{{__('app.select')}}</option>
                                        @foreach($class as $data)
                                            <option value="{{$data->id}}">{{$data->class_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 mb-3">
                                    <label>{{__('app.Section')}}</label>
                                    <select class="form-control mb-3 js-select" id="section_id" name="section_id" required onchange="loadGroup()">
                                        <option value="" selected>{{__('app.select')}}</option>
                                    </select>
                                </div>
                                <div class="col-12" id="group-select">
                                    {{-- <label class="form-label">{{__('app.Group')}}</label>
                                    <select class="form-control mb-3 js-select" id="group_id" name="group_id" onchange="subject_chf()">
                                        <option value=" " selected>{{__('app.select')}}</option>
                                    </select> --}}
                                </div>
                                @if(Request::segment(6) != 'all')
                                <div class="col-12 mb-3">
                                    <label>Subject</label>
                                    <select class="form-control mb-3 js-select" id="subject_id" name="subject_id">
                                        <option  selected>{{__('app.select')}}</option>
                                    </select>
                                </div>
                                @else
                                    <input type="hidden" name="subject" value="1">
                                @endif
                                {{-- <div class="col-12 mb-3">
                                    <label>{{__('app.t')}}</label>
                                    <select class="form-control mb-3 js-select"id="term_id" name="term_id">
                                        @foreach($term as $term)
                                            <option value="{{$term->id}}">{{$term->term_name}}</option>
                                        @endforeach
                                    </select>
                                </div> --}}
                                <div class="col-12">
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary">{{__('app.Show Result')}}</button>
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
    $tutorialShow = getTutorial('assign-teacher');
    ?>
    @include('frontend.partials.tutorial')

@endsection

@push('js')
     <script>
        function loadSection() {
            let class_id = $("#class_id").val();

            let groupElement = `<label class="form-label">Group Name</label>
                                <select class="form-select mb-3" id="group_id" name="group_id">
                                    <option selected>Select one</option>
                                </select>`;

            $.ajax({
                url:'{{route('admin.show.section')}}',
                method:'POST',
                data:{
                    '_token':'{{csrf_token()}}',
                    class_id:class_id
                },

                success: function (response) {
                    $('#section_id').html(response.html);

                    if(response.class > 8)
                    {
                        $("#group-select").html(groupElement);
                    }
                    else
                    {
                        $("#group-select").html('');
                    }
                }
            });

        }

        function loadGroup() {
            let class_id = $("#class_id").val();
            let section_id = $("#section_id").val();
            console.log(section_id,'sports-section');
            $.ajax({
                url:'{{route('admin.show.group')}}',
                method:'POST',
                data:{
                    '_token':'{{csrf_token()}}',
                    class_id:class_id,
                    section_id:section_id,
                },

                success: function (response) {
                    $('#group_id').html(response);
                }
            });

        }

    </script>
@endpush
