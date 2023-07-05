@extends('layouts.school.master')

@section('content')
    <!--start content-->
    <main class="page-content">
        <div class="row">
            <div class="col-xl-6 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <div class="border p-3 rounded">
                            <form class="row g-3" method="get" action="{{route('student.attendance.create.show.post.date.all')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-12">
                                    @include('frontend.layouts.message')
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Class</label>
                                    <select class="form-control mb-3 js-select"aria-label="Default select example" name="class_id" id="class_id" required onchange="loadSection()">
                                        <option value="" selected>Select One</option>
                                        @foreach($class as $data)
                                            <option value="{{$data->id}}">{{$data->class_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Section</label>
                                    <select class="form-control mb-3 js-select"id="section_id" name="section_id" onchange="loadClass()" required>
                                        <option value="" selected>Select one</option>
                                    </select>
                                </div>
                                <div class="col-12" id="group-select">
                                    {{-- <label class="form-label">Group Name</label>
                                    <select class="form-control mb-3 js-select" id="group_id" name="group_id">
                                        <option selected>Select one</option>
                                    </select> --}}
                                </div>
                                <div class="col-12">
                                    <label class="form-label">{{__('app.Month')}}</label>
                                    <select class="form-control mb-3 js-select" id="month_id" name="month_id" required>
                                        <option value="" selected>Select one</option>
                                        <option value="01">January</option>
                                        <option value="02">February</option>
                                        <option value="03">March</option>
                                        <option value="04">April</option>
                                        <option value="05">May</option>
                                        <option value="06">June</option>
                                        <option value="07">July</option>
                                        <option value="08">August</option>
                                        <option value="09">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>

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
        function loadSection() {
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

        function loadClass() {
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
