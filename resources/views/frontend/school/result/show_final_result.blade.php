@extends('layouts.school.master')

@section('content')
    <!--start content-->
    <main class="page-content">
        <div class="row">
            <div class="col-xl mx-auto">
                @if (count($studentResults) > 0)
                <div class="card">
                    <div class="card-body" id="printDi">
                        <div class="border p-3 rounded" style="overflow-x:auto;">
                           <div id="printDiv">
                                <div class="d-flex justify-content-center">
                                    @if (File::exists(public_path(Auth::user()->school_logo)) && !is_null(Auth::user()->school_logo))
                                        <img src="{{asset(Auth::user()->school_logo)}}" alt="school logo" class="img-fluid" width="80" style="width:100px; height:80px; margin-right:20px;">
                                    @endif
                                    <div class="text-center">
                                        <h4 style="margin-bottom: 0px;"> {{ strtoupper(Auth::user()->school_name )}} </h4>
                                        <p style="margin-bottom: 0px; font-size:12px"> {{ (Auth::user()->slogan )}} </p>
                                        <p style="margin-bottom: 0px;"> {{ Auth::user()->address }} </p>
                                        <h5>Annual Examination Result</h5>
                                    </div>
                                </div>

                                <hr>

                                <div class="d-flex mb-2 justify-content-between">
                                    @if(File::exists(asset($studentResults->first()->user?->image)))
                                    <img src="{{asset($studentResults->first()->user?->image)}}" class="img-fluid" alt="student image" style="height: 70px; width: 70px; margin-right:20px;">
                                    @else
                                    <img src="{{asset('d/no-img.jpg')}}" class="img-fluid" alt="student image" style="height: 70px; width: 70px; margin-right:20px;">
                                    @endif

                                    <div class="h6 col-md-3" style="font-size: 12px;">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td>Student Name</td>
                                                    <td>: {{ strtoupper($studentResults->first()->user?->name) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Father Name</td>
                                                    <td>: {{ strtoupper($studentResults->first()->user?->father_name)  }}</td>
                                                </tr>
                                                {{-- <tr>
                                                    <td>Mother Name</td>
                                                    <td>: {{ $studentResults->first()->user?->mother_name }}</td>
                                                </tr> --}}
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

                                    <div class="h6 col-md-4" style="font-size: 12px;">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td>Class</td>
                                                    <td>: {{ $studentResults->first()->user?->class?->class_name }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Section</td>
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

                                    <div class="ml-auto d-flex justify-content-end">
                                        <table class="table table-bordered" style="font-size: 8px;">
                                            <thead>
                                                <tr align="center">
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

                                <table class="table table-bordered text-center" style="font-size: 12px;">
                                    <thead>
                                    <tr align="center">
                                        <th>Subject Name</th>
                                        <th>Full Marks</th>
                                        <th>Pass Marks</th>
                                        {{-- @dd(array_slice($subjects, 0, 1, true)) --}}
                                        @foreach (array_slice($subjects, 0, 1, true) as $key => $subject)
                                            @foreach ($subject as $k => $v)
                                                <th class="p-0">
                                                    {{ $k }}
                                                    <table class="table table-bordered m-0">
                                                        <tr>
                                                            <th width="25%">Written</th>
                                                            <th width="25%">Mcq</th>
                                                            <th width="25%">Other</th>
                                                            <th width="25%">Total</th>
                                                        </tr>
                                                    </table>
                                                </th>
                                            @endforeach
                                        @endforeach
                                        <th>Average</th>
                                        <th>Grade Latter</th>
                                        <th>Grade Point</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                        @php
                                            $totalAvg = 0;
                                            $totalGpa = 0;
                                        @endphp
                                        @foreach ($subjects as $key => $subject )
                                            @foreach ($subject as $k => $v)
                                                @php
                                                    $total[$k] = 0;
                                                @endphp
                                            @endforeach
                                        @endforeach
                                        @foreach ($subjects as $key => $subject )
                                        <tr>
                                            <td>{{ $key }}</td>
                                            <td>100</td>
                                            <td>33</td>
                                            @php
                                                $sum = 0;

                                            @endphp

                                            @foreach ($subject as $k => $v)
                                                @php
                                                    $total[$k] += $v['total'];
                                                    $sum += $v['total'];
                                                    // $totalTermMark = \App\Models\Term::where('school_id', Auth::id())->selectRaw("SUM(total_mark) as term_total_mark")->first(); (Old System Result)
                                                    // $totalTermMark = \App\Models\ResultSetting::where('school_id', Auth::id())->selectRaw("SUM(all_subject_mark) as term_total_mark")->first();
                                                    $subject_id = $v['subject_id'];
                                                    $class_id = $studentResults->first()->user?->class_id;
                                                    $totalTermMark = \App\Models\ResultSubjectCountableMark::where('school_id', Auth::id())->where('institute_class_id', $class_id)->whereIn('result_setting_id', $term_id)->where('subject_id', $subject_id)->selectRaw("SUM(mark) as term_total_mark")->first();
                                                    $count = $totalTermMark->term_total_mark;
                                                @endphp
                                                @if ($v['total'] != 0)
                                                    <td class="p-0">
                                                        <table class="table table-bordered m-0">
                                                            <tr>
                                                                <td width="25%">{{ $v['written'] }}</td>
                                                                <td width="25%">{{ $v['mcq'] }}</td>
                                                                <td width="25%">{{ $v['other'] }}</td>
                                                                <td width="25%">{{ $v['total'] }}</td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                @else
                                                    <td class="p-0">
                                                        <table class="m-0 table table-bordered">
                                                            <tr>
                                                                <td width="25%"><br></td>
                                                                <td width="25%"><br></td>
                                                                <td width="25%"><br></td>
                                                                <td width="25%"><br></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                @endif
                                            @endforeach
                                        <td>
                                            {{ number_format(($sum * 100) / $count, 2) }}
                                        </td>
                                        <td>{{ annualGrade(number_format(($sum * 100) / $count, 2)) }}</td>
                                        <td>{{ annualGpa(number_format(($sum * 100) / $count, 2)) }}</td>
                                        @php
                                            $totalGpa += annualGpa(number_format(($sum * 100) / $count, 2));
                                            $finalGpa = number_format($totalGpa / count($subjects), 2);
                                            $totalAvg += number_format(($sum * 100) / $count, 2);
                                        @endphp
                                        </tr>
                                        @endforeach
                                        @php
                                        @endphp
                                        <tr>
                                            <th colspan="3">Total Mark And GPA</th>
                                            @foreach ($total as $value)
                                                <th>{{ $value }}</th>
                                            @endforeach
                                            <th>{{ number_format(($totalAvg / count($subjects)), 2) }}</th>
                                            <th>{{ classWiseGpa($finalGpa) }}</th>
                                            <th> {{$finalGpa }}</th>
                                            {{-- <th>{{ finalGrade($totalAvg, Auth::id()) }}</th> --}}
                                            {{-- <th>{{ finalGpa($totalAvg) }} {{$finalGpa }}</th> --}}
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="row justify-content-between">

                                    <div class="ml-auto col-2">
                                        <table class="table table-bordered" style="font-size: 12px; border-color:black;">
                                            <thead>
                                                <tr align="center">
                                                    <th colspan="2">Mark Grade</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td style="padding:1px;">80-100</td>
                                                    <td width="20%" style="padding:1px;">A+</td>
                                                </tr>
                                                <tr>
                                                    <td style="padding:1px;">70-79</td>
                                                    <td style="padding:1px;">A</td>
                                                </tr>
                                                <tr>
                                                    <td style="padding:1px;">60-69</td>
                                                    <td style="padding:1px;">A-</td>
                                                </tr>
                                                <tr>
                                                    <td style="padding:1px;">50-59</td>
                                                    <td style="padding:1px;">B</td>
                                                </tr>
                                                <tr>
                                                    <td style="padding:1px;">40-49</td>
                                                    <td style="padding:1px;">C</td>
                                                </tr>
                                                <tr>
                                                    <td style="padding:1px;">33-39</td>
                                                    <td style="padding:1px;">D</td>
                                                </tr>
                                                <tr>
                                                    <td style="padding:1px;">0-32</td>
                                                    <td style="padding:1px;">F</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>                            
    
                                    <div class="col-3">
                                        <div>
                                            <table class=" table table-bordered text-center" style="font-size: 12px; border-color:black;">
    
                                                <tbody>
                                                    <tr class="row">
                                                        <td class="col-8 border-end-0" style="border-bottom-color: white;" style="padding:2px;">Total Working Days</td>
                                                        <td class="col-4" style="padding:2px;"></td>
                                                    </tr>
                                                    <tr class="row">
                                                        <td class="col-8 border-end-0 border-top-0" style="padding:2px;">Present</td>
                                                        <td class="col-4" style="padding:2px;"></td>
                                                    </tr>
                                                    <tr class="row">
                                                        <td class="col-8 border-end-0 border-top-0" style="padding:2px;">Absent</td>
                                                        <td class="col-4" style="padding:2px;"></td>                                                
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
    
                                        <div>
                                            <table class=" table table-bordered text-center" style="font-size: 12px; border-color:black;">
    
                                                <tbody>
                                                    <tr class="row">
                                                        <td class="col-8 border-end-0" style="padding:2px;">Position in class</td>
                                                        <td class="col-4" style="padding:2px;">{{(isset($resultStatus)) ? ' ' : $studentRank}}</td>
                                                    </tr>
                                                    <tr class="row">
                                                        <td class="col-8 border-end-0 border-top-0" style="padding:2px;">Position in section</td>
                                                        <td class="col-4" style="padding:2px;">{{(isset($resultStatus)) ? ' ' : $section_studentRank}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        
                                    </div>
    
                                    <div class="col-6" style="font-size: 12px;">
                                        <table class=" table table-bordered text-center" style="border-color: black;">
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
                <div class="col-12 d-flex justify-content-center">
                    <button class="btn btn-success" onclick="printDiv()">Print</button>
                </div>
                @else
                <div class="card">
                    <div class="card-body">
                        <h3 class="text-danger text-center">Result Not Available</h3>
                    </div>
                </div>
                @endif
            </div>
        </div>
        <!--end row-->
    </main>

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
@endpush
