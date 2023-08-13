<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class PermissionController extends Controller
{
    /**
     * Premission Page show
     * 
     * @author CodeCell <support@codecell.com.bd>
     * @contributor Sajjad <sajjad.develpr@gmail.com>
     * @created 16-07-23
     */
    public function premissionShow()
    {   
        $data['permissions']    = Permission::where('school_id', Auth::user()->id)->get();

        return view('frontend.school.role.permission_index', $data);
    }

    /**
     * Premission Create Show
     * 
     * @author CodeCell <support@codecell.com.bd>
     * @contributor Sajjad <sajjad.develpr@gmail.com>
     * @created 17-07-23
     */
    public function premissionCreate()
    {
        $data['roles']          = Role::where('school_id', Auth::user()->id)->get();
        $data['teachers']       = Teacher::where('school_id', Auth::user()->id)->get();

        return view('frontend.school.role.permission_create', $data);
    }

    /**
     * Premission Create Show
     * 
     * @author CodeCell <support@codecell.com.bd>
     * @contributor Sajjad <sajjad.develpr@gmail.com>
     * @param int $id
     * @created 17-07-23
     */
    public function premissionDelete(int $id)
    {
        Permission::findOrFail($id)->delete();

        toast("Permission Delete Successfuly", 'success');
        return redirect()->back();
    }

    /**
     * Premission Save
     * 
     * @author CodeCell <support@codecell.com.bd>
     * @contributor Sajjad <sajjad.develpr@gmail.com>
     * @param Request
     * @param $request
     * @created 16-07-23
     */
    public function storePermission(Request $request)
    {   
        $request->validate([
            'role_name'        => 'required',
            'teacher_name.*'   => 'required',
            'permission.*'     => 'required', 
        ]);
        
        try {
            $teachers = $request->teacher_name;
            foreach ($teachers as $key => $teacher) {
                Permission::create([
                    'school_id'     => Auth::user()->id,
                    'teacher_id'    => $teacher,
                    'role_id'     => $request->role_name,
                    'permission'    => $request->permission,
                ]);
            }
            toast('Permission Save Successfuly', 'success');
            return redirect()->route('permission.index');
        } catch (\Exception $e) {
            Alert::error('Server Problem', $e->getMessage());
            return back(); 
        }
    }

    /**
     * Premission Edit
     * 
     * @author CodeCell <support@codecell.com.bd>
     * @contributor Sajjad <sajjad.develpr@gmail.com>
     * @param int $id
     * @created 17-07-23
     */
    public function premissionEdit($id)
    {   
        $data['permission']     = Permission::where(['school_id' => Auth::user()->id, 'id' => $id])->first();
        $data['roles']          = Role::where('school_id', Auth::user()->id)->get();
        $data['teachers']       = Teacher::where('school_id', Auth::user()->id)->get();

        return view('frontend.school.role.permission_edit', $data);
    }

    /**
     * Premission Edit
     * 
     * @author CodeCell <support@codecell.com.bd>
     * @contributor Sajjad <sajjad.develpr@gmail.com>
     * @param Request
     * @param $request
     * @param int $id
     * @created 17-07-23
     */
    public function premissionUpdate(Request $request, $id)
    {   
        $request->validate([
            'role_name'        => 'required',
            'teacher_name'   => 'required',
            'permission.*'     => 'required', 
        ]);
        
        try {
            $teacher = $request->teacher_name;
                Permission::findOrFail($id)->update([
                    'teacher_id'    => $teacher,
                    'role_id'     => $request->role_name,
                    'permission'    => $request->permission,
                ]);

            toast('Permission Update Successfuly', 'success');
            return redirect()->route('permission.index');
        } catch (\Exception $e) {
            Alert::error('Server Problem', $e->getMessage());
            return redirect()->back(); 
        }
    }

    /**
     * Delete All
     * 
     * @author CodeCell <support@codecell.com.bd>
     * @contributor Sajjad <sajjad.develpr@gmail.com>
     * @param Request
     * @param $request
     * @created 17-07-23
     */
    public function deleteAll(Request $request)
    {
        Permission::whereIn('id', $request->permissions)->delete();

        Alert::success(' Selected Permission Are Deleted', 'Success Message');
        return response()->json(['status'=>'success']);
    }
}
