@extends('layouts.school.master')

@section('content')
<!--start content-->
<style>
    .Row {
        display: table;
        width: 100%;
        /*Optional*/
        table-layout: fixed;
        /*Optional*/
        border-spacing: 10px;
        /*Optional*/
    }

    .Column {
        display: table-cell;
        background-color: white;
        /*Optional*/
    }
</style>
<main class="page-content">


    <div class="col-xl-12 mx-auto">
        <!-- nav-tab -->
        <hr style="width:100%;text-align:left;margin-left:0;margin-bottom:0;height:5px;background-color:#5c84f6">
        <div class="card">
            <div class="card-header">
                <center>
                    <h3 class="mt-2 mb-2">Student Fees </h3>
                </center>
                <ul class="nav nav-tabs card-header-tabs" data-bs-tabs="tabs">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="true" data-bs-toggle="tab" href="#Profile">Fees</a>
                    </li>

                </ul>
            </div>
            <div class="card-body tab-content">
                <div class="tab-pane active" id="Profile">

                    <table class="table table-bordered w-100">
                        <tbody>
                            <tr>
                                <td rowspan="7" class="text-center" width="20%">
                                    @if(File::exists(public_path($data['student']->image)))
                                    <img src="{{asset($data['student']->image)}}" alt="{{$data['student']->name}}" width="150" height="150">
                                    @else
                                    <img src="{{asset('d/no-img.jpg')}}" alt="{{$data['student']->name}}" width="150" height="150">
                                    @endif
                                </td>
                                <th width="25%">Student Name</th>
                                <td>{{$data['student']->name}}</td>
                                <th>Roll</th>
                                <td>{{$data['student']->roll_number}}</td>

                            <tr>
                                <th>{{__('app.class')}}</th>
                                <td>{{$data['student']->class?->class_name}}</td>
                                <th>{{__('app.section')}}</th>
                                <td>{{$data['student']->section?->section_name}}</td>
                            </tr>
                            <tr>
                                <th>Shift</th>
                                <td>
                                    @if ($data['student']->shift == 1)
                                    <span class="badge bg-success px-2">{{strtoupper("Morning")}}</span>
                                    @elseif ($data['student']->shift == 2)
                                    <span class="badge bg-success px-2">{{strtoupper("Day")}}</span>
                                    @else
                                    <span class="badge bg-success px-2">{{strtoupper("Evening")}}</span>
                                    @endif
                                </td>
                                <th>SID</th>
                                <td>{{$data['student']->unique_id}}</td>
                            </tr>
                            <tr>
                                <th>Father Name</th>
                                <td>{{$data['student']->father_name}}</td>
                                <th>Mother Name</th>
                                <td>{{$data['student']->mother_name}}</td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td>{{$data['student']->phone}}</td>
                                <th></th>
                                <td></td>
                            </tr>
                    
                        </tbody>
                    </table>


                </div>
                <!-- Fees -->




            </div>
        </div>

    </div>

    <div class="col-xl-12 mx-auto">
        <!-- nav-tab -->
        <hr style="width:100%;text-align:left;margin-left:0;margin-bottom:0;height:5px;background-color:#5c84f6">
        <div class="card">
            <div class="card-header">

                <table class="table">

                    <tbody>
                        <thead>
                            <tr>
                                <th>Month</th>
                                <th>Status</th>
                                <th>Amount</th>
                                <th>Paid</th>
                                <th>Due</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        @foreach($data['months'] as $key=>$da)
                        <tr>
                            <td>{{$da}}</td>
                            <td>
                                {!!getStatus(Auth::id(),$data['student']->id,$key)!!}
                            </td>
                            <td>
                                {{getFees(Auth::id(),$data['student']->id,$key)+$data['monthlyFee']-$discountCount}}
                            </td>
                            <td> {{getPaid(Auth::id(),$data['student']->id,$key)}}
                            </td>

                            <td>
                                {{(getFees(Auth::id(),$data['student']->id,$key)+$data['monthlyFee']-$discountCount)-(getPaid(Auth::id(),$data['student']->id,$key))}}

                            </td>

                            <td><a href="" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal{{$key}}"><i class="bi bi-border-outer"></i></a>
                            </td>
                            <div class="modal fade" id="exampleModal{{$key}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel"></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{route('student.payment.post')}}" method="post">
                                                @method('put')
                                                @csrf
                                                <input type="hidden" name="month_name" value="{{$da}}">
                                                <input type="hidden" name="student_id" value="{{$data['student']->id}}">

                                                @if($da== 'January')<input type="hidden" name="month_id" value="0">
                                                @elseif($da== 'February') <input type="hidden" name="month_id" value="1">
                                                @elseif($da== 'March') <input type="hidden" name="month_id" value="2">
                                                @elseif($da== 'April') <input type="hidden" name="month_id" value="3">
                                                @elseif($da== 'May') <input type="hidden" name="month_id" value="4">
                                                @elseif($da== 'June') <input type="hidden" name="month_id" value="5">
                                                @elseif($da== 'July') <input type="hidden" name="month_id" value="6">
                                                @elseif($da== 'August') <input type="hidden" name="month_id" value="7">
                                                @elseif($da== 'September') <input type="hidden" name="month_id" value="8">
                                                @elseif($da== 'October') <input type="hidden" name="month_id" value="9">
                                                @elseif($da== 'November') <input type="hidden" name="month_id" value="10">
                                                @else <input type="hidden" name="month_id" value="11">
                                                @endif
                                                <div>
                                                    <label for="">Month</label>
                                                    <input readonly type="" placeholder="" value="{{$da}}" class="form-control">
                                                </div>

                                                <div>
                                                    <label for="">Total Amount</label>
                                                    <input type="number" readonly id="amount" name="amount" value="{{   getFees(Auth::id(),$data['student']->id,$key)+$data['monthlyFee']-$discountCount}}" class="form-control">
                                                </div>
                                                <div>

                                                    <div>
                                                        <label for="" style="color: red;">Due</label>
                                                        <input type="number" readonly id="due" name="amount" style="color: red
                                                        ;" value="{{$rdue =(getFees(Auth::id(),$data['student']->id,$key)+$data['monthlyFee']-$discountCount)-(getPaid(Auth::id(),$data['student']->id,$key))}}" class="form-control">
                                                    </div>
                                                    <div>

                                                        <label for="">Discount</label>
                                                        <input readonly type="" placeholder="" value="{{$data['student']->discount}}%" class="form-control">
                                                    </div>

                                                    <div>
                                                        <label for="">Paid Amount</label>
                                                        <input type="number" onkeyup="paidAmount(this.value, '{{$rdue}}', '{{$key}}')" placeholder="" id="paid_amount" class="form-control" name="paid_amount">

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" id="submit_btn_{{$key}}" class="btn btn-primary">Save</button>
                                                    </div>
                                            </form>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                        </tr>

                        @endforeach

                    </tbody>
                </table>

            </div>
        </div>

    </div>
</main>






<!-- Button trigger modal -->


<!-- Modal -->






















@endsection

@push('js')
<script>
    $("#paymentRecivedForm").submit(function(e) {
        e.preventDefault();
        var j = $("#paymentRecivedForm").serialize();
        $.ajax({
            url: "{{url('/school/finance/payment/receive')}}",
            type: "POST",
            data: $("#paymentRecivedForm").serialize(),
            success: function(resp) {
                $("#payment-reciept").html(resp.html);
                printDiv("payment-reciept");
                location.reload();
            },
            error: function(error) {
                Swal.fire({
                    title: "Try Later",
                    text: 'Have Some Problem. Please Try Again Later.',
                    inputPlaceholder: 'Nombre',
                });
            }
        })
    });


    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }
</script>
<script>
    function paidAmount(paid, due, id) {
        console.log(paid + "====>" + due + '====>' + id);
        var paid = parseInt(paid);
        var due = parseInt(due);

        if (paid > due) {
            document.getElementById("submit_btn_" + id).disabled = true;
        } else {
            document.getElementById("submit_btn_" + id).disabled = false;
        }
    }
</script>
@endpush