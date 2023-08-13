<?php

namespace App\Http\Controllers;

use App\Models\ClassPeriod;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class ClassPeriodController extends Controller
{

    public $school;

    public function __construct()
    {   
        $this->middleware(function($request, $next){
            $this->school = Auth::user(); //auth user details

            return $next($request);
        });
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
         $seoTitle = 'Class PeriodeList';
            $seoDescription = 'Class PeriodeList';
            $seoKeyword = 'Class PeriodeList';
            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
            ];
        $rows = DB::table('class_periods')->where('school_id', $this->school->id)->orderBy('shift', 'asc')->get();

        if($rows->count() > 0)
        {
            return view('frontend.school.period.table')->with(compact('rows','seo_array'));
        }
        else
        {
            $rows = [];
            return view('frontend.school.period.form', compact('rows','seo_array'));
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($shift = 2) // 2 for day shift
    {
        if(Auth::user()->status == 0){
            return redirect()->route('school.payment.info');
        }elseif (Auth::user()->status == 2){
            toast('Sorry Admin can Inactive Your Account Please Contact','error');
            return back();
        }
        if(Auth::user()->is_editor != 3) {
            return back();
        }else {
             $seoTitle = 'Class PeriodeCreate ';
            $seoDescription = 'Class PeriodeCreate';
            $seoKeyword = 'Class PeriodeCreate';
            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
            ];
            $rows = [];

            if(is_null($shift))
            {
                return view('frontend.school.period.form', compact('rows', 'shift','seo_array'));
            }
            else
            {
                $rows = ClassPeriod::where(['school_id' => $this->school->id, 'shift' => $shift])->get();

                if($rows->count() > 0)
                {
                    return view('frontend.school.period.form', compact('rows', 'shift','seo_array'));
                }
                else
                {
                    return view('frontend.school.period.form', compact('rows', 'shift','seo_array'));
                }

            }

            
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        for($i=0; $i < count($request->title); $i++)
        {       
            if(!is_null($request['start_time'][$i]) && !is_null($request['end_time'][$i]))
            {
                DB::table('class_periods')->updateOrInsert(
                    [
                        'school_id'  =>  $this->school->id,
                        'shift'     =>  $request['shift'],
                        'title' =>  $request['title'][$i],
                    ],
                    [
                        'from_time' =>  $request['start_time'][$i],
                        'to_time' =>  $request['end_time'][$i],
                        'created_at' =>  now(),
                        'updated_at' =>  now(),
                    ]
                );
            } 
        }

        return redirect(route('period.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try
        {
            $row = ClassPeriod::where(['school_id' => $this->school->id, 'id' => $id]);

            if($row->exists())
            {
                $row = $row->first();
                return view('frontend.school.period.form', compact('row'));
            }
            else
            {
                Alert::error('Record not found', "");
                return back();
            }
        }
        catch(Exception $e)
        {
            Alert::error('Server Error', $e->getMessage());
            return back();
        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        try
        {
            $row = ClassPeriod::where(['school_id' => $this->school->id, 'id' => $id]);

            if($row->exists())
            {
                $row = $row->update([
                    'shift'     =>  $request['shift'],
                    'title' =>  $request['title'],
                    'from_time' =>  $request['start_time'],
                    'to_time' =>  $request['end_time'],
                    'updated_at' =>  now(),
                ]);

                return redirect(route('period.index'));
            }
            else
            {
                Alert::error('Record not found', "");
                return back();
            }
        }
        catch(Exception $e)
        {
            Alert::error('Server Error', $e->getMessage());
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function periodDelete($id)
    {
        if (Auth::user()->status == 0) {
            return redirect()->route('school.payment.info');
        } elseif (Auth::user()->status == 2) {
            toast('Sorry Admin can Inactive Your Account Please Contact', 'error');
            return back();
        }
        
        $delete = ClassPeriod::where('id', $id)->delete();
        
        Alert::error('Success Subject deleted', 'Success Message');
        return redirect(route('period.index'));
    }
    

 public function periodDeletepar(Request $request)
 {
     $ids = $request->ids;
     ClassPeriod::withTrashed()->where('id', $id)->forcedelete();
     toast("Data delete permanently", "success");
     return back();
 }

 public function periodrestore($id){
    ClassPeriod::withTrashed()->where('id', $id)->restore();
     toast("Restore data", "success");
     return back();
 }
}
