@extends('layouts.school.master')
@section('content')
<style>
    .recycle1:hover {
        background-color: blueviolet;
        border-color: blueviolet !important;
        color: white !important;
    }

    .recyclebtn {
        border-color: blueviolet !important;
        color: blueviolet !important;
    }

    .recyclebtn:hover {
        background-color: blueviolet;
        border-color: blueviolet !important;
        color: white !important;
    }
</style>
<main class="page-content">
    <div class="row">
        @if ($User->Empty()||
        $resultCountablemark->Empty()||$fee->Empty()||
        $assignFess->Empty()||$staffSalary->Empty()->Empty()||$TeacherSalary->Empty()||$expense->Empty()||$studentMontyFee->Empty()||$syllabus->Empty()||$resultSetting->Empty()||$section->Empty()||$Teacher->Empty()||$Result->Empty()||$fund->Empty()||
        $admission->Empty()||$period->Empty()||$subject->Empty()||
        $staff->Empty()||$class->Empty()||$borrowlist->Empty()||$booklist->Empty()||$bookType->Empty()||$question->Empty())

        @if ($class->isNotEmpty())

        <div class="col-md-3 mb-3">
            <div class="card  bg-white mb-0" style="box-shadow:4px 3px 13px  .7px #e5bff7;border-radius:18px;">
                <h4 class="mb-0 text-center" style="margin-top:20px">Class</h4>
                <div class="card-body text-center p-1">
                    <div class="card-body text-center">
                        <div class="widget-icon mx-auto mb-5">
                            <i class="bi bi-person-circle" style="font-size: 80px;color:blueviolet"></i>
                        </div>
                        <div class="d-grid gap-2 col-8 mx-auto">
                            <button type="button" class="btn btn-outline-danger btn-sm recyclebtn" data-bs-toggle="modal" data-bs-target="#class">
                                View
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        @endif

        @if ($User->isNotEmpty())

        <div class="col-md-3 mb-3">
            <div class="card  bg-white mb-0" style="box-shadow:4px 3px 13px  .7px #e5bff7;border-radius:18px;">
                <h4 class="mb-0 text-center" style="margin-top:20px">Student</h4>
                <div class="card-body text-center p-1">
                    <div class="card-body text-center">
                        <div class="widget-icon mx-auto mb-5">
                            <i class="bi bi-person-circle" style="font-size: 80px;color:blueviolet"></i>
                        </div>
                        <div class="d-grid gap-2 col-8 mx-auto">
                            <button type="button" class="btn btn-outline-danger btn-sm recyclebtn" data-bs-toggle="modal" data-bs-target="#student">
                                View
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        @endif
        @if ($Teacher->isNotEmpty())

        <div class="col-md-3 mb-3">
            <div class="card  bg-white mb-0" style="box-shadow:4px 3px 13px  .7px #e5bff7;border-radius:18px;">
                <h4 class="mb-0 text-center" style="margin-top:20px">Teacher</h4>
                <div class="card-body text-center p-1">
                    <div class="card-body text-center">
                        <div class="widget-icon mx-auto mb-5">
                            <i class="bi bi-person-video3" style="font-size: 80px;color:blueviolet"></i>
                        </div>
                        <div class="d-grid gap-2 col-8 mx-auto">
                            <button type="button" class="btn btn-outline-danger btn-sm recyclebtn" data-bs-toggle="modal" data-bs-target="#teacher">
                                View
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        @endif
        @if ($staff->isNotEmpty())
        <div class="col-md-3 mb-2">
            <div class="card  bg-white mb-0" style="box-shadow:4px 3px 13px  .7px #e5bff7;border-radius:18px;">
                <h4 class="mb-0 text-center" style="margin-top:20px">Staff</h4>
                <div class="card-body text-center p-1">
                    <div class="card-body text-center">
                        <div class="widget-icon mx-auto mb-5">
                            <i class="bi bi-person-fill" style="font-size: 80px;color:blueviolet"></i>
                        </div>
                        <div class="d-grid gap-2 col-8 mx-auto">
                            <button type="button" class="btn btn-outline-danger btn-sm recyclebtn" data-bs-toggle="modal" data-bs-target="#staff">
                                View
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        @endif
        @if ($Result->isNotEmpty()||$resultSetting->isNotEmpty()||$resultCountablemark->isNotEmpty())
        <div class="col-md-3 mb-3">
            <div class="card  bg-white mb-0" style="box-shadow:4px 3px 13px  .7px #e5bff7;border-radius:18px;">
                <h4 class="mb-0 text-center" style="margin-top:20px">Result</h4>
                <div class="card-body text-center p-1">
                    <div class="card-body text-center">
                        <div class="widget-icon mx-auto mb-5">
                            <i class="bi bi-file" style="font-size: 80px;color:blueviolet"></i>
                        </div>
                        <div class="d-grid gap-2 col-8 mx-auto">
                            <button type="button" class="btn btn-outline-danger btn-sm recyclebtn" data-bs-toggle="modal" data-bs-target="#result1">
                                View
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        @endif
        @if($fee->isNotEmpty() ||$assignFess->isNotEmpty()||
        $studentMontyFee->isNotEmpty()||
        $TeacherSalary->isNotEmpty()||
        $staffSalary->isNotEmpty()||$expense->isNotEmpty()||
        $fund->isNotEmpty())
        <div class="col-md-3 mb-3">
            <div class="card  bg-white mb-0" style="box-shadow:4px 3px 13px  .7px #e5bff7;border-radius:18px;">
                <h4 class="mb-0 text-center" style="margin-top:20px">Finance</h4>
                <div class="card-body text-center p-1">
                    <div class="card-body text-center">
                        <div class="widget-icon mx-auto mb-5">
                            <i class="bi bi-currency-dollar" style="font-size: 80px;color:blueviolet"></i>
                        </div>
                        <div class="d-grid gap-2 col-8 mx-auto">
                            <button type="button" class="btn btn-outline-danger btn-sm recyclebtn" data-bs-toggle="modal" data-bs-target="#finance">
                                View
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        @endif
        @if ($admission->isNotEmpty())
        <div class="col-md-3 mb-2">
            <div class="card  bg-white mb-0" style="box-shadow:4px 3px 13px  .7px #e5bff7;border-radius:18px;">
                <h4 class="mb-0 text-center" style="margin-top:20px">Admission</h4>
                <div class="card-body text-center p-1">
                    <div class="card-body text-center">
                        <div class="widget-icon mx-auto mb-5">
                            <i class="bi bi-input-cursor-text" style="font-size: 80px;color:blueviolet"></i>
                        </div>
                        <div class="d-grid gap-2 col-8 mx-auto">
                            <button type="button" class="btn btn-outline-danger btn-sm recyclebtn" data-bs-toggle="modal" data-bs-target="#admission">
                                View
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        @endif
        @if ($question->isNotEmpty())
        <div class="col-md-3 mb-2">
            <div class="card  bg-white mb-0" style="box-shadow:4px 3px 13px  .7px #e5bff7;border-radius:18px;">
                <h4 class="mb-0 text-center" style="margin-top:20px">Question</h4>
                <div class="card-body text-center p-1">
                    <div class="card-body text-center">
                        <div class="widget-icon mx-auto mb-5">
                            <i class="bi bi-journal-medical" style="font-size: 80px;color:blueviolet"></i>
                        </div>
                        <div class="d-grid gap-2 col-8 mx-auto">
                            <button type="button" class="btn btn-outline-danger btn-sm recyclebtn" data-bs-toggle="modal" data-bs-target="#question">
                                View
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        @endif
        @if($bookType->isNotEmpty() ||$booklist->isNotEmpty()||$booklist->isNotEmpty())
        <div class="col-md-3 mb-2">
            <div class="card  bg-white mb-0" style="box-shadow:4px 3px 13px  .7px #e5bff7;border-radius:18px;">
                <h4 class="mb-0 text-center" style="margin-top:20px">Library</h4>
                <div class="card-body text-center p-1">
                    <div class="card-body text-center">
                        <div class="widget-icon mx-auto mb-5">
                            <i class="bi bi-book" style="font-size: 80px;color:blueviolet"></i>
                        </div>
                        <div class="d-grid gap-2 col-8 mx-auto">
                            <button type="button" class="btn btn-outline-danger btn-sm recyclebtn" data-bs-toggle="modal" data-bs-target="#library">
                                View
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>@endif


        @else
        <center style="color: purple;">
            <h5>
                This File is Empty
            </h5>
        </center>

        @endif


    </div>

