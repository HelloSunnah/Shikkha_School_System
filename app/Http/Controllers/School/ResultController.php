<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\CustomAttendanceInput;
use App\Models\InstituteClass;
use App\Models\MarkType;
use App\Models\Result;
use App\Models\ResultSetting;
use App\Models\ResultSubjectCountableMark;
use App\Models\Section;
use App\Models\Term;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;

class ResultController extends Controller
{
    /**
     * Show View Page Select Class and Term
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function classWiseResult()
    {   
        $seoTitle = 'Result Search Page';
        $seoDescription = 'Result Search Page' ;
        $seoKeyword = 'Result Search Page';
        $seo_array = [
            'seoTitle' => $seoTitle,
            'seoKeyword' => $seoKeyword,
            'seoDescription' => $seoDescription,
        ];
        $class = InstituteClass::where('school_id', Auth::user()->id)->get();
        $terms = ResultSetting::where('school_id', Auth::user()->id)->orderBy('id','desc')->get();
        $users = User::where('school_id', Auth::user()->id)->get();
        return view('frontend.school.result.class_wise_result', compact('class', 'terms','seo_array'));
    }

    /**
     * Save Absent Student Result
     * 
     * @author Sajjad <sajjad.develpr@gmail.com>
     * @param Request
     * @param $request
     * @return 
     */
    public function studentResultAbsent(Request $request)
    {   
        Result::updateOrCreate([
            'school_id'             => Auth::user()->id,
            'student_id'            => $request->student_id,
            'student_roll_number'   => $request->roll_number,
            'institute_class_id'    => $request->class_id,
            'section_id'            => $request->section_id,
            'subject_id'            => $request->subject_id,
            'term_id'               => $request->term_id
        ],
        [
            'attendance'            => 0,
            'assignment'            => 0,
            'class_test'            => 0,
            'presentation'          => 0,
            'quiz'                  => 0,
            'practical'             => 0,
            'written'               => 0,
            'mcq'                   => 0,
            'others'                => 0,
            'total'                 => 0,
            'grade'                 => 'F',
            'gpa'                   => 0,
            'absent'                => 1
        ]);

        return response()->json(['status' => 'success']);
    }

    /**
     * Class Wise User
     *
     * @param $id
     */
    public function classWiseUser(Request $request)
    {   
        $users = User::where('school_id', Auth::user()->id)->where('class_id', $request->class_id)->get()->groupBy('section_id');

        $students = [];
        foreach ($users as $section_id => $user) {
            foreach ($user as $userName) {
                $students[getSectionName($section_id)->section_name][$userName['id']] = $userName['name'];
            }
        }
        
        return response()->json($students);
    }

