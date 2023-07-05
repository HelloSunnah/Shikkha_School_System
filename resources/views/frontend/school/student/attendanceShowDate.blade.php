@extends('layouts.school.master')

@section('content')
    <!--start content-->
    <main class="page-content">
        <div class="row">
            <div class="col-xl-6 mx-auto">
                <div class="card" style="box-shadow:4px 3px 13px  .7px #bf52f2;border-radius:5px">
                    <div class="card-body">
                        <div class="border p-3 rounded">
                            <form class="row g-3" method="get" action="{{route('student.attendance.create.show.post.date')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-12">
                                    @include('frontend.layouts.message')
                                </div>
                                <div class="col-12">
                                    <select class="form-control mb-3 js-select" aria-label="Default select example" name="class_id" id="class_id" onchange="game_chf()">
                                        <option value=" " selected>Class Name</option>
                                        @foreach($class as $data)
                                            <option value="{{$data->id}}">{{$data->class_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="select-form">Section Name</label>
                                    <select class="form-control mb-3 js-select" id="section_id" name="section_id" onchange="group_chf()" required>
                                        <option selected></option>
                                    </select>
                                </div>
                                <div class="col-12" id="group-select">
                                    {{-- <label class="form-label">Group Name</label>
                                    <select  class="form-control mb-3 js-select" id="group_id" name="group_id">
                                        <option selected>Select one</option>
                                    </select> --}}
                                </div>
                                <div class="col-12">
                                    <label class="form-label">{{__('app.date')}}</label>
                                    <input type="date" name="date" class="form-control" required>
                                </div>
                                <div class="col-12">
                                    <div class="d-grid">
                                            <button type="submit" class="btn btn-primary">{{__('app.Show Attendance')}}</button>
                                        </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-grid">
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="lni lni-youtube"></i> Tutorial</button>
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
        $tutorialShow = getTutorial('student-attendance-show');
    ?>
    @include('frontend.partials.tutorial')

@endsection



@push('js')
    <script>
        function game_chf() {
            let class_id = $("#class_id").val();
            let groupElement = `<label class="form-label">Group Name</label>
                                <select class="form-control mb-3 js-select"  id="group_id" name="group_id">
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

        function group_chf() {
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
