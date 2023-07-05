@extends('layouts.master')

@section('content')
    <!--start content-->
    <main class="page-content">

        <div class="row mb-5 ">
            <div class="col">
                <div class="card">
                    <div style="background-color:#19aa8d; color:white;" class="card-header">
                        <div class="row">
                            <div class="col-lg-12">
                                <center>
                                    <h3 style="margin-top:10px;font-size:50px">SCHOOL LIST</h3>
                                </center>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="margin-top:20px ; padding-bottom:30px">
                        <div class="container">
                            <div class="row  mb-5">
                                <div class="col-5 ">
                                    <form action="{{ route('SchoolListsearch') }}">
                                        <div class="input-group">
                                            <input type="search" name="search_key" class="form-control "
                                                placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                                            <button type="submit" class="btn btn-warning">search</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-7">
                                    <div class="text-right">
                                        <div class="btn btn-success  btn-lg"><a style="color: white"
                                                href="{{ route('SchoolRegisterPage') }}">Register</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="table-responsive">
                                    <table id="example" class="table table-striped table-bordered " style="width:100%">
                                        <thead>
                                            <tr>
                                                <th scope="col">no</th>
                                                <th scope="col">School Name</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Contact</th>
                                                <th scope="col">Teacher</th>
                                                <th scope="col">Student</th>
                                                <th scope="col">Stuff</th>
                                                <th scope="col">SMS</th>
                                                <th scope="col">School Add Date</th>
                                                <th>Subscription</th>
                                                <th colspan="2">Action</th>
                                                <th scope="col">Offline fees</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($schools as $school)
                                                <tr>
                                                    <th scope="row">{{ $school->id }}</th>
                                                    <td>{{ $school->school_name }}</td>
                                                    <td>{{ $school->email }}</td>
                                                    <td>{{ $school->phone_number }}</td>
                                                    <td>{{ CountTeacher($school->id) }}</td>
                                                    <td>{{ CountUser($school->id) }}</td>
                                                    <td>{{ CountStuff($school->id) }}</td>
                                                    <td>{{ getMessageCount($school->id) }}</td>
                                                    <td>{{ $school->created_at }}</td>
                                                    <td>
                                                        @if ($school->subscription_status == 0)
                                                            <a href="{{ route('subscription.status', $school->id) }}"
                                                                class="btn btn-secondary btn-sm">Trail Mode</a>
                                                        @elseif ($school->subscription_status == 2)
                                                            <a href="{{ route('subscription.status', $school->id) }}"
                                                                class="btn btn-danger btn-sm text-white">Inactive</a>
                                                        @else
                                                        <a href="{{ route('subscription.status', $school->id) }}"
                                                            class="btn btn-primary btn-sm text-white">Active</a>
                                                        @endif
                                                    </td>
                                                    {{-- <td><button type="button" class="btn btn-success " data-toggle="modal"
                                                            data-target="#modalstatus-{{ $school->id }}">
                                                            Add
                                                        </button>


                                                        <div class="modal fade" id="modalstatus-{{ $school->id }}"
                                                            tabindex="-1" role="dialog"
                                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h2 class=" text-center" id="exampleModalLabel">
                                                                            Subscription</h2>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="container">
                                                                            <div class="row">
                                                                                <div class="col-12">
                                                                                    <!-- resources/views/subscribe.blade.php -->
                                                                                    <form method="post"
                                                                                        action="{{ route('School.subscriptionstore') }}">
                                                                                        @csrf
                                                                                        <h2>Do you want to Subcription this
                                                                                            school</h2>
                                                                                        <input type="hidden"
                                                                                            value="{{ $school->id }}"
                                                                                            name="school_id">

                                                                                        <input type="hidden" value="1"
                                                                                            name="status">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Close</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Subscribe</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    </td> --}}
                                                    <td><a href="{{ route('School.SingleView', $school->id) }}"
                                                            class="btn btn-warning" style="color:white"><i
                                                                class="bi bi-eye-fill"></i></a></td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary " data-toggle="modal"
                                                            data-target="#modal-{{ $school->id }}">
                                                            <i class="bi bi-cash-coin"></i>
                                                        </button>
                                                        {{-- modal start --}}
                                                        <div class="modal fade modal-xl" id="modal-{{ $school->id }}"
                                                            tabindex="-1" role="dialog"
                                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog" role="document"
                                                                style="max-width: 80%;">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h2 class=" text-center" id="exampleModalLabel">
                                                                            SCHOOL FEES</h2>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="container">
                                                                            <div class="row">
                                                                                <div class="col-12">
                                                                                    <table id="example"
                                                                                        class="table table-striped table-bordered "
                                                                                        style="width:100%">
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <th scope="col">no</th>
                                                                                                <th scope="col">Month
                                                                                                    Name</th>
                                                                                                <th scope="col">Amount
                                                                                                </th>
                                                                                                <th scope="col">School
                                                                                                    Name</th>
                                                                                                <th scope="col">Status
                                                                                                </th>
                                                                                                <th scope="col">Payment
                                                                                                    Date $ Time</th>
                                                                                                {{-- <th colspan="2">Action</th> --}}
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                            @forelse($school->schoolfee_Relation as $data)
                                                                                                <tr>
                                                                                                    <td>{{ $data->id }}
                                                                                                    </td>
                                                                                                    <td>{{ $data->month_name }}
                                                                                                    </td>
                                                                                                    <td>{{ $data->amount }}
                                                                                                    </td>
                                                                                                    <td>{{ $data->school_id }}
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        @if ($data->status == 2)
                                                                                                            <a href="{{ route('changestatus', $data->id) }}"
                                                                                                                class="btn btn-primary">active</a>
                                                                                                        @elseif($data->status == 1)
                                                                                                            <a href="{{ route('changestatus', $data->id) }}"
                                                                                                                class="btn btn-warning">panding</a>
                                                                                                        @else
                                                                                                            <a href="{{ route('changestatus', $data->id) }}"
                                                                                                                class="btn btn-danger">inactive</a>
                                                                                                        @endif
                                                                                                    </td>
                                                                                                    <td>{{ $data->created_at }}
                                                                                                    </td>
                                                                                                </tr>
                                                                                            @empty
                                                                                                <tr align="center">
                                                                                                    <td colspan="6">No
                                                                                                        Record Found</td>
                                                                                                </tr>
                                                                                            @endforelse
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Close</button>3
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            {{-- modal end --}}

                                                    </td>
                                                    <td><a href="{{ route('billing.page', $school->id) }}"
                                                            class="btn btn-secondary">fee check</a></td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
