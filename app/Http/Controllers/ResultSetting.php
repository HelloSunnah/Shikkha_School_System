<?php

namespace App\Http\Controllers;

use App\Models\InstituteClass;
use App\Models\MarkType;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use App\Models\Result;
use App\Models\Subject;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\Auth;
use App\Models\ResultSubjectCountableMark;
use App\Models\ResultSetting as ModelsResultSetting;
use App\Models\Section;

class ResultSetting extends Controller
{
    /**
     * Show Result Create Setting Page (Sajjad Devel)
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function createSetting()
    {
        $create = "createResultSetting";
        return view("frontend.school.student.result.result_setting", compact('create'));
    }

    /**
     * Author by Sajjad
     * Show All Result Setting with ajax
     * 
     * @return \Illuminate\Contracts\View\View
     */
    public function showResultSetting()
    {   dd('hi');
        $leatestResultSettings = ModelsResultSetting::where('school_id', Auth::user()->id)->latest()->first();
        dd($leatestResultSettings);
        return response()->json($leatestResultSettings);
        // return view('frontend.school.student.result.createShow', compact('leatestResultSettings'));
    }

    /**
     * Save Setting (Sajjad Devel)
     *
     * @param Request
     * @param $request
     * @return \Illuminate\Routing\Redirector
     */
    public function saveSetting(Request $request)
    {
        $request->validate([
            "title"          => "required|regex:/^[a-zA-Z0-9\s]+$/u",
            "pass_mark"      => "required|numeric",
            "subject_mark"   => "required|numeric"
        ]);

        try {
            $id =  ModelsResultSetting::create([
                "title"                 => $request->title,
                "pass_mark"             => $request->pass_mark,
                "all_subject_mark"      => $request->subject_mark,
                "school_id"             => Auth::user()->id
            ]);

            toast("Your Result Setting Successful", "success");
            return redirect()->route("show.mark.type", ['id' => $id->id]);
        } catch (\Exception $e) {
            toast("$e", "error");
        }
    }

    /**
     * Update Result Setting
     *
     * @param Request
     * @param $request
     * @return
     */
    public function updateSetting(Request $request)
    {   
        $resultSettingId = $request->resultSettingId;

        $request->validate([
            "title"          => "required|regex:/^[a-zA-Z0-9\s]+$/u",
            "pass_mark"      => "required|numeric",
            "subject_mark"   => "required|numeric"
        ]);

        ModelsResultSetting::where("school_id", Auth::user()->id)->where('id', $request->resultSettingId)->update([
            "title"                 => $request->title,
            "pass_mark"             => $request->pass_mark,
            "all_subject_mark"      => $request->subject_mark,
            "school_id"             => Auth::user()->id
        ]);

        toast("Update Result Setting Successfuly", 'success');
        return redirect()->route("show.mark.type", ['id' => $resultSettingId]);
    }

    /**
     * Duplicate Result Setting
     *
     * @param $id
     * @return \Illuminate\Routing\Redirector
     */
    public function duplicateResultSetting($id)
    {
        $resultSetting = ModelsResultSetting::findOrFail($id);
        $resultSubjectCountableMarks = ResultSubjectCountableMark::where('school_id', Auth::user()->id)->where('result_setting_id', $id)->get();
        $title = $resultSetting->title;
        $number = filter_var($title, FILTER_SANITIZE_NUMBER_INT);
        $findTitle = str_replace($number, '', $title);
        $maxNum = [];

        $searchTitles = ModelsResultSetting::where('school_id', Auth::user()->id)->where('title', 'like', '%' . $findTitle . '%')->get();
        foreach ($searchTitles as $searchTitle) {
            $number = filter_var($searchTitle->title, FILTER_SANITIZE_NUMBER_INT);
            $maxNum[] = $number;
        }

        $maxTermNum = max($maxNum);
        if ($maxTermNum == null) {
            $newTitle = $title . ' ' . '1';
        } else {
            $newTitle = $findTitle . ' ' . ++$maxTermNum;
        }

        try {
            $id =  ModelsResultSetting::create([
                "title"                 => $newTitle,
                "pass_mark"             => $resultSetting->pass_mark,
                "all_subject_mark"      => $resultSetting->all_subject_mark,
                "school_id"             => Auth::user()->id
            ]);

            foreach ($resultSubjectCountableMarks as $resultSubjectCountableMark) {
                ResultSubjectCountableMark::create([
                    "result_setting_id"         => $id->id,
                    "institute_class_id"        => $resultSubjectCountableMark->institute_class_id,
                    "subject_id"                => $resultSubjectCountableMark->subject_id,
                    "school_id"                 => Auth::user()->id,
                    "mark"                      => $resultSubjectCountableMark->mark,
                ]);
            };

            toast("Result Setting Duplicate Successfully", "success");

            return redirect()->route('result.school.admin.create.show.all');
        } catch (Exception $e) {
            toast($e->getMessage(), 'error');

            return back();
        }
    }

