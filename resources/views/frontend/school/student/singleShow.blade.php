@extends('layouts.school.master')

@section('content')
    <!--start content-->
    <main class="page-content">
        <div class="row">
            <div class="col-xl-9 mx-auto">
                <!-- nav-tab -->
                <hr style="width:100%;text-align:left;margin-left:0;margin-bottom:0;height:5px;background-color:#a405de">
                <div class="card">
                    <div class="card-header">

                        <h5 class="card-title"></h5>
                        <ul class="nav nav-tabs card-header-tabs" data-bs-tabs="tabs">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="true" data-bs-toggle="tab"
                                    href="#Profile">{{__('app.Student')}} {{__('app.Profile')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#Fees">{{__('app.Student')}} {{__('app.Fees')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#Result">{{__('app.Student')}} {{__('app.Result')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#Document">{{__('app.Student')}} {{__('app.Document')}}</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body tab-content">
                        {{-- student Profile --}}
                        <div class="tab-pane active" id="Profile">

                            <table class="table table-hover table-bordered">
                                <tbody>
                                    <tr>
                                        <td>{{__('app.Student')}} {{__('app.ID')}}</td>
                                        <td>{{ $user->unique_id }} </td>
                                    </tr>
                                    <tr>
                                        <td>{{__('app.Name')}} </td>
                                        <td>{{ $user->name }} </td>
                                    </tr>
                                    <tr>
                                        <td>{{__('app.Roll')}} </td>
                                        <td>{{ $user->roll_number }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('app.Class')}} </td>
                                        <td>{{ $user->clasRelation->class_name }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('app.Section')}} </td>
                                        <td>{{ $user->sectionRelation->section_name }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('app.Group')}} </td>
                                        <td>
                                            @if ($user->group_id == 1)
                                                Science
                                            @elseif ($user->group_id == 2)
                                                Commerce
                                            @elseif ($user->group_id == 3)
                                                Humanities
                                            @else
                                                ----
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{__('app.Email')}} </td>
                                        <td>{{ $user->email }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('app.Phone')}} </td>
                                        <td>{{ $user->phone }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('app.Gender')}} </td>
                                        <td>{{ $user->gender }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('app.dob')}} </td>
                                        <td>{{ $user->dob }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('app.Blood')}} {{__('app.Group')}}  </td>
                                        <td>{{ $user->blood_group }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('app.Father Name')}} </td>
                                        <td>{{ $user->father_name }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('app.Mother Name')}} </td>
                                        <td>{{ $user->mother_name }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('app.Address')}} </td>
                                        <td>{{ $user->address }}</td>
                                    </tr>

                                </tbody>
                            </table>


                        </div>
                        <!-- Student Fees -->
                        <div class="tab-pane" id="Fees">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>{{__('app.Month')}}</th>
                                        <th>{{__('app.Description')}}</th>
                                        <th>{{__('app.Paid')}}</th>
                                        <th>{{__('app.Due')}}</th>
                                        <th>{{__('app.Status')}}</th>

                                    </tr>
                                </thead>

                                <tbody>

                                    @foreach ($studentMonthlyFees as $studentMonthlyFee)
                                        <tr>
                                            <td>{{ $studentMonthlyFee->month_name }}</td>
                                            <td>{{ App\Models\FeesType::find(App\Models\StudentFee::find($studentMonthlyFee->student_fees_id)?->fees_type_id)?->title }}</td>
                                            <td>{{ $studentMonthlyFee->paid_amount }} ৳ </td>
                                            <td>{{ $studentMonthlyFee->amount - $studentMonthlyFee->paid_amount}} ৳ </td>
                                            @if ($studentMonthlyFee->status == 2)
                                                <td><span class="badge bg-success"> {{__('app.Paid')}} </span></td>
                                            @else
                                                <td><span class="badge bg-danger">{{__('app.Due Fee')}}</span></td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {{-- print Button --}}
                            <div class="text-center" style="margin-top:20px">
                                <button class="button" onclick="printDiv()">Print</button>
                            </div>
                            {{-- End Print Button --}}

                            {{-- Start Print --}}
                            <div class="hide" style="display:none">
                                <div class="container" id="printDiv">
                                    <div class="row">
                                        <div class="col-md-3" style="margin-right: 50px; margin-left: 50px; color:black;">                                           

                                            {{-- School Info --}}
                                            <div class="d-flex justify-content-center">
                                                @if (File::exists(public_path(Auth::user()->school_logo)) && !is_null(Auth::user()->school_logo))
                                                    <img src="{{asset(Auth::user()->school_logo)}}" alt="school logo" class="img-fluid" width="80" style="width:80px; height:80px;margin-right:10px;">
                                                @endif
                                                <div class="text-center">
                                                    <h4 style="margin-bottom: 0px;padding:0px; margin:0px;padding:0px;"> {{ strtoupper(Auth::user()->school_name) }} </h4>
                                                    <p style="margin-bottom: 0px;padding:0px; margin:0px;padding:0px;"> <b>{{ Auth::user()->slogan != null ? '('.Auth::user()->slogan.')': ""}}</b> </p>
                                                    <p style="margin-bottom: 0px;padding:0px; margin:0px;padding:0px;"> {{ Auth::user()->address }} </p>
                                                    
                                                </div>
                                            </div>
                                            {{-- End School Info --}}

                                            {{-- Start Student Info --}}

                                            <div class="d-flex justify-content-between" >            
                                                <div class="col-md-12">
                                                    <div class="row">                                                            
                                                        <div class="col-12" style="font-size: 16px;">
                                                            <table style="border-color: black; white-space: nowrap;">
                                                                <tbody>
                                                                    <tr> 
                                                                        <td>Student Name: {{$user->name}}</td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Class: {{$user->clasRelation->class_name}}</td>                                                                            
                                                                        <td>Section: {{$user->sectionRelation->section_name}}</td>
                                                                        <td></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Roll: {{$user->roll_number}}</td> 
                                                                        <td>ID No: {{$user->unique_id}}</td>
                                                                        <td>Date : {{$date->format('d-m-Y')}}</td>
                                                                    </tr>
                                                                                                                                            
                                                                </tbody>
                                                            </table>

                                                        </div>
                                                        
                                                    </div>

                                                </div>                                                        
                                            </div>

                                            {{-- end student Info --}}

                                            {{-- Start fees table --}}
                                            <div class="table">
                                                <table class="table table-hover table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th style="padding: 2px;">{{__('app.No')}}</th>
                                                            <th style="padding: 2px;">{{__('app.Month')}}</th>
                                                            <th style="padding: 2px;">{{__('app.Description')}}</th>
                                                            <th style="padding: 2px;">{{__('app.Paid')}}</th>
                                                            <th style="padding: 2px;">{{__('app.Due')}}</th>                        
                                                        </tr>
                                                    </thead>

                                                    <tbody>

                                                        @foreach ($studentMonthlyFees as $key => $studentMonthlyFee)
                                                            <tr>
                                                                <td style="padding: 2px;">{{++$key}}</td>
                                                                <td style="padding: 2px;">{{ $studentMonthlyFee->month_name }}</td>
                                                                <td style="padding: 2px;">{{ App\Models\FeesType::find(App\Models\StudentFee::find($studentMonthlyFee->student_fees_id)?->fees_type_id)?->title }}</td>
                                                                <td style="padding: 2px;">{{ $studentMonthlyFee->paid_amount }} ৳ </td>
                                                                <td style="padding: 2px;">{{ $studentMonthlyFee->amount - $studentMonthlyFee->paid_amount}} ৳ </td>                                                                    
                                                            </tr>
                                                        @endforeach
                                                        <tr>
                                                            <td style="padding: 2px;"></td>
                                                            <td style="padding: 2px;">Total :</td>
                                                            <td style="padding: 2px;"></td>
                                                            <td style="padding: 2px;">{{$totalPaid}} ৳</td>
                                                            <td style="padding: 2px;">{{$totalDue}} ৳</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            {{-- End fees table --}}

                                            {{-- Start Class Teacher --}}
                                            <div class="classTeacher">
                                                <table>
                                                    <tbody>
                                                        <tr>
                                                            <td>Class Teacher: {{$classTeacher}}</td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td>CT: {{$classTeacherPhone}}</td>
                                                            <td>Accountant: {{$accountant}}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <br>
                                                <p><span style="color: red"> ১০ তারিখের মধ্যে বেতন পরিশোধের অনুরোধ রইল এবং <br> বেতন প্রদানের সময় সীটটি সঙ্গে আনতে হবে।</span></p>
                                            </div>

                                            {{-- End Class Teacher --}}

                                            {{-- signature start --}}
                                            <div class="row">
                                                <div class="d-flex justify-content-center">
                                                    <div class="col-6" style="font-size: 12px;">
                                                        <table class="table text-center" style="border-color: black;">
                                                            
                                                            <tbody>
                                                                <tr style="height: 90%">
                                                                    <td style="height: 50px; width:150px;"></td>
                                                                    <td style="border: none;"></td>
                                                                    <td style="height: 50px; width:150px;"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="table-bordered" style="border-bottom: none;">Accountant Sign</td>&nbsp;
                                                                    <td style="border: none;"></td>
                                                                    <td class="table-bordered" style="border-bottom: none;">Guardian Sign</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <div class="text-center">
                                                            <span>Office Copy</span>
                                                        </div>
                                                    </div>
                                                    
                                                </div>    
                                            </div>
                                            {{-- signature End --}}
                                                                                                
                                        </div>

                                        <div class="col-md-3" style="margin-right: 50px; margin-left: 50px;  color:black;">
                                                        
                                            {{-- School Info --}}
                                            <div class="d-flex justify-content-center">
                                                @if (File::exists(public_path(Auth::user()->school_logo)) && !is_null(Auth::user()->school_logo))
                                                    <img src="{{asset(Auth::user()->school_logo)}}" alt="school logo" class="img-fluid" width="80" style="width:80px; height:80px;margin-right:10px;">
                                                @endif
                                                <div class="text-center">
                                                    <h4 style="margin-bottom: 0px;padding:0px; margin:0px;padding:0px;"> {{ strtoupper(Auth::user()->school_name) }} </h4>
                                                    <p style="margin-bottom: 0px;padding:0px; margin:0px;padding:0px;"> <b>{{ Auth::user()->slogan != null ? '('.Auth::user()->slogan.')': ""}}</b> </p>
                                                    <p style="margin-bottom: 0px;padding:0px; margin:0px;padding:0px;"> {{ Auth::user()->address }} </p>
                                                    
                                                </div>
                                            </div>
                                            {{-- End School Info --}}
            
                                            {{-- <hr style="margin-top: 0px;"> --}}
            
                                            {{-- Start Student Info --}}
                                            
                                            <div class="d-flex justify-content-between" >            
                                                <div class="col-md-12">
                                                    <div class="row">                                                            
                                                        <div class="col-12" style="font-size: 16px;">
                                                            <table style="border-color: black; white-space: nowrap;">
                                                                <tbody>
                                                                    <tr> 
                                                                        <td>Student Name: {{$user->name}}</td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Class: {{$user->clasRelation->class_name}}</td>                                                                            
                                                                        <td>Section: {{$user->sectionRelation->section_name}}</td>
                                                                        <td></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Roll: {{$user->roll_number}}</td> 
                                                                        <td>ID No: {{$user->unique_id}}</td>
                                                                        <td>Date : {{$date->format('d-m-Y')}}</td>
                                                                    </tr>
                                                                                                                                            
                                                                </tbody>
                                                            </table>
            
                                                        </div>
                                                        
                                                    </div>
            
                                                </div>                                                        
                                            </div>

                                            {{-- end student Info --}}
                                            {{-- Start fees table --}}
                                            <div class="table">
                                                <table class="table table-hover table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th style="padding: 2px;">{{__('app.No')}}</th>
                                                            <th style="padding: 2px;">{{__('app.Month')}}</th>
                                                            <th style="padding: 2px;">{{__('app.Description')}}</th>
                                                            <th style="padding: 2px;">{{__('app.Paid')}}</th>
                                                            <th style="padding: 2px;">{{__('app.Due')}}</th>                        
                                                        </tr>
                                                    </thead>
                    
                                                    <tbody>
                    
                                                        @foreach ($studentMonthlyFees as $key => $studentMonthlyFee)
                                                            <tr>
                                                                <td style="padding: 2px;">{{ ++$key }}</td>
                                                                <td style="padding: 2px;">{{ $studentMonthlyFee->month_name }}</td>
                                                                <td style="padding: 2px;">{{ App\Models\FeesType::find(App\Models\StudentFee::find($studentMonthlyFee->student_fees_id)?->fees_type_id)?->title }}</td>
                                                                <td style="padding: 2px;">{{ $studentMonthlyFee->paid_amount }} ৳ </td>
                                                                <td style="padding: 2px;">{{ $studentMonthlyFee->amount - $studentMonthlyFee->paid_amount}} ৳ </td>                                                                    
                                                            </tr>
                                                        @endforeach
                                                        <tr>
                                                            <td style="padding: 2px;"></td>
                                                            <td style="padding: 2px;">Total :</td>
                                                            <td style="padding: 2px;"></td>
                                                            <td style="padding: 2px;">{{$totalPaid}} ৳</td>
                                                            <td style="padding: 2px;">{{$totalDue}} ৳</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
        
                                            {{-- End fees table --}}

                                            {{-- Start Class Teacher --}}
                                            <div class="classTeacher">
                                                <table>
                                                    <tbody>
                                                        <tr>
                                                            <td>Class Teacher: {{$classTeacher}}</td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td>CT: {{$classTeacherPhone}}</td>
                                                            <td>Accountant: {{$accountant}}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <br>
                                                <p><span style="color: red"> ১০ তারিখের মধ্যে বেতন পরিশোধের অনুরোধ রইল এবং <br> বেতন প্রদানের সময় সীটটি সঙ্গে আনতে হবে।</span></p>
                                            </div>

                                            {{-- End Class Teacher --}}

                                            {{-- signature start --}}
                                            <div class="row">
                                                <div class="d-flex justify-content-center">
                                                    <div class="col-6" style="font-size: 12px;">
                                                        <table class="table text-center" style="border-color: black;">
                                                            
                                                            <tbody>
                                                                <tr style="height: 90%">
                                                                    <td style="height: 50px; width:150px;"></td>
                                                                    <td style="border: none;"></td>
                                                                    <td style="height: 50px; width:150px;"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="table-bordered" style="border-bottom: none;">Accountant Sign</td>&nbsp;
                                                                    <td style="border: none;"></td>
                                                                    <td class="table-bordered" style="border-bottom: none;">Guardian Sign</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <div class="text-center">
                                                            <span>Class Teacher Copy</span>
                                                        </div>
                                                    </div>
                                                    
                                                </div>    
                                            </div>
                                            {{-- signature End --}}
                                                    
                                        </div>

                                        <div class="col-md-3" style="margin-left: 50px;  color:black;">
                                                        
                                            {{-- School Info --}}
                                            <div class="d-flex justify-content-center">
                                                @if (File::exists(public_path(Auth::user()->school_logo)) && !is_null(Auth::user()->school_logo))
                                                    <img src="{{asset(Auth::user()->school_logo)}}" alt="school logo" class="img-fluid" width="80" style="width:80px; height:80px;margin-right:10px;">
                                                @endif
                                                <div class="text-center">
                                                    <h4 style="margin-bottom: 0px;padding:0px; margin:0px;padding:0px;"> {{ strtoupper(Auth::user()->school_name) }} </h4>
                                                    <p style="margin-bottom: 0px;padding:0px; margin:0px;padding:0px;"> <b>{{ Auth::user()->slogan != null ? '('.Auth::user()->slogan.')': ""}}</b> </p>
                                                    <p style="margin-bottom: 0px;padding:0px; margin:0px;padding:0px;"> {{ Auth::user()->address }} </p>
                                                    
                                                </div>
                                            </div>
                                            {{-- End School Info --}}

                                            {{-- Start Student Info --}}
                                            
                                            <div class="d-flex justify-content-between" >            
                                                <div class="col-md-12">
                                                    <div class="row">                                                            
                                                        <div class="col-12" style="font-size: 16px;">
                                                            <table style="border-color: black; white-space: nowrap;">
                                                                <tbody>
                                                                    <tr> 
                                                                        <td>Student Name: {{$user->name}}</td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Class: {{$user->clasRelation->class_name}}</td>                                                                            
                                                                        <td>Section: {{$user->sectionRelation->section_name}}</td>
                                                                        <td></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Roll: {{$user->roll_number}}</td> 
                                                                        <td>ID No: {{$user->unique_id}}</td>
                                                                        <td>Date : {{$date->format('d-m-Y')}}</td>
                                                                    </tr>
                                                                                                                                            
                                                                </tbody>
                                                            </table>
            
                                                        </div>
                                                        
                                                    </div>
            
                                                </div>                                                        
                                            </div>

                                            {{-- end student Info --}}
                                            {{-- Start fees table --}}
                                            <div class="table">
                                                <table class="table table-hover table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th style="padding: 2px;">{{__('app.No')}}</th>
                                                            <th style="padding: 2px;">{{__('app.Month')}}</th>
                                                            <th style="padding: 2px;">{{__('app.Description')}}</th>
                                                            <th style="padding: 2px;">{{__('app.Paid')}}</th>
                                                            <th style="padding: 2px;">{{__('app.Due')}}</th>                        
                                                        </tr>
                                                    </thead>
                    
                                                    <tbody>
                    
                                                        @foreach ($studentMonthlyFees as $key => $studentMonthlyFee)
                                                            <tr>
                                                                <td style="padding: 2px;">{{ ++$key}}</td>
                                                                <td style="padding: 2px;">{{ $studentMonthlyFee->month_name }}</td>
                                                                <td style="padding: 2px;">{{ App\Models\FeesType::find(App\Models\StudentFee::find($studentMonthlyFee->student_fees_id)?->fees_type_id)?->title }}</td>
                                                                <td style="padding: 2px;">{{ $studentMonthlyFee->paid_amount }} ৳ </td>
                                                                <td style="padding: 2px;">{{ $studentMonthlyFee->amount - $studentMonthlyFee->paid_amount}} ৳ </td>                                                                    
                                                            </tr>
                                                        @endforeach
                                                        <tr>
                                                            <td style="padding: 2px;"></td>
                                                            <td style="padding: 2px;">Total :</td>
                                                            <td style="padding: 2px;"></td>
                                                            <td style="padding: 2px;">{{$totalPaid}} ৳</td>
                                                            <td style="padding: 2px;">{{$totalDue}} ৳</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
        
                                            {{-- End fees table --}}

                                            {{-- Start Class Teacher --}}
                                            <div class="classTeacher">
                                                <table>
                                                    <tbody>
                                                        <tr>
                                                            <td>Class Teacher: {{$classTeacher}}</td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td>CT: {{$classTeacherPhone}}</td>
                                                            <td>Accountant: {{$accountant}}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <br>
                                                <p><span style="color: red"> ১০ তারিখের মধ্যে বেতন পরিশোধের অনুরোধ রইল এবং <br> বেতন প্রদানের সময় সীটটি সঙ্গে আনতে হবে।</span></p>
                                            </div>

                                            {{-- End Class Teacher --}}

                                            {{-- signature start --}}
                                            <div class="row">
                                                <div class="d-flex justify-content-center">
                                                    <div class="col-6" style="font-size: 12px;">
                                                        <table class="table text-center" style="border-color: black;">
                                                            
                                                            <tbody>
                                                                <tr style="height: 90%">
                                                                    <td style="height: 50px; width:150px;"></td>
                                                                    <td style="border: none;"></td>
                                                                    <td style="height: 50px; width:150px;"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="table-bordered" style="border-bottom: none;">Accountant Sign</td>&nbsp;
                                                                    <td style="border: none;"></td>
                                                                    <td class="table-bordered" style="border-bottom: none;">Guardian Sign</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <div class="text-center">
                                                            <span>Guardian Copy</span>
                                                        </div>
                                                    </div>
                                                    
                                                </div>    
                                            </div>
                                            {{-- signature End --}}
                                                   
                                        </div>
                                    </div>
                                    
                                </div>

                            </div>
                            {{-- End Print --}}
                        </div>

                        {{-- end fees --}}

                        <div class="tab-pane" id="Result">
                            <h6 style="background-color:#cccfcd;margin:5px;padding:5px">FIRST TERM EXEMINATION RESULT</h6>
                            <table class="table table-hover ">
                                <thead>
                                    <tr>
                                        <th>Subject</th>
                                        <th>Written</th>
                                        <th>Mcq</th>
                                        <th>Practical</th>
                                        <th>Total</th>
                                        <th>Grade</th>
                                        <th>Result</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td colspan="5">No record found</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="Document">
                            <div class="row">
                                <div class="col-4"></div>
                                <div class="col-4 "> </div>
                                <div class="col-4">
                                    <button type="button" class="btn btn-primary btn-sm mb-2" data-bs-toggle="modal"
                                        data-bs-target="#document">
                                        {{__('app.Upload')}} {{__('app.Student')}} {{__('app.Document')}} 
                                    </button>
                                </div>
                            </div>
                            <table class="table table-hover ">
                                <thead>
                                    <tr>
                                        <th>{{__('app.Title')}}</th>
                                        <th>{{__('app.Document')}}</th>
                                        <th colspan="3">{{__('app.Action')}}</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($alldocuments as $document)
                                        <tr>
                                            <td>{{ $document->title }}</td>
                                            <td>{{ $document->uploadfile }}</td>
                                            <td>
                                                {{-- <a href="{{ route('document.view', $document->id) }}" target="_blank"
                                                    style="text-decoration: none;color:black; font-size:20px;" ><i
                                                        class="bi bi-eye-fill"></i></a> --}}

                                                <a href="{{ route('document.download', $document->uploadfile) }}" style="font-size:25px;" ><i
                                                        class="bi bi-box-arrow-in-down"></i></a>

                                                <a href="{{ route('document.delete', $document->id) }}"
                                                    style="text-decoration: none;color:#7c00a7; font-size:20px;" ><i
                                                        class="bi bi-x-circle"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>

                    </div>
                </div>

            </div>
            <div class="col-xl-3 mx-auto">
                <hr style="width:100%;text-align:left;margin-left:0;margin-bottom:0;height:5px;background-color:#a405de">
                <div class="card">
                    <div class="mt-10">
                        
                        <img class=" shadow-4-strong" style="margin-left:35px; margin-top:20px; border-radius:5px" src="{{ asset($user->image ?? 'd/no-img.jpg') }}" width="170px" alt="img not found">
                        <div style="margin-left:15px; margin-top:10px;">
                            <h6><strong>{{__('app.Name')}}: {{ $user->name }} </strong></h6>
                            <h6><strong>{{__('app.Student')}} {{__('app.ID')}}: {{ $user->unique_id }} </strong></h6>
                            <h6><strong>{{__('app.Class')}}: {{ $user->clasRelation->class_name }}</strong></h6>
                            <h6><strong>{{__('app.Section')}}: {{ $user->sectionRelation->section_name }} </strong></h6>
                            <h6><strong>{{__('app.Roll')}}: {{ $user->roll_number }} </strong></h6>
                        </div>
                    </div>
                </div>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                    Change Password
                </button>
                @error('password')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <a href="{{ route('Transfer', $user->id) }}" target="_blank" class="btn btn-warning mt-2">Transfer</a>

            </div>
        </div>
    </main>




    <!-- Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background: #7c00a7">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Student login </h5>
                    <button type="button" class="btn-close btn-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" id="addPassword" method="post">
                    @csrf
                    <input type="hidden" id="id" value="{{ $user->id }}">
                    <div class="modal-body">
                        <div class="errmsgcontainer mb-3">

                        </div>

                        <div class="mb-3">
                            <label for="password" class="col-form-label">New Password</label>
                            <input type="password" name="password" class="form-control" id="password"
                                placeholder="{{ __('app.sign5') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="col-form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control"
                                id="password_confirmation" placeholder="{{ __('app.confirm') }} {{ __('app.sign5') }}"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">{{__('app.Back')}}</button>
                        <button type="submit" class="btn btn-primary btn-sm add_btn">{{__('app.Save')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- end Modal --}}


    <!-- Document -->
    <div class="modal fade" id="document" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background: #7c00a7">
                    <h5 class="modal-title text-white" id="exampleModalLabel">{{__('app.Student')}} {{__('app.Document')}} {{__('app.Upload')}}</h5>
                    <button type="button" class="btn-close btn-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('document.post') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    
                    <div class="modal-body">
                        <div class="mb-3">
                            <input type="hidden" name="student_id" value="{{ $user->id }}" class="form-control"
                                id="student_id">
                        </div>
                        <div class="mb-3">
                            <label for="title" class="col-form-label">{{__('app.Document')}} {{__('app.Name')}}</label>
                            <input type="text" name="title" class="form-control" id="title"
                                placeholder="{{__('app.Document')}} {{__('app.Name')}}" required>
                        </div>

                        <div class="mb-3">
                            <label for="uploadfile" class="col-form-label">{{__('app.Upload')}} {{__('app.Document')}}</label>
                            <input type="file" name="uploadfile" class="form-control" id="uploadfile" accept="application/pdf"
                                placeholder="{{__('app.Upload')}} {{__('app.Document')}}" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">{{__('app.Back')}}</button>
                        <button type="submit" class="btn btn-primary btn-sm ">{{__('app.Save')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<!-- Document View-->




  
@endsection

@push('js')
    <script>
        function printDiv(printDiv) {
            var printContents = document.getElementById('printDiv').innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            $(document).on('click', ' .add_btn', function(e) {
                e.preventDefault();
                let id = $('#id').val();
                let password = $('#password').val();
                let password_confirmation = $('#password_confirmation').val();
                //console.log(name+price);
                $.ajax({
                    url: "{{ route('student.Password') }}",
                    method: 'post',
                    data: {
                        id: id,
                        password: password,
                        password_confirmation: password_confirmation
                    },
                    success: function(res) {
                        if (res.status == 'success') {
                            $('#addModal').modal('hide');
                            $('#addpassword')[0].reset('hide');
                            location.reload();
                        }
                    },
                    error: function(err) {
                        let error = err.responseJSON;
                        $.each(error.errors, function(index, value) {
                            $('.errmsgcontainer').append('<span class="text-danger">' +
                                value + '</span>' + '<br>')
                        });
                    }
                });
            });
        });
    </script>
@endpush
