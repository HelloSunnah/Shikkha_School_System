<?php

namespace App\Http\Controllers\School;

use App\Models\Term;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Models\ClassSyllabus;
use App\Models\InstituteClass;
use App\Models\School;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Controllers\SchoolController;
use RealRashid\SweetAlert\Facades\Alert;

class SyllabusController extends Controller
{
    public function SyllabusCreate()
    {
        $seoTitle = 'Syllabus Create';
        $seoDescription = 'Syllabus Create';
        $seoKeyword = 'Syllabus Create';
        $seo_array = [
            'seoTitle' => $seoTitle,
            'seoKeyword' => $seoKeyword,
            'seoDescription' => $seoDescription,
        ];
        $term = Term::where('school_id', auth()->id())->orderby('id', 'desc')->get();
        $class = InstituteClass::where('school_id', auth()->id())->get();
        $subjects = Subject::all();
        return view('frontend.school.syllabus.create', compact('class', 'subjects', 'term','seo_array'));
    }
    public function SyllabusCreatePost(Request $request)
    {
        $request->validate([
            // validate syllabus
            'term_id' => 'required',
            'class_id' => 'required',
            'subject_id' => 'required',
            'syllabus' => 'required'

        ]);
        $data= ClassSyllabus::where('class_id',$request->class_id)->where('term_id',$request->term_id)->where('subject_id',$request->subject_id)->first();
   if($data!== null){
        $data->update([
            // create syllabus
            'term_id' => $request->term_id,
            'class_id' => $request->class_id,
            'subject_id' => $request->subject_id,
            'syllabus' => $request->syllabus

        ]);
    }
   else{

   $data= ClassSyllabus::create([
        // create syllabus
        'term_id' => $request->term_id,
        'class_id' => $request->class_id,
        'subject_id' => $request->subject_id,
        'syllabus' => $request->syllabus

    ]);

   }
   Alert::success('Syllabus Created Succesfully', 'Success Message');

        return back();
    }
    public function SyllabusDataShow()
    {
        $seoTitle = 'Syllabus DataShow';
        $seoDescription = 'Syllabus DataShow';
        $seoKeyword = 'Syllabus DataShow';
        $seo_array = [
            'seoTitle' => $seoTitle,
            'seoKeyword' => $seoKeyword,
            'seoDescription' => $seoDescription,
        ];
        $syllabus = ClassSyllabus::with('classRelation', 'subjectRelation', 'termRelation')->get();
        return view('frontend.school.syllabus.show', compact('syllabus','seo_array'));
    }



    public function  pdeletesyllabus($id){
        ClassSyllabus::withTrashed()->where('id', $id)->forcedelete();
        toast("Data delete permanently", "success");
        return back();

    }
    public function  restoresyllabus($id){
        ClassSyllabus::withTrashed()->where('id', $id)->restore();
        toast("Restore data", "success");
        return back();

    }

         

    // public function SyllabusShow()
    // {
    //     // syllabus page show
    //     // $syllabus= Syllabus::->first();
    //     // dd($syllabus);
    //     $syllabus = ClassSyllabus::with('classRelation', 'subjectRelation','termRelation')->get();

    //     return view('frontend.school.syllabus.show', compact('syllabus'));
    // }


    public function SyllabusFormShow()
    {
         $seoTitle = 'Syllabus Searchpage';
        $seoDescription = 'Syllabus Searchpage';
        $seoKeyword = 'Syllabus Searchpage';
        $seo_array = [
            'seoTitle' => $seoTitle,
            'seoKeyword' => $seoKeyword,
            'seoDescription' => $seoDescription,
        ];
        $class = InstituteClass::where('school_id', auth()->id())->get();
        
        return view('frontend.school.syllabus.selectform', compact('class','seo_array'));
    }



    public function SyllabusFormPost(Request $request)
    {
       
        $seoTitle = 'Syllabus View';
        $seoDescription = 'Syllabus View';
        $seoKeyword = 'Syllabus View';
        $seo_array = [
            'seoTitle' => $seoTitle,
            'seoKeyword' => $seoKeyword,
            'seoDescription' => $seoDescription,
        ];
         $syllabus = ClassSyllabus::with('termRelation')->where('class_id', $request->select_class)->get()->groupBy('term_id');
         $school = School::find(Auth::user()->id);
         
        if ($syllabus->count()>0){
            return view('frontend.school.syllabus.show')->with(compact('syllabus','school','seo_array'));
        }
        else {
            Alert::error('Sorry', "No record found");
            return back();
        }

    }


    public function syllabusEdit($id)
    {
        // view syllabus edit
        $editSyllabus = ClassSyllabus::find($id);
        $commonClass = InstituteClass::all();
        $commonSubject = Subject::all();
        return view('frontend.school.syllabus.edit', compact('commonClass', 'commonSubject', 'editSyllabus'));
    }
    public function syllabusEditPost(Request $request, $id)
    {
        // validation for edit
        $editSubmit = ClassSyllabus::find($id);
        $request->validate([
            'class_id' => 'required',
            'subject_id' => 'required',
            'term_id'=>'required',
            'syllabus' => 'required'

        ]);
        // for syllabus update
        $editSubmit->update([
            'class_id' => $request->common_class_id,
            'subject_id' => $request->common_subject_id,
            'term_id'=>$request->term_id,
            'syllabus' => $request->syllabus


        ]);
        return redirect()->route('syllabus.table.show');
    }




    public function syllabusDelete($id)
    {
        // syllabus delete
        ClassSyllabus::find($id)->delete();
        toast('opps deleted', 'danger');

        return back();
    }
}
