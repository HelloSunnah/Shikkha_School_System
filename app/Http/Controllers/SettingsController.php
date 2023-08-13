<?php

namespace App\Http\Controllers;

use DateTime;
use Exception;
use App\Models\Role;
use App\Models\User;
use App\Models\Price;
use App\Mail\Reminder;
use App\Models\Result;
use App\Models\School;
use App\Models\Ticket;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Employee;
use App\Models\FeesType;
use App\Models\Question;
use App\Models\Todolist;
use App\Models\BorrowBook;
use App\Models\Permission;
use App\Models\ClassPeriod;
use App\Models\LibBookType;
use App\Models\Transection;
use Illuminate\Http\Request;
use App\Models\ClassSyllabus;
use App\Models\ResultSetting;
use App\Models\TeacherSalary;
use App\Models\EmployeeSalary;
use App\Models\InstituteClass;
use App\Models\Shikkhabilling;
use Illuminate\Support\Carbon;
use App\Models\LibraryBookInfo;
use App\Models\OnlineAdmission;
use App\Models\AssignStudentFee;
use PhpParser\Node\Stmt\Return_;
use App\Models\StudentMonthlyFee;
use App\Models\Billingtransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\ResultSubjectCountableMark;

class SettingsController extends Controller
{

    public $school;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->school = Auth::user(); //auth user details