</main>


<!-- Modal of student -->
<div class="modal fade " id="student" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header" style="background-color: blueviolet;color:white">
                <h5 class="modal-title" id="exampleModalLabel">Student Data</h5>
                <button type="button" class="btn-close btn-white" style="color:white;" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="example" class="table  table-bordered" style="width:100%">

                        <thead>
                            @if ($User->isNotEmpty())
                            <tr>
                                <th><input type="checkbox" id="select_all_ids"></th>
                                {{-- <th>{{ __('app.n') }}</th> --}}
                                <th>{{ __('app.Name') }}</th>
                                <th>Data Deleted</th>
                                <th>Data Modified</th>
                                <th>{{ __('app.action') }}</th>
                            </tr>


                            @else
                            <center style="color: purple;">
                                <h5>No data available</h5>
                            </center>
                            @endif
                        </thead>
                        <tbody>
                            @foreach ($User as $key => $data)
                            <tr>
                                <td><input type="checkbox" class="check_id" name="ids" value=""></td>
                                {{-- <td>{{++$key}}</td> --}}
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->deleted_at }}</td>
                                <td>{{ $data->created_at }}</td>
                                <td>
                                    <div class="btn-group mr-2" role="group" aria-label="First group">
                                        <a href="{{ route('restore.student', $data->id) }}" class="btn btn-outline-primary btn-sm recycle1" style="border-color:blueviolet !important;color:blueviolet"><i class="bi bi-recycle"></i>Restore</a>
                                        <a href="{{ route('Pdelete.student', $data->id) }}" class="btn btn-outline-danger btn-sm " ><i class="bi bi-trash2"></i>Parmanent Delete</a>

                                    </div>
                                </td>


                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal of for Finance -->
