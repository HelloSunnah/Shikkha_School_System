@extends('layouts.school.master')

@section('content')
<main class="page-content">

    <section class="mt-3">
        <div class="container-fluid">
            <div class="row justify-content-center">

                <div class="col-md-7  mt-4 ">

                    <div class="card">
                        <div class="card-body">
                            <table class="table" style="border:1px solid rgb(43, 60, 188">
                                <div class="row my-3">
                                    <div class="col">
                                        <a class="btn btn-info" href="{{route('accesoriesType')}}"> + Accesories </a>
                                        <a class="btn btn-primary" href="{{route('receipt.Show')}}">History</a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-8"> 
                                        <label for="Student Name">{{__('app.Student')}} {{__('app.Name')}}</label>
                                        <input type="text" id="s_n" required onkeyup="Sname()" placeholder="{{__('app.Student')}} {{__('app.Name')}}" class="form-control">
                                        <span class="mt-2" id="s_name"></span>
                                    </div>
                                    <div class="col-4"> 
                                        <label for="Roll Number">{{__('app.Roll')}}</label>
                                        <input type="number" id="roll" required onkeyup="roll()" placeholder="{{__('app.Roll')}}" class="form-control">
                                        <span class="mt-2" id="roll"></span>
                                    </div>
                                </div>
                                <br>
                                <div class="row mb-4">
                                    <div class="col-6">
                                        <label for="Class">{{__('app.Class')}}</label>
                                        <select class="form-control mb-3 js-select" name="class" onchange="loadSection()" id="class" class="form-control">
                                            <option value="" selected disabled> {{__('app.select')}} </option>
                                            @foreach($class as $row )
                                            <option value="{{$row->id}}">
                                                {{$row->class_name}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-6">
                                        <label for="Section">{{__('app.Section')}}</label>
                                        <select class="form-control mb-3 js-select" name="section_id" id="section_id" onchange="section()" class="form-control">
                                        </select>
                                    </div>
                                </div>

                                <thead>
                                    <tr>
                                        
                                        <th>{{__('app.Accesories')}}</th>
                                        <th style="width: 31%">{{__('app.quantity')}}</th>
                                        <th>{{__('app.Price')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>                                        
                                        <td>
                                            <select class="form-control mb-3 js-select" name="accesories" id="accesories" class="form-control">
                                                <option value="" selected disabled>Select One</option>

                                                @foreach($orders as $row )
                                                <option id="{{$row->id}}" value="{{$row->accesories}}" class="accesories custom-select">
                                                    {{$row->accesories}}
                                                </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" id="qty" min="1" value="1" class="form-control">
                                        </td>
                                        <td>
                                            <h5 class="mt-1" id="price"></h5>
                                        </td>
                                        <td><button id="add" class="btn btn-primary">{{__('app.add')}}</button></td>
                                    </tr>
                                    <tr>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-12"></div>

                <div class="col-md-7  mt-4" style="border:1px solid rgb(43, 60, 188)">
                    <div class="p-4" id="printDiv"> 
                        <div class="d-flex justify-content-center">
                            @if (File::exists(public_path(Auth::user()->school_logo)) && !is_null(Auth::user()->school_logo))
                                <img src="{{asset(Auth::user()->school_logo)}}" alt="school logo" class="img-fluid" width="80" style="width:80px; height:80px;margin-right:20px;">
                            @endif                                                                                                                                                                 
                            <div class="text-center text-dark">
                                @if( app()->getLocale() === 'en')
                                <h4>{{$school->school_name}}</h4>
                                <p style="margin-top:-5px !important;font-size:12px">{{$school->slogan}}</p>
                                <p style="margin-top:-5px !important;font-size:14px">{{$school->address}}</p>
                                @else
                                    <h4>{{$school->school_name_bn}}</h4>
                                    <p style="margin-top:-5px !important;font-size:12px">{{$school->slogan_bn}}</p>
                                    <p style="margin-top:-5px !important;font-size:14px">{{$school->address_bn}}</p>
                                @endif                                
                                    
                                <div class="row text-center">
                                    <h5 style="margin-top:5px !important;font-size:22px;margin-bottom:10px;">{{__('app.Receipt')}}</h5>
                                </div>                                
                            </div>                                        
                        </div><br>

                        <div class="row ">
                            <div class="col-5"> <span class="mt-2"> {{__('app.name')}}: </span><span class="mt-2" id="share"></span>

                            </div>
                            <div class="col-5"> <span class="mt-2"> {{__('app.roll')}} : </span><span class="mt-2" id="s_roll"></span>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-5"> <span class="mt-2"> {{__('app.class')}}: </span><span class="mt-2" id="s_class"></span>

                            </div>
                            <div class="col-5"> <span class="mt-2"> {{__('app.Section')}}: </span><span class="mt-2" id="s_section"></span>

                            </div>
                        </div>
                        <span class="mt-4"> {{__('app.time')}} : </span><span class="mt-4" id="time"></span>
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6 ">
                                <span id="day">{{date('F')}}</span> : <span id="year">{{date('d/m/Y')}}</span>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 text-right">
                            </div>
                            <div class="row">
                                </span>
                                <table id="receipt_bill" class="table mt-3">
                                    <thead>
                                        <tr>
                                            <th class="text-center"></th>
                                            <th>{{(__('app.Accessories'))}}</th>
                                            <th>{{__('app.quantity')}}</th>
                                            <th class="text-center">{{__('app.Price')}}</th>
                                            <th class="text-center">{{__('app.total')}}</th>

                                        </tr>
                                    </thead>
                                    <tbody id="new">

                                    </tbody>
                                    <tr>
                                        <td> </td>
                                        <td> </td>
                                        <td> </td>
                                        <td class="text-right text-dark">
                                            <h6>{{__('app.total')}}: ৳ </h6>
                                        </td>
                                        <td class="text-center text-dark">
                                            <h5> <strong><span id="subTotal"></strong></h5>
                                        </td>
                                        </td>
                                    </tr>

                                </table>
                            </div>
                        </div>
                    </div>

        {{-- Print Receipt --}}
                    <div class="col-12" style="display: none">
                        <div id="printDiv">
                            <div class="p-4"> 
                                <div class="d-flex justify-content-center">
                                    @if (File::exists(public_path(Auth::user()->school_logo)) && !is_null(Auth::user()->school_logo))
                                        <img src="{{asset(Auth::user()->school_logo)}}" alt="school logo" class="img-fluid" width="80" style="width:80px; height:80px;margin-right:20px;">
                                    @endif                                                                                                                                                                 
                                    <div class="text-center text-dark">
                                        @if( app()->getLocale() === 'en')
                                        <h4>{{$school->school_name}}</h4>
                                    @else
                                        <h4>{{$school->school_name_bn}}</h4>
                                    @endif

                                    @if( app()->getLocale() === 'en')
                                        <p style="margin-top:-5px !important;font-size:12px">{{$school->slogan}}</p>
                                    @else
                                        <p style="margin-top:-5px !important;font-size:12px">{{$school->slogan_bn}}</p>
                                    @endif
                                        <p style="margin-top:-5px !important;font-size:14px">{{$school->address}}</p>
                                    <div class="row text-center">
                                        <h5 style="margin-top:5px !important;font-size:22px;margin-bottom:10px;">{{__('app.School')}} {{__('app.Receipt')}}</h5>
                                    </div>
                                        
                                    </div>                                        
                                </div><br>
        
                                <div class="row ">
                                    <div class="col-5"> <span class="mt-2"> {{__('app.name')}}: </span><span class="mt-2" id="share"></span>
        
                                    </div>
                                    <div class="col-5"> <span class="mt-2"> {{__('app.roll')}} : </span><span class="mt-2" id="s_roll"></span>
        
                                    </div>
                                </div>
        
                                <div class="row">
                                    <div class="col-5"> <span class="mt-2"> {{__('app.class')}}: </span><span class="mt-2" id="s_class"></span>
        
                                    </div>
                                    <div class="col-5"> <span class="mt-2"> {{__('app.Section')}}: </span><span class="mt-2" id="s_section"></span>
        
                                    </div>
                                </div>
                                <span class="mt-4"> {{__('app.time')}} : </span><span class="mt-4" id="time"></span>
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6 ">
                                        <span id="day">{{date('F')}}</span> : <span id="year">{{date('d/m/Y')}}</span>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 text-right">
                                    </div>
                                    <div class="row">
                                        </span>
                                        <table id="receipt_bill" class="table mt-3">
                                            <thead>
                                                <tr>
                                                    <th class="text-center"></th>
                                                    <th>{{(__('app.Accessories'))}}</th>
                                                    <th>{{__('app.quantity')}}</th>
                                                    <th class="text-center">{{__('app.Price')}}</th>
                                                    <th class="text-center">{{__('app.total')}}</th>
        
                                                </tr>
                                            </thead>
                                            <tbody id="new">
        
                                            </tbody>
                                            <tr>
                                                <td> </td>
                                                <td> </td>
                                                <td> </td>
                                                <td class="text-right text-dark">
                                                    <h6>{{__('app.total')}}: ৳ </h6>
                                                </td>
                                                <td class="text-center text-dark">
                                                    <h5> <strong><span id="subTotal"></strong></h5>
                                                </td>
                                                </td>
                                            </tr>
        
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="p-4"> 
                                <div class="d-flex justify-content-center">
                                    @if (File::exists(public_path(Auth::user()->school_logo)) && !is_null(Auth::user()->school_logo))
                                        <img src="{{asset(Auth::user()->school_logo)}}" alt="school logo" class="img-fluid" width="80" style="width:80px; height:80px;margin-right:20px;">
                                    @endif                                                                                                                                                                 
                                    <div class="text-center text-dark">
                                        @if( app()->getLocale() === 'en')
                                        <h4>{{$school->school_name}}</h4>
                                    @else
                                        <h4>{{$school->school_name_bn}}</h4>
                                    @endif
                                    @if( app()->getLocale() === 'en')
                                        <p style="margin-top:-5px !important;font-size:12px">{{$school->slogan}}</p>
                                    @else
                                        <p style="margin-top:-5px !important;font-size:12px">{{$school->slogan_bn}}</p>
                                    @endif
                                        <p style="margin-top:-5px !important;font-size:14px">{{$school->address}}</p>
                                    <div class="row text-center">
                                        <h5 style="margin-top:5px !important;font-size:22px;margin-bottom:10px;">{{__('app.Student')}} {{__('app.Receipt')}}</h5>
                                    </div>
                                        
                                    </div>                                        
                                </div><br>
        
                                <div class="row ">
                                    <div class="col-5"> <span class="mt-2"> {{__('app.name')}}: </span><span class="mt-2" id="share"></span>
        
                                    </div>
                                    <div class="col-5"> <span class="mt-2"> {{__('app.roll')}} : </span><span class="mt-2" id="s_roll"></span>
        
                                    </div>
                                </div>
        
                                <div class="row">
                                    <div class="col-5"> <span class="mt-2"> {{__('app.class')}}: </span><span class="mt-2" id="s_class"></span>
        
                                    </div>
                                    <div class="col-5"> <span class="mt-2"> {{__('app.Section')}}: </span><span class="mt-2" id="s_section"></span>
        
                                    </div>
                                </div>
                                <span class="mt-4"> {{__('app.time')}} : </span><span class="mt-4" id="time"></span>
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6 ">
                                        <span id="day">{{date('F')}}</span> : <span id="year">{{date('d/m/Y')}}</span>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 text-right">
                                    </div>
                                    <div class="row">
                                        </span>
                                        <table id="receipt_bill" class="table mt-3">
                                            <thead>
                                                <tr>
                                                    <th class="text-center"></th>
                                                    <th>{{(__('app.Accessories'))}}</th>
                                                    <th>{{__('app.quantity')}}</th>
                                                    <th class="text-center">{{__('app.Price')}}</th>
                                                    <th class="text-center">{{__('app.total')}}</th>
        
                                                </tr>
                                            </thead>
                                            <tbody id="new">
        
                                            </tbody>
                                            <tr>
                                                <td> </td>
                                                <td> </td>
                                                <td> </td>
                                                <td class="text-right text-dark">
                                                    <h6>{{__('app.total')}}: ৳ </h6>
                                                </td>
                                                <td class="text-center text-dark">
                                                    <h5> <strong><span id="subTotal"></strong></h5>
                                                </td>
                                                </td>
                                            </tr>
        
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

        {{-- End Print Receipt --}}

                    <div class="row my-3 float-right">
                        <div class="col d-flex justify-content-cemter">

                            <button onclick="printDiv('printDiv')" class="btn btn-primary">{{__('app.print')}}</button>
                        </div>
                    </div>

                </div>

            </div>
    </section>
</main>

@endsection

@push('js')

<script>
    function Sname() {
        var x = document.getElementById("s_n").value;
        document.getElementById("share").textContent = x;
    }
</script>

<script>
    function section() {
        var x = $("#section_id option:selected").text();

        document.getElementById("s_section").textContent = x;

    }
</script>
<script>
    function roll() {
        var x = document.getElementById("roll").value;

        document.getElementById("s_roll").textContent = x;

    }
</script>
<script>
    $(document).ready(function() {
        $('#accesories').change(function() {
            var ids = $(this).find(':selected')[0].id;
            $.ajax({
                type: 'GET',
                url: '/getPrice/' + ids,
                data: {},
                dataType: 'json',
                success: function(data) {
                    $('#price').text(data);
                }
            });
        });

        var count = 1;
        $('#add').on('click', function() {

            var sname = $("#s_n").val();
            var sectionId = $("#section_id").val();
            var roll = $("#roll").val();

            if (sname == "" || sectionId == "" || roll == "") {
                alert("Please fillup student name, section, roll");
                die();
            }

            var name = $('#accesories').val();
            var qty = $('#qty').val();
            var price = $('#price').text();

            if (accesories == "") {
                alert("Please  Add Accesories");
                die();
            }
            if (qty == 0) {
                alert("Please Add Quantity");
          } else {
                billFunction();
            }

            function billFunction() {
                var total = 0;

                $("#receipt_bill").each(function() {
                    var total = price * qty;
                    var subTotal = 0;
                    subTotal += parseInt(total);


                    var table = '<tr id="row' + count + '"><td><button  onclick="removeRow(' + count + ')"><i class="fa-solid fa-trash"></i></button></td><td>' + name + '</td><td>' + qty + '</td><td>' + price + '</td><td><strong><input type="hidden" id="total" value="' + total + '">' + total + '</strong></td></tr>';
                    $('#new').append(table)

                    // Code for Sub Total of Vegitables 
                    var total = 0;
                    $('tbody tr td:last-child').each(function() {
                        var value = parseInt($('#total', this).val());
                        if (!isNaN(value)) {
                            total += value;
                        }
                    });
                    $('#subTotal').text(total);

                    // Code for calculate tax of Subtoal 5% Tax Applied
                    var Tax = (total * 5) / 100;
                    $('#taxAmount').text(Tax.toFixed(2));

                    // Code for Total Payment Amount

                    var Subtotal = $('#subTotal').text();
                    var taxAmount = $('#taxAmount').text();

                    var totalPayment = parseFloat(Subtotal) + parseFloat(taxAmount);
                    $('#totalPayment').text(totalPayment.toFixed(2)); // Showing using ID 

                });
                count++;
                $.ajax({
                    url: "{{route('ajax.load.accesories.transaction')}}",
                    type: "POST",
                    data: {
                        "name": $("#s_n").val(),
                        "roll": $("#roll").val(),
                        "class": $("#class").val(),
                        "section": $("#section_id").val(),
                        "amount": $("#subTotal").text(),
                        "quantity": $("#qty").val(),
                        "accesories": $("#accesories").val(),
                        "_token": "{{csrf_token()}}",
                    },
                    success: function(res) {
                        console.log(res);
                    },
                    error: function(error) {
                        console.log(error);
                    }
                })

            }
        });



        // Code for year 

        var currentdate = new Date();
        var datetime = currentdate.getDate() + "/" +
            (currentdate.getMonth() + 1) + "/" +
            currentdate.getFullYear();
        $('#year').text(datetime);



        // Code for extract Weekday     
        function myFunction() {
            var d = new Date();
            var weekday = new Array(7);
            weekday[0] = "Sunday";
            weekday[1] = "Monday";
            weekday[2] = "Tuesday";
            weekday[3] = "Wednesday";
            weekday[4] = "Thursday";
            weekday[5] = "Friday";
            weekday[6] = "Saturday";

            var day = weekday[d.getDay()];
            return day;
        }
        var day = myFunction();
        $('#day').text(day);
    });
</script>

<script>
    function removeRow(count) {
        $("#row" + count).remove();
        
    }
</script>
<script>
    window.onload = displayClock();

    function displayClock() {
        var time = new Date().toLocaleTimeString();
        document.getElementById("time").innerHTML = time;
        setTimeout(displayClock, 1000);
    }
</script>

<script>
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        $.ajax({
            url: "{{route('ajax.load.accesories')}}",
            type: "POST",
            data: {
                "amount": $("#subTotal").text(),
                "_token": "{{csrf_token()}}",
            },
            success: function(res) {
                console.log(res);
            },
            error: function(error) {
                console.log(error);
            }
        })

        window.print();

        document.body.innerHTML = originalContents;


    }
</script>

<script>
    var d = new datetime();
    document.getElementById("date").innerHTML = d;
</script>
<script>
    function loadSection() {

        var x = $("#class option:selected").text();

        document.getElementById("s_class").innerHTML = x;

        let class_id = $("#class").val();

        $.ajax({
            url: "{{route('ajax.load.section')}}",
            type: "GET",
            data: {
                "class_id": class_id
            },
            success: function(res) {
                $("#section_id").html(res);
            }
        })
    }
</script>

@endpush