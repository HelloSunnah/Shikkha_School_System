@extends('layouts.school.master')

@push('css')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
@endpush

@section('content')
    <!--start content-->
    <main class="page-content">       


        <div class="row">
            <div class="col-xl-12">                 
                <div class="card-header py-3 bg-transparent">
                    <div class="d-sm-flex align-items-center">
                        <h5 class="mb-2 mb-sm-0" ><a href="{{route('expense.show')}}"><span style="color:black;"> {{__('app.expenses_list')}}</span></a></h5>
                        <div class="ms-auto">
                            <button type="button" class="btn btn-secondary" onclick="history.back()">{{__('app.back')}}</button>
                            <a href="{{route('expense.create')}}" class="btn btn-primary">{{__('app.Add new expense')}}</a>

                        </div>
                    </div>
                </div>

                <div class="row" >
                    <div class="col">
                        <div class="card shadow">
            
                            <div class="card-body">
            
                                <div class="form-group">
                                    <form action="{{route('expense.show')}}" method="GET" id="orderIdForm">
                                        @csrf
                                        
                                        <div class="form-group">
                                            <div class="row">
            
                                                <div class="col-md">
                                                    <label for=""><b>{{__('app.Search On Date/Start Date')}}</b></label>
                                                    <input type="text" placeholder="YYYY-MM-DD" id="datepicker" name="searchdate" 
                                                        class="form-control @error('searchdate') is-invalid @enderror">
            
                                                    @error('searchdate')
                                                        <span class="invalid-feedback">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                            
                                                </div>
                                                <div class="col-md">
                                                    <label for=""><b>{{__('app.Search End Date')}}</b></label>
                                                    <input type="text" placeholder="YYYY-MM-DD" id="datepicker2" name="enddate" 
                                                        class="form-control @error('enddate') is-invalid @enderror">
            
                                                    @error('enddate')
                                                        <span class="invalid-feedback">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                            
                                                </div>
                                            
            
                                        
                                                <div class="col-md">
                                                    <label for=""><b>{{__('app.Search On month')}}</b></label>
                                                    <select  class="form-control mb-3 js-select" name="searchmonth" class="form-control @error('searchmonth') is-invalid @enderror">
                                                    <option value="" selected>{{__('app.Month')}} {{__('app.select')}}</option>
                                                    <option value="1" @isset(request()->searchmonth) {{(request()->searchmonth == 1) ? 'selected' : ''}}  @endisset>January</option>
                                                    <option value="2" @isset(request()->searchmonth) {{(request()->searchmonth == 2) ? 'selected' : ''}}  @endisset>February</option>
                                                    <option value="3" @isset(request()->searchmonth) {{(request()->searchmonth == 3) ? 'selected' : ''}}  @endisset>March</option>
                                                    <option value="4" @isset(request()->searchmonth) {{(request()->searchmonth == 4) ? 'selected' : ''}}  @endisset>April</option>
                                                    <option value="5" @isset(request()->searchmonth) {{(request()->searchmonth == 5) ? 'selected' : ''}}  @endisset>May</option>
                                                    <option value="6" @isset(request()->searchmonth) {{(request()->searchmonth == 6) ? 'selected' : ''}}  @endisset>June</option>
                                                    <option value="7" @isset(request()->searchmonth) {{(request()->searchmonth == 7) ? 'selected' : ''}}  @endisset>July</option>
                                                    <option value="8" @isset(request()->searchmonth) {{(request()->searchmonth == 8) ? 'selected' : ''}}  @endisset>August</option>
                                                    <option value="9" @isset(request()->searchmonth) {{(request()->searchmonth == 9) ? 'selected' : ''}}  @endisset>September</option>
                                                    <option value="10" @isset(request()->searchmonth) {{(request()->searchmonth == 10) ? 'selected' : ''}}  @endisset>October</option>
                                                    <option value="11" @isset(request()->searchmonth) {{(request()->searchmonth == 11) ? 'selected' : ''}}  @endisset>November</option>
                                                    <option value="12" @isset(request()->searchmonth) {{(request()->searchmonth == 12) ? 'selected' : ''}}  @endisset>December</option>
                                                </select>
            
                                                    @error('searchmonth')
                                                        <span class="invalid-feedback">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                            
                                                </div>
            
                                                 
                                                
                                                <div class="col">
                                                    <label for="search">  </label><br>
                                                    <button class="btn btn-primary">{{__('app.search')}}</button>
                                                </div>
            
                                                
                                            </div>
                                        </div>
                                            
                                    </form>
                                </div>
                                
                            </div>
                        </div>
                    </div>
               </div>

               <div class="card shadow">
                <div class="card-body" >
                    <h4><span class="align: center;">{{__('app.Total Expense')}}: {{number_format($sumFund)}}</span> 
                        <i class="fa-solid fa-bangladeshi-taka-sign"></i> 
                    </h4>
                </div>
            </div>
                
                <div class="card shadow">
                    <div class="card-body  table-responsive">
                        <table id="example" class="table table-striped table-hover data-table">
                            <button type="button" class="btn btn-danger btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#delete_all_records" >
                                {{__('app.deleteall')}}
                               </button>                            <thead>
                                <tr >
                                    <th><input type="checkbox" id="select_all_ids"></th>
                                    <th scope="col">{{__('app.ID')}}</th>
                                    <th scope="col">{{__('app.date')}}</th>
                                    <th scope="col">{{__('app.Expense Purpose')}}</th>
                                    <th scope="col">{{__('app.Payment Method')}}</th>
                                    <th scope="col">{{__('app.Account')}}</th>
                                    <th scope="col">{{__('app.Expense by')}}</th>
                                    <th scope="col">{{__('app.Amount')}}</th>
                                    <th scope="col">{{__('app.Remark')}}</th>
                                    <th scope="col">{{__('app.action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($expense as $key => $item)
                                <tr id="expence_ids{{$item->id}}">
                                    <td><input type="checkbox" class="check_ids" name="ids" value="{{$item->id}}"></td>
                                    <th scope="row" >{{++$key}}</th>
                                    <td>{{date('d-m-Y',strtotime($item->datee))}}</td>
                                    <td>{{$item->purpose}}</td>
                                    <td>@if( $item->payment_method == 1) Hand Cash
                                        @elseif( $item->payment_method == 2) Bank Transiction 
                                        @else 
                                        @endif
                                    </td>
                                    <td>{{ \App\Models\Bank::find($item->account)->account_number ?? ""}}</td>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->amount}}</td>
                                    <td>{{$item->remark}}</td>
                                    <td class="text-nowrap">
                                            <a href="{{ route('expense.edit', $item->id) }}" class="btn btn-sm btn-primary">
                                                {{__('app.Edit')}}
                                        </a>
            
                                        <button class="btn btn-sm btn-primary"
                                            onclick="if(confirm('Are you sure? you are going to delete this record')){ location.replace('delete/{{$item->id}}'); }">
                                            {{__('app.Delete')}}
                                        </button> 
                                    </td>
                                    
                                </tr>
                                @empty
                                <tr>
                                    <div class="col-12 py-5 text-center">
                                        <tr>
                                            <td colspan="9" style="text-align: center;">No record found</td>
                                        </tr>
                                    </div>
                                </tr>
                                @endforelse
                                
                            </tbody>
                        </table>
                    </div>
                </div> 
            </div>
        </div>
    </main>
    <!-- delete checkbox Modal -->
<div class="modal fade" id="delete_all_records" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content" >
        <div class="modal-header" style="background-color:blueviolet;">
          <h4 class="modal-title" id="exampleModalLabel" style="color:white;">{{__('app.Status4')}} {{__('app.Record')}}</h4>
          <button type="button" class="btn-close btn-white" style="color:white;" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <h5>
            {{__('app.checkdelete')}}
          </h5>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('app.no')}}</button>
          <button type="button" id="all_delete" class="btn btn-primary" style="background-color:blueviolet !important;border-color:blueviolet !important;">{{__('app.yes')}}</button>
        </div>
      </div>
    </div>
</div>
    <?php
    $tutorialShow = getTutorial('department-show');
    ?>
    @include('frontend.partials.tutorial')
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

    <script>
        $(function(e){
            $("#select_all_ids").click(function(){
                $('.check_ids').prop('checked',$(this).prop('checked'));
            });
            $("#all_delete").click(function(e){
                e.preventDefault();
                var all_ids=[];
                $('input:checkbox[name=ids]:checked').each(function(){
                    all_ids.push($(this).val());
                });
                console.log(all_ids);
                $.ajax({
                    url:"{{route('expense.check.delete')}}",
                    type:"DELETE",
                    data:{
                        ids:all_ids,
                        _token:"{{csrf_token()}}"
                    },
                    success:function(response){
                        $.each(all_ids,function(key,val){
                            $('#expense_ids'+val).remove();
                            window.location.reload(true);
                        });
                    }
                });
            });
            });
    </script>
@endpush