<div class="modal fade " id="finance" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header" style="background-color: blueviolet;color:white">
                <h5 class="modal-title" id="exampleModalLabel">Finance Data</h5>
                <button type="button" class="btn-close btn-white" style="color:white;" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    @if($fee->isNotEmpty() ||$assignFess->isNotEmpty()||
                    $studentMontyFee->isNotEmpty()||
                    $TeacherSalary->isNotEmpty()||
                    $staffSalary->isNotEmpty()||$expense->isNotEmpty()||
                    $fund->isNotEmpty())

                    <table id="example" class="table  table-bordered" style="width:100%">

                        <thead>

                            @if ($fee->isNotEmpty())
                            <center style="color: purple;">
                                <h5>School Fee Type</h5>
                            </center>
                            <tr>
                                <th><input type="checkbox" id="select_all_ids"></th>
                                {{-- <th>{{ __('app.n') }}</th> --}}
                                <th>{{ __('app.Name') }}</th>
                                <th>Data Deleted</th>
                                <th>Data Modified</th>
                                <th>{{ __('app.action') }}</th>
                            </tr>

                            @endif
                        </thead>
                        <tbody>
                            @foreach ($fee as $key => $data)
                            <tr>
                                <td><input type="checkbox" class="check_id" name="ids" value=""></td>
                                {{-- <td>{{++$key}}</td> --}}
                                <td>{{ $data->title }}</td>
                                <td>{{ $data->deleted_at }}</td>
                                <td>{{ $data->created_at }}</td>
                                <td>
                                    <div class="btn-group mr-2" role="group" aria-label="First group">
                                        <a href="{{route('restore.fee', $data->id) }}" class="btn btn-outline-primary btn-sm recycle1" style="border-color:blueviolet !important;color:blueviolet"><i class="bi bi-recycle"></i>Restore</a>
                                        <a href="{{route('pdelete.fee', $data->id) }}" class="btn btn-outline-danger btn-sm "><i class="bi bi-trash2"></i>Parmanent Delete</a>

                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                    <table id="example" class="table  table-bordered" style="width:100%">

                        <thead>
                            @if ($assignFess->isNotEmpty())
                            <h5>Assign Fee</h5>
                            <tr>
                                <th><input type="checkbox" id="select_all_ids"></th>
                                {{-- <th>{{ __('app.n') }}</th> --}}
                                <th>{{ __('app.Name') }}</th>
                                <th>Data Deleted</th>
                                <th>Data Modified</th>
                                <th>{{ __('app.action') }}</th>
                            </tr>

                            @endif
                        </thead>
                        <tbody>
                            @foreach ($assignFess as $key => $data)
                            <tr>
                                <td><input type="checkbox" class="check_id" name="ids" value=""></td>
                                {{-- <td>{{++$key}}</td> --}}
                                <td>{{ $data->fees_details}}</td>
                                <td>{{ $data->deleted_at }}</td>
                                <td>{{ $data->created_at }}</td>
                                <td>
                                    <div class="btn-group mr-2" role="group" aria-label="First group">
                                        <a href="{{ route('restore.assignFess', $data->id) }}" class="btn btn-outline-primary btn-sm recycle1" style="border-color:blueviolet !important;color:blueviolet"><i class="bi bi-recycle"></i>Restore</a>
                                        <a href="{{ route('pdelete.assignFess', $data->id) }}" class="btn btn-outline-danger btn-sm "><i class="bi bi-trash2"></i>Parmanent Delete</a>

                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                    <table id="example" class="table  table-bordered" style="width:100%">

                        <thead>
                            @if ($studentMontyFee->isNotEmpty())
                            <h5>Student Month Fee</h5>
                            <tr>
                                <th><input type="checkbox" id="select_all_ids"></th>
                                {{-- <th>{{ __('app.n') }}</th> --}}
                                <th>{{ __('app.Name') }}</th>
                                <th>{{ __('Month Name') }}</th>
                                <th>{{ __('Fees') }}</th>
                                <th>Data Deleted</th>
                                <th>Data Modified</th>
                                <th>{{ __('app.action') }}</th>
                            </tr>

                            @endif
                        </thead>
                        <tbody>
                            @foreach ($studentMontyFee as $key => $data)
                            <tr>
                                <td><input type="checkbox" class="check_id" name="ids" value=""></td>
                                {{-- <td>{{++$key}}</td> --}}
                                <td>
                                    Name: {{$data->user?->name}} <br>
                                    Class: {{$data->user?->class?->class_name}} <br>
                                    Section: {{$data->user?->section?->section_name}} <br>
                                    Roll: {{$data->user?->roll_number}} <br>
                                    UID: {{$data->user?->unique_id}} <br>
                                </td>
                                <td>{{ $data->month_name }}</td>
                                <td>{{ $data->amount }}</td>
                                <td>{{ $data->deleted_at }}</td>
                                <td>{{ $data->created_at }}</td>
                                <td>
                                    <div class="btn-group mr-2" role="group" aria-label="First group">
                                        <a href="{{ route('restore.studentMontyFee', $data->id) }}" class="btn btn-outline-primary btn-sm recycle1" style="border-color:blueviolet !important;color:blueviolet"><i class="bi bi-recycle"></i>Restore</a>
                                        <a href="{{ route('pdelete.studentMontyFee', $data->id) }}" class="btn btn-outline-danger btn-sm "><i class="bi bi-trash2"></i>Parmanent Delete</a>

                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>

                    <table id="example" class="table  table-bordered" style="width:100%">

                        <thead>
                            @if ($TeacherSalary->isNotEmpty())
                            <h5>Teache Salary</h5>
                            <tr>
                                <th><input type="checkbox" id="select_all_ids"></th>
                                {{-- <th>{{ __('app.n') }}</th> --}}
                                <th>{{ __('app.Name') }}</th>
                                <th>Data Deleted</th>
                                <th>Data Modified</th>
                                <th>{{ __('app.action') }}</th>
                            </tr>

                            @endif
                        </thead>
                        <tbody>
                            @foreach ($TeacherSalary as $key => $data)
                            <tr>
                                <td><input type="checkbox" class="check_id" name="ids" value=""></td>
                                {{-- <td>{{++$key}}</td> --}}
                                <td>{{ $data->month_name }}</td>
                                <td>{{ $data->deleted_at }}</td>
                                <td>{{ $data->created_at }}</td>
                                <td>
                                    <div class="btn-group mr-2" role="group" aria-label="First group">
                                        <a href="{{ route('restore.TeacherSalary', $data->id) }}" class="btn btn-outline-primary btn-sm recycle1" style="border-color:blueviolet !important;color:blueviolet"><i class="bi bi-recycle"></i>Restore</a>
                                        <a href="{{ route('pdelete.TeacherSalary', $data->id) }}" class="btn btn-outline-danger btn-sm "><i class="bi bi-trash2"></i>Parmanent Delete</a>

                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                    <table id="example" class="table  table-bordered" style="width:100%">

                        <thead>
                            @if ($staffSalary->isNotEmpty())
                            <h5>Staff Salary</h5>
                            <tr>
                                <th><input type="checkbox" id="select_all_ids"></th>
                                {{-- <th>{{ __('app.n') }}</th> --}}
                                <th>{{ __('app.Name') }}</th>
                                <th>Data Deleted</th>
                                <th>Data Modified</th>
                                <th>{{ __('app.action') }}</th>
                            </tr>

                            @endif
                        </thead>
                        <tbody>
                            @foreach ($staffSalary as $key => $data)
                            <tr>
                                <td><input type="checkbox" class="check_id" name="ids" value=""></td>
                                {{-- <td>{{++$key}}</td> --}}
                                <td>{{ $data->month_name }}</td>
                                <td>{{ $data->deleted_at }}</td>
                                <td>{{ $data->created_at }}</td>
                                <td>
                                    <div class="btn-group mr-2" role="group" aria-label="First group">
                                        <a href="{{ route('restore.staffSalary', $data->id) }}" class="btn btn-outline-primary btn-sm recycle1" style="border-color:blueviolet !important;color:blueviolet"><i class="bi bi-recycle"></i>Restore</a>
                                        <a href="{{ route('pdelete.staffSalary', $data->id) }}" class="btn btn-outline-danger btn-sm "><i class="bi bi-trash2"></i>Parmanent Delete</a>

                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                    <table id="example" class="table  table-bordered" style="width:100%">

                        <thead>
                            @if ($expense->isNotEmpty())
                            <h5>Expense</h5>
                            <tr>
                                <th><input type="checkbox" id="select_all_ids"></th>
                                {{-- <th>{{ __('app.n') }}</th> --}}
                                <th>{{ __('app.Name') }}</th>
                                <th>Data Deleted</th>
                                <th>Data Modified</th>
                                <th>{{ __('app.action') }}</th>
                            </tr>

                            @endif
                        </thead>
                        <tbody>
                            @foreach ($expense as $key => $data)
                            <tr>
                                <td><input type="checkbox" class="check_id" name="ids" value=""></td>
                                {{-- <td>{{++$key}}</td> --}}
                                <td>{{ $data->purpose }}</td>
                                <td>{{ $data->deleted_at }}</td>
                                <td>{{ $data->created_at }}</td>
                                <td>
                                    <div class="btn-group mr-2" role="group" aria-label="First group">
                                        <a href="{{ route('restore.expense', $data->id) }}" class="btn btn-outline-primary btn-sm recycle1" style="border-color:blueviolet !important;color:blueviolet"><i class="bi bi-recycle"></i>Restore</a>
                                        <a href="{{ route('pdelete.expense', $data->id) }}" class="btn btn-outline-danger btn-sm "><i class="bi bi-trash2"></i>Parmanent Delete</a>

                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                    <table id="example" class="table  table-bordered" style="width:100%">

                        <thead>

                            @if ($fund->isNotEmpty())
                            <h5>Fund List</h5>
                            <tr>
                                <th><input type="checkbox" id="select_all_ids"></th>
                                {{-- <th>{{ __('app.n') }}</th> --}}
                                <th>{{ __('app.Name') }}</th>
                                <th>Data Deleted</th>
                                <th>Data Modified</th>
                                <th>{{ __('app.action') }}</th>
                            </tr>

                            @endif
                        </thead>
                        <tbody>
                            @foreach ($fund as $key => $data)
                            <tr>
                                <td><input type="checkbox" class="check_id" name="ids" value=""></td>
                                {{-- <td>{{++$key}}</td> --}}
                                <td>{{ $data->purpose }}</td>
                                <td>{{ $data->deleted_at }}</td>
                                <td>{{ $data->created_at }}</td>
                                <td>
                                    <div class="btn-group mr-2" role="group" aria-label="First group">
                                        <a href="{{ route('restore.fund', $data->id) }}" class="btn btn-outline-primary btn-sm recycle1" style="border-color:blueviolet !important;color:blueviolet"><i class="bi bi-recycle"></i>Restore</a>
                                        <a href="{{ route('pdelete.fund', $data->id) }}" class="btn btn-outline-danger btn-sm "><i class="bi bi-trash2"></i>Parmanent Delete</a>

                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>






















