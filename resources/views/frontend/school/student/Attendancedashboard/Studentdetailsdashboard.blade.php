@extends('layouts.school.master')

@push('js')
    @include('frontend.school.student.Attendancedashboard.include.user_list_script')
@endpush

@section('content')
    <main class="page-content">
        <h4 class="mb-4 text-primary">Students</h4>

        <div class="row">
            <div class="col-12 mb-3">
                <div class="card">
                    <div class="card-body bg-primary text-light">
                        <form id="filterFormData" onsubmit="event.preventDefault()">
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-3 mb-3">
                                    <div class="form-group">
                                        <label>Shift</label>
                                        <select name="shift" class="form-control js-select" id="filter_shift"
                                            onchange="submitFilterForm()">
                                            <option value=""></option>
                                            <option value="1"
                                                @isset(request()->shift) {{ request()->shift == 1 ? 'selected' : '' }} @endisset>
                                                Morning</option>
                                            <option value="2"
                                                @isset(request()->shift) {{ request()->shift == 2 ? 'selected' : '' }} @endisset>
                                                Day</option>
                                            <option value="3"
                                                @isset(request()->shift) {{ request()->shift == 3 ? 'selected' : '' }} @endisset>
                                                Evening</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-6 col-lg-3 mb-3">
                                    <div class="form-group">
                                        <label>Class</label>
                                        <select name="classId" class="form-control js-select" id="filter_class"
                                            onchange="loadSectionFromClass(this.value)">
                                            @foreach ($classes as $classId => $className)
                                                <option value="{{ $classId }}">{{ $className }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- @if (isset(request()->classId) && !empty(request()->classId) && isset($sections) && count($sections) > 0) --}}
                                <div class="col-sm-12 col-md-6 col-lg-3 mb-3">
                                    <div class="form-group">
                                        <label for="">Section</label>
                                        <select name="sectionId" class="form-control js-select" id="section"
                                            onchange="submitFilterForm()">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                                {{-- @endif --}}

                                <div class="col-sm-12 col-md-6 col-lg-3 mb-3">
                                    <div class="form-group">
                                        <label for="">Roll Number</label>
                                        <input type="number" class="form-control" id="filter_roll"
                                            onkeyup="submitFilterForm()" name="roll"
                                            @if (isset(request()->roll) && !empty(request()->roll)) value="{{ request()->roll }}" @endif>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="row mt-4">
                            <div class="col-md-4">
                                <div class="card mb-0">
                                    <div class="card-body text-dark">
                                        <div class="d-flex justify-content-between gap-1 align-items-center">
                                            <div> <img src="{{asset('assets/nav-icons/student.svg')}}" alt="student" width="40"> <h6>Connected Students </h6></div>
                                            
                                            <h3 class="m-0" id="connected_user_card">0</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card mb-0">
                                    <div class="card-body text-dark">
                                        <div class="d-flex justify-content-between gap-1 align-items-center">
                                            <div> <img src="{{asset('assets/nav-icons/student.svg')}}" alt="student" width="40"> <h6>Disconnected Students </h6></div>
                                            
                                            <h3 class="m-0" id="disconnected_user_card">0</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card shadow">
                    <div class="card-body table-responsive">

                        <table class="table table-hover table-bordered">
                            <thead>
                                <th>Roll</th>
                                <th>Student</th>
                                <th>Class / Section</th>
                                <th>Shift</th>
                                <th>UID</th>
                                <th>Connection</th>
                            </thead>
                            <tbody id="userListId">

                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">

                    </div>
                </div>
            </div>
        </div>
    </main>

    <div class="modal fade" id="loader" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0" style="background: none">
                <div class="modal-body">
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="spinner-grow text-primary me-3" role="status" aria-hidden="true"></div>
                        <h5 class="m-0 text-primary">Just a moment, Please...</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
