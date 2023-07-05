@extends('layouts.school.master')
@push('css')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">

@endpush
@section('content')
<!--start content-->
<!--start content-->
<main class="page-content">


    <div class="row text-dark">
        <div class="col-xl-12">
            <div class="card-header py-3 bg-transparent">
                <div class="d-sm-flex align-items-center">
                    <h5 class="mb-2 mb-sm-0 text"><a href="{{route('fund.show')}}"><span style="color:black;">{{__('app.All')}} {{__('app.Fund List')}}</span></a></h5>
                    <div class="ms-auto">
                        <button type="button" class="btn btn-secondary" onclick="history.back()">{{__('app.back')}}</button>
                        <a href="{{route('expense.create')}}" class="btn btn-primary"> {{__('app.Add new Fund')}}</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="card shadow">

                    <div class="card-body">
    
                        <div class="form-group">
                            <form action="{{route('fund.list')}}" method="GET" id="orderIdForm">
                                @csrf
    
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
                                            <select class="form-control mb-3 js-select" name="searchmonth" class="form-control @error('searchmonth') is-invalid @enderror">
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
                                            <button class="btn btn-primary">{{__('app.search')}}</button>
                                            <a href="{{route('fund.list')}}" class="btn btn-info">Reset</a>
                                        </div>
    
    
                                    </div>
                                </div>
    
                            </form>
                        </div>
    
    
                        {{-- <div class=" tab-pane" id="result">
                            <div class="table-responsive">
                                <table id="example" class="table table-hover table-bordered">
    
                                    <thead>
    
    
                                        <tr>
                                            <th>Date</th>
                                            <th>Fund Purpose</th>
                                            <th>Amount</th>
                                            <th>Funded By</th>
    
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($fund as $expense)
                                            <tr>
                                                <td>{{ $expense->updated_at->todatestring() }}</td>
                                                <td>{{ $expense->purpose }}</td>
                                                <td>{{ $expense->amount }}</td>
                                                <td>{{ $expense->name }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
    
                        </div> --}}
                    </div>
                </div>
            </div>
                        
        </div>

        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-body">
                        <h4><span class="align: center;">{{__('app.Total Revenue')}}: {{number_format($sumFund)}}</span>
                            <i class="fa-solid fa-bangladeshi-taka-sign"></i>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
        
        
        <div class="row">
            <div class="col">
                <div class="card-header">
    
                    <h5 class="card-title"></h5>
                    <ul class="nav nav-tabs card-header-tabs" data-bs-tabs="tabs">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="true" data-bs-toggle="tab" href="#studentFees">Student Fees</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#accessories">Accesories</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#fund">All Fund</a>
                        </li>
        
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col">            
                <div class="card">
                    <div class="card-body tab-content">
    
                        <div class="tab-pane active" id="studentFees">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
            
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Student Name</th>
                                            <th>Class</th>
                                            <th>Section</th>
                                            <th>Month</th>
                                            <th>Amount</th>
            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($student as $data)
                                        <tr>
                                            <td>{{$data->updated_at->todatestring()}}</td>
                                            <td>{{App\Models\User::find($data->student_id)?->name}} ({{App\Models\User::find($data->student_id)?->roll_number}})</td>
                                            <td>{{App\Models\InstituteClass::find(App\Models\User::find($data->student_id)->class_id)?->class_name}}</td>
                                            <td>{{App\Models\Section::find(App\Models\User::find($data->student_id)->section_id)?->section_name}}</td>
                                            <td>{{$data->month_name}}</td>
                                            <td>{{$data->paid_amount}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
            
            
            
            
                            </div>
                        </div>
        
                        <!-- Fees -->
                        <div class=" tab-pane" id="accessories">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">    
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Accesories Name</th>    
                                            <th>Amount</th>
                                            <th>Student Name</th>    
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($accesories as $data)
                                        <tr>
                                            <td>{{$data->updated_at->todatestring()}}</td>
                                            <td>{{$data->accesories}}</td>
                                            <td>{{$data->amount}}</td>
                                            <td>{{$data->name}}</td>
                                        </tr>
                                        @endforeach    
                                    </tbody>
                                </table>
                            </div>    
                        </div>
            
                        {{-- Fund list --}}
        
                        <div class=" tab-pane" id="fund">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Fund Purpose</th>
                                            <th>Amount</th>
                                            <th>Funded By</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @dd($fund); --}}
                                        @foreach($fund as $item)
                                            <tr>
                                                <td>{{$item->updated_at->todatestring()}}</td>
                                                <td>{{$item->purpose}}</td>
                                                <td>{{$item->amount}}</td>
                                                <td>{{$item->name}}</td>
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

@push('js')

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
    </script>
    <script>
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