<!-- Modal of teacher -->
<div class="modal fade " id="teacher" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header" style="background-color: blueviolet;color:white">
                <h5 class="modal-title" id="exampleModalLabel">Teacher Data</h5>
                <button type="button" class="btn-close btn-white" style="color:white;" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="example" class="table  table-bordered" style="width:100%">
                        {{-- <button type="button" style="background-color: blueviolet;border-color:blueviolet"
                        class="btn btn-danger btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#delete_all_records">
                        Delete All
                    </button> --}}
                        <thead>
                            @if ($Teacher->isNotEmpty())
                            <tr>
                                <th><input type="checkbox" id="select_all_ids"></th>
                                {{-- <th>{{ __('app.n') }}</th> --}}
                                <th>{{ __('app.Name') }}</th>
                                <th>Data Deleted</th>
                                <th>Data Modified</th>
                                <th>{{ __('app.action') }}</th>
                            </tr>


                            @else
                            <center style="color: purple;">
                                <h5>No data available</h5>
                            </center>
                            @endif
                        </thead>
                        <tbody>
                            @foreach ($Teacher as $key => $data)
                            <tr>
                                <td><input type="checkbox" class="check_id" name="ids" value=""></td>
                                {{-- <td>{{++$key}}</td> --}}
                                <td>{{ $data->full_name }}</td>
                                <td>{{ $data->deleted_at }}</td>
                                <td>{{ $data->created_at }}</td>
                                <td>
                                    <div class="btn-group mr-2" role="group" aria-label="First group">
                                        <a href="{{ route('restore.teacher', $data->id) }}" class="btn btn-outline-primary btn-sm recycle1" style="border-color:blueviolet !important;color:blueviolet"><i class="bi bi-recycle"></i>Restore</a>
                                        <a href="{{ route('Pdelete.teacher', $data->id) }}" class="btn btn-outline-danger btn-sm "><i class="bi bi-trash2"></i>Parmanent Delete</a>

                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade " id="library" tabindex="-1" aria-labelledby="exampleModalLabel"  data-bs-backdrop="static"aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header" style="background-color: blueviolet;color:white">
                <h5 class="modal-title" id="exampleModalLabel">Library Data</h5>
                <button type="button" class="btn-close btn-white" style="color:white;" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="example" class="table  table-bordered" style="width:100%">
                        @if($bookType->isNotEmpty() ||$booklist->isNotEmpty()||$booklist->isNotEmpty())
                        <thead>
                            @if($bookType->isNotEmpty())
                            <center style="color: purple;">
                                <h4>BooK Type</h4>
                            </center>
                            <tr>
                                <th><input type="checkbox" id="select_all_ids"></th>
                                {{-- <th>{{ __('app.n') }}</th> --}}
                                <th>{{ __('app.Name') }}</th>
                                <th>Data Deleted</th>
                                <th>Data Modified</th>
                                <th>{{ __('app.action') }}</th>
                            </tr>

                            @endif
                        </thead>
                        <tbody>
                            @foreach ($bookType as $key => $data)
                            <tr>
                                <td><input type="checkbox" class="check_id" name="ids" value=""></td>
                                {{-- <td>{{++$key}}</td> --}}
                                <td>{{ $data->book_type }}</td>
                                <td>{{ $data->deleted_at }}</td>
                                <td>{{ $data->created_at }}</td>
                                <td>
                                    <div class="btn-group mr-2" role="group" aria-label="First group">
                                        <a href="{{ route('restore.booktype', $data->id) }}" class="btn btn-outline-primary btn-sm recycle1" style="border-color:blueviolet !important;color:blueviolet"><i class="bi bi-recycle"></i>Restore</a>
                                        <a href="{{ route('pdelete.booktype', $data->id) }}" class="btn btn-outline-danger btn-sm "><i class="bi bi-trash2"></i>Parmanent Delete</a>

                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>

                    <table id="example" class="table  table-bordered" style="width:100%">

                        <thead>
                            @if($booklist->isNotEmpty())
                            <center style="color: purple;">
                                <h4>Book List</h4>
                            </center>
                            <tr>
                                <th><input type="checkbox" id="select_all_ids"></th>
                                {{-- <th>{{ __('app.n') }}</th> --}}
                                <th>{{ __('app.Name') }}</th>
                                <th>Data Deleted</th>
                                <th>Data Modified</th>
                                <th>{{ __('app.action') }}</th>
                            </tr>
                            @endif
                        </thead>
                        <tbody>
                            @foreach ($booklist as $key => $data)
                            <tr>
                                <td><input type="checkbox" class="check_id" name="ids" value=""></td>
                                {{-- <td>{{++$key}}</td> --}}
                                <td>{{ $data->book_name }}</td>
                                <td>{{ $data->deleted_at }}</td>
                                <td>{{ $data->created_at }}</td>
                                <td>
                                    <div class="btn-group mr-2" role="group" aria-label="First group">
                                        <a href="{{ route('restore.book', $data->id) }}" class="btn btn-outline-primary btn-sm recycle1" style="border-color:blueviolet !important;color:blueviolet"><i class="bi bi-recycle"></i>Restore</a>
                                        <a href="{{ route('pdelete.book', $data->id) }}" class="btn btn-outline-danger btn-sm "><i class="bi bi-trash2"></i>Parmanent Delete</a>

                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                    <table id="example" class="table  table-bordered" style="width:100%">

                        <thead>
                            @if($borrowlist->isNotEmpty())
                            <center style="color: purple;">
                                <h4>Borrower List</h4>
                            </center>
                            <tr>
                                <th><input type="checkbox" id="select_all_ids"></th>
                                {{-- <th>{{ __('app.n') }}</th> --}}
                                <th>{{ __('app.Name') }}</th>
                                <th>Data Deleted</th>
                                <th>Data Modified</th>
                                <th>{{ __('app.action') }}</th>
                            </tr>
                            @endif
                        </thead>
                        <tbody>
                            @foreach ($borrowlist as $key => $data)
                            <tr>
                                <td><input type="checkbox" class="check_id" name="ids" value=""></td>
                                {{-- <td>{{++$key}}</td> --}}
                                <td>{{ $data->student_id }}</td>
                                <td>{{ $data->deleted_at }}</td>
                                <td>{{ $data->created_at }}</td>
                                <td>
                                    <div class="btn-group mr-2" role="group" aria-label="First group">
                                        <a href="{{ route('restore.borrower', $data->id) }}" class="btn btn-outline-primary btn-sm recycle1" style="border-color:blueviolet !important;color:blueviolet"><i class="bi bi-recycle"></i>Restore</a>
                                        <a href="{{ route('pdelete.borrower', $data->id) }}" class="btn btn-outline-danger btn-sm "><i class="bi bi-trash2"></i>Parmanent Delete</a>

                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                        @else
                        <center style="color: purple;">
                            <h5>No data available</h5>
                        </center>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal of Reault -->


