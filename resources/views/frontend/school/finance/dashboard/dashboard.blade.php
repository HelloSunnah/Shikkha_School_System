@extends('layouts.school.master')

@section('content')
    <main class="page-content">

        <div class="row">
            <div class="col-xl-4 mb-2 mx-auto">
                <a href="{{ route('teacher.salary.Show') }}">
                    <div class="card  bg-white mb-0" style="border-radius:18px;box-shadow:4px 3px 13px  .7px #eedff5;">
                        <h6 class="mb-0 text-center" style="color: blueviolet;margin-top:20px">
                            {{ __('app.Total Teacher Salary') }}</h6>
                        <div class="card-body text-center p-4">
                            <h3 style="color:rgb(2, 2, 2);">{{ number_format($teacherSalary) }} ৳</h3>
                            <div class="d-flex justify-content-center gap-3 pt-4">
                                <h6 style="color:#30d915"><i class="bi bi-graph-up-arrow"></i> 17% </h6>
                                <p style="color:rgb(36, 36, 36)">{{ __('app.sincelastweek') }}</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-4 mb-2 mx-auto">
                <a href="{{ route('teacher.salary.Show') }}">
                    <div class="card  bg-white mb-0" style="border-radius:18px;box-shadow:4px 3px 13px  .7px #eedff5;">
                        <h6 class="mb-0 text-center" style="color: blueviolet;margin-top:20px">
                            {{ __('app.Total Teacher Salary Paid') }}</h6>
                        <div class="card-body text-center p-4">
                            <h3 style="color:rgb(2, 2, 2);">{{ number_format($teacherPaidSalary) }} ৳</h3>
                            <div class="d-flex justify-content-center gap-3 pt-4">
                                <h6 style="color:#30d915"><i class="bi bi-graph-up-arrow"></i> 17% </h6>
                                <p style="color:rgb(36, 36, 36)">{{ __('app.sincelastweek') }}</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-4 mb-2 mx-auto">
                <a href="{{ route('teacher.salary.Show') }}">
                    <div class="card  bg-white mb-0" style="border-radius:18px;box-shadow:4px 3px 13px  .7px #eedff5;">
                        <h6 class="mb-0 text-center" style="color: blueviolet;margin-top:20px">
                            {{ __('app.Total Teacher Salary Due') }}</h6>
                        <div class="card-body text-center p-4">
                            <h3 style="color:rgb(2, 2, 2);">{{number_format ($teacherSalary - $teacherPaidSalary) }} ৳</h3>
                            <div class="d-flex justify-content-center gap-3 pt-4">
                                <h6 style="color:#30d915"><i class="bi bi-graph-up-arrow"></i> 17% </h6>
                                <p style="color:rgb(36, 36, 36)">{{ __('app.sincelastweek') }}</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

        </div>
        <div class="row">
            <div class="col-xl-4 mb-2 mx-auto">
                <a href="{{route('school.staff.salary.List')}}">
                    <div class="card  bg-white mb-0" style="border-radius:18px;box-shadow:4px 3px 13px  .7px #eedff5;">
                        <h6 class="mb-0 text-center" style="color: blueviolet;margin-top:20px">{{__('app.Staff Salary')}}</h6>
                        <div class="card-body text-center p-4">
                            <h3 style="color:rgb(2, 2, 2);">{{number_format($StaffSalary)}} ৳</h3>
                            <div class="d-flex justify-content-center gap-3 pt-4">
                                <h6 style="color:#30d915"><i class="bi bi-graph-up-arrow"></i> 17% </h6>
                                <p style="color:rgb(36, 36, 36)">{{ __('app.sincelastweek') }}</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-4 mb-2 mx-auto">
                <a href="{{route('school.staff.salary.List')}}">
                    <div class="card  bg-white mb-0" style="border-radius:18px;box-shadow:4px 3px 13px  .7px #eedff5;">
                        <h6 class="mb-0 text-center" style="color: blueviolet;margin-top:20px">{{__('app.Staff Salary Paid')}}</h6>
                        <div class="card-body text-center p-4">
                            <h3 style="color:rgb(2, 2, 2);">{{number_format($StaffPaidSalary)}} ৳</h3>
                            <div class="d-flex justify-content-center gap-3 pt-4">
                                <h6 style="color:#30d915"><i class="bi bi-graph-up-arrow"></i> 17% </h6>
                                <p style="color:rgb(36, 36, 36)">{{ __('app.sincelastweek') }}</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-4 mb-2 mx-auto">
                <a href="{{route('school.staff.salary.List')}}">
                    <div class="card  bg-white mb-0" style="border-radius:18px;box-shadow:4px 3px 13px  .7px #eedff5;">
                        <h6 class="mb-0 text-center" style="color: blueviolet;margin-top:20px">
                            {{ __('app.Staff Salary Due') }}</h6>
                        <div class="card-body text-center p-4">
                            <h3 style="color:rgb(2, 2, 2);">{{number_format($StaffSalary - $StaffPaidSalary)}} ৳</h3>
                            <div class="d-flex justify-content-center gap-3 pt-4">
                                <h6 style="color:#30d915"><i class="bi bi-graph-up-arrow"></i> 17% </h6>
                                <p style="color:rgb(36, 36, 36)">{{ __('app.sincelastweek') }}</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

        </div>
        <div class="row">
            <div class="col-xl-4 mb-2 mx-auto">
                <a href="{{route('expense.show')}}">
                    <div class="card  bg-white mb-0" style="border-radius:18px;box-shadow:4px 3px 13px  .7px #eedff5;">
                        <h6 class="mb-0 text-center" style="color: blueviolet;margin-top:20px">{{__('app.Total Expense')}} {{__('app.This Month')}}</h6>
                        <div class="card-body text-center p-4">
                            <h3 style="color:rgb(2, 2, 2);">{{number_format($ExpenseThisMonth)}} ৳</h3>
                            <div class="d-flex justify-content-center gap-3 pt-4">
                                <h6 style="color:#30d915"><i class="bi bi-graph-up-arrow"></i> 17% </h6>
                                <p style="color:rgb(36, 36, 36)">{{ __('app.sincelastweek') }}</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-4 mb-2 mx-auto">
                <a href="{{route('school.finance.userlist')}}">
                    <div class="card  bg-white mb-0" style="border-radius:18px;box-shadow:4px 3px 13px  .7px #eedff5;">
                        <h6 class="mb-0 text-center" style="color: blueviolet;margin-top:20px">{{__('app.Total Student Fee')}}</h6>
                        <div class="card-body text-center p-4">
                            <h3 style="color:rgb(2, 2, 2);">{{number_format($TotalFees)}} ৳</h3>
                            <div class="d-flex justify-content-center gap-3 pt-4">
                                <h6 style="color:#30d915"><i class="bi bi-graph-up-arrow"></i> 17% </h6>
                                <p style="color:rgb(36, 36, 36)">{{ __('app.sincelastweek') }}</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-4 mb-2 mx-auto">
                <a href="{{route('school.finance.userlist')}}">
                    <div class="card  bg-white mb-0" style="border-radius:18px;box-shadow:4px 3px 13px  .7px #eedff5;">
                        <h6 class="mb-0 text-center" style="color: blueviolet;margin-top:20px">{{__('app.Collected Fee')}}</h6>
                        <div class="card-body text-center p-4">
                            <h3 style="color:rgb(2, 2, 2);">{{number_format($colected)}} ৳</h3>
                            <div class="d-flex justify-content-center gap-3 pt-4">
                                <h6 style="color:#30d915"><i class="bi bi-graph-up-arrow"></i> 17% </h6>
                                <p style="color:rgb(36, 36, 36)">{{ __('app.sincelastweek') }}</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

        </div>
        <div class="row">
            <div class="col-xl-4 mb-2 mx-auto">
                <a href="{{route('school.finance.userlist')}}">
                    <div class="card  bg-white mb-0" style="border-radius:18px;box-shadow:4px 3px 13px  .7px #eedff5;">
                        <h6 class="mb-0 text-center" style="color: blueviolet;margin-top:20px">{{__('app.Due Fee')}}</h6>
                        <div class="card-body text-center p-4">
                            <h3 style="color:rgb(2, 2, 2);">{{$due}} ৳</h3>
                            <div class="d-flex justify-content-center gap-3 pt-4">
                                <h6 style="color:#30d915"><i class="bi bi-graph-up-arrow"></i> 17% </h6>
                                <p style="color:rgb(36, 36, 36)">{{ __('app.sincelastweek') }}</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-4 mb-2 mx-auto">
                <a href="{{route('fund.show')}}">
                    <div class="card  bg-white mb-0" style="border-radius:18px;box-shadow:4px 3px 13px  .7px #eedff5;">
                        <h6 class="mb-0 text-center" style="color: blueviolet;margin-top:20px">{{__('app.Fund Receive')}}</h6>
                        <div class="card-body text-center p-4">
                            <h3 style="color:rgb(2, 2, 2);">{{number_format($sumFund)}} ৳</h3>
                            <div class="d-flex justify-content-center gap-3 pt-4">
                                <h6 style="color:#30d915"><i class="bi bi-graph-up-arrow"></i> 17% </h6>
                                <p style="color:rgb(36, 36, 36)">{{ __('app.sincelastweek') }}</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-4 mb-2 mx-auto">
                <a href="#">
                    <div class="card  bg-white mb-0" style="border-radius:18px;box-shadow:4px 3px 13px  .7px #eedff5;">
                        <h6 class="mb-0 text-center" style="color: blueviolet;margin-top:20px">{{__('app.Accesories')}}</h6>
                        <div class="card-body text-center p-4">
                            <h3 style="color:rgb(2, 2, 2);">{{number_format($accesories)}} ৳</h3>
                            <div class="d-flex justify-content-center gap-3 pt-4">
                                <h6 style="color:#30d915"><i class="bi bi-graph-up-arrow"></i> 17% </h6>
                                <p style="color:rgb(36, 36, 36)">{{ __('app.sincelastweek') }}</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

        </div>
        <div class="row">
            <div class="col-xl-4 mb-2 mx-auto">
                <a href="{{route('expense.show')}}">
                    <div class="card  bg-white mb-0" style="border-radius:18px;box-shadow:4px 3px 13px  .7px #eedff5;">
                        <h6 class="mb-0 text-center" style="color: blueviolet;margin-top:20px">{{__('app.Total Expense')}}</h6>
                        <div class="card-body text-center p-4">
                            <h3 style="color:rgb(2, 2, 2);">{{number_format($Expense)}} ৳</h3>
                            <div class="d-flex justify-content-center gap-3 pt-4">
                                <h6 style="color:#30d915"><i class="bi bi-graph-up-arrow"></i> 17% </h6>
                                <p style="color:rgb(36, 36, 36)">{{ __('app.sincelastweek') }}</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-4 mb-2 mx-auto">
                <a href="{{route('fund.show')}}">
                    <div class="card  bg-white mb-0" style="border-radius:18px;box-shadow:4px 3px 13px  .7px #eedff5;">
                        <h6 class="mb-0 text-center" style="color: blueviolet;margin-top:20px">{{__('app.Fund Receive')}}</h6>
                        <div class="card-body text-center p-4">
                            <h3 style="color:rgb(2, 2, 2);">{{number_format($totalSchoolFund)}} ৳</h3>
                            <div class="d-flex justify-content-center gap-3 pt-4">
                                <h6 style="color:#30d915"><i class="bi bi-graph-up-arrow"></i> 17% </h6>
                                <p style="color:rgb(36, 36, 36)">{{ __('app.sincelastweek') }}</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @if ($profit > '0')
            <div class="col-xl-4 mb-2 mx-auto">
                <a href="#">
                    <div class="card  bg-white mb-0" style="border-radius:18px;box-shadow:4px 3px 13px  .7px #eedff5;">
                        <h6 class="mb-0 text-center" style="color: blueviolet;margin-top:20px">{{__('app.Total Profit')}}</h6>
                        <div class="card-body text-center p-4">
                            <h3 style="color:rgb(2, 2, 2);">{{number_format($profit)}} ৳</h3>
                            <div class="d-flex justify-content-center gap-3 pt-4">
                                <h6 style="color:#30d915"><i class="bi bi-graph-up-arrow"></i> 17% </h6>
                                <p style="color:rgb(36, 36, 36)">{{ __('app.sincelastweek') }}</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @else 
            <div class="col-xl-4 mb-2 mx-auto">
                <a href="#">
                    <div class="card  bg-white mb-0" style="border-radius:18px;box-shadow:4px 3px 13px  .7px #eedff5;">
                        <h6 class="mb-0 text-center" style="color: blueviolet;margin-top:20px">{{__('app.Total Loss')}}</h6>
                        <div class="card-body text-center p-4">
                            <h3 style="color:rgb(2, 2, 2);">{{number_format(abs($profit))}} ৳</h3>
                            <div class="d-flex justify-content-center gap-3 pt-4">
                                <h6 style="color:#30d915"><i class="bi bi-graph-up-arrow"></i> 17% </h6>
                                <p style="color:rgb(36, 36, 36)">{{ __('app.sincelastweek') }}</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endif
        </div>
        <!--end Cards-->


    {{-- filter reports --}}

    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-body">
                    <div class="form-group">
                        <div class="row">

                            <div class="col-md">
                                <label for=""><b>{{__('app.Search On Date/Start Date')}}</b></label>
                                <input type="text" placeholder="YYYY-MM-DD" id="datepicker" name="searchdate" class="form-control @error('searchdate') is-invalid @enderror">

                                @error('searchdate')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror


                            </div>
                            <div class="col-md">
                                <label for=""><b>{{__('app.Search End Date')}}</b></label>
                                <input type="text" placeholder="YYYY-MM-DD" id="datepicker2" name="enddate" class="form-control @error('enddate') is-invalid @enderror">

                                @error('enddate')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                            </div>
                            <div class="col-md">
                                <label for=""><b>{{__('app.Search On month')}}</b></label>
                                <select class="form-control mb-3 js-select" id="searchmonth" onchange="loadmonthyreport()" name="searchmonth" class="form-control @error('searchmonth') is-invalid @enderror">
                                    <option value="" selected>{{__('app.Month')}} {{__('app.select')}}</option>
                                    <option value="1" @isset(request()->searchmonth) {{(request()->searchmonth == 1) ? 'selected' : ''}} @endisset>January</option>
                                    <option value="2" @isset(request()->searchmonth) {{(request()->searchmonth == 2) ? 'selected' : ''}} @endisset>February</option>
                                    <option value="3" @isset(request()->searchmonth) {{(request()->searchmonth == 3) ? 'selected' : ''}} @endisset>March</option>
                                    <option value="4" @isset(request()->searchmonth) {{(request()->searchmonth == 4) ? 'selected' : ''}} @endisset>April</option>
                                    <option value="5" @isset(request()->searchmonth) {{(request()->searchmonth == 5) ? 'selected' : ''}} @endisset>May</option>
                                    <option value="6" @isset(request()->searchmonth) {{(request()->searchmonth == 6) ? 'selected' : ''}} @endisset>June</option>
                                    <option value="7" @isset(request()->searchmonth) {{(request()->searchmonth == 7) ? 'selected' : ''}} @endisset>July</option>
                                    <option value="8" @isset(request()->searchmonth) {{(request()->searchmonth == 8) ? 'selected' : ''}} @endisset>August</option>
                                    <option value="9" @isset(request()->searchmonth) {{(request()->searchmonth == 9) ? 'selected' : ''}} @endisset>September</option>
                                    <option value="10" @isset(request()->searchmonth) {{(request()->searchmonth == 10) ? 'selected' : ''}} @endisset>October</option>
                                    <option value="11" @isset(request()->searchmonth) {{(request()->searchmonth == 11) ? 'selected' : ''}} @endisset>November</option>
                                    <option value="12" @isset(request()->searchmonth) {{(request()->searchmonth == 12) ? 'selected' : ''}} @endisset>December</option>
                                </select>

                                @error('searchmonth')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                            </div>
                            <div class="col">
                                <label for="search"> </label><br>
                                <button class="btn btn-primary" onclick="loadAmount()">{{__('app.search')}}</button>                                    
                            </div>

                        </div>
                    </div>                    
                </div>
            </div>
        </div>                        
    </div>

    <div class="card col-md-8">
        <div class="card shadow">
            <div class="card-body  table-responsive">
                <table id="example" class="table table-striped table-hover data-table">                           
                    <thead>
                        <tr >
                            <th class="col-8">{{__('app.Type')}}</th>
                            <th class="col-4">{{__('app.Amount')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Student Fees Collection</td>
                            <td id="student-fees"></td>
                        </tr>
                        <tr>
                            <td>Accessories Sell</td>
                            <td id="accessories"></td>
                        </tr>
                        <tr>
                            <td>Total Fund</td>
                            <td id="fund"></td>
                        </tr>
                        <tr>
                            <td>Total Expense</td>
                            <td id="expense"></td>
                        </tr>
                        <tr>
                            <td>Teacher Salary</td>
                            <td id="teacher-salary"></td>
                        </tr>
                        <tr>
                            <td>Staff Salary</td>
                            <td id="staff-salary"></td>
                        </tr>
                        <tr>
                            <td>Total Receive</td>
                            <td id="total-received"></td>
                        </tr>
                        <tr>
                            <td>Total Expenses</td>
                            <td id="total-expense"></td>
                        </tr>
                        
                        <tr>
                            <td>Profit/loss</td>
                            <td id="profit"></td>
                        </tr>                                                
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    {{-- End Filter Reports --}}
</main>

@endsection

    
{{-- url:'{{_r_o_u_t_e('school.finance.dashoboard.filtered')}}', --}}

@push('js')
    <script>
        // function loadAmount() {
        //     let searchdate = $("#datepicker").val();
        //     let enddate = $("#datepicker2").val();
        //     let searchMonth = $("#searchMonth").val();
        //     $.ajax({
        //         
        //         method:'POST',
        //         data:{
        //             '_token':'{{csrf_token()}}',
        //             searchdate:searchdate,
        //             enddate:enddate,
        //             searchmonth:searchmonth,
        //         },
        //         success: function (response) {                    
        //             document.getElementById('student-fees').innerHTML = 'Student fees: ' + response.sumstudent;
        //             document.getElementById('accessories').innerHTML = 'Accessories: ' + response.sumaccesories;
        //             document.getElementById('fund').innerHTML = 'Funds: ' + response.sumfund;
        //             document.getElementById('expense').innerHTML = 'Expense: ' + response.sumexpenses;
        //             document.getElementById('teacher-salary').innerHTML = 'Teacher Salary: ' + response.sumTeacher;
        //             document.getElementById('staff-salary').innerHTML = 'Staff Salary: ' + response.sumstaff;
        //             document.getElementById('profit').innerHTML = 'Profit: ' + response.profit;
        //         }
        //     });
        // }
        

        function loadmonthyreport() {
            let searchMonth = $("#searchMonth").val();
            $.ajax({
                url:'{{route('school.finance.dashoboard.filtered.monthly')}}',
                method:'POST',
                data:{
                    '_token':'{{csrf_token()}}',
                    searchmonth:searchmonth,
                },
                success: function (response) {                    
                    document.getElementById('student-fees').innerHTML = 'Student fees: ' + response.sumstudent;
                    document.getElementById('accessories').innerHTML = 'Accessories: ' + response.sumaccesories;
                    document.getElementById('fund').innerHTML = 'Funds: ' + response.sumfund;
                    document.getElementById('expense').innerHTML = 'Expense: ' + response.sumexpenses;
                    document.getElementById('teacher-salary').innerHTML = 'Teacher Salary: ' + response.sumTeacher;
                    document.getElementById('staff-salary').innerHTML = 'Staff Salary: ' + response.sumstaff;
                    document.getElementById('profit').innerHTML = 'Profit: ' + response.profit;
                }
            });
        }
    </script>

    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
    <script>
        $(document).ready(function(){
            $("#datepicker").datepicker({
                yearRange: "1950:2030",
                dateFormat: "yy-mm-dd",
                yearRange: "1950:2030",
                changeMonth: true,
                changeYear: true,
            });
        })
        $(document).ready(function(){
            $("#datepicker2").datepicker({
                yearRange: "1950:2030",
                dateFormat: "yy-mm-dd",
                yearRange: "1950:2030",
                changeMonth: true,
                changeYear: true,
            });
        })
    </script>

@endpush
