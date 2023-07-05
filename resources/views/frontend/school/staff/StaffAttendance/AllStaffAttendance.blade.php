@extends('layouts.school.master')
@section('content')

<main class="page-content">

    <div class="row mt-5">
        <div class="col-xl-6 mx-auto">
            <div class="card" style="box-shadow:4px 3px 13px  .7px #bb55eb;border-radius:5px">
                <div class="card-body">
                    <div class="border p-3 rounded">
                        <form class="row g-3" method="get" action="{{route('StaffAttendance.AllView.Post')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-12">
                                @include('frontend.layouts.message')
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
</main>


@endsection