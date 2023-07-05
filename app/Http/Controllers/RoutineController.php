<?php

namespace App\Http\Controllers;

use App\Models\ClassPeriod;
use Exception;
use App\Models\Routine;
use Illuminate\Http\Request;
use App\Models\InstituteClass;
use App\Models\Teacher;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class RoutineController extends Controller
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
        $classes = DB::table('institute_classes')->where('school_id',$this->school->id)->get();
        $sections = DB::table('sections')->where('school_id',$this->school->id)->get();


        //return $abc =  $this->school->id;

        return view('frontend.school.routine.index')->with(compact('classes', 'sections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            for($i=0; $i < count($request->period); $i++)
            {
                $teacherExist = Routine::where(['shift' => $request['shift'], 'day'   => $request['day'], 'period_id'   => $request['period'][$i], 'teacher_id' =>  $request['teacher'][$i]])->exists();
                if($request->edit != "update_routine") {
                    if($teacherExist) {
                        toast('Teacher have already class. Select another teacher', 'error');
                        return back();
                    }
                }
                    Routine::updateOrCreate([
                        'school_id'  =>  $this->school->id,
                        'class_id'  =>  $request['class'],
                        'section_id'  =>  $request['section'],
                        'period_id'   =>  $request['period'][$i],
                        'shift'   =>  $request['shift'],
                        'day'  =>  $request['day'],
                    ], [
                        'note'  =>  $request['note'][$i],
                        'subject_id'  =>  $request['subject'][$i],
                        'teacher_id'  =>  $request['teacher'][$i],
                    ]);
            }

            toast('Routine Create Successfully', 'success');
        }
        catch(Exception $e)
        {
            toast($e->getMessage(), 'error');
        }

        return redirect(url("/school/routine/show?shift={$request['shift']}&class={$request['class']}&section={$request['section']}"));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $rows = Routine::where([
            'school_id' => $this->school->id,
            'class_id'  => $request->class,
            'section_id'   => $request->section,
            'shift'   => $request->shift,
        ])->get()->groupBy('day');

        $data = $request->only('class', 'section', 'shift');
        $data['dataFor'] = "create";
        $data['subjects'] = DB::table('subjects')->where('class_id', $data['class'])->get();
        $data['teachers'] = DB::table('teachers')->where('school_id', $this->school->id)->where('active',1)->get();
        $data['periods'] = DB::table('class_periods')->where('school_id', $this->school->id)->where('shift', $request->shift)->get();

        if($data['periods']->count() > 0)
        {
            return view('frontend.school.routine.table')->with(compact('rows', 'data'));
        }
        else
        {
            Alert::info("Message", "Please create class period first");
            return redirect(route('period.create', $request->shift));
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }


    public function editRoutine(Request $request)
    {
        $data = $request->only('class', 'section', 'shift', 'period', 'day');

        $rows = Routine::where([
            'school_id' => $this->school->id,
            'class_id'  => $data['class'],
            'section_id'   => $data['section'],
            'shift'   => $data['shift'],
        ])->get()->groupBy('day');


        $data['editRoutine'] = Routine::where([
                                    'school_id' => $this->school->id,
                                    'class_id'  => $data['class'],
                                    'section_id'   => $data['section'],
                                    'shift'   => $data['shift'],
                                    'day'   => $data['day'],
                                ])
                                ->get();

        $data['dataFor'] = "edit";

        $data['subjects'] = DB::table('subjects')->where('class_id', $data['class'])->get();
        $data['teachers'] = DB::table('teachers')->where('school_id', $this->school->id)->get();
        $data['periods'] = DB::table('class_periods')->where('school_id', $this->school->id)->where('shift', $data['shift'])->get();


        if($data['periods']->count() > 0)
        {
            return view('frontend.school.routine.table')->with(compact('rows', 'data'));
        }
        else
        {
            Alert::info("Message", "Please create class period first");
            return redirect(route('period.create', $data['shift']));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function school_Routine_view(){

        $periods = ClassPeriod::where(['school_id' => $this->school->id, 'shift' => 1])->get();
        $rows = Routine::with('period', 'class', 'subject', 'section')->where(['school_id' => $this->school->id, 'shift' => 1])->orderBy('day', 'asc')->get();
        $rowsec = Routine::where(['school_id' => $this->school->id, 'shift' => 1])->orderBy('day', 'asc')->get()->groupBy('section_id');
        // dd($rows->toArray());
        // dd($rowsec);
        $prepare = [];
        foreach ($rows as $key => $value) {
            if(!is_null($value->class)  && !is_null($value->section) && !is_null($value->subject))
            {
                $prepare[$value->day][$value->class->class_name][$value->section->section_name][$value->subject->subject_name] = $value->period;
            }
        }
        // dd($prepare);
        $class = Routine::where(['school_id' => $this->school->id , 'shift' => 1])->get()->groupBy('class_id');

        $data['institute_classes'] = DB::table('institute_classes')->where('school_id', $this->school->id)->get();
        $data['section'] = DB::table('sections')->where('school_id', $this->school->id)->get();
        $data['periods'] = DB::table('class_periods')->where('school_id', $this->school->id)->get();
        $data['subjects'] = DB::table('subjects')->get();

        $data['teachers'] = DB::table('teachers')->where('school_id', $this->school->id)->where('active',1)->get();

        // $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        // $classes = InstituteClass::with('section:id,class_id,section_name')->where('school_id', Auth::id())->get(['id','class_name']);

        // $resp = [];

        // foreach($days as $day)
        // {
        //     $routine = [];
        //     // return $classes;
        //     foreach($classes as $class)
        //     {
        //         if(isset($class->id) && isset($class->section->id))
        //         {
        //             return $routine[] = Routine::where('day', $day)->get();
        //         }
        //     }


        //     $resp[] = [
        //         "day"   =>  $day,
        //         "classes"   =>  $classes,
        //         "routine" => $routine
        //     ];
        // }

        //return $resp;

        return view('frontend.school.routine.School_Routine',compact('rows','data','class', 'periods', 'prepare'));
    }

     /**
     * Get Teacher by ajax request
     *
     * @param Request
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTeacher(Request $request)
    {
        $period = ClassPeriod::select('id')->where('shift', $request->shift)->where('school_id', Auth::user()->id)->pluck('id')->toArray();
        $teachers = [];
        foreach ($period as $key => $value) {
            $teacher_id = Routine::where(['shift' => $request['shift'], 'day'   => $request['day']])->where('period_id', $value)->first();
            if (isset($teacher_id->teacher_id)) {
                $teachers[] = Teacher::where('school_id', Auth::user()->id)->whereNotIn('id', [$teacher_id->teacher_id])->get();
            } else {
                $teachers[] = Teacher::where('school_id', Auth::user()->id)->get();
            }
        }
        return response()->json(['teacher' => $teachers, 'period' => $period]);

        // $period = ClassPeriod::select('id')->where('shift', $request->shift)->where('school_id', Auth::user()->id)->pluck('id')->toArray();
        // $teacher = Routine::where(['shift' => $request['shift'], 'day'   => $request['day'], 'period_id' => $request['period']])->first();
        // $teachers = Teacher::where('school_id', Auth::user()->id)->whereNotIn('id', [$teacher->teacher_id])->get();
        // return response()->json(['teacher' => $teachers, 'period' => $period]);

    }

}
