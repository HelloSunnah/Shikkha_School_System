<?php

namespace App\Http\Controllers\Exam;

use App\Models\ExamRoutine;
use App\Http\Controllers\Controller;
use App\Models\InstituteClass;
use App\Models\School;
use App\Models\Subject;
use App\Models\Term;
use App\Models\User;
use Carbon\Carbon;
use App\Models\ResultSetting;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ExamController extends Controller
{
    /**
     * Fetch Routine
     * 
     * @return \Illuminate\Contracts\View\ 
     */
    public function examRoutine()
    {   
        $seoTitle = 'Exam Routine';
        $seoDescription = 'Exam Routine' ;
        $seoKeyword = 'Exam Routine' ;
        $seo_array = [
            'seoTitle' => $seoTitle,
            'seoKeyword' => $seoKeyword,
            'seoDescription' => $seoDescription,
        ];
        $data['classes'] = InstituteClass::where('school_id', Auth::user()->id)->get();
        $data['terms']   = Term::where('school_id', Auth::user()->id)->orderBy('id', 'asc')->get();

        return view('frontend.school.exam.index', $data ,compact('seo_array'));
    }

    /**
     * Fetch Subject
     * 
     * @param int $id
     * @return respone 
     */
    public function getSubject($id)
    {
        $subjects = Subject::where('school_id', Auth::user()->id)->where('class_id', $id)->get();
        
        return response()->json($subjects);
    }

    /**
     * Fetch Routine
     * 
     * @param int $id
     * @param int $term_id
     * @return respone 
     */
    public function getRoutine($id, $term_id, $shift_id)
    {
        $routines = ExamRoutine::with('class', 'subject', 'term')
                                ->where('school_id', Auth::user()->id)
                                ->where('shift_id', $shift_id)
                                ->where('term_id', $term_id)
                                ->where('class_id', $id)
                                ->orderBy('date', 'asc')
                                ->get();
        
        return response()->json($routines);
    }

    /**
     * Save Routine
     * 
     * @param Request $request
     * @return respone 
     */
    public function storeExamRoutine(Request $request)
    {   
        $validate = Validator::make($request->all(), [
            "class_id"        => "required",
            "subject_id"      => "required",
            "date"            => "required|date",
            "start_time"      => "required",
            "end_time"        => "required",
            "exam_term"       => "required",
            "shift_id"       => "required",
        ], [
            "class_id.required" => "The class field is required.",
            "subject_id.required" => "The subject field is required.",
            "date.required" => "The date field is required.",
            "start_time.required" => "The start time field is required.",
            "end_time.required" => "The end time field is required.",
            "exam_term.required" => "The exam term field is required.",
            "shift_id.required" => "The Shift field is required.",
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'fail',
                'error'  => $validate->errors()->toArray()
            ]);
        }

        $rotuine = ExamRoutine::where('term_id', $request->exam_term)->where('class_id', $request->class_id)->where('subject_id', $request->subject_id);
        if ($rotuine->exists()) {
            return response()->json([
                'status' => 'fail',
                'error'  => ['subject_id' => ['This Subject is Already Exist']]
            ]);
        };

        ExamRoutine::insert([
            "school_id"         => Auth::user()->id,
            "term_id"           => $request->exam_term,
            "shift_id"           => $request->shift_id,
            "class_id"          => $request->class_id,
            "subject_id"        => $request->subject_id,
            "date"              => \Carbon\Carbon::parse($request->date)->format('d/m/Y'),
            "start_time"        =>  \Carbon\Carbon::parse($request->start_time)->format('h:ia'),
            "end_time"          =>  \Carbon\Carbon::parse($request->end_time)->format('h:ia'),
            "day"               => \Carbon\Carbon::parse($request->date)->format('l'),
        ]);

        return response()->json(['Success' => 'Exam Routine Create Successfully']);
    }

    /**
     * Delete Exam Routine
     * 
     * @param int $id
     * @return respone 
     */
    public function deleteExamRoutine($id)
    {
        ExamRoutine::findOrFail($id)->delete();
        
        return back();
    }

    /**
     * Generate Pdf
     * 
     * @param int $class_id
     * @param int $term_id
     * @return respone pdf download 
     */
    public function generatePdf($class_id, $term_id)
    {
        $data['exam_routines'] = ExamRoutine::with('class', 'subject')->where('school_id', Auth::user()->id)->where('term_id', $term_id)->where('class_id', $class_id)->orderBy('date', 'asc')->get();
        $data['school']        = School::where('id', Auth::user()->id)->first();
        $data['term']          = Term::findOrFail($term_id);
        $data['class']         = InstituteClass::findOrFail($class_id);
        $data['shift'] = "Day";
        
        if($data['exam_routines']->first()->shift_id == 1)
        {
            $data['shift'] = "Morning";
        }
        else
        {
            $data['shift'] = "Evening";
        }

        $pdf = PDF::loadView('frontend.school.exam.exam_routine', $data);
        $pdf->render();
        // return $pdf->download('Exam_Routine.pdf');
        return $pdf->stream('Exam_Routine.pdf', ['Attachment' => false]);
    }



    // view admit card
    public function showAdmitCard(){
        $seoTitle = 'Admit Card';
        $seoDescription = 'Admit Card' ;
        $seoKeyword = 'Admit Card' ;
        $seo_array = [
            'seoTitle' => $seoTitle,
            'seoKeyword' => $seoKeyword,
            'seoDescription' => $seoDescription,
        ];
        $class = InstituteClass::where('school_id',Auth::id())->get();
        $term = ResultSetting::where('school_id',Auth::id())->get();
        if(count($term)>0){
            return view('frontend.school.exam.admitCard', compact('class','term','seo_array'));    
        }
        else{
            $resultSettings = ResultSetting::where('school_id', Auth::user()->id)->orderBy('id', 'asc')->get();
            return view('frontend.school.student.result.createShow', compact('resultSettings'));
        }
    }

    // Admit Card Download
    public function showAdmitCardDownload(Request $request){
        //  return $request -> term_id;
        $request->validate([
            'term_id' => 'required',
            'class_id' => 'required',
        ]);

        $term = ResultSetting::find($request -> term_id)->title;
        if($request->section_id){
            $student = User::where('school_id', Auth::user()->id)->where('class_id', $request->class_id)->where('section_id', $request->section_id)->get();
        }
        else{
            $student = User::where('school_id', Auth::user()->id)->where('class_id', $request->class_id)->get();
        }
        $class = InstituteClass::find($request -> class_id)->class_name;
        $subject = Subject::where('school_id', Auth::user()->id)->where('class_id', $request->class_id)->get();
        $year = Carbon::now()->format('Y');

        return view('frontend.school.exam.admitCardDownload',compact('term', 'student', 'subject', 'class', 'year'));

    }

    // view sit Plan
    public function showSitPlan(){
        $seoTitle = 'Sit Plan';
        $seoDescription = 'Sit Plan' ;
        $seoKeyword = 'Sit Plan' ;
        $seo_array = [
            'seoTitle' => $seoTitle,
            'seoKeyword' => $seoKeyword,
            'seoDescription' => $seoDescription,
        ];
        $class = InstituteClass::where('school_id',Auth::id())->get();
        $term = ResultSetting::where('school_id',Auth::id())->get();
        $year = Carbon::now()->format('Y');
        return view('frontend.school.exam.sitPlan', compact('class','term', 'year','seo_array'));
    }

    // Sit Plan Download
    public function showSitPlanDownload(Request $request){
        $request->validate([
            'term_id' => 'required',
            'class_id' => 'required',
        ]);
        $term = ResultSetting::find($request -> term_id)->title;
        
        if($request->section_id){
            $student = User::where('school_id', Auth::user()->id)->where('class_id', $request->class_id)->where('section_id', $request->section_id)->get();
        }
        else{
            $student = User::where('school_id', Auth::user()->id)->where('class_id', $request->class_id)->get();
        }
        $class = InstituteClass::find($request -> class_id)->class_name;
        $subject = Subject::where('school_id', Auth::user()->id)->where('class_id', $request->class_id)->get();
        $year = Carbon::now()->format('Y');
        return view('frontend.school.exam.sitPlanDownload',compact('term', 'student', 'subject', 'class', 'year'));

    }
}
