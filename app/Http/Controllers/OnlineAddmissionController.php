<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;
use App\Models\InstituteClass;
use App\Models\OnlineAdmission;
use App\Models\SEOModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;

class OnlineAddmissionController extends Controller
{
    public function onlineAdmissionForm($unique_id)
    {
        $seoTitle = SEOModel::where('page_no','=','15')->first()->title;
        $seoDescription = SEOModel::where('page_no','=','15')->first()->description;
        $seoKeyword = SEOModel::where('page_no','=','15')->first()->keyword;
        $seo_array = [
            'seoTitle' => $seoTitle,
            'seoKeyword' => $seoKeyword,
            'seoDescription' => $seoDescription,
        ];

        $school=School::where('unique_id', $unique_id)->first();

        $classes = InstituteClass::where('school_id', $school->id)->get();

        return view('frontend.school.admission.admissionForm',compact('school', 'classes', 'seo_array'));
    }

    public function onlineAdmissionSingleShow($id){
        $data = OnlineAdmission::find($id);
        return view('frontend.school.admission.RequestStudentView',compact('data'));
    }


    public function onlineAdmissionFormPost(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'dob'=>'required',
            'f_name'=>'required',
            'm_name'=> 'required',
            'g_name'=>'required',
            'relation'=>'required',
            'religion'=>'required',
            'In_class'=>'required',
            'gender'    => 'required',
        ]);

        $fileName=null;
        if ($request->hasFile('image')){
            $fileName=date('Ymdhmsis').'.'.$request->file('image')->
            getclientOriginalExtension();
            $request->file('image')->storeAs('/up',$fileName);
        }

        OnlineAdmission::create([
            'name'=>$request->name,
            'dob'=>$request->dob,
            'image'=>$fileName,
            'f_name'=>$request->f_name,
            'f_occupation'=>$request->f_occupation,
            'm_name'=>$request->m_name,
            'm_occupation'=>$request->m_occupation,
            'f_phone'=>$request->f_phone,
            'm_phone'=>$request->m_phone,
            'm_nid'=>$request->m_nid,
            'f_nid'=>$request->f_nid,

            'blood_group'=>$request->blood_group,
            'gender'=>$request->gender,
            'pre_address'=>$request->pre_address,

            'par_address'=>$request->par_address,
            'g_name'=>$request->g_name,
            'g_phone'=>$request->g_phone,
            'relation'=>$request->relation,
            'religion'=>$request->religion,
            'income'=>$request->income,
            'nationality'=>$request->nationality,
            'group'=>$request->group,
            'old_school'=>$request->old_school,
            'In_class'=>$request->In_class
        ]);
        Alert::success('Form Submitted Success ', 'Success Message');

        return redirect()->route('online.Admission.submited');
    }
     
    public function onlineAdmissionsubmited(){
        return view ('frontend.school.admission.admissionsubmitpage');
    }
    
    public function pDeleteAdmission($id)
    {
        OnlineAdmission::withTrashed()->where('id', $id)->forcedelete();
        toast("Data delete permanently", "success");
        return back();  }
    public function restoreAdmission($id){
        OnlineAdmission::withTrashed()->where('id', $id)->restore();
        toast("Restore data", "success");
        return back();
    }

    public function onlineAdmissionEdit($id){

        $school = school::find(Auth::user()->id);
        $classes = InstituteClass::where('school_id', $school->id)->get();

        $edit=onlineAdmission::find($id);
        return view('frontend.school.admission.AdmissionEdit',compact('edit','school','classes'));
    }


    public function onlineAdmissionEditPost(Request $request,$id)
    {
        $request->validate([
            'name'=>'required',
            'dob'=>'required',
            'image'=>'required|file',
            'f_name'=>'required',
            'm_name'=> 'required',
            'pre_address'=>'required',
            'par_address'=>'required',
            'g_name'=>'required',
            'g_phone'=>'required',
            'relation'=>'required',
            'religion'=>'required',
            'In_class'=>'required',
            'old_school'=>'required',
        ]);
        $edit=OnlineAdmission::find($id);

        $fileName = $edit->image;
        if ($request->hasFile('image')) {
            $removeFile = public_path() . '/up' . $fileName;
            File::delete($removeFile);
            $fileName = date('Ymdhmsis') . '.' . $request->file('image')->getclientOriginalExtension();
            $request->file('image')->storeAs('/up', $fileName);
        }

        $edit->update([

            'name'=>$request->name,
            'dob'=>$request->dob,
            'image'=>$fileName,
            'f_name'=>$request->f_name,
            'f_occupation'=>$request->f_occupation,
            'm_name'=>$request->m_name,
            'm_occupation'=>$request->m_occupation,
            'f_phone'=>$request->f_phone,
            'm_phone'=>$request->m_phone,
            'm_nid'=>$request->m_nid,
            'f_nid'=>$request->f_nid,

            'blood_group'=>$request->blood_group,
            'gender'=>$request->gender,
            'pre_address'=>$request->pre_address,

            'par_address'=>$request->par_address,
            'g_name'=>$request->g_name,
            'g_phone'=>$request->g_phone,
            'relation'=>$request->relation,
            'religion'=>$request->religion,
            'income'=>$request->income,
            'nationality'=>$request->nationality,
            'group'=>$request->group,
            'old_school'=>$request->old_school,
            'In_class'=>$request->In_class
                ]);
        Alert::success('Edit  Success ', 'Success Message');

        return redirect()->route('online.Admission.Form.list');

    }

    public function onlineAdmissionDelete($id){

        OnlineAdmission::find($id)->delete();
        Alert::error('Opps Deleted ', 'error Message');

        return back();
    }

    public function onlineAdmissionFormList(){

         $seoTitle = 'Admission List';
        $seoDescription = 'Admission List' ;
        $seoKeyword = 'Admission List' ;
        $seo_array = [
            'seoTitle' => $seoTitle,
            'seoKeyword' => $seoKeyword,
            'seoDescription' => $seoDescription,
        ];
        $list=OnlineAdmission::all();

        return view('frontend.school.admission.admissionFormList',compact('list','seo_array'));
    }

    public function onlineAdmission_Check_Delete(Request $request){
        $ids = $request->ids;
        OnlineAdmission::whereIn('id',$ids)->delete();
        Alert::success(' Selected Admission request are deleted', 'Success Message');
        return response()->json(['status'=>'success']);
    }
}
