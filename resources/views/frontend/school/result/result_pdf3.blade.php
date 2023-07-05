<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        {
            padding: 10;
            margin: 10;
        }
        .fixed-width{
            max-width: 1150px;
            margin: auto;
            border:2px solid black;
        }
        .clear::after{
            content: '';
            clear: both;
            display: block;
        }
        .left{
            float: left;
        }
        .right{
            float: right;
        }
        .center{
            float:center;
        }
        img{
            max-width: 100%;
        }
        a{
            text-decoration: none;
        }
        .mid-content{
            max-width: 1100px;
            margin: auto;
        }
        body h1 h2 h3 h4 h5 h6 p span{
            font-family: 'Work Sans', sans-serif;
        }
        .text-center{
            text-align: center;
        }
        .text-left{
            text-align: left;
        }
        .text-right{
            text-align: right;
        }
        .header-left{
            width: 35%;
            display: block;
        }
        .header-right{
            width: 65%;
            margin-left: -140px;
        }
        .header-bottom-left{
            width: 50%;
            display: block;
        }
        .header-bottom-right{
            width: 50%;
            display: block;
        }
        .bottom-left{
            width: 48%;
            display: block;
        }
        .bottom-right{
            width: 48%;
            display: block;
        }
        .mark-left{
            width: 35%;
            float: left;
            padding-right: 10px;
            display: block;
        }
        .mark-right{
            width: 52%;
            float: right;
            display: block;
            padding-right: 22px
        }
        .bordered-table {
        border-collapse: collapse;
        }

        .bordered-table th,
        .bordered-table td {
        border: 1px solid black;
        padding: 12px;
        text-align: center;
        }
        .bottom{
            padding-top:30px;
        }
    </style>