<div class="modal fade " id="class" tabindex="-1" aria-labelledby="exampleModalLabel"data-bs-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header" style="background-color: blueviolet;color:white">
                <h5 class="modal-title" id="exampleModalLabel">Class Data</h5>
                <button type="button" class="btn-close btn-white" style="color:white;" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="example" class="table  table-bordered" style="width:100%">
                        @if($class->isNotEmpty()||$section->isNotEmpty()||$subject->isNotEmpty()||$period->isNotEmpty())
                        <thead>
                            @if($class->isNotEmpty())
                            <center>
                                <h4>Class</h4>
                            </center>
                            <tr>
                                <th><input type="checkbox" id="select_all_ids"></th>
                                {{-- <th>{{ __('app.n') }}</th> --}}
                                <th>{{ __('app.Name') }}</th>
                                <th>Data Deleted</th>
                                <th>Data Modified</th>
                                <th>{{ __('app.action') }}</th>
                            </tr>
                            @endif
                        </thead>
                        <tbody>
                            @foreach ($class as $key => $data)
                            <tr>
                                <td><input type="checkbox" class="check_id" name="ids" value=""></td>
                                {{-- <td>{{++$key}}</td> --}}
                                <td>{{ $data->class_name }}</td>
                                <td>{{ $data->deleted_at }}</td>
                                <td>{{ $data->created_at }}</td>
                                <td>
                                    <div class="btn-group mr-2" role="group" aria-label="First group">
                                        <a href="{{ route('restore.class', $data->id) }}" class="btn btn-outline-primary btn-sm recycle1" style="border-color:blueviolet !important;color:blueviolet"><i class="bi bi-recycle"></i>Restore</a>
                                        <a href="{{ route('Pdelete.class', $data->id) }}" class="btn btn-outline-danger btn-sm "><i class="bi bi-trash2"></i>Parmanent Delete</a>

                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>


                    <table id="example" class="table  table-bordered" style="width:100%">
                        {{-- <button type="button" style="background-color: blueviolet;border-color:blueviolet"
                        class="btn btn-danger btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#delete_all_records">
                        Delete All
                    </button> --}}
                        <thead>
                            @if($section->isNotEmpty())
                            <center>
                                <h5>Section</h5>
                            </center>
                            <tr>
                                <th><input type="checkbox" id="select_all_ids"></th>
                                {{-- <th>{{ __('app.n') }}</th> --}}
                                <th>{{ __('app.Name') }}</th>
                                <th>Data Deleted</th>
                                <th>Data Modified</th>
                                <th>{{ __('app.action') }}</th>
                            </tr>
                            @endif
                        </thead>
                        <tbody>
                            @foreach ($section as $key => $data)
                            <tr>
                                <td><input type="checkbox" class="check_id" name="ids" value=""></td>
                                {{-- <td>{{++$key}}</td> --}}
                                <td>{{ $data->section_name }}</td>
                                <td>{{ $data->deleted_at }}</td>
                                <td>{{ $data->created_at }}</td>
                                <td>
                                    <div class="btn-group mr-2" role="group" aria-label="First group">
                                        <a href="{{ route('restore.section', $data->id) }}" class="btn btn-outline-primary btn-sm recycle1" style="border-color:blueviolet !important;color:blueviolet"><i class="bi bi-recycle"></i>Restore</a>
                                        <a href="{{ route('Pdelete.section', $data->id) }}" class="btn btn-outline-danger btn-sm "><i class="bi bi-trash2"></i>Parmanent Delete</a>

                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                    <table id="example" class="table  table-bordered" style="width:100%">
                        {{-- <button type="button" style="background-color: blueviolet;border-color:blueviolet"
                        class="btn btn-danger btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#delete_all_records">
                        Delete All
                    </button> --}}
                        <thead>
                            @if($period->isNotEmpty())
                            <center>
                                <h5>Class Period</h5>
                            </center>
                            <tr>
                                <th><input type="checkbox" id="select_all_ids"></th>
                                {{-- <th>{{ __('app.n') }}</th> --}}
                                <th>{{ __('app.Name') }}</th>
                                <th>Data Deleted</th>
                                <th>Data Modified</th>
                                <th>{{ __('app.action') }}</th>
                            </tr>
                            @endif
                        </thead>
                        <tbody>
                            @foreach ($period as $key => $data)
                            <tr>
                                <td><input type="checkbox" class="check_id" name="ids" value=""></td>
                                {{-- <td>{{++$key}}</td> --}}
                                <td>{{ $data->title }}</td>
                                <td>{{ $data->deleted_at }}</td>
                                <td>{{ $data->created_at }}</td>
                                <td>
                                    <div class="btn-group mr-2" role="group" aria-label="First group">
                                        <a href="{{ route('restore.period', $data->id) }}" class="btn btn-outline-primary btn-sm recycle1" style="border-color:blueviolet !important;color:blueviolet"><i class="bi bi-recycle"></i>Restore</a>
                                        <a href="{{ route('Pdelete.period', $data->id) }}" class="btn btn-outline-danger btn-sm "><i class="bi bi-trash2"></i>Parmanent Delete</a>

                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>

                    <table id="example" class="table  table-bordered" style="width:100%">

                        <thead>
                            @if($subject->isNotEmpty())
                            <center>
                                <h5>Subject</h5>
                            </center>
                            <tr>
                                <th><input type="checkbox" id="select_all_ids"></th>
                                {{-- <th>{{ __('app.n') }}</th> --}}
                                <th>{{ __('app.Name') }}</th>
                                <th>Data Deleted</th>
                                <th>Data Modified</th>
                                <th>{{ __('app.action') }}</th>
                            </tr>
                            @endif
                        </thead>
                        <tbody>
                            @foreach ($subject as $key => $data)
                            <tr>
                                <td><input type="checkbox" class="check_id" name="ids" value=""></td>
                                {{-- <td>{{++$key}}</td> --}}
                                <td>{{ $data->subject_name }}</td>
                                <td>{{ $data->deleted_at }}</td>
                                <td>{{ $data->created_at }}</td>
                                <td>
                                    <div class="btn-group mr-2" role="group" aria-label="First group">
                                        <a href="{{ route('restore.subject', $data->id) }}" class="btn btn-outline-primary btn-sm recycle1" style="border-color:blueviolet !important;color:blueviolet"><i class="bi bi-recycle"></i>Restore</a>
                                        <a href="{{ route('Pdelete.subject', $data->id) }}" class="btn btn-outline-danger btn-sm "><i class="bi bi-trash2"></i>Parmanent Delete</a>

                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>

                    <table id="example" class="table  table-bordered" style="width:100%">
                        <thead>
                            @if($syllabus->isNotEmpty())
                            <center>
                                <h5>syllabus</h5>
                            </center>
                            <tr>
                                <th><input type="checkbox" id="select_all_ids"></th>
                                {{-- <th>{{ __('app.n') }}</th> --}}
                                <th>{{ __('app.Name') }}</th>
                                <th>Data Deleted</th>
                                <th>Data Modified</th>
                                <th>{{ __('app.action') }}</th>
                            </tr>
                            else
                            <div></div>
                            @endif
                        </thead>
                        <tbody>
                            @foreach ($syllabus as $key => $data)
                            <tr>
                                <td><input type="checkbox" class="check_id" name="ids" value=""></td>
                                {{-- <td>{{++$key}}</td> --}}
                                <td>{{ $data->Syllabus }}</td>
                                <td>{{ $data->deleted_at }}</td>
                                <td>{{ $data->created_at }}</td>
                                <td>
                                    <div class="btn-group mr-2" role="group" aria-label="First group">
                                        <a href="{{ route('restore.syllabus', $data->id) }}" class="btn btn-outline-primary btn-sm recycle1" style="border-color:blueviolet !important;color:blueviolet"><i class="bi bi-recycle"></i>Restore</a>
                                        <a href="{{ route('Pdelete.syllabus', $data->id) }}" class="btn btn-outline-danger btn-sm "><i class="bi bi-trash2"></i>Parmanent Delete</a>

                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>


                    </table>

                    @endif

                </div>
            </div>
        </div>
    </div>
