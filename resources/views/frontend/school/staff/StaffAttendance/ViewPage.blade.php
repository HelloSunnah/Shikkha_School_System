@extends('layouts.school.master')
@push('css')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">

@endpush
@section('content')



<main class="page-content">
    <h3 class="mt-5 mb-3 text-center text-primary">Take Staff Attendance</h3>
<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <div class="card " style="box-shadow:4px 3px 13px  .7px #ca71f3;border-radius:5px">
            <div class="card-body">
                <form class="row g-3" method="get" action="{{route('StaffAttendance.DatePost')}}" enctype="multipart/form-data">
                    @csrf
                <div >
                    <label for="">Select Date</label>
                    <input type="text" id="datepicker" class="form-control" value="{{ $defaultDate }}"  name="date"  required>
                </div>
                <div class="row mt-3">
                    <div class="col">
                        <button type="submit" class="btn btn-primary w-100">{{__('app.Show Attendance')}}</button>
                    </div>
                    <div class="col">
                        <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="lni lni-youtube"></i> Tutorial</button>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
    <div class="col-md-3"></div>
</div>

</main>


@endsection
@push('js')

    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
    <script>
        $(document).ready(function(){
            $("#datepicker").datepicker({
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true,
            });
        })
    </script>
@endpush