</head>
<body>
    <div class="" id="printDiv" style="background: white;">
            <div class="fixed-width">
                <div class="mid-content clear" style="padding-top:30px;">
                    <div class="header-left text-right left" style="padding-right: 20px;">
                        @if (File::exists(public_path(Auth::user()->school_logo)) && !is_null(Auth::user()->school_logo))
                            <img src="{{asset(Auth::user()->school_logo)}}" alt="school logo" class="" width="80" style="width:100px; height:100px;margin-right:10px;">
                        @endif
                    </div>
                    <div class="header-right text-center left ">
                        <h3 style="margin-bottom:-8px;"> {{ strtoupper(Auth::user()->school_name) }} </h3>
                        <p style="margin-bottom:-11px;"> <b>{{ Auth::user()->slogan != null ? '('.Auth::user()->slogan.')': ""}}</b> </p>
                        <p style="margin-bottom: -15px;"> {{ Auth::user()->address }} </p>
                        <h5>{{ $term->title }}</h5>
                    </div>
                </div>
                
                <hr style="color:rgb(189, 2, 180);margint-top:30px">
                <div class="mid-content " style="margin-top: 20px;margin-bottom:40px">
                    <div class="clear">
                        <div class="header-bottom-left left ">
                            <div class="left" >
                                @if(File::exists(public_path($studentResults->first()->user?->image)))
                                    <img src="{{asset($studentResults->first()->user?->image)}}" class="" alt="student image" style="height: 100px; width: 80px">
                                @else
                                    <img src="{{asset('d/no-img.jpg')}}" class="" alt="student image" style="height: 60px; width: 60px">
                                @endif
                            </div>
                            <div class="right text-left ">
                                <div class="" style="font-size: 15px;padding-right:40px;">
                                    <table style="border-color: black;">
                                        <tbody>
                                            <tr> 
                                                <td>Student Name</td>
                                                <td>: {{ strtoupper($studentResults->first()->user?->name) }}</td>
                                            </tr>
                                            <tr>
                                                <td>Father Name</td>
                                                <td>: {{ strtoupper($studentResults->first()->user?->father_name) }}</td>
                                            </tr>
                                            <tr>
                                                <td>Shift</td>
                                                <td>: @if($studentResults->first()->user?->shift == 1) Morning @elseif($studentResults->first()->user?->shift == 2) Day @elseif($studentResults->first()->user?->shift == 3) Evening @endif</td>
                                            </tr>
                                            <tr>
                                                <td>Roll</td> 
                                                <td>: {{ $studentResults->first()->user?->roll_number }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    
                        <div class="header-bottom-right right ">
                            <div class="left">
                                <div class="" style="font-size: 15px;padding-left:40px;">
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td>{{__('app.class')}}</td>
                                                <td>: {{ $studentResults->first()->user?->class?->class_name }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('app.section')}}</td>
                                                <td>: {{ $studentResults->first()->user?->section?->section_name }}</td>
                                            </tr>
                                            <tr>
                                                <td>SID</td>
                                                <td>: {{ $studentResults->first()->user?->unique_id ?? 'none' }}</td>
                                            </tr>
                                            <tr>
                                                <td>Year</td>
                                                <td>: {{date("Y")}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="right ">
                                <div class="">
                                    <table class="bordered-table" style="font-size: 15px; border-color:black;">
                                        <thead>
                                            <tr align="">
                                                <th colspan="2">Performance In Class</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="padding:1px;">Excelent</td>
                                                <td width="20%" style="padding:1px;"></td>
                                            </tr>
                                            <tr>
                                                <td style="padding:1px;magrin-left:2px;">Very Good</td>
                                                <td style="padding:1px;"></td>
                                            </tr>
                                            <tr>
                                                <td style="padding:1px;">Good</td>
                                                <td style="padding:1px;"></td>
                                            </tr>
                                            <tr>
                                                <td style="padding:1px;">Poor</td>
                                                <td style="padding:1px;"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mid-content">
                    <table class="bordered-table" style="font-size: 15px;width:100%;margin-bottom:20px;">
                        <thead style="padding:0px;">
                            <tr>
                                <th width="350px;" class="text-nowrap">Subject Name</th>
                                <th scope="col">Full Mark</th>
                                <th scope="col">Pass Marks</th>
                                @foreach ($markType as $data)
                                    @if ($data->mark_type == 'Class_Test')
                                        <th>CT</th>
                                    @else
                                        <th>{{$data->mark_type}}</th>
                                    @endif
                                @endforeach
                                <th scope="col">Total Marks</th>
                                <th scope="col">Grade</th>
                                <th scope="col">Grade Point</th>
                            </tr>
                        </thead>
                        <tbody style="padding:0px;">
                            @php
                                $total = 0;
                                $totalGpa = 0.000;
                                // $totalSubject = count($studentResults); Permanent
                                $totalSubject = 0; //Temporay
                            @endphp

                            @foreach ($studentResults as $result)
                                @if ($result->total != 0)           
                                    @php
                                        $totalSubject += 1; //Temporary
                                        $term_id = $term->id;
                                        $class_id = $result->institute_class_id;
                                        $subject_id = $result->subject_id;
                                        $current_pass_mark = ($term->pass_mark / 100) * subjectMark($term_id, $class_id, $subject_id);
                                        $pass_mark = ($current_pass_mark * 100) / subjectMark($term_id, $class_id, $subject_id);
                                    @endphp
                                    <tr>
                                        @if(!is_null($result?->subject))
                                            @if($result?->subject?->subject_name == 'Information and Communication Technology')
                                                <td width="300px;" scope="row" style="padding: 1px; color:black;">ICT</td>
                                            @elseif($result->subject->subject_name == 'Bangla First Paper')
                                                <td width="300px;" scope="row" style="padding: 1px; color:black;">Bangla 1st Paper</td>
                                            @elseif($result->subject->subject_name == 'Bangla Second paper')
                                                <td width="300px;" scope="row" style="padding: 1px; color:black;">Bangla 2nd Paper</td>
                                            @elseif($result->subject->subject_name == 'English First Paper')
                                                <td width="300px;" scope="row" style="padding: 1px; color:black;">English 1st Paper</td>
                                            @elseif($result->subject->subject_name == 'English Second Paper')
                                                <td width="300px;" scope="row" style="padding: 1px; color:black;">English 2nd Paper</td>
                                                @elseif($result->subject->subject_name == 'Islam/ Other Religions')
                                                <td width="300px;" scope="row" style="padding: 1px; color:black;">Islam/ Other</td>
                                            @else
                                                <td width="300px;" scope="row" style="padding: 1px; color:black;">{{ $result->subject->subject_name }}</td>
                                            @endif
                                        

                                            <td style="padding: 0px; color:black;">{{ subjectMark($term_id, $class_id, $subject_id) }}</td>
                                            <td style="padding: 0px; color:black;">{{ number_format($current_pass_mark, 0) }}</td>
                                        @foreach ($markType as $data)
                                            @if($data->mark_type == 'Attendance')
                                                <td style="padding: 0px; color:black;">{{$result->attendance}}</td>
                                            @elseif($data->mark_type == 'Written')
                                                <td style="padding: 0px; color:black;">{{$result->written}}</td>
                                            @elseif($data->mark_type == 'MCQ')
                                                <td style="padding: 0px; color:black;">{{$result->mcq}}</td>
                                            @elseif($data->mark_type == 'Assignment')
                                                <td style="padding: 0px; color:black;">{{$result->assignment}}</td>
                                            @elseif($data->mark_type == 'Presentation')
                                                <td style="padding: 0px; color:black;">{{$result->presentation}}</td>
                                            @elseif($data->mark_type == 'Quiz')
                                                <td style="padding: 0px; color:black;">{{$result->quiz}}</td>
                                            @elseif($data->mark_type == 'Practical')
                                                <td style="padding: 0px; color:black;">{{$result->practical}}</td>
                                            @elseif($data->mark_type == 'Others')
                                                <td style="padding: 0px; color:black;">{{$result->others}}</td>
                                            @elseif ($data->mark_type == 'Class_Test')
                                                <td style="padding: 0px; color:black;">{{$result->class_test}}</td>
                                            @endif
                                        @endforeach
                                        <td style="padding: 0px; color:black;">{{ $result->total }}</td>
                                        <td style="padding: 0px; color:black;">{{ $result->grade }}</td>
                                        <td style="padding: 0px; color:black;">{{ $result->gpa }}</td>
                                        @endif
                                    </tr>
                                    @php
                                        $total += $result->total;
                                        $totalGpa += $result->gpa;
                                        $totalMark = $result->total * 100 / subjectMark($term_id, $class_id, $subject_id);
                                        if ($totalMark < $pass_mark) {
                                            $resultStatus = "Fail";
                                        }
                                    @endphp
                                @endif
                            @endforeach
                            @php
                                $grading_point = array(
                                                        'A+' => 5, 'A' => 4, 'A-' => 3.5, 'B' => 3, 'C' => 2, 'D' => 1, 'F' => 0
                                                    );

                                foreach ($grading_point as $gpa => $minimum_grade) {
                                        if (number_format($totalGpa / $totalSubject, 2) >= $minimum_grade) {
                                            $gpa_point = $gpa;
                                            break;
                                        }
                                    }
                            @endphp
                            <tr> 
                                
                                <td colspan="{{$markTypeCount + 2 }}"><b>Total/ GPA</b> </td>
                                <td><b>{{ $total }}</b> </td>
                                @if (isset($resultStatus))
                                    <td colspan="2" ><b>{{ $resultStatus }}</b> </td>
                                @else
                                    <td><b>{{ $gpa_point }}</b> </td>
                                    <td><b>{{ number_format($totalGpa / $totalSubject, 2) }}</b> </td>
                                @endif
                            </tr>
                        </tbody>
                    </table>
                </div>
            <br>
                <div class="mid-content clear" style="margin-bottom:30px" >
                    <div class="header-bottom-left left">
                        <div class="mark-left">
                            <table class="bordered-table" style="font-size: 15px;width:100%">
                                <thead>
                                    <tr align="">
                                        <th colspan="3">Mark Grade</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr align="">
                                        <td style="padding:1px;">80-100</td>
                                        <td width="20%" style="padding:1px;">A+</td>
                                        <td width="30%" style="padding:1px;">5.00</td>
                                    </tr>
                                    <tr align="">
                                        <td style="padding:1px;">70-79</td>
                                        <td width="20%" style="padding:1px;">A</td>
                                        <td width="30%" style="padding:1px;">4.00</td>
                                    </tr>
                                    <tr align="">
                                        <td style="padding:1px;">60-69</td>
                                        <td width="20%" style="padding:1px;">A-</td>
                                        <td width="30%" style="padding:1px;">3.50</td>
                                    </tr>
                                    <tr align="">
                                        <td style="padding:1px;">50-59</td>
                                        <td width="20%" style="padding:1px;">B</td>
                                        <td width="30%" style="padding:1px;">3.00</td>
                                    </tr>
                                    <tr align="">
                                        <td style="padding:1px;">40-49</td>
                                        <td width="20%" style="padding:1px;">C</td>
                                        <td width="30%" style="padding:1px;">2.50</td>
                                    </tr>
                                    <tr align="">
                                        <td style="padding:1px;">33-39</td>
                                        <td width="20%" style="padding:1px;">D</td>
                                        <td width="30%" style="padding:1px;">2.00</td>
                                    </tr>
                                    <tr align="">
                                        <td style="padding:1px;">0-32</td>
                                        <td width="20%" style="padding:1px;">F</td>
                                        <td width="30%" style="padding:1px;">0.00</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class=" mark-right">
                            <div class="top">
                                <table class="bordered-table" style="font-size: 15px;width:100%">

                                    <tbody>
                                        <tr class="">
                                            <td class="" style="border-bottom-color: white;" style="padding:2px;">Total Working Days</td>
                                            <td class="" style="padding:2px;"></td>
                                        </tr>
                                        <tr class="">
                                            <td class="" style="padding:2px;">Present</td>
                                            <td class="" style="padding:2px;"></td>
                                        </tr>
                                        <tr class="">
                                            <td class="" style="padding:2px;">Absent</td>
                                            <td class="" style="padding:2px;"></td>                                                
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="bottom">
                                <table class="bordered-table" style="font-size: 15px;width:100%">
                                    <tbody>
                                        <tr class="">
                                            <td class="" style="padding:2px;">Position in Class</td>
                                            <td class="" style="padding:2px;">{{(isset($resultStatus)) ? ' ' : $studentRank}}</td>
                                        </tr>
                                        <tr class="">
                                            <td class="" style="padding:2px;">Position in Section</td>
                                            <td class="" style="padding:2px;">{{(isset($resultStatus)) ? ' ' : $section_studentRank}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>                            
                    <div class="header-bottom-right right" style="font-size: 15px;">
                        <div>
                            <table class="bordered-table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th colspan="3">Signatures</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="height: 90%">
                                        <td style="height: 80px; width:150px;"></td>
                                        <td style="height: 80px; width:150px;"></td>
                                        <td style="height: 80px; width:150px;"></td>
                                    </tr>
                                    <tr>
                                        <td>Class Teacher</td>
                                        <td>Principal</td>
                                        <td>Guardian</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>                            
            </div>
        </div>
    </div>
           
    <div class="text-center" style="margin-top:20px">
        <button class="" onclick="printDiv()">Print</button>
    </div>
</div>
</body>
</html>