</div>





<div class="modal fade " id="result" tabindex="-1" aria-labelledby="exampleModalLabel"data-bs-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header" style="background-color: blueviolet;color:white">
                <h5 class="modal-title" id="exampleModalLabel">Result Data</h5>
                <button type="button" class="btn-close btn-white" style="color:white;" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="example" class="table  table-bordered" style="width:100%">
                        <thead>

                            @if($resultSetting->isNotEmpty())
                            <center style="color:purple;">
                                <h5>Result Setting</h5>
                            </center>
                            <tr>
                                <th><input type="checkbox" id="select_all_ids"></th>
                                {{-- <th>{{ __('app.n') }}</th> --}}
                                <th>{{ __('app.Name') }}</th>
                                <th>Data Deleted</th>
                                <th>Data Modified</th>
                                <th>{{ __('app.action') }}</th>
                            </tr>


                            @endif
                        </thead>
                        <tbody>
                            @foreach ($resultSetting as $key => $data)
                            <tr>
                                <td><input type="checkbox" class="check_id" name="ids" value=""></td>
                                {{-- <td>{{++$key}}</td> --}}
                                <td>{{ $data->title }}</td>
                                <td>{{ $data->deleted_at }}</td>
                                <td>{{ $data->created_at }}</td>
                                <td>
                                    <div class="btn-group mr-2" role="group" aria-label="First group">
                                        <a href="{{ route('restore.resultSetting', $data->id) }}" class="btn btn-outline-primary btn-sm recycle1" style="border-color:blueviolet !important;color:blueviolet"><i class="bi bi-recycle"></i>Restore</a>
                                        <a href="{{ route('Pdelete.resultSetting', $data->id) }}" class="btn btn-outline-danger btn-sm "><i class="bi bi-trash2"></i> Parmanent Delete</a>

                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                    <table id="example" class="table  table-bordered" style="width:100%">
                        @if($Result->isNotEmpty()||$resultSetting->isNotEmpty()||$resultCountablemark->isNotEmpty()||$period->isNotEmpty())

                        <thead>

                            @if($Result->isNotEmpty())
                            <center style="color:purple;">
                                <h5>Result</h5>
                            </center>

                            <tr>
                                <th><input type="checkbox" id="select_all_ids"></th>
                                {{-- <th>{{ __('app.n') }}</th> --}}
                                <th>{{ __('app.Name') }}</th>
                                <th>Data Deleted</th>
                                <th>Data Modified</th>
                                <th>{{ __('app.action') }}</th>
                            </tr>

                            @endif
                        </thead>
                        <tbody>
                            @foreach ($Result as $key => $data)
                            <tr>
                                <td><input type="checkbox" class="check_id" name="ids" value=""></td>
                                {{-- <td>{{++$key}}</td> --}}
                                <td>{{ $data->gpa }}</td>
                                <td>{{ $data->deleted_at }}</td>
                                <td>{{ $data->created_at }}</td>
                                <td>
                                    <div class="btn-group mr-2" role="group" aria-label="First group">
                                        <a href="{{ route('restore.result', $data->id) }}" class="btn btn-outline-primary btn-sm recycle1" style="border-color:blueviolet !important;color:blueviolet"><i class="bi bi-recycle"></i>Restore</a>
                                        <a href="{{ route('Pdelete.result', $data->id) }}" class="btn btn-outline-danger btn-sm "><i class="bi bi-trash2"></i>Parmanent Delete</a>

                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                    <table id="example" class="table  table-bordered" style="width:100%">
                        <thead>

                            @if($resultCountablemark->isNotEmpty())
                            <center style="color:purple;">
                                <h5>Result Countable Mark</h5>
                            </center>
                            <tr>
                                <th><input type="checkbox" id="select_all_ids"></th>
                                {{-- <th>{{ __('app.n') }}</th> --}}
                                <th>{{ __('app.Name') }}</th>
                                <th>Data Deleted</th>
                                <th>Data Modified</th>
                                <th>{{ __('app.action') }}</th>
                            </tr>


                            @endif
                        </thead>
                        <tbody>
                            @foreach ($resultCountablemark as $key => $data)
                            <tr>
                                <td><input type="checkbox" class="check_id" name="ids" value=""></td>
                                {{-- <td>{{++$key}}</td> --}}
                                <td>{{ $data->grade }}</td>
                                <td>{{ $data->deleted_at }}</td>
                                <td>{{ $data->created_at }}</td>
                                <td>
                                    <div class="btn-group mr-2" role="group" aria-label="First group">
                                        <a href="{{ route('restore.resultCountablemark', $data->id) }}" class="btn btn-outline-primary btn-sm recycle1" style="border-color:blueviolet !important;color:blueviolet"><i class="bi bi-recycle"></i>Restore</a>
                                        <a href="{{ route('Pdelete.resultCountablemark', $data->id) }}" class="btn btn-outline-danger btn-sm "><i class="bi bi-trash2"></i>Parmanent Delete</a>

                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        @else
                        <center style="color: purple;">
                            <h5>No data available</h5>
                        </center>
                        @endif
                    </table>


                </div>
            </div>
        </div>
    </div>