    /**
     * Delete Result Setting
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteSetting($id)
    {
        $countResult = ResultSubjectCountableMark::where('result_setting_id', $id)->delete();

        $result = Result::where('term_id', $id)->delete();

        ModelsResultSetting::findOrFail($id)->delete();
        ResultSubjectCountableMark::where("result_setting_id", $id)->where('school_id', Auth::user()->id)->delete();
        Result::where('term_id', $id)->where('school_id', Auth::user()->id)->delete();
        toast("Result Setting Delete Successfuly", "success");
        return back();
    }

    /**
     * Edit Result System
     *
     * @param $id
     * @return \Illuminate\Contracts\View\View
     */
    public function editResultSetting($id)
    {   
        return redirect()->route("result.up.first.step", ['id' => $id]);
    }

    /**
     * Just Edit Result Setting
     *
     * @param $id
     * @return \Illuminate\Contracts\View\View
     */
    public function justEditResultSetting($id)
    {
        $editResultSetting = ModelsResultSetting::findOrFail($id);
        $create = "editSetting";
        return view("frontend.school.student.result.result_setting", compact('editResultSetting', 'create'));
    }

    /**
     * Store Subject Mark
     *
     * @param Request
     * @param $request
     * @return \Illuminate\Http\Response
     */
    public function storeSubjectMark(Request $request)
    {   
        $request->validate([
            "resultSettingId"   => 'required',
            "subjectMark.*"     =>  'required|min:1'
        ]);

        foreach ($request->subjectMark as $class_id => $marks) {
            foreach ($marks as $subject_id => $mark) {
                ResultSubjectCountableMark::updateOrCreate(
                    [
                        "result_setting_id"         => $request->resultSettingId,
                        "institute_class_id"        => $class_id,
                        "subject_id"                => $subject_id,
                        "school_id"                 => Auth::user()->id,
                    ],
                    [
                        "mark"                      => $mark,
                    ]
                );
            }
        }

        return response()->json(['status' => "success"]);
    }

    /**
     * Get Section With Ajax
     * 
     * @param $class_id
     * @return \Illuminate\Http\Response
     */
    public function getSectionWithAjax($class_id)
    {   
        $sections = Section::where('school_id', Auth::user()->id)
                            ->where('class_id', $class_id)
                            ->get();

        return response()->json($sections);
    }
    
    /**
     * Result pdf download first step
     * 
     * @param Request 
     * @param $request
     * @return \Illuminate\Contracts\View\View
     */
    public function resultPdf(Request $request)
    {   
        $class = InstituteClass::where('school_id', Auth::user()->id)->get();
        $terms = ModelsResultSetting::where('school_id', Auth::user()->id)->orderBy('id','desc')->get();
        $users = User::where('school_id', Auth::user()->id)->get();
        return view('frontend.school.result.result_pdf', compact('class', 'terms', 'users'));
    }

    /**
     * View All Result Class Wise
     * 
     * @param Request 
     * @param $request
     * @return \Illuminate\Contracts\View\View
     */
    public function resultPdfDownload(Request $request)
    {      
        $request->validate([
            "student_wise_term_id" => 'required',
            "student_wise_class_id" => 'required',
            "section_name.*"    => 'required'
        ]);

        if(!isset($request->section_name)){
            toast("At least select one section", 'error');
            return back();
        }
        
        try {
            $markType = MarkType::where('institute_classes_id', $request->student_wise_class_id)
                    ->where('school_id', Auth::user()->id)->orderBy('id', 'Asc')->get();

            $markTypeCount = MarkType::where('institute_classes_id', $request->student_wise_class_id)
                            ->where('school_id', Auth::user()->id)->count();
                        
            $term = ModelsResultSetting::where('school_id', Auth::user()->id)
                    ->where('id', $request->student_wise_term_id)->first();
                
            $results = Result::where('school_id', Auth::user()->id)
                        ->where('institute_class_id', $request->student_wise_class_id)
                        ->whereIn('section_id', $request->section_name)
                        ->where('term_id', $request->student_wise_term_id)
                        ->orderBy("student_roll_number", "ASC")
                        ->get()
                        ->groupBy('student_id');
                        
            $markTypeCount = $markTypeCount+1;
          
          } catch (\Exception $e) {
                return $e->getMessage();
          }
        
        
       return view('frontend.school.result.result_pdf_download', compact('results' , 'term', 'markType', 'markTypeCount'));
    }

    public  function resultrestore($id)
    {
        Result::withTrashed()->where('id', $id)->restore();
        toast("Restore data", "success");
        return back();
    }
    public  function pdeleteresult($id)
    {
        Result::withTrashed()->where('id', $id)->forcedelete();
        toast("Data delete permanently", "success"  );
        return back();
    }
    public  function resultSettingrestore($id)
    {
        ModelsResultSetting::withTrashed()->where('id', $id)->restore();
        toast("Restore data", "success");
        return back();
    }
    public  function pdeleteresultSetting($id)
    {
        ModelsResultSetting::withTrashed()->where('id', $id)->forcedelete();
        toast("Data delete permanently", "success");
        return back();
    }
    public  function resultCountablemarkrestore($id)
    {
        ResultSubjectCountableMark::withTrashed()->where('id', $id)->restore();
        toast("Restore data", "success");
        return back();
    }
    public  function pdeleteresultCountablemark($id)
    {
        ResultSubjectCountableMark::withTrashed()->where('id', $id)->forcedelete();
        toast("Data delete permanently", "success");
        return back();
    }
}