    /**
     * Show Class Wise, Student Wise, Final Year Result
     *
     * @param Request
     * @param $request
     * @return
     */
    public function showClassWiseResult(Request $request)
    {   
        $seoTitle = 'Result';
        $seoDescription = 'Result' ;
        $seoKeyword = 'Result';
        $seo_array = [
            'seoTitle' => $seoTitle,
            'seoKeyword' => $seoKeyword,
            'seoDescription' => $seoDescription,
        ];
        if ($request->resultType == "studentWise") {
            $request->validate(
                [
                    'student_wise_class_id' => 'required',
                    'student_wise_term_id' => 'required',
                    'student_wise_student_id' => 'required',
                ],
                [
                    'student_wise_class_id.required' => 'Class Section Required',
                    'student_wise_student_id.required' => 'Student Section Required',
                    'student_wise_term_id.required' => 'Term Section Required',
                ]
            );
            
            $checkTotalMark = DB::table('results')
                                    ->where('school_id', Auth::user()->id)
                                    ->where('institute_class_id', $request->student_wise_class_id)
                                    ->where('student_id', $request->student_wise_student_id)
                                    ->where('term_id', $request->student_wise_term_id)
                                    ->sum('total');
                                 
            if($checkTotalMark > 0){     
                $markType = MarkType::where('institute_classes_id', $request->student_wise_class_id)
                                    ->where('school_id', Auth::user()->id)->orderBy('id', 'Asc')->get();

                $markTypeCount = MarkType::where('institute_classes_id', $request->student_wise_class_id)
                                        ->where('school_id', Auth::user()->id)->count();
                                        
                $term = ResultSetting::where('school_id', Auth::user()->id)
                                        ->where('id', $request->student_wise_term_id)->first();

                $studentResults = Result::where('school_id', Auth::user()->id)
                                        ->where('institute_class_id', $request->student_wise_class_id)
                                        ->where('student_id', $request->student_wise_student_id)
                                        ->where('term_id', $request->student_wise_term_id)
                                        ->orderBy('subject_id', 'ASC')
                                        ->get();
                
                $markTypeCount = $markTypeCount + 1;

                $attendance = Attendance::where('attendance', 1)
                                        ->where('class_id', $request->student_wise_class_id)
                                        ->where('student_id', $request->student_wise_student_id)
                                        ->where('school_id', Auth::user()->id)->count();
                
                $section = User::find($request->student_wise_student_id);
                
                if($studentResults->count() > 0)
                {
                    return view('frontend.school.result.show_student_result', compact('studentResults', 'section', 'term', 'markType', 'markTypeCount', 'attendance','seo_array'));
                }
                else
                {
                    Alert::info("Sorry", "Result not published yet");
                    return back();
                }
            }

            Alert::info("Sorry", "Result not input yet");
            return back();   
        }

        elseif ($request->resultType == 'yearlyFinalResult') {
            $request->validate(
                [
                    'final_wise_class_id' => 'required',
                    'final_student_wise_student_id' => 'required',
                ],
                [
                    'final_wise_class_id.required' => 'Class Section Required',
                    'final_student_wise_student_id.required' => 'Student Section Required',
                ]
                );
            
            $term_id = $request->resultSetting;
            if(!(count($term_id) > 1)) {
                Alert::info("At least select two term !");
                return back();
            }
            $studentResults = Result::where('school_id', Auth::user()->id)->where('institute_class_id', $request->final_wise_class_id)
                ->where('student_id', $request->final_student_wise_student_id)
                ->whereIn('term_id', $term_id)
                ->orderBy('term_id','ASC')
                ->get();

            $subjects = [];

            foreach ($studentResults as $key => $result) {
                if(!is_null($result->term)):
                    // $subjects[$result->subject->subject_name][$result->term->term_name] = [
                    $subjects[$result->subject->subject_name][$result->term->title] = [
                        'subject_id'  => $result->subject_id,
                        'total' => $result->total,
                        'written' => $result->written,
                        'mcq' => $result->mcq,
                        'other' => $result->attendence + $result->assignment + $result->class_test + $result->presentation + $result->quiz + $result->practical + $result->others,
                    ];

                endif;
            }

            $rank = Result::select('student_id')->selectRaw("SUM(total) as finalTotal")
                            ->where('school_id', Auth::user()->id)
                            ->where('institute_class_id', $request->final_wise_class_id)
                            ->orderByDesc('finalTotal')
                            ->groupBy('student_id')
                            ->get();
           
            $findRank       = $rank->where('student_id', $request->final_student_wise_student_id);
            $studentRank    = $findRank->keys()->first() + 1;

            $section = User::find($request->final_student_wise_student_id);
            $section_rank = Result::select('student_id')->selectRaw("SUM(total) as finalTotal")
                            ->where('school_id', Auth::user()->id)
                            ->where('institute_class_id', $request->final_wise_class_id)
                            // ->where('term_id', $request->student_wise_term_id)
                            ->where('section_id', $section->section_id)
                            ->orderByDesc('finalTotal')
                            ->groupBy('student_id')
                            ->get();

            $section_findRank       = $section_rank->where('student_id', $request->final_student_wise_student_id);
            $section_studentRank    = $section_findRank->keys()->first() + 1;

            $userSection = User::where('id', $request->final_student_wise_student_id)->first();
            $attendance = Attendance::where('section_id', $userSection->section_id)->where('student_id', $request->final_student_wise_student_id)->get();

            return view('frontend.school.result.show_final_result', compact('subjects', 'term_id', 'studentResults', 'studentRank', 'attendance','section_studentRank','seo_array'));
        }
        else {
            $request->validate(
                    [
                        'class_wise_class_id' => 'required',
                        'class_wise_term_id' => 'required',
                    ],
                    [
                        'class_wise_class_id.required' => 'Class Section Required',
                        'class_wise_term_id.required' => 'Term Section Required',
                    ]
                );
        
            $class = $request->class_wise_class_id;
            $term = $request->class_wise_term_id;

            $students =  User::where('school_id', Auth::user()->id)->where('class_id', $class)->onlyTrashed()->get()->pluck('id')->toArray();
              
            $classResults = Result::where('results.school_id', Auth::user()->id)
                                        ->with('user')
                                        ->where('institute_class_id', $request->class_wise_class_id)
                                        ->where('term_id', $request->class_wise_term_id)
                                        ->whereNotIn('student_id', $students)
                                        ->get()->groupBy('student_id');
           
            $studentsId = array_keys($classResults->toArray());
            
            $attendanceCount = CustomAttendanceInput::where('school_id', Auth::user()->id)
                                                    ->where('result_setting_id', $request->class_wise_term_id)
                                                    ->whereIn('user_id', $studentsId)->count();

            if ($attendanceCount != count($classResults)) {
                $classResults = $classResults; 
                $attendanceNotEqual = 1;
            } else {
                $classResults = Result::leftJoin('custom_attendance_input as attendance', 'results.student_id', '=', 'attendance.user_id')
                                    ->whereNotIn('results.student_id', $students)
                                    ->where('results.school_id', Auth::user()->id)
                                    ->where('attendance.school_id', Auth::user()->id)
                                    ->where('institute_class_id', $request->class_wise_class_id)
                                    ->where('term_id', $request->class_wise_term_id)
                                    ->where('attendance.result_setting_id', $request->class_wise_term_id)
                                    ->get()->groupBy('student_id');

                $attendanceNotEqual = 0;
            }
            
            $result_pass_mark = ResultSetting::findOrFail($term);
            $arrOfResult =[];
            foreach ($classResults as $result => $data){
                $total = 0;
                $totalGpa = 0.000;
                $totalSubject = 0;
                $resultStatus = 1;
                foreach($data as $results){
                    if($results->absent == 1 || $results->total != 0) {
                        $total += $results->total;
                        $totalGpa += $results->gpa;
                        $optionalSubject = $data->first()->user?->optional_subject;
                        if ($optionalSubject != null) {
                            $optionalSubjectId = \App\Models\Subject::where('school_id', Auth::user()->id)->where('class_id', $class)->whereIn('subject_code', $optionalSubject)->get()->pluck('id')->toArray();
                            $optionalResult = $data->whereIn('subject_id', $optionalSubjectId)->first();
                            $not = $optionalResult->subject_id == $results->subject_id;
                            if (!$not) {
                                if( gpa($results->mcq, $results->written, $results->practical, $results->total, $term, $class, $results->subject_id) == 0 ) $resultStatus = 0;
                            } 
                        } else {
                            if( gpa($results->mcq, $results->written, $results->practical, $results->total, $term, $class, $results->subject_id) == 0 ) $resultStatus = 0;
                        }
                        $totalSubject++;
                    }
                }

                $optionalSubject = $data->first()->user?->optional_subject;
                if (in_array($data->first()->user?->class?->class_name, classFilter()) && $optionalSubject != null) {
                    $totalSubject = $totalSubject - 1; 
                    $optionalSubjectId = \App\Models\Subject::where('school_id', Auth::user()->id)->where('class_id', $class)->whereIn('subject_code', $optionalSubject)->get()->pluck('id')->toArray();
                    $optionalResult = $data->whereIn('subject_id', $optionalSubjectId)->first();
                    $totalGpa = $totalGpa - $optionalResult->gpa;
                    $addOptionalPoint = $optionalResult->gpa - 2;
                    $addOptionalPoint = $addOptionalPoint < 0 ? 0 : $addOptionalPoint;
                    $totalGpa = $totalGpa + $addOptionalPoint;
                    
                    $totalGpa = number_format($totalGpa / $totalSubject, 2);
                    $totalGpa = $totalGpa > 5 ? 5 : $totalGpa; 
                } else {
                    $totalGpa = $totalSubject != 0 ? number_format($totalGpa / $totalSubject, 2) : 1;
                }
                
                $arrOfResult[][$total]= [
                    'total'                  => $total,
                    'totalGpa'               => $totalGpa,
                    'resultStatus'           => $resultStatus,
                    'student_id'             => $data[0]->student_id,
                    'student_roll_number'    => $data[0]->student_roll_number,
                    'present'                => isset($data[0]->present) ? $data[0]->present : 0,
                ];
            }

            $passStudent = [];
            $failStudent = [];
            $arraySize = sizeof($arrOfResult);
            $sortedArrayOfResult = collect($arrOfResult)->sortByDesc('total');

            foreach ($arrOfResult as $key => $results) {
                foreach ($results as $key => $result) {
                    if($result['resultStatus'] == 1) {
                        $passStudent[] = $result;
                    }else{
                        $failStudent[] = $result;
                    }
                }
            }

            $findPassStudentGpaColumn = array_column($passStudent, 'totalGpa');
            $findPassStudentTotalColumn = array_column($passStudent, 'total');
            $findPassStudentPresentColumn = array_column($passStudent, 'present');
            $findPassStudentStudent_roll_number = array_column($passStudent, 'student_roll_number');
            array_multisort($findPassStudentGpaColumn, SORT_DESC, $findPassStudentTotalColumn, SORT_DESC, $findPassStudentPresentColumn, SORT_DESC, $findPassStudentStudent_roll_number, SORT_ASC, $passStudent);
            
            $findFailStudentGpaColumn = array_column($failStudent, 'totalGpa');
            $findFailStudentTotalColumn = array_column($failStudent, 'total');
            $findFailStudentPresentColumn = array_column($failStudent, 'present');
            $findFailStudentStudent_roll_number = array_column($failStudent, 'student_roll_number');
            array_multisort($findFailStudentGpaColumn, SORT_DESC, $findFailStudentTotalColumn, SORT_DESC, $findFailStudentPresentColumn, SORT_DESC, $findFailStudentStudent_roll_number, SORT_ASC, $failStudent);

            return view('frontend.school.result.classWiseResult', compact('sortedArrayOfResult','passStudent', 'failStudent','term','class', 'arraySize', 'attendanceNotEqual','seo_array'));
        }
    }

   

}
