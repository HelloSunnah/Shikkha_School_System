<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="col-md-12">
        
        @php
            $totalAdditionFees = App\Models\StudentMonthlyFee::where(['school_id' => Auth::id(),'student_id' => $student->id,'month_id'=>$monthKey])->sum('amount');
        @endphp
        
        <div class="col-md-12">
            <div class="card">
                {{-- school Copy --}}
                <div class="col-12 col-lg-12">
                    <div class="d-flex justify-content-center text-dark">
                        @if (File::exists(public_path(Auth::user()->school_logo)) && !is_null(Auth::user()->school_logo))
                        <img src="{{asset(Auth::user()->school_logo)}}" alt="school logo" class="img-fluid" width="80" style="width:80px; height:80px;margin-right:20px;">
                        @endif                                                                                
                        <div class="text-center">
                            <h4 style="margin-bottom: 0px; "> {{ strtoupper( Auth::user()->school_name) }} </h4>
                            <p style="margin-bottom: 0px; font-size:12px margin-bottom:10px;"> {{ (Auth::user()->address )}} </p>
                            <p style="margin-bottom: 0px; font-size:12px margin-bottom:10px;">School Copy</p>
                        </div>
                    </div>
                        
                    <!-- .row -->
    
                    <hr class="row brc-default-l1 mx-n1 mb-4" />
    
                    <div class="row">
                        <div class="col-6">
                            <span class="text-sm text-grey-m2 align-middle" style="color:black">Student Name: {{$student->name}}</span><br>
                            <span class="text-sm text-grey-m2 align-middle" style="color:black">Class: {{App\Models\InstituteClass::find($student->class_id)->class_name}}</span><br>
                            <span class="text-sm text-grey-m2 align-middle" style="color:black">Roll No: {{$student->roll_number}}</span>
                            
                        </div>
                        <div class="col-6">
                            <span class="text-sm text-grey-m2 align-middle" style="color:black">Section: {{App\Models\Section::find($student->section_id)->section_name}}</span><br>
                            <span class="text-sm text-grey-m2 align-middle" style="color:black">Shift: @if ($student->shift == 1) Morning @elseif ($student->shift ==2) Day @else Evening @endif </span>
                        </div>                                                                                                                        
                    </div>
    
                    <br>
                    
                    <div class="col-12">
                        <div class="row">
                            <table class="table table-bordered text-dark">
                                <thead> 
                                    <tr>
                                        <th style="padding-left: 10px;padding: 0px;">Fees Title</th>
                                        <th style="padding-left: 10px;padding: 0px;">Fees Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="padding-left: 10px;padding: 0px;">Monthly Fees</td>
                                        <td style="padding-left: 10px;padding: 0px;">{{($monthlyFee - $discountCount)}}</td>
                                    </tr>
                                    @foreach ($studentFeesType as $key => $feesItem)                                                                                                                
                                        @if ($key != '0')
                                            <tr>
                                                <td style="padding-left: 10px;padding: 0px;">{{App\Models\FeesType::find($feesItem->fees_type_id)->title}}</td>
                                                <td style="padding-left: 10px;padding: 0px;">{{$feesItem->amount}}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    <tr>
                                        <td style="padding-left: 10px;padding: 0px;"><b>Total</b></td>
                                        <td style="padding-left: 10px;padding: 0px;"><b>{{($totalAdditionFees+$monthlyFee-$discountCount)}}</b></td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left: 10px;padding: 0px;"><b>Total Paid</b></td>
                                        <td style="padding-left: 10px;padding: 0px;"><b>{{(getPaid(Auth::id(),$student->id,$key))}}</b></td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left: 10px;padding: 0px;"><b>Current Due</b></td>
                                        <td style="padding-left: 10px;padding: 0px;"><b>{{($totalAdditionFees+$monthlyFee-$discountCount)-(getPaid(Auth::id(),$student->id,$key))}}</b></td>
                                    </tr>
                                </tbody>                                                                                                    
                            </table>                                                                                                
                        </div>
                    </div>
    
                    {{-- signatures --}}
    
                    <div class="row d-flex justify-content-between">
                        <div class="col-6" style="font-size: 12px;">
                            <table class=" table table-borderless text-center" style="border-color: black;">
                                
                                <tbody>
                                    &nbsp;&nbsp;
                                    <tr class="col-md-6">
                                        <hr class="col-md-2">
                                        <td class="col-md-2">Class Teacher</td>
                                        <td class="col-md-2">Accountant</td>
                                        <td class="col-md-2">Principal</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div> 
                    </div>
    
                    {{-- End signatures --}}
                    
                    
                </div>
    
                {{-- End School Copy --}}
                
                <br><br>
        
                {{-- Student Copy --}}
    
                <div class="col-12 col-lg-12">
                    <div class="d-flex justify-content-center text-dark">
                        @if (File::exists(public_path(Auth::user()->school_logo)) && !is_null(Auth::user()->school_logo))
                        <img src="{{asset(Auth::user()->school_logo)}}" alt="school logo" class="img-fluid" width="80" style="width:80px; height:80px;margin-right:20px;">
                        @endif                                                                                
                        <div class="text-center">
                            <h4 style="margin-bottom: 0px; "> {{ strtoupper( Auth::user()->school_name) }} </h4>
                            <p style="margin-bottom: 0px; font-size:12px margin-bottom:10px;"> {{ (Auth::user()->address )}} </p>
                            <p style="margin-bottom: 0px; font-size:12px margin-bottom:10px;">Student Copy</p>
                        </div>
                    </div>
                        
                    <!-- .row -->
    
                    <hr class="row brc-default-l1 mx-n1 mb-4" />
    
                    <div class="row">
                        <div class="col-6">
                            <span class="text-sm text-grey-m2 align-middle" style="color:black">Student Name: {{$student->name}}</span><br>
                            <span class="text-sm text-grey-m2 align-middle" style="color:black">Class: {{App\Models\InstituteClass::find($student->class_id)->class_name}}</span><br>
                            <span class="text-sm text-grey-m2 align-middle" style="color:black">Roll No: {{$student->roll_number}}</span>
                            
                        </div>
                        <div class="col-6">
                            <span class="text-sm text-grey-m2 align-middle" style="color:black">Section: {{App\Models\Section::find($student->section_id)->section_name}}</span><br>
                            <span class="text-sm text-grey-m2 align-middle" style="color:black">Shift: @if ($student->shift == 1) Morning @elseif ($student->shift ==2) Day @else Evening @endif </span>
                        </div>                                                                                                                        
                    </div>
    
                    <br>
                    
                    <div class="col-12">
                        <div class="row">
                            <table class="table table-bordered text-dark">
                                <thead> 
                                    <tr>
                                        <th style="padding-left: 10px;padding: 0px;">Fees Title</th>
                                        <th style="padding-left: 10px;padding: 0px;">Fees Ampunt</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="padding-left: 10px;padding: 0px;">Monthly Fees</td>
                                        <td style="padding-left: 10px;padding: 0px;">{{($monthlyFee-$discountCount)}}</td>
                                    </tr>
                                    @foreach ($studentFeesType as $feesItem)                                                                                                                
                                        @if (count($studentFeesType) > 0)
                                            <tr>
                                                <td style="padding-left: 10px;padding: 0px;">{{App\Models\FeesType::find($feesItem->fees_type_id)?->title}}</td>
                                                <td style="padding-left: 10px;padding: 0px;">{{$feesItem->amount}}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    <tr>
                                        <td style="padding-left: 10px;padding: 0px;"><b>Total {{($totalAdditionFees)}}</b></td>
                                        <td style="padding-left: 10px;padding: 0px;"><b>{{($totalAdditionFees+$monthlyFee-$discountCount)}}</b></td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left: 10px;padding: 0px;"><b>Total Paid</b></td>
                                        <td style="padding-left: 10px;padding: 0px;"><b>{{(getPaid(Auth::id(),$student->id,$key))}}</b></td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left: 10px;padding: 0px;"><b>Current Due</b></td>
                                        <td style="padding-left: 10px;padding: 0px;"><b>{{($totalAdditionFees+$monthlyFee-$discountCount)-(getPaid(Auth::id(),$student->id,$key))}}</b></td>
                                    </tr>
                                </tbody>                                                                                                    
                            </table>                                                                                                
                        </div>
                    </div>
    
                    {{-- signatures --}}
    
                    <div class="row d-flex justify-content-center">
                        <div class="col-6" style="font-size: 12px;">
                            <table class=" table table-borderless text-center" style="border-color: black;">
                                
                                <tbody>
                                    &nbsp;&nbsp;
                                    <tr class="col-md-6">
                                        <hr class="col-md-2">
                                        <td class="col-md-2">Class Teacher</td>
                                        <td class="col-md-2">Accountant</td>
                                        <td class="col-md-2">Principal</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div> 
                    </div>
    
                    {{-- End signatures --}}
                    
                    
                </div>
    
                {{-- End Student Copy --}}
    
            </div>
        </div>
        
    </div>
    
    
</body>
</html>