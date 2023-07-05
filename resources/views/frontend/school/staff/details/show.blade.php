@extends('layouts.school.master')

@section('content')
<!--start content-->
<!--start content-->
<main class="page-content">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header py-3 bg-transparent">
                    <div class="d-sm-flex align-items-center">
                        <h5 class="mb-2 mb-sm-0">{{__('app.Stuff')}} {{__('app.List')}}</h5>
                        <div class="ms-auto">
                            <button type="button" class="btn btn-secondary btn-sm" title="{{__('app.back')}}" onclick="history.back()"><i class="bi bi-arrow-left-square"></i></button>
                            @if(Request::segment(2) != 'staff-salary')
                            <a href="{{route('school.staff.List.create')}}" class="btn btn-primary btn-sm" title="{{__('app.staff create')}}"><i class="bi bi-plus-square"></i></a>
                            @endif
                            <button type="button" title="{{__('app.Tutorial')}}" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="lni lni-youtube"></i> </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <button type="button" class="btn btn-danger btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#delete_all_records">
                                {{__('app.deleteall')}}
                            </button>

                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="select_all_ids"></th>
                                    <th>{{__('app.nong')}}</th>
                                    <th>{{__('app.EmployeeName')}}</th>
                                    <th>{{__('app.Phone')}} </th>
                                    <th>{{__('app.UniqueId')}} </th>
                                    <th>{{__('app.position')}}</th>
                                    <th>{{__('app.shift')}}</th>
                                    <th>{{__('app.action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($employee as $key => $data)
                                <tr id="staff_ids{{$data->id}}">
                                    <td><input type="checkbox" class="check_id" name="ids" value="{{$data->id}}"></td>
                                    <td>{{$key++ +1}} </td>
                                    <td>
                                        <a href="{{route('staff.view',$data->id)}}" class="text-decoration-none">{{strtoupper($data->employee_name)}}</a>
                                    </td>
                                    <td>{{$data->phone_number}}</td>
                                    <td>{{$data->employee_id}}</td>

                                    <td>{{strtoupper($data->position)}}</td>
                                    <td>{{$data->shift}}</td>
                                    <td>
                                        @if(Request::segment(2) == 'staff-salary')
                                        <button class="btn btn-primary btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#addSalary{{$key}}">Pay Salary</button>


                                        {{-- staff salary Payment --}}

                                        <div class="modal fade" id="addSalary{{$key}}" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalToggleLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header" style="background: #7c00a7">
                                                        <h5 class="modal-title text-white" id="addSalary{{$key}}">{{__('app.Stuff')}} {{__('app.Payment')}} {{__('app.Details')}}</h5>
                                                        <button type="button" class="btn-close btn-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div class="table-responsive">
                                                                    <table class="table table-striped table-bordered" style="width:100%">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Month Name</th>
                                                                                <th>Amount</th>
                                                                                <th>Due</th>
                                                                                <th>Last updated Date</th>
                                                                                <th>Action</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach($staffSalary as $item)
                                                                            @if($item->employee_id == $data->id)
                                                                            <tr>
                                                                                <td>{{$item->month_name}}</td>
                                                                                <td>
                                                                                    @if($item->amount == 0) Non-Paid
                                                                                    @else {{$item->amount}} ৳
                                                                                    @endif
                                                                                </td>
                                                                                <td>{{($item->amount == 0) ? $data->salary  : $data->salary - $item->amount}} ৳</td>
                                                                                <td>
                                                                                    @if($item->amount > 0) {{$item->updated_at->format('d-m-Y')}}

                                                                                    @endif
                                                                                    {{-- {{$item->updated_at->format('d-m-Y')}}
                                                                                </td> --}}
                                                                                <td>
                                                                                    @if($item->amount != $data->salary)
                                                                                    <button class="btn btn-primary btn-sm mb-3" data-bs-target="#paySalary{{$item->id}}" data-bs-toggle="modal">Pay Salary</button>
                                                                                    @else
                                                                                    <button class="btn btn-primary btn-sm mb-3" style="pointer-events: none; background: #7c00a7;">Full Paid</button>
                                                                                    @endif
                                                                                </td>

                                                                                {{-- child Modal --}}
                                                                                <div class="modal fade" id="paySalary{{$item->id}}" tabindex="-1" aria-labelledby="exampleModalToggleLabel2" aria-hidden="true">
                                                                                    <div class="modal-dialog modal-dialog-centered">
                                                                                        <div class="modal-content">
                                                                                            <div class="modal-header" style="background: #7c00a7">
                                                                                                <h5 class="modal-title text-white" id="exampleModalLabel"> Pay Staff Salary</h5>
                                                                                                <button type="button" class="btn-close btn-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                            </div>
                                                                                            <div class="modal-body">
                                                                                                <form class="row g-3" method="post" action="{{route('school.staff.salary.update',$item->id)}}" enctype="multipart/form-data">
                                                                                                    @csrf
                                                                                                    <div class="col-12">
                                                                                                        <label class="form-label text-dark">Pay For {{$item->month_name}}</label>
                                                                                                        <div class="input-group mb-3"> <span class="input-group-text" id="basic-addon1">Amount Taka</span>
                                                                                                            <input type="hidden" name="employee_phone" value="{{$data->phone_number}}">
                                                                                                            @if($item->amount == 0)
                                                                                                            <input type="text" class="form-control" name="amount" value="{{$data->salary}}" placeholder="৳">
                                                                                                            @else
                                                                                                            <input type="text" class="form-control" name="amount" value="{{$data->salary - $item->amount}}" placeholder="৳">
                                                                                                            @endif
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-12">
                                                                                                        <div class="d-grid">
                                                                                                            <button type="submit" class="btn btn-primary">Submit</button>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </form>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                {{-- End Child Modal --}}
                                                                            </tr>
                                                                            @endif

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

                                        {{-- End staff salary Payment --}}
                                        @else
                                        <div class="btn-group mr-2" role="group" aria-label="First group">
                                            <a href="{{route('staff.view',$data->id)}}" class="btn btn-info btn-sm" title="{{__('app.View')}}"><i class="bi bi-eye"></i></a>

                                            <button type="button" class="btn btn-primary btn-sm" title="{{__('app.edit')}}" data-bs-toggle="modal" data-bs-target="#editModal{{$key}}"><i class="bi bi-pencil-square"></i></button>

                                            <button type="button" class="btn btn-danger btn-sm" title="{{__('app.Delete')}}" data-bs-toggle="modal" data-bs-target="#deleteModal{{$key}}"><i class="bi bi-trash-fill"></i></button>
                                        </div>
                                        @endif
                                    </td>

                                    <div class="modal fade" id="editModal{{$key}}" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header" style="background: #7c00a7">
                                                    <h5 class="modal-title text-white" id="exampleModalLabel">{{__('app.Stuff')}}</h5>
                                                    <button type="button" class="btn-close btn-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                    <div class="modal-body border ms-4 me-4 mt-4 mb-4">
                                                        <form class="row g-3" method="post" action="{{ route('school.staff.List.create.update', $data->id) }}" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="col-12 mt-4">
                                                                <label class="form-label">{{ __('app.EmployeeName') }} <span style="color:red;">*</span></label>
                                                                <input type="text" class="form-control" required name="employee_name" value="{{ $data->employee_name }}" required>
                                                            </div>   
                                                            <div class="col-12 mt-4">
                                                                <label class="form-label">{{ __('app.phone') }} <span style="color:red;">*</span></label>
                                                                <input type="integer" class="form-control" required  name="phone_number" value="{{ $data->phone_number }}" required>
                                                            </div>

                                                            <div class="col-12 mt-4">
                                                                <label class="form-label">{{ __('app.PositionName') }} <span style="color:red;">*</span></label>
                                                                <select class="form-select mb-3" aria-label="Default select example" name="position" required>
                                                                    @foreach ($position_name as $item)
                                                                    <option value="{{ $data->position}}" {{ ($data->position == $item->position_name) ? 'selected' : '' }}>
                                                                        {{ $item->position_name }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="col-12 mt-4">
                                                                <label class="select-form">{{ __('app.Gender') }} <span style="color:red;">*</span></label>
                                                                    <select name="gender" class="form-control mb-3 js-select" id="formSelect">
                                                                        <option value="" selected>Select One</option>
                                                                        <option value="Female" {{ old('gender', $data->gender) == 'Female' ? 'selected' : '' }}>Female
                                                                        </option>
                                                                        <option value="Male" {{ old('gender', $data->gender) == 'Male' ? 'selected' : '' }}>Male
                                                                        </option>
                                                                    </select>
                                                            </div>
                                                            
                                                            <div class="col-12 mt-4">
                                                                <label >{{ __('app.image') }}</label>
                                                                <div class="input-group mb-3">
                                                                    <input type="file" class="form-control" id="image-file" name="image" placeholder="image" accept="image/*">
                                                                    <img src="{{ asset($data->image) }}" alt="" width="100">
                                                                </div>
                                                            </div>
                                                            <div class="col-12 mt-4">
                                                                <label class="form-label">{{ __('app.Address') }}<span style="color:red;">*</span></label>
                                                                <input type="text" required class="form-control"name="address" value="{{$data->address}}"> 
                                                            </div>
                                                            <div class="col-12 mt-4">
                                                                <label class="select-form">{{ __('app.Shift') }}</label>
                                                                <select class="form-control mb-3 js-select" name="shift" id="shift" required>
                                                                    <option value="Morning" {{ ($data->shift == 'Morning') ? 'selected' : '' }}>{{ __('app.morning') }}</option>
                                                                    <option value="Day" {{ ($data->shift == 'Day') ? 'selected' : '' }}>{{ __('app.day') }}</option>
                                                                    <option value="Evening" {{ ($data->shift == 'Evening') ? 'selected' : '' }}>{{ __('app.evening') }}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 mt-4">
                                                            <label class="form-label">{{ __('app.Address') }}<span style="color:red;">*</span></label>
                                                            <input type="text" required class="form-control" name="address" value="{{ $data->address }}">
                                                        </div>
                                                        <div class="col-12 mt-4">
                                                            <label class="select-form">{{ __('app.Shift') }}</label>
                                                            <select class="form-control mb-3 js-select" name="shift" id="shift" required>
                                                                <option value="Morning" {{ ($data->shift == "Morning") ? 'selected' : '' }}>{{ __('app.morning') }}</option>
                                                                <option value="Day" {{ ($data->shift == "Day") ? 'selected' : '' }}>{{ __('app.day') }}</option>
                                                                <option value="Evening" {{ ($data->shift == "Evening") ? 'selected' : '' }}>{{ __('app.evening') }}</option>
                                                            </select>
                                                        </div>

                                                            <div class="col-12 mt-4">
                                                                <label class="form-label">{{ __('app.Salary') }}<span style="color:red;">*</span></label>
                                                                <input type="text" required class="form-control" placeholder="{{ __('app.Salary') }}" name="salary" value="{{$data->salary}}">
                                                            </div>


                                                        <div class="col-12 mt-3">
                                                            <div class="d-grid">
                                                                <button type="submit" class="btn btn-primary">{{ __('app.Submit') }}</button>
                                                            </div>
                                                        </div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="deleteModal{{$key}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header" style="background: #7c00a7">
                                                    <h5 class="modal-title text-white" id="exampleModalLabel">{{__('app.Stuff')}} {{__('app.Delete')}}</h5>
                                                    <button type="button" class="btn-close btn-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form method="get" action="{{route('school.staff.delete',$data->id)}}">
                                                    <div class="modal-body">
                                                        <h5>{{__('app.surecall')}} ?</h5>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('app.No')}}</button>
                                                        <button type="submit" class="btn btn-primary">{{__('app.yes')}}</button>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>

                                </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- Modal -->
<div class="modal fade" id="delete_all_records" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#7c00a7;">
                <h4 class="modal-title" id="exampleModalLabel" style="color:white;">{{__('app.Stuff')}} {{__('app.Record')}}</h4>
                <button type="button" class="btn-close btn-white" style="color:white;" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5>
                    {{__('app.checkdelete')}}
                </h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('app.no')}}</button>
                <button type="button" id="all_delete" class="btn btn-primary">{{__('app.yes')}}</button>
            </div>
        </div>
    </div>
</div>

<?php
$tutorialShow = getTutorial('staff-salary-show');
?>
@include('frontend.partials.tutorial')

@endsection

@push('js')
<script>
    $(function(e) {
        $("#select_all_ids").click(function() {
            $('.check_id').prop('checked', $(this).prop('checked'));
        });
        $("#all_delete").click(function(e) {
            e.preventDefault();
            var all_ids = [];
            $('input:checkbox[name=ids]:checked').each(function() {
                all_ids.push($(this).val());
            });
            // console.log(all_ids);
            $.ajax({
                url: "{{route('staff.Check.delete')}}",
                type: "DELETE",
                data: {
                    ids: all_ids,
                    _token: "{{csrf_token()}}"
                },
                success: function(response) {
                    $.each(all_ids, function(key, val) {
                        $('#staff_ids' + val).remove();
                        window.location.reload(true);
                    });
                }
            });

        });
    });
</script>
@endpush