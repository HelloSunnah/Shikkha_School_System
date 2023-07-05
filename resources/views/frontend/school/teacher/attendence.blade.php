@extends('layouts.school.master')

@section('content')
<!--start content-->
<main class="page-content">
    <div class="row">
        <div class="col-xl-6 mx-auto">
            <div class="card">
                <div class="card-body">
                    <div class="border p-3 rounded">
                        <form class="row g-3" method="get" action="{{route('teacher.attendance.post')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-12">
                                @include('frontend.layouts.message')
                            </div>


                            <div class="col-md-12 mb-12">
                                <label class="form-label">{{__('app.date')}} </label>
                                <input type="text" id="datepicker" class="form-control" name="date" value="{{$defaultDate}}" required>
                            </div>

                            <div class="col-6">
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">{{__('app.Show Attendance')}}</button>
                                </div>
                            </div>
                            <div class="col-6">
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

<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
<script>
    $(document).ready(function() {
        $("#datepicker").datepicker({
            dateFormat: "yy-mm-dd",
            changeMonth: true,
            changeYear: true,
        });
    })
</script>

@endsection