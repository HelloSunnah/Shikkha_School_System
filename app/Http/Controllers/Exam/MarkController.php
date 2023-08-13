<?php

namespace App\Http\Controllers\Exam;

use App\Http\Controllers\Controller;
use App\Models\InstituteClass;
use App\Models\MarkType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;

class MarkController extends Controller
{
    /**
     * Show Mark Type Page
     *
     * @return \Illuminate\Contracts\View
     */
    public function index($id)
    {   
        $seoTitle = 'Result Setting';
        $seoDescription = 'Result Setting' ;
        $seoKeyword = 'Result Setting';
        $seo_array = [
            'seoTitle' => $seoTitle,
            'seoKeyword' => $seoKeyword,
            'seoDescription' => $seoDescription,
        ];
        $resultSettingId = $id;
        $classes = InstituteClass::where('school_id', Auth::user()->id)->get();

        return view('frontend.school.mark_type.mark_type', compact('classes', 'resultSettingId','seo_array'));
    }

    /**
     * Store Mark Types in Database
     *
     * @param Request
     * @param $request
     * @return back
     */
    public function store(Request $request)
    {   
        try {
            DB::beginTransaction();
            DB::table('mark_types')->where('school_id', Auth::id())->delete();

            if(isset($request->subjects))
            {
                foreach ($request->subjects as $key => $value) {
                    foreach ($value as $subject) {
                        MarkType::create([
                            'institute_classes_id'      => $key,
                            'school_id'                 => Auth::user()->id,
                            'mark_type'                 => $subject,
                        ]);
                    }
                }
                toast("Mark Type Add Successfully", 'success');

                return redirect()->route("result.mark.set", ['id' => $request->resultSettingId]);
            }
            else
            {
                toast("Please select an item", 'error');
                return back();
            }
        DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return $e;
        }
    }
}