            return $next($request);
        });
    }

    /**
     * show index
     * 
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index()
    {
        //$institute_class= DB::table("institute_classes")->where('school_id'==Auth::user())->get();
        //return $institute_class;
         $seoTitle = 'School Setting';
        $seoDescription = 'School Setting' ;
        $seoKeyword = 'School Setting' ;
        $seo_array = [
            'seoTitle' => $seoTitle,
            'seoKeyword' => $seoKeyword,
            'seoDescription' => $seoDescription,
        ];
        if (!empty($institute_classes)) {
            $data = [];
            $data['sections'] = DB::table("common_classes")->whereNotNull('section')->get();
            $data['classes'] = [];
            $classes = DB::table("common_classes")->whereNull('section')->get();
            foreach ($classes as $class) {
                $data['classes'][] = [
                    'id' =>  $class->id,
                    'title' =>  $class->title,
                    'subjects'  =>  DB::table("common_subjects")->where('class', $class->id)->get(['id', 'code', 'name'])
                ];
            }
            return view('frontend.school.settings')->with(compact('data','seo_array'));
        } else {

            $data = [];
            $data['sections'] = DB::table("common_classes")->whereNotNull('section')->get();
            $data['classes'] = [];
            $classes = DB::table("common_classes")->whereNull('section')->get();
            foreach ($classes as $class) {
                $data['classes'][] = [
                    'id' =>  $class->id,
                    'title' =>  $class->title,
                    'subjects'  =>  DB::table("common_subjects")->where('class', $class->id)->get(['id', 'code', 'name'])
                ];
            }
            return view('frontend.school.settings')->with(compact('data','seo_array'));
        }
    }



    /**
     * Store Subject in Database
     * 
     * @author CodeCell <support@codecell.com.bd>
     * @contributor Shahidul 
     * @modifier Sajjad <sajjad.develpr.gmail.com>
     * @modifed 05-07-23
     * @param Request 
     * @param $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'class' => 'required|array',
            ],
            [
                'class.required'    =>  'Please select at least one item'
            ]
        );

        try {
            foreach ($request->class as $classId) {
                $class = DB::table('common_classes')->where('id', $classId)->first();

                $justName = str_replace("Class ", "", $class->title);

                if (InstituteClass::where(['school_id' => Auth::user()->id, 'class_name' => $class->title])->exists()) {
                    $class_name = $class->title;
                } else {
                    $class_name = $justName;
                }

                $newClass = InstituteClass::updateOrCreate(
                    [
                        'class_name'    =>  $class_name,
                        'school_id'     =>  $this->school->id,
                    ],
                    [
                        'class_fees'    =>  0,
                        'active'        =>  1
                    ]
                );

                $subjects = DB::table('common_subjects')
                    ->where('class', $classId)
                    ->whereIn('id', $request->subjects)
                    ->get();

                foreach ($subjects as $item) {
                    Subject::updateOrCreate(
                        [
                            'class_id'      =>  $newClass->id,
                            'subject_name'  =>  $item->name,
                            'school_id'     =>  $this->school->id,
                            'active'        =>  1,
                        ],
                        [
                            'subject_code'  =>  $item->code,
                            'group_id'      =>  $item->group
                        ]
                    );
                }
            }

            toast("Multiple Class and Subject Create Successfuly", 'success');
            return redirect(route('school.dashboard'));
        } catch (Exception $e) {
            Alert::error('Server Problem', $e->getMessage());
            return back();
        }
    }

    /**
     * show school profile 
     */
    public function school_profile()
    {
        $school = School::find(Auth::id());
        return view('frontend.school.schoolProfile.schoolProfile', compact('school'));
    }


    /**
     * update school password
     */
    public function school_Password(Request $request)
    {
        $school = School::find(Auth::id());
        $request->validate([
            'password' => ['required', 'min:5', 'confirmed']
        ]);
        $school->update([

            'password' => bcrypt($request->password)
        ]);
        Alert::success('School password is Changed', 'Success Message');
        return response()->json([
            'status' => 'success'
        ]);
    }



    /**
     * edit school profile
     * 
     * @param mixed $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function school_profileEdit($id)
    {
        $school = School::find(Auth::id());
        return view('frontend.school.schoolProfile.EditProfile', compact('school'));
    }


    /** 
     * update school profile
     */
    public function school_profile_Update(Request $request, $id)
    {
        $school = School::find($id);

        $request->validate([
            'school_logo' => 'image|mimes:jpeg,png,jpg|dimensions:width=640,height=640'
        ]);


        if ($request->hasFile('school_logo')) {
            File::delete(public_path($school->school_logo));

            $fileName = date('Ymdhmsis') . '.' . $request->file('school_logo')->extension();
            $request->file('school_logo')->move(public_path('uploads/SchoolLogo'), $fileName);
            $filePath = "uploads/SchoolLogo/" . $fileName;
            $filePath = $filePath;
        }


        $school->update([
            'school_name' => $request->school_name,
            'school_name_bn'    => $request->school_name_bn,
            'email' => $request->email,
            'address' => $request->address,
            'address_bn' => $request->address_bn,
            'phone_number' => $request->phone_number,
            'state' => $request->state,
            'city' => $request->city,
            'postcode' => $request->postcode,
            'slogan' => $request->slogan,
            'slogan_bn' => $request->slogan_bn,
            'ein_number' => $request->ein_number,
            'school_logo' => $filePath ?? $school->school_logo,
        ]);

        Alert::success("Great!", "Record updated successfully");
        return redirect()->route('school.profile');
    }



    //todo list over
    public function Recyclepage()
    {
        $school = School::find(Auth::id());
        $fee = FeesType::onlyTrashed()->where('school_id', $school->id)->orderBy('deleted_at', 'desc')->get();
        $assignFess = AssignStudentFee::onlyTrashed()->where('school_id', $school->id)->orderBy('deleted_at', 'desc')->get();
        $staffSalary = EmployeeSalary::onlyTrashed()->where('school_id', $school->id)->orderBy('deleted_at', 'desc')->get();
        $TeacherSalary = TeacherSalary::onlyTrashed()->where('school_id', $school->id)->orderBy('deleted_at', 'desc')->get();
        $expense = Transection::onlyTrashed()->where('school_id', $school->id)->where('status', 1)->orderBy('deleted_at', 'desc')->get();
        $fund = Transection::onlyTrashed()->where('school_id', $school->id)->where('status', 2)->orderBy('deleted_at', 'desc')->get();
        $studentMontyFee = StudentMonthlyFee::onlyTrashed()->where('school_id', $school->id)->orderBy('deleted_at', 'desc')->get();

        $syllabus = ClassSyllabus::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        $resultCountablemark = ResultSubjectCountableMark::onlyTrashed()->where('school_id', $school->id)->orderBy('deleted_at', 'desc')->paginate(5);
        $resultSetting = ResultSetting::onlyTrashed()->where('school_id', $school->id)->orderBy('deleted_at', 'desc')->paginate(5);
        $User = User::onlyTrashed()->where('school_id', $school->id)->orderBy('deleted_at', 'desc')->get();
        $Teacher = Teacher::onlyTrashed()->where('school_id', $school->id)->orderBy('deleted_at', 'desc')->get();
        $Result = Result::onlyTrashed()->where('school_id', $school->id)->orderBy('deleted_at', 'desc')->paginate(5);
        $admission = OnlineAdmission::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        $staff = Employee::onlyTrashed()->where('school_id', $school->id)->orderBy('deleted_at', 'desc')->get();
        $question = Question::onlyTrashed()->where('school_id', $school->id)->orderBy('deleted_at', 'desc')->get();
        $bookType = LibBookType::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        $booklist = LibraryBookInfo::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        $borrowlist = BorrowBook::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        $section = Section::onlyTrashed()->where('school_id', $school->id)->orderBy('deleted_at', 'desc')->get();
        $class = InstituteClass::onlyTrashed()->where('school_id', $school->id)->orderBy('deleted_at', 'desc')->get();
        $period = ClassPeriod::onlyTrashed()->where('school_id', $school->id)->orderBy('deleted_at', 'desc')->get();

        $subject = Subject::onlyTrashed()->where('school_id', $school->id)->orderBy('deleted_at', 'desc')->get();
        return view('frontend.school.schoolProfile.Recyclepage', compact(
            'User',
            'resultCountablemark',
            'fee',
            'assignFess',
            'staffSalary',
            'TeacherSalary',
            'expense',
            'studentMontyFee',
            'syllabus',
            'resultSetting',
            'section',
            'Teacher',
            'Result',
            'fund',
            'admission',
            'period',
            'subject',
            'staff',
            'class',
            'borrowlist',
            'booklist',
            'bookType',
            'question'
        ));
    }

    public function userRoleShow()
    {
        $roles = Role::where('school_id', Auth::user()->id)->get();
        return view('frontend.school.role.showRole', compact('roles'));
    }
    public function  userRolecreate()
    {
        return view('frontend.school.role.roleCreate');
    }

    public function  userRolecreatePost(Request $request)
    {

        $role = Role::create([
            'school_id' => Auth::user()->id,
            'role' => $request->input('role'),
        ]);

        $permissions = $request->input('permissions', []);

        foreach ($permissions as $menu => $actions) {
            Permission::create([
                'created_by' => Auth::user()->id,
                'role_id' => $role->id,
                'permission' => $menu
            ]);
        }
        Alert::success('Role Created Succesfully', 'Success Message');

        return redirect()->route('user.role.show');
    }
    public function userRoleeditPost(Request $request)
    {


        $role = Role::updateOrCreate([
            'school_id' => Auth::user()->id,
            'role' => $request->input('role'),
        ]);

        $permissions = $request->input('permissions', []);

        foreach ($permissions as $menu => $actions) {
            Permission::updateOrCreate([
                'created_by' => Auth::user()->id,
                'role_id' => $role->id,
                'permission' => $menu
            ]);
        }
        Alert::success('Role Edited Succesfully', 'Success Message');

        return redirect()->route('user.role.show');
    }
    public function  userRoleedit(Request $request, $id)
    {
        $roleEdit = Role::find($id);
        $permissions = Permission::where('role_id', $id)->get();

        return view('frontend.school.role.roleCreate', compact('roleEdit', 'permissions'));
    }

    public function   Userroledelete($id)
    {
        $permissions = Permission::where('role_id', $id)->delete();
        $role = Role::find($id);
        $role->delete();
        Alert::success('Successfully role Deleted', 'Success Message');
        return back();
    }
    public function assignRole()
    {
        $role = Role::where('school_id', auth::user()->id)->get();
        $teacher = Teacher::where('school_id', auth::user()->id)->paginate(5);
        return view('frontend.school.role.assignRole', compact('teacher', 'role'));
    }

    public function assignRolepost(Request $request, $id)
    {
        $assign = Teacher::find($id);
        $assign->update(
            [
                'role' => $request->role,
            ]

        );
        Alert::success(' role assigned', 'Success Message');
        return back();
    }

    public function school_billing()
    {
        $school = School::find(Auth::id());
        $billing = Shikkhabilling::where('school_id', $school->id)->orderBy('created_at', 'desc')->get();
        return view('frontend.school.schoolProfile.schoolbilling', compact('school', 'billing'));
    }

    public function billing_transaction()
    {
        $school = School::find(Auth::id());
        return view('frontend.school.schoolProfile.schoolbillingtransaction', compact('school'));
    }
    public function billing_transaction_Store(Request $request)
    {
        $request->validate([
            'sending_number' => 'required',
            'amount' => 'required',
        ]);
        try {
            Billingtransaction::create([
                'school_id' => $request->school_id,
                'payment_method' => $request->payment_method,
                'transaction_id' => $request->transaction_id,
                'sending_number' => $request->sending_number,
                'amount' => $request->amount,
            ]);
            Alert::success('Your Payment successfully done');
            return redirect()->back();
        } catch (Exception $e) {
            Alert::error('Error');
            return redirect()->back();
        }
    }
}
