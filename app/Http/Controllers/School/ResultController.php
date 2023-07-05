<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\CustomAttendanceInput;
use App\Models\InstituteClass;
use App\Models\MarkType;
use App\Models\Result;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ResultSetting;
use App\Models\Section;
use App\Models\Term;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Laravel\Ui\Presets\Preset;

class ResultController extends Controller
{
    /**
     * Show View Page Select Class and Term
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function classWiseResult()
    {   
        $class = InstituteClass::where('school_id', Auth::user()->id)->get();
        $terms = ResultSetting::where('school_id', Auth::user()->id)->orderBy('id','desc')->get();
        $users = User::where('school_id', Auth::user()->id)->get();
        return view('frontend.school.result.class_wise_result', compact('class', 'terms'));
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

                $markTypeCount = $markTypeCount+1;

                $attendance = Attendance::where('attendance', 1)
                                        ->where('class_id', $request->student_wise_class_id)
                                        ->where('student_id', $request->student_wise_student_id)
                                        ->where('school_id', Auth::user()->id)->count();

                $rank = DB::table('results')->join('custom_attendance_input as attendance', 'results.student_id', '=', 'attendance.user_id')
                                ->select('student_id','student_roll_number', 'attendance.present as present' )->selectRaw("SUM(results.total) as finalTotal")
                                ->where('results.institute_class_id', $request->student_wise_class_id)
                                ->where('results.term_id', $request->student_wise_term_id)
                                ->where('attendance.result_setting_id', $request->student_wise_term_id)
                                ->where('results.school_id', Auth::user()->id)
                                ->where('attendance.school_id', Auth::user()->id)
                                ->groupBy('results.student_id','results.student_roll_number', 'present')
                                ->orderBy('finalTotal', 'DESC')
                                ->orderBy('present', 'DESC')
                                ->orderBy('student_roll_number', 'ASC')
                                ->get();

                $findRank       = $rank->where('student_id', $request->student_wise_student_id);
                $studentRank    = $findRank->keys()->first() + 1;
                
                $section = User::find($request->student_wise_student_id);
                $section_rank = DB::table('results')->join('custom_attendance_input as attendance', 'results.student_id', '=', 'attendance.user_id')
                                ->select('student_id','student_roll_number', 'attendance.present as present' )->selectRaw("SUM(results.total) as finalTotal")
                                ->where('results.institute_class_id', $request->student_wise_class_id)
                                ->where('section_id', $section->section_id)
                                ->where('results.term_id', $request->student_wise_term_id)
                                ->where('attendance.result_setting_id', $request->student_wise_term_id)
                                ->where('results.school_id', Auth::user()->id)
                                ->where('attendance.school_id', Auth::user()->id)
                                ->groupBy('results.student_id','results.student_roll_number', 'present')
                                ->orderBy('finalTotal', 'DESC')
                                ->orderBy('present', 'DESC')
                                ->orderBy('student_roll_number', 'ASC')
                                ->get();

                $section_findRank       = $section_rank->where('student_id', $request->student_wise_student_id);
                $section_studentRank    = $section_findRank->keys()->first() + 1;

                if($studentResults->count() > 0)
                {
                    return view('frontend.school.result.show_student_result', compact('studentResults', 'section', 'term', 'markType', 'markTypeCount', 'attendance', 'studentRank', 'section_studentRank'));
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

            return view('frontend.school.result.show_final_result', compact('subjects', 'term_id', 'studentResults', 'studentRank', 'attendance','section_studentRank'));
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
                
                $classResults = DB::table('results')->leftJoin('custom_attendance_input as attendance', 'results.student_id', '=', 'attendance.user_id')
                                    ->where('results.school_id', Auth::user()->id)
                                    ->where('attendance.school_id', Auth::user()->id)
                                    ->where('institute_class_id', $request->class_wise_class_id)
                                    ->where('term_id', $request->class_wise_term_id)
                                    ->where('attendance.result_setting_id', $request->class_wise_term_id)
                                    ->get()->groupBy('student_id');
                
                   
                $term_mark= Term::where('id',$term)->first();
                $result_pass_mark = ResultSetting::findOrFail($term);
               
                $arrOfResult =[];
                foreach ($classResults as $result => $data){
                    $total = 0; 
                    $totalGpa = 0.000;
                    $totalSubject = 0;
                    $resultStatus = 1;

                    foreach($data as $results){
                        if($results->total != 0) {
                            $pass_mark = ($result_pass_mark->pass_mark / 100) * subjectMark($term, $class, $results->subject_id);
                            $total += $results->total;
                            $totalGpa += $results->gpa;
                            $totalMark = $results->total * 100 / subjectMark($term, $class, $results->subject_id);
                            if( $results->total < $pass_mark ) $resultStatus = 0;
                            $totalSubject++;
                        }
                    }
                    
                    $totalGpa = number_format($totalGpa / $totalSubject, 2);
                    $arrOfResult[][$total]= [
                        'total'                  => $total,
                        'totalGpa'               => $totalGpa,
                        'totalMark'              => $totalMark,
                        'resultStatus'           => $resultStatus,
                        'student_id'             => $data[0]->student_id,
                        'student_roll_number'    => $data[0]->student_roll_number,
                        'present'                => $data[0]->present
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
               
                $findPassStudentTotalColumn = array_column($passStudent, 'total');
                $findPassStudentPresentColumn = array_column($passStudent, 'present');
                $findPassStudentStudent_roll_number = array_column($passStudent, 'student_roll_number');
                array_multisort($findPassStudentTotalColumn, SORT_DESC, $findPassStudentPresentColumn, SORT_DESC, $findPassStudentStudent_roll_number, SORT_ASC, $passStudent);
                
                $findFailStudentTotalColumn = array_column($failStudent, 'total');
                $findFailStudentPresentColumn = array_column($failStudent, 'present');
                $findFailStudentStudent_roll_number = array_column($failStudent, 'student_roll_number');
                array_multisort($findFailStudentTotalColumn, SORT_DESC, $findFailStudentPresentColumn, SORT_DESC, $findFailStudentStudent_roll_number, SORT_ASC, $failStudent);
                
                return view('frontend.school.result.classWiseResult', compact('sortedArrayOfResult','passStudent', 'failStudent','term','class', 'arraySize'));
        }
    }

   

}
