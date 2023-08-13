<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\TryCatch;
use RealRashid\SweetAlert\Facades\Alert;

/**
 * Role Show, Create, Update, Delete
 * 
 * @author CodeCell <support@codecell.com.bd>
 * @contributor Sajjad <sajjad.develpr@gmail.com>
 * @created 16/07/23
 */
class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['roles'] = Role::where(['school_id' => Auth::user()->id])->get();

        return view('frontend.school.role.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
            'role_name' => 'required|max:100',
        ],
        ['role_name.required' => 'Role Name Required']);

        $roleNameExist = Role::where('school_id', Auth::user()->id)->where('role_name', $request->role_name)->exists();
        if($roleNameExist) {
            toast('Role Name Exist', 'error');
            return redirect()->back();
        }

        Role::create([
            'role_name' => $request->role_name,
            'type'      => str_replace(' ', '_', $request->role_name),
            'school_id' => Auth::user()->id,
        ]);

        toast('Role Create Successfuly', 'success');
        return redirect()->route('roles.index');
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
            'role_name' => 'required|max:100',
        ],
        [   'role_name.required' => 'Role Name Required']);
        $thisRole = Role::findOrFail($id);
        $roleNameExist = Role::where('school_id', Auth::user()->id)->where('role_name', '!=', $thisRole->role_name)->where('role_name', $request->role_name)->exists();
        if($roleNameExist) {
            toast('Role Name Exist', 'error');
            return redirect()->route('roles.index');
        }

        Role::findOrFail($id)->update([
            'role_name' => $request->role_name,
            'type'      => str_replace(' ', '_', $request->role_name),
        ]);

        toast('Role Updated Successfuly', 'success');
        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Role::findOrFail($id)->delete();

        toast('Role Delete Successfuly', 'success');
        return redirect()->route('roles.index');
    }

}
