<?php

namespace App\Http\Controllers\Exam;

use App\Models\Term;
use App\Models\Subject;
use App\Models\Question;
use App\Models\ExamRoutine;
use Illuminate\Http\Request;
use App\Models\InstituteClass;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Validated;
use Facade\Ignition\DumpRecorder\Dump;
use function PHPUnit\Framework\isNull;

use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller
{
    /**
     * Show Question Create Page
     * 
     * @return \Illuminate\Contracts\View\ 
     */
    public function index()
    {
        $data['classes'] = InstituteClass::where('school_id', Auth::user()->id)->get();
        $data['terms']   = Term::where('school_id', Auth::user()->id)->get();
        $data['json'] = Question::get();

        return view('frontend.school.question.index', $data);
    }

    /**
     * Save Question
     * 
     * @param Request
     * @param $request
     * @return \Illuminate\Contracts\View\ 
     */
    public function questionStore(Request $request)
    {   
        // $question = Question::where('school_id', Auth::user()->id)->where('type', $request->question_type)
        //                     ->where('term_id', $request->exam_term)->where('class_id', $request->class_name)
        //                     ->where('subject_id', $request->subject_name)->get();
        
        $question_top = Validator::make($request->only('exam_term', 'class_name', 'subject_name', 'hours', 'total_mark'), [
                'exam_term'         => 'required|',
                'class_name'        => 'required',
                'subject_name'      => 'required',
                'hours'             => 'required|numeric|min:1|max:100',
                'total_mark'        => 'required|numeric|min:1|max:100',
        ], [
                "exam_term.required"          => "Exam field term is required",
                "class_name.required"         => "Class field is required",
                "subject_name.required"       => "Subject field is required",
                "total_mark.required"         => "Total mark field is required",
        ]);

        if ($question_top->fails()) {
            return response()->json([
                'status' => 'fail',
                'error'  => $question_top->errors()->toArray()
            ]);
        }

        if (!empty($request->question_title[1])) {

            $unValid = Validator::make($request->all(), [
                'exam_term'         => 'required|',
                'class_name'        => 'required',
                'subject_name'      => 'required',
                'hours'             => 'required|numeric|min:1|max:100',
                'total_mark'        => 'required|numeric|min:1|max:100',
                'question_title.*'    => 'required',
                'question_mark.*'     => 'required',
                'questions.*'          => 'required',
                
            ], [

                "exam_term.required"          => "Exam field term is required",
                "class_name.required"         => "Class field is required",
                "subject_name.required"       => "Subject field is required",
                "total_mark.required"         => "Total mark field is required",
                "question_title.*.required"   => "Question title field is required",
                "question_mark.*.required"    => "Mark field is required",
                "questions.*.required"        => "Question field is required"   
            ]);

            if ($unValid->fails()) {
                return response()->json([
                    'status' => 'fail',
                    'error'  => $unValid->errors()->toArray()
                ]);
            }

            if (is_null($request->question_id)) {

                Question::create([
                    'type'          => $request->question_type,  
                    'school_id'     => Auth::user()->id,
                    'term_id'       => $request->exam_term,
                    'class_id'       => $request->class_name,
                    'subject_id'       => $request->subject_name,
                    'hours'          => $request->hours,
                    'total_marks'   => $request->total_mark,   
                    'question_title' => $request->question_title,
                    'question_mark' => $request->question_mark,
                    'question'     => $request->questions
                ]);

            } else {
                $question_id = Question::findOrFail($request->question_id);
                
                $question_id->update([
                    'type'          => $request->question_type,  
                    'school_id'     => Auth::user()->id,
                    'term_id'       => $request->exam_term,
                    'class_id'       => $request->class_name,
                    'subject_id'       => $request->subject_name,
                    'hours'          => $request->hours,
                    'total_marks'   => $request->total_mark,   
                    'question_title' => $request->question_title,
                    'question_mark' => $request->question_mark,
                    'question'     => $request->questions
              ]);
            }

            toast('Question Create Successful', 'success');
            return response()->json(['status' => 'success']);

        }  elseif (!empty($request->mcqQuestion_no[1][1])) {

            $unValid = Validator::make($request->all(), [
                'exam_term'         => 'required',
                'class_name'        => 'required',
                'subject_name'      => 'required',
                'hours'             => 'required|numeric|min:1|max:100',
                'total_mark'        => 'required|numeric|min:1|max:100',
                'mcqQuestion_no.*'    => 'required',
                'mcqQuestions.*'    => 'required',
                
            ], [
                "exam_term.required"    => "Exam field term is required",
                "class_name.required"   => "Class field is required",
                "subject_name.required" => "Subject field is required",
                "total_mark.required"   => "Total mark field is required",
                "mcqQuestion_no.*.required"   => "Mcq question field is required",
                "mcqQuestions.*.required"   => "Question field is required",
            ]);

            if ($unValid->fails()) {
                return response()->json([
                    'status' => 'fail',
                    'error'  => $unValid->errors()->toArray()
                ]);
            }

            if (is_null($request->question_id)) {

                Question::create([
                    'type'          => $request->question_type,
                    'school_id'     => Auth::user()->id,
                    'term_id'       => $request->exam_term,
                    'class_id'       => $request->class_name,
                    'subject_id'       => $request->subject_name,
                    'hours'          => $request->hours,
                    'total_marks'   => $request->total_mark,
                    'mcq_question'  => $request->mcqQuestion_no,   
                    'question_mark' => $request->mcqQuestion_mark,
                    'question'     => $request->mcqQuestions
                ]);
            } else {
                $question_id = Question::findOrFail($request->question_id);
                $question_id->update([
                    'type'          => $request->question_type,
                    'school_id'     => Auth::user()->id,
                    'term_id'       => $request->exam_term,
                    'class_id'       => $request->class_name,
                    'subject_id'       => $request->subject_name,
                    'hours'          => $request->hours,
                    'total_marks'   => $request->total_mark,
                    'mcq_question'  => $request->mcqQuestion_no,   
                    'question_mark' => $request->mcqQuestion_mark,
                    'question'     => $request->mcqQuestions
                ]);
            }

            toast('Question Create Successful', 'success');
            return response()->json(['status' => 'success']);

        } elseif (!empty($request->creQuestions[1])) {
            
            $unValid = Validator::make($request->all(), [
                'exam_term'             => 'required',
                'class_name'            => 'required',
                'subject_name'          => 'required',
                'hours'                 => 'required|numeric|min:1|max:100',
                'total_mark'            => 'required|numeric|min:1|max:100',
                'creQuestion_no.*'      => 'required',
                'creQuestion_mark.*'    => 'required',
                'creQuestions.*'        => 'required',
                
            ], [
                "exam_term.required"            => "This exam field term is required",
                "class_name.required"           => "This class field is required",
                "subject_name.required"         => "This subject field is required",
                "total_mark.required"           => "This total mark field is required",
                "creQuestions.*.required"       => "This question field is required",
                "creQuestion_no.*.required"     => "This creative question field is required",
                "creQuestion_mark.*.required"   => "This question mark field is required",
            ]);

            if ($unValid->fails()) {
                return response()->json([
                    'status' => 'fail',
                    'error'  => $unValid->errors()->toArray()
                ]);
            }
            
            if (is_null($request->question_id)) {

                Question::create([
                    'type'              => $request->question_type,
                    'school_id'         => Auth::user()->id,
                    'term_id'           => $request->exam_term,
                    'class_id'          => $request->class_name,
                    'subject_id'        => $request->subject_name,
                    'hours'             => $request->hours,
                    'total_marks'       => $request->total_mark,
                    'cre_question'      => $request->creQuestion_no,   
                    'question_mark'     => $request->creQuestion_mark,
                    'question'          => $request->creQuestions
                ]);
            } else {
                $question_id = Question::findOrFail($request->question_id);
                $question_id->update([
                    'type'              => $request->question_type,
                    'school_id'         => Auth::user()->id,
                    'term_id'           => $request->exam_term,
                    'class_id'          => $request->class_name,
                    'subject_id'        => $request->subject_name,
                    'hours'             => $request->hours,
                    'total_marks'       => $request->total_mark,
                    'cre_question'      => $request->creQuestion_no,   
                    'question_mark'     => $request->creQuestion_mark,
                    'question'          => $request->creQuestions
                ]);

            }

            toast('Question Create Successful', 'success');
            return response()->json(['status' => 'success']);
        }
        
        toast(' Check your question field blank', 'error');
        return back();
    }

    /**
     * Save Question
     * 
     * @param Request
     * @param $request
     * @return \Illuminate\Contracts\View\ 
     */
    public function ajaxQuestionStore(Request $request)
    {   

        if ($request->question_type == "Written") {
            
            $validator = Validator::make($request->all(), [
                'exam_term'         => 'required|',
                'class_name'        => 'required',
                'subject_name'      => 'required',
                'hours'             => 'required|min:1|numeric',
                'total_mark'        => 'required|min:1|numeric',
                'question_title.*'    => 'required',
                'question_mark.*'     => 'required',
                // 'questions.*'          => 'required',
                
            ], [
                "exam_term.required"            => "This exam field term is required",
                "class_name.required"           => "This class field is required",
                "subject_name.required"         => "This subject field is required",
                "total_mark.required"           => "This total mark field is required",
                "question_title.*.required"     => "This question title field is required",
                "question_mark.*.required"      => "This mark field is required",
                "questions.*.required"          => "This question field is required"   
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'fail',
                    'error'  => $validator->errors()->toArray()
                ]);
            }else {
                if (is_null($request->question_id)) {
                    
                    $id =  Question::create([
                          'type'          => $request->question_type,  
                          'school_id'     => Auth::user()->id,
                          'term_id'       => $request->exam_term,
                          'class_id'       => $request->class_name,
                          'subject_id'       => $request->subject_name,
                          'hours'          => $request->hours,
                          'total_marks'   => $request->total_mark,   
                          'question_title' => $request->question_title,
                          'question_mark' => $request->question_mark,
                          'question'     => $request->questions
                      ]);
                      
                      if($id->id != null) {
                          return response()->json($id);
                      }
                } else {
                    $question_id = Question::findOrFail($request->question_id);
                    
                    $question_id->update([
                          'type'          => $request->question_type,  
                          'school_id'     => Auth::user()->id,
                          'term_id'       => $request->exam_term,
                          'class_id'       => $request->class_name,
                          'subject_id'       => $request->subject_name,
                          'hours'          => $request->hours,
                          'total_marks'   => $request->total_mark,   
                          'question_title' => $request->question_title,
                          'question_mark' => $request->question_mark,
                          'question'     => $request->questions
                    ]);
                }
            }
        }  elseif ($request->question_type == "MCQ") {
           
            $validator = Validator::make($request->all(), [
                'exam_term'         => 'required',
                'class_name'        => 'required',
                'subject_name'      => 'required',
                'hours'             => 'required|min:1|numeric',
                'total_mark'        => 'required|min:1|numeric',
                'mcqQuestion_no.*'    => 'required',
                // 'mcqQuestions.*'    => 'required',
                
            ], [
                "exam_term.required"    => "This exam field term is required",
                "class_name.required"   => "This class field is required",
                "subject_name.required" => "This subject field is required",
                "total_mark.required"   => "This total mark field is required",
                "mcqQuestion_no.*.required"   => "This mcq question field is required",
                // "mcqQuestions.*.required"   => "This question field is required",
            ]);
            
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'fail',
                    'error'  => $validator->errors()->toArray()
                ]);
            }else{
                if (is_null($request->question_id)) {
                    
                   $id = Question::create([
                        'type'          => $request->question_type,
                        'school_id'     => Auth::user()->id,
                        'term_id'       => $request->exam_term,
                        'class_id'       => $request->class_name,
                        'subject_id'       => $request->subject_name,
                        'hours'          => $request->hours,
                        'total_marks'   => $request->total_mark,
                        'mcq_question'  => $request->mcqQuestion_no,   
                        'question_mark' => $request->mcqQuestion_mark,
                        'question'     => $request->mcqQuestions
                    ]);
    
                    return response()->json($id);
                }
                $question_id = Question::findOrFail($request->question_id);
    
                $question_id->update([
                    'type'          => $request->question_type,
                    'school_id'     => Auth::user()->id,
                    'term_id'       => $request->exam_term,
                    'class_id'       => $request->class_name,
                    'subject_id'       => $request->subject_name,
                    'hours'          => $request->hours,
                    'total_marks'   => $request->total_mark,
                    'mcq_question'  => $request->mcqQuestion_no,   
                    'question_mark' => $request->mcqQuestion_mark,
                    'question'     => $request->mcqQuestions
                ]);
            }
        } elseif ($request->question_type == "Creative") {
            $validator = Validator::make($request->all(), [
                'exam_term'             => 'required',
                'class_name'            => 'required',
                'subject_name'          => 'required',
                'hours'                 => 'required|min:1|numeric',
                'total_mark'            => 'required|min:1|numeric',
                'creQuestion_no.*'      => 'required',
                'creQuestion_mark.*'    => 'required',
                // 'creQuestions.*'        => 'required',
                
            ], [
                "exam_term.required"            => "This exam field term is required",
                "class_name.required"           => "This class field is required",
                "subject_name.required"         => "This subject field is required",
                "total_mark.required"           => "This total mark field is required",
                // "creQuestions.*.required"       => "This question field is required",
                "creQuestion_no.*.required"     => "This creative question field is required",
                "creQuestion_mark.*.required"   => "This question mark field is required",
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'fail',
                    'error'  => $validator->errors()->toArray()
                ]);
            }else{

                if (is_null($request->question_id)) {
    
                  $id =  Question::create([
                    'type'              => $request->question_type,
                    'school_id'         => Auth::user()->id,
                    'term_id'           => $request->exam_term,
                    'class_id'          => $request->class_name,
                    'subject_id'        => $request->subject_name,
                    'hours'             => $request->hours,
                    'total_marks'       => $request->total_mark,
                    'cre_question'      => $request->creQuestion_no,   
                    'question_mark'     => $request->creQuestion_mark,
                    'question'          => $request->creQuestions
                    ]);
    
                    return response()->json($id);
                }
                $question_id = Question::findOrFail($request->question_id);
    
                $question_id->update([
                'type'              => $request->question_type,
                'school_id'         => Auth::user()->id,
                'term_id'           => $request->exam_term,
                'class_id'          => $request->class_name,
                'subject_id'        => $request->subject_name,
                'hours'             => $request->hours,
                'total_marks'       => $request->total_mark,
                'cre_question'      => $request->creQuestion_no,   
                'question_mark'     => $request->creQuestion_mark,
                'question'          => $request->creQuestions
                ]);
            }
    
        }
    }
    
    /**
     * Ckeditor Upload Image
     * 
     * @param Request 
     * @param $request
     * @return \Illuminate\Contracts\View\ 
     */
    public function imageUpload(Request $request)
    {
        if($request->hasFile('upload')) {
            //get filename with extension
            $filenamewithextension = $request->file('upload')->getClientOriginalName();

            //get filename without extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

            //get file extension
            $extension = $request->file('upload')->getClientOriginalExtension();

            //filename to store
            $filenametostore = $filename.'_'.time().'.'.$extension;

            //Upload File
            $request->file('upload')->move('public/uploads', $filenametostore);

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('public/uploads/'.$filenametostore);
            $message = 'File uploaded successfully';
            $result = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url')</script>";

            // Render HTML output
            @header('Content-type: text/html; charset=utf-8');
            echo $result;
        }
    }

    /** 
     * Show All Question
     * 
     * @return View
     */
    public function showQuestion()
    {
        $data['questions'] = Question::with('term', 'class', 'subject')->where('school_id', auth()->user()->id)->get();
        $data['classes'] = InstituteClass::where('school_id', Auth::user()->id)->get();
        $data['terms']   = Term::where('school_id', Auth::user()->id)->orderBy('id','desc')->get();
        
        return view('frontend.school.question.questionShow', $data);
    }
    
    /**
     * View Single Question with ajax
     * 
     * @param $id
     * @return 
     */
    public function viewSingleQuestion($id)
    {
        $questions = Question::with('school', 'term', 'class', 'subject')->where('school_id', auth()->user()->id)
                                ->where('id', $id)->latest()->get(); 

        return response()->json($questions);
    }

    /**
     * View Single Question
     * 
     * @param $id
     * @return 
     */
    public function viewMcqCreativeQuestion($id)
    {
        $questions = Question::with('school', 'term', 'class', 'subject')->where('school_id', auth()->user()->id)
                                ->where('id', $id)->latest()->get();
        
        return view('frontend.school.question.view_single_question', compact('questions'));                        
    }

    /**
     * Term Wies Question 
     * 
     * @param $id
     * @return 
     */
    public function termWiseQuestion($id)
    {
        $questions = Question::with('school', 'term', 'class', 'subject')->where('school_id', auth()->user()->id)
                                ->where('class_id', $id)->latest()->get();                 

        return response()->json($questions);
    }

    /**
     * Edit Question 
     * 
     * @param $id
     * @return 
     */
    public function editQuestion($id)
    {
        $data['question'] = Question::with('school', 'term', 'class', 'subject')
                                ->where('school_id', auth()->user()->id)
                                ->where('id', $id)->first();
        $data['classes'] = InstituteClass::where('school_id', Auth::user()->id)->get();
        $data['terms']   = Term::where('school_id', Auth::user()->id)->get();
        $data['subjects'] = Subject::where('school_id', Auth::user()->id)->get();
        return view('frontend.school.question.edit_question', $data);
    }

    /**
     * Update Question
     * 
     * @param Request
     * @param $request
     * @param $id
     * @return redirect 
     */
    public function updateQuestion(Request $request, $id)
    { 
        $qnUpdate = Question::where('school_id', Auth::user()->id)->where('id', $id);
        
        if (!empty($request->question_title[1])) {

            $request->validate([
                'question_type'     => 'required', 
                'exam_term'         => 'required|',
                'class_name'        => 'required',
                'subject_name'      => 'required',
                'hours'             => 'required|numeric|min:1|max:100',
                'total_mark'        => 'required|numeric|max:100',
                'question_title.*'    => 'required',
                'question_mark.*'     => 'required|numeric',
                'questions.*'          => 'required',
                
            ], [
                "question_type.required"    => "Question type field is required",
                "exam_term.required"        => "Exam field term is required",
                "class_name.required"       => "Class field is required",
                "subject_name.required"     => "Subject field is required",
                "total_mark.required"       => "Total mark field is required",
                "question_title.*.required"   => "Question title field is required",
                "question_mark.*.required"    => "Mark field is required",
                "questions.*."                 => "Question field is required"   
            ]);
    
            $qnUpdate->update([
                'type'          => $request->question_type,  
                'school_id'     => Auth::user()->id,
                'term_id'       => $request->exam_term,
                'class_id'       => $request->class_name,
                'subject_id'       => $request->subject_name,
                'hours'          => $request->hours,
                'total_marks'   => $request->total_mark,   
                'question_title' => $request->question_title,
                'question_mark' => $request->question_mark,
                'question'     => $request->questions
            ]);
            toast('Question Update Successful', 'success');
    
            return redirect()->route('show.question');

        }  elseif (!empty($request->mcqQuestion_no[1][1])) {
            $request->validate([
                'question_type'     => 'required',
                'exam_term'         => 'required',
                'class_name'        => 'required',
                'subject_name'      => 'required',
                'hours'             => 'required|numeric|min:1|max:100',
                'total_mark'        => 'required|numeric|max:100',
                'mcqQuestion_no.*'  => 'required',
                'mcqQuestions.*'    => 'required',
                
                
            ], [
                "question_type.required"    => "Question type field is required",
                "exam_term.required"    => "Exam field term is required",
                "class_name.required"   => "Class field is required",
                "subject_name.required" => "Subject field is required",
                "total_mark.required"   => "Total mark field is required",
                "mcqQuestion_no.*.required"   => "Mcq question field is required",
                "mcqQuestions.*.required"   => "Question field is required",
            ]);
    
            $qnUpdate->update([
                'type'          => $request->question_type,
                'school_id'     => Auth::user()->id,
                'term_id'       => $request->exam_term,
                'class_id'       => $request->class_name,
                'subject_id'       => $request->subject_name,
                'hours'          => $request->hours,
                'total_marks'   => $request->total_mark,
                'mcq_question'  => $request->mcqQuestion_no,   
                'question'     => $request->mcqQuestions
            ]);
            toast('Question Update Successful', 'success');
    
            return redirect()->route('show.question');

        } elseif (!empty($request->creQuestions[1])) {
            // dd($request->all());
            $request->validate([
                'question_type'     => 'required',
                'exam_term'         => 'required',
                'class_name'        => 'required',
                'subject_name'      => 'required',
                'hours'             => 'required|numeric|min:1|max:100',
                'total_mark'        => 'required|numeric|max:100',
                'creQuestion_no.*'    => 'required',
                'creQuestion_mark.*'    => 'required',
                'creQuestions.*'    => 'required',
                
            ], [
                "question_type.required"    => "Question type field is required",
                "exam_term.required"    => "Exam field term is required",
                "class_name.required"   => "Class field is required",
                "subject_name.required" => "Subject field is required",
                "total_mark.required"   => "Total mark field is required",
                "creQuestions.*.required"   => "Question field is required",
                "creQuestion_no.*.required"   => "Creative question field is required",
                "creQuestion_mark.*.required"   => "Question mark field is required",
            ]);
    
            $qnUpdate->update([
                'type'          => $request->question_type,
                'school_id'     => Auth::user()->id,
                'term_id'       => $request->exam_term,
                'class_id'       => $request->class_name,
                'subject_id'       => $request->subject_name,
                'hours'          => $request->hours,
                'total_marks'   => $request->total_mark,
                'cre_question'  => $request->creQuestion_no,   
                'question_mark' => $request->creQuestion_mark,
                'question'     => $request->creQuestions
            ]);
            toast('Question Update Successful', 'success');
    
            return redirect()->route('show.question');
        }
        
        return redirect()->back(); 
    }

    /**
     * Delete Question
     * 
     * @param $id
     * @return redirect
     */
    public function deleteQuestion($id)
    {
        $deleteQuestion = Question::where('school_id', Auth::user()->id)->findOrFail($id);
        $deleteQuestion->delete();
        toast("Question Delete Successful", "success");

        return redirect()->back();
    }
    public function Question_check_delete(Request $request)
    {
        $ids = $request->ids;
        Question::whereIn('id',$ids)->delete();
        Alert::success(' Selected Questions are deleted', 'Success Message');
        return response()->json(['status'=>'success']);
    }

    /**
     * Ajax Delete Question
     * 
     * @param $id
     * @return redirect
     */
    public function ajaxDeleteQuestion($id)
    {
        $deleteQuestion = Question::where('school_id', Auth::user()->id)->findOrFail($id);
        $deleteQuestion->delete();
        toast("Question Delete Successful", "success");

        return redirect()->back();
    }

    /**
     * Pdf Download
     * 
     * @param $id
     * @return 
     */
    public function pdfQuestion($id)
    {
        $question = Question::with('school', 'term', 'class', 'subject')
        ->where('school_id', auth()->user()->id)
        ->where('id', $id)->first();
        $pdf = Pdf::loadView('frontend.school.question.question_pdf', compact('question'));
        return $pdf->download('question.pdf');
        // return view('frontend.school.question.question_pdf', compact('question'));
    }
    
    public function PdeleteQuestion( $id)
    {
        Question::withTrashed()->where('id', $id)->forcedelete();
        toast("Data delete permanently", "success");
        return back();
    }
    public function restoreQuestion($id){
        Question::withTrashed()->where('id', $id)->restore();
        toast("Restore data", "success");
        return back();
    }

}
