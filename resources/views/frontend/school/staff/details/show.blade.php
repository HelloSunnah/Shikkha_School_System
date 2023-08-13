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
                                        <button class="btn btn-primary btn-sm mb-3" onclick="showPaymentDetails('{{$data->id}}')">Pay Salary</button>
                                        @else
                                        <div class="btn-group mr-2" role="group" aria-label="First group">
                                            <a href="{{route('staff.view',$data->id)}}" class="btn btn-info btn-sm" title="{{__('app.View')}}"><i class="bi bi-eye"></i></a>



                                            @endif
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
</main>

{{-- Modal for showing salary details --}}
<div class="modal fade" id="payment_details">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Payment Details</h5>
            </div>
            <div class="modal-body table-responsive">

            </div>
        </div>
    </div>
</div>


{{-- modal for salary payment --}}
<div class="modal fade" id="paySalaryModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: #7c00a7">
                <h5 class="modal-title text-white" id="exampleModalLabel">Pay Salary</h5>
                <button type="button" class="btn-close btn-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

            </div>
        </div>
    </div>
</div>

<!-- Delete All Modal -->
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
    const currency = '৳';

    let showPaymentDetails = (staffId) => {

        $.ajax({
            url: '/school/staff-salary/history/' + staffId,
            type: 'get',
            success: (response) => {
                console.log(response);

                if (response.data.length) {
                    let paidAmount, dueAmount, salaryStatus, fixed_salary, paid_amount, month_name, last_update_at;

                    let element = `<table class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Month Name</th>
                                                <th>Amount</th>
                                                <th>Due</th>
                                                <th>Last updated Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>`;

                    response.data.forEach((item, key) => {

                        fixed_salary = Number(parseFloat(item['fixed_salary']));
                        paid_amount = item['paid_amount'];
                        month_name = item['month'];
                        last_updated_at = item['last_updated_at'];
                        if (paid_amount == 0) {
                            paidAmount = '<span class="badge bg-warning text-dark">UNPAID</span>';
                            dueAmount = fixed_salary;
                        } else {
                            paidAmount = paid_amount + currency;
                            dueAmount = fixed_salary - paid_amount;
                        }

                        if (paid_amount != fixed_salary) {
                            salaryStatus = `<button class="btn btn-primary btn-sm mb-3" onclick="paySalaryModal(${fixed_salary}, ${paid_amount}, '${month_name}', ${item['id']})">Pay Salary</button>`;
                        } else {
                            salaryStatus = `<button class="btn btn-primary btn-sm mb-3" style="pointer-events: none; background: #7c00a7;">Full Paid</button>`;
                        }


                        element += `<tr>
                                <td>${month_name}</td>
                                <td>${paidAmount}</td>
                                <td>${dueAmount} ${currency}</td>
                                <td>${last_updated_at}</td>
                                <td>${salaryStatus}</td>
                            </tr>`
                    });

                    element += `</tbody></table>`;

                    $("#payment_details .modal-body").html(element);

                    $("#payment_details").modal('show');
                } else {
                    Swal.fire({
                        icon: 'info',
                        title: 'Not found',
                        text: "Record does not exists",
                    });
                }
            },
            error: (error) => {
                console.log(error);

                Swal.fire({
                    icon: 'error',
                    title: 'Server Error',
                    text: error.responseJSON.message,
                });
            },
        });

    }


    let paySalaryModal = (FixedSalary, PaidAmount, Month, RowId) => {

        let paidAmount = FixedSalary;

        if (PaidAmount != 0) {
            paidAmount = paidAmount - PaidAmount;
        }


        let element = `<form class="row g-3" method="post" enctype="multipart/form-data" id="paidSalaryForm" onsubmit="paidSalaryFormSubmit(event)">
                    @csrf
                    <input type="hidden" name="id" value="${RowId}"/>
                    <div class="col-12">
                        <label class="form-label text-dark">Pay For ${Month}</label>
                        <input type="text" class="form-control" name="amount" value="${paidAmount}" placeholder="${paidAmount}">
                    </div>
                    <div class="col-12">
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>`;

        $("#paySalaryModal .modal-body").html(element);

        $("#paySalaryModal").modal("show");
    }


    let paidSalaryFormSubmit = (event) => {
        event.preventDefault();

        $.ajax({
            url: '{{route("school.staff.salary.update")}}',
            type: 'POST',
            data: $("#paidSalaryForm").serialize(),
            success: (response) => {
                console.log(response);
                showPaymentDetails(response.data.staffId);

                $("#paySalaryModal").modal("hide");
                Swal.fire({
                    icon: 'success',
                    title: 'Great!',
                    text: response.message,
                });
            },
            error: (error) => {
                console.log(error);

                Swal.fire({
                    icon: 'error',
                    title: 'Server Error',
                    text: error.responseJSON.message,
                });
            }
        });
    }


    $(function(e) {
                $("#select_all_ids").click(function() {
                    $('.check_id').prop('checked', $(this).prop('checked'));
                });
            }
</script>


@endpush