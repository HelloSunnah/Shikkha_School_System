<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class TermController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = Term::where('school_id', Auth::id())->get();
        return view('frontend.school.student.result.term.show', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('frontend.school.student.result.term.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'term_name'      => 'required|regex:/^[a-zA-Z0-9\s]+$/u',
            'term_name_bn'   => 'required',
            'total_mark'    => 'required|numeric'
        ]);

        $class = new Term();
        $class->term_name = $request->term_name;
        $class->term_name_bn = $request->term_name_bn;
        $class->total_mark   = $request->total_mark;
        $class->active = (is_null($request->active) ? 0 : $request->active);
        $class->school_id = Auth::user()->id;
        $class->save();
        toast('Successfully Term Created', 'success');
        return redirect()->route('term.index');
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
        $row = Term::find($id);
        return view('frontend.school.student.result.term.create', compact('row'));
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
        $request->validate([
            'term_name' => 'required|regex:/^[a-zA-Z0-9\s]+$/u',
            'term_name_bn'  => 'required',
            'total_mark'    => 'required|numeric'
        ]);

        $class = Term::find($id);
        $class->term_name = $request->term_name;
        $class->term_name_bn = $request->term_name_bn;
        $class->total_mark   = $request->total_mark;
        $class->active = (is_null($request->active) ? 0 : $request->active);
        $class->school_id = Auth::user()->id;
        $class->save();
        Alert::success('Success Term Updated', 'Success Message');
        return redirect()->route('term.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Term::where('id', $id)->delete();
        Alert::error('Success Term Deleted', 'Success Message');
        return back();
    }
    public function term_check_delete(Request $request){
        $ids = $request->ids;
        Term::whereIn('id',$ids)->delete();
        Alert::success(' Selected Term are deleted', 'Success Message');
        return response()->json(['status'=>'success']);
    }
}
