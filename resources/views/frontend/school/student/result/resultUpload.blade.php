@extends('layouts.school.master')

@section('content')
    <!--start content-->
    <main class="page-content">

        <div class="row">
            
            <div class="col-xl-6 mx-auto">
                <x-page-title title='Result Input'/>

                <div class="card">
                    <div class="card-body">
                        <div class="border p-3 rounded">
                            <form class="row g-3" method="get" action="{{route('result.school.create.show.post')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-12">
                                    @include('frontend.layouts.message')
                                </div>
                                <input type="hidden" name="resultSettingId" value="{{ $resultSettingId }}">
                                <div class="col-12 mb-3">
                                    <label class="select-form" for="">{{__('app.select_class')}}</label>
                                    <select class="form-control mb-3 js-select" name="class_id" id="class_id" required onchange="loadSection()">
                                        <option value="" selected>{{__('app.select')}}</option>
                                        @foreach($class as $data)
                                            <option value="{{$data->id}}" data-class-name="{{ $data->class_name }}">{{$data->class_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="select-form">{{__('app.Section')}}</label>
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
                                    <label class="select-form">Subject</label>
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
    {{-- Update Notice Modal Start --}}
        <div class="modal fade" id="updateNotice" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Notice</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4>Please update your Class Nine, Ten, Eleven, Twelve student infromation. Otherwise you can't input your students result.</h4>
                    <h5>How To Update Student Information:</h5>
                    <ol type="1">
                        <li>Go to student list. <a href="{{ route("student.teacher.create.show") }}">Student List{{ "(Click Here)" }}</a></li>
                        <li>Click edit or pencil icon button.</li>
                        <li>Click {{ "(Choose Subject) button" }} then you can see Student Subject pop up dialog box.</li>
                        <li>Now you choose Student Main Subject and Optional{{ "(4th)" }} Subject then click save button</li>
                    </ol>
                    <h5>If you update student information. Then don't need update again.</h5>
                </div>
            </div>
            </div>
        </div>
    {{-- Update Notice Modal End --}}
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

    <script>
        @php
           $classes = json_encode(classFilter());
        @endphp;

        var classes = '{{ $classes }}';
        console.log(classes);
        $("#class_id").change(function () { 
           let getClass = $(this).find('option:selected').attr("data-class-name");
           if (classes.includes(getClass)) {
                $("#updateNotice").modal("show");
            }     
        });
        
        
    </script>
@endpush