</div>




<div class="modal fade " id="result1" tabindex="-1" aria-labelledby="exampleModalLabel"  data-bs-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header" style="background-color: blueviolet;color:white">
                <h5 class="modal-title" id="exampleModalLabel">Result Data</h5>
                <button type="button" class="btn-close btn-white" style="color:white;" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    @if($Result->isNotEmpty()||$resultSetting->isNotEmpty()||$resultCountablemark->isNotEmpty()||$period->isNotEmpty())

                    <table id="example" class="table  table-bordered" style="width:100%">
                        <thead>

                            @if($Result->isNotEmpty())
                            <center style="color:purple;">
                                <h5>Result</h5>
                            </center>

                            <tr>
                                <th><input type="checkbox" id="select_all_ids"></th>
                                {{-- <th>{{ __('app.n') }}</th> --}}
                                <th>{{ __('app.Roll') }}</th>
                                <th>Data Deleted</th>
                                <th>Data Modified</th>
                                <th>{{ __('app.action') }}</th>
                            </tr>

                            @endif
                        </thead>
                        <tbody>
                            @foreach ($Result as $key => $data)
                            <tr>
                                <td><input type="checkbox" class="check_id" name="ids" value=""></td>
                                {{-- <td>{{++$key}}</td> --}}
                                <td>{{ $data->student_roll_number }}</td>
                                <td>{{ $data->deleted_at }}</td>
                                <td>{{ $data->created_at }}</td>
                                <td>
                                    <div class="btn-group mr-2" role="group" aria-label="First group">
                                        <a href="{{ route('restore.result', $data->id) }}" class="btn btn-outline-primary btn-sm recycle1" style="border-color:blueviolet !important;color:blueviolet"><i class="bi bi-recycle"></i>Restore</a>
                                        <a href="{{ route('Pdelete.result', $data->id) }}" class="btn btn-outline-danger btn-sm "><i class="bi bi-trash2"></i>Parmanent Delete</a>

                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
            


                    <table id="example" class="table  table-bordered" style="width:100%">
                        <thead>

                            @if($resultCountablemark->isNotEmpty())
                            <center style="color:purple;">
                                <h5>Result Countable Mark</h5>
                            </center>
                            <tr>
                                <th><input type="checkbox" id="select_all_ids"></th>
                                {{-- <th>{{ __('app.n') }}</th> --}}
                                <th>{{ __('app.Subject') }}</th>
                                <th>Data Deleted</th>
                                <th>Data Modified</th>
                                <th>{{ __('app.action') }}</th>
                            </tr>


                            @endif
                        </thead>
                        <tbody>
                            @foreach ($resultCountablemark as $key => $data)
                            <tr>
                                <td><input type="checkbox" class="check_id" name="ids" value=""></td>
                                {{-- <td>{{++$key}}</td> --}}
                                <td>{{App\Models\Subject::find($data->subject_id)?->subject_name}}</td>
                                <td>{{ $data->deleted_at }}</td>
                                <td>{{ $data->created_at }}</td>
                                <td>
                                    <div class="btn-group mr-2" role="group" aria-label="First group">
                                        <a href="{{ route('restore.resultCountablemark', $data->id) }}" class="btn btn-outline-primary btn-sm recycle1" style="border-color:blueviolet !important;color:blueviolet"><i class="bi bi-recycle"></i>Restore</a>
                                        <a href="{{ route('Pdelete.resultCountablemark', $data->id) }}" class="btn btn-outline-danger btn-sm "><i class="bi bi-trash2"></i>Parmanent Delete</a>

                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        @else
                        <center style="color: purple;">
                            <h5>No data available</h5>
                        </center>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade " id="admission" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static"aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header" style="background-color: blueviolet;color:white">
                <h5 class="modal-title" id="exampleModalLabel">Admission Data</h5>
                <button type="button" class="btn-close btn-white" style="color:white;" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="example" class="table  table-bordered" style="width:100%">
                        {{-- <button type="button" style="background-color: blueviolet;border-color:blueviolet"
                        class="btn btn-danger btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#delete_all_records">
                        Delete All
                    </button> --}}
                        <thead>
                            @if($admission->isNotEmpty())
                            <tr>
                                <th><input type="checkbox" id="select_all_ids"></th>
                                {{-- <th>{{ __('app.n') }}</th> --}}
                                <th>{{ __('app.title') }}</th>
                                <th>Data Deleted</th>
                                <th>Data Modified</th>
                                <th>{{ __('app.action') }}</th>
                            </tr>
                            @else
                            <center style="color: purple;">
                                <h5>No data available</h5>
                            </center>
                            @endif
                        </thead>
                        <tbody>
                            @foreach ($admission as $key => $data)
                            <tr>
                                <td><input type="checkbox" class="check_id" name="ids" value=""></td>
                                {{-- <td>{{++$key}}</td> --}}
                                <td>{{$data->type}}</td>

                                <td>{{ $data->deleted_at }}</td>
                                <td>{{ $data->created_at }}</td>
                                <td>
                                    <div class="btn-group mr-2" role="group" aria-label="First group">
                                        <a href="{{ route('restore.admission', $data->id) }}" class="btn btn-outline-primary btn-sm recycle1" style="border-color:blueviolet !important;color:blueviolet"><i class="bi bi-recycle"></i>Restore</a>
                                        <a href="{{ route('Pdelete.admission', $data->id) }}" class="btn btn-outline-danger btn-sm "><i class="bi bi-trash2"></i>Parmanent Delete</a>

                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade " id="question" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header" style="background-color: blueviolet;color:white">
                <h5 class="modal-title" id="exampleModalLabel">Question Data</h5>
                <button type="button" class="btn-close btn-white" style="color:white;" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="example" class="table  table-bordered" style="width:100%">
                        {{-- <button type="button" style="background-color: blueviolet;border-color:blueviolet"
                        class="btn btn-danger btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#delete_all_records">
                        Delete All
                    </button> --}}
                        <thead>
                            @if($question->isNotEmpty())
                            <tr>
                                <th><input type="checkbox" id="select_all_ids"></th>
                                {{-- <th>{{ __('app.n') }}</th> --}}
                                <th>{{ __('app.title') }}</th>
                                <th>Data Deleted</th>
                                <th>Data Modified</th>
                                <th>{{ __('app.action') }}</th>
                            </tr>
                            @else
                            <center style="color: purple;">
                                <h5>No data available</h5>
                            </center>
                            @endif
                        </thead>
                        <tbody>
                            @foreach ($question as $key => $data)
                            <tr>
                                <td><input type="checkbox" class="check_id" name="ids" value=""></td>
                                {{-- <td>{{++$key}}</td> --}}
                                <td>{{$data->type}}</td>

                                <td>{{ $data->deleted_at }}</td>
                                <td>{{ $data->created_at }}</td>
                                <td>
                                    <div class="btn-group mr-2" role="group" aria-label="First group">
                                        <a href="{{ route('restore.question', $data->id) }}" class="btn btn-outline-primary btn-sm recycle1" style="border-color:blueviolet !important;color:blueviolet"><i class="bi bi-recycle"></i>Restore</a>
                                        <a href="{{ route('Pdelete.admission', $data->id) }}" class="btn btn-outline-danger btn-sm "><i class="bi bi-trash2"></i>Parmanent Delete</a>

                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade " id="staff" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header" style="background-color: blueviolet;color:white">
                <h5 class="modal-title" id="exampleModalLabel">Staff Data</h5>
                <button type="button" class="btn-close btn-white" style="color:white;" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="example" class="table  table-bordered" style="width:100%">
                        {{-- <button type="button" style="background-color: blueviolet;border-color:blueviolet"
                        class="btn btn-danger btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#delete_all_records">
                        Delete All
                    </button> --}}
                        <thead>
                            @if($staff->isNotEmpty())
                            <tr>
                                <th><input type="checkbox" id="select_all_ids"></th>
                                {{-- <th>{{ __('app.n') }}</th> --}}
                                <th>{{ __('app.Name') }}</th>
                                <th>Data Deleted</th>
                                <th>Data Modified</th>
                                <th>{{ __('app.action') }}</th>
                            </tr>

                            @else
                            <center style="color: purple;">
                                <h5>No data available</h5>
                            </center>
                            @endif
                        </thead>
                        <tbody>
                            @foreach ($staff as $key => $data)
                            <tr>
                                <td><input type="checkbox" class="check_id" name="ids" value=""></td>
                                {{-- <td>{{++$key}}</td> --}}
                                <td>{{ $data->employee_name }}</td>
                                <td>{{ $data->deleted_at }}</td>
                                <td>{{ $data->created_at }}</td>
                                <td>
                                    <div class="btn-group mr-2" role="group" aria-label="First group">
                                        <a href="{{ route('restore.staff', $data->id) }}" class="btn btn-outline-primary btn-sm recycle1" style="border-color:blueviolet !important;color:blueviolet"><i class="bi bi-recycle"></i>Restore</a>
                                        <a href="{{ route('p.delete.staff', $data->id) }}" class="btn btn-outline-danger btn-sm "><i class="bi bi-trash2"></i>Parmanent Delete</a>

                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $(function(e) {
        $("#select_all_ids").click(function() {
            $('.check_id').prop('checked', $(this).prop('checked'));
        });
        //  $("#all_delete").click(function(e){
        //     e.preventDefault();
        //     var all_ids=[];
        //     $('input:checkbox[name=ids]:checked').each(function(){
        //         all_ids.push($(this).val());
        //     });
        //    // console.log(all_ids);
        //     // $.ajax({
        //     //     url:"{{ route('stafftype.Check.delete') }}",
        //     //     type:"DELETE",
        //     //     data:{
        //     //         ids:all_ids,
        //     //         _token:"{{ csrf_token() }}"
        //     //     },
        //     //     success:function(response){
        //     //         $.each(all_ids,function(key,val){
        //     //             $('#stafftype_ids'+val).remove();
        //     //             window.location.reload(true);
        //     //         });
        //     //     }
        //     // });

        //  });
    });
</script>
@endpush