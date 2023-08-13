<?php
namespace App\Http\Controllers\School;
use App\Http\Controllers\Controller;
use App\Models\AssignStudentFee;
use App\Models\Bank;
use App\Models\Employee;
use App\Models\FeesType;
use App\Models\InstituteClass;
use App\Models\StudentFee;
use App\Models\TeacherSalary;
use App\Models\StudentMonthlyFee;
use App\Models\Teacher;
use App\Models\EmployeeSalary;
use App\Models\School;
use App\Models\Section;
use App\Models\User;
use App\Models\AssignTeacher;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Transection;
use App\Traits\HttpResponse;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class FinanceController extends Controller
{
    use HttpResponse;
    /**
     * go to finance dashboard
     */
    public function assignFessrestore($id)
    {
        AssignStudentFee::withTrashed()->where('id', $id)->restore();
        toast("Restore data", "success");
        return back();
    }
    public function feerestore($id)
    {
        FeesType::withTrashed()->where('id', $id)->restore();
        toast("Restore data", "success");
        return back();
    }
    public function staffSalaryrestore($id)
    {
        EmployeeSalary::withTrashed()->where('id', $id)->restore();
        toast("Restore data", "success");
        return back();
    }
    public function TeacherSalaryrestore($id)
    {
        TeacherSalary::withTrashed()->where('id', $id)->restore();
        toast("Restore data", "success");
        return back();
    }
    public function expenserestore($id)
    {
        Transection::withTrashed()->where('id', $id)->restore();
        toast("Restore data", "success");
        return back();
    }
    public function fundrestore($id)
    {
        Transection::withTrashed()->where('id', $id)->restore();
        toast("Restore data", "success");
        return back();
    }
    public function studentMontyFeerestore($id)
    {
        StudentMonthlyFee::withTrashed()->where('id', $id)->restore();
        toast("Restore data", "success");
        return back();
    }
    public function assignFesspdelete($id)
    {
        AssignStudentFee::withTrashed()->where('id', $id)->forcedelete();
        toast("Data delete permanently", "success");
        return back();
    }
    public function feepdelete($id)
    {
        FeesType::withTrashed()->where('id', $id)->forcedelete();
        toast("Data delete permanently", "success");
        return back();
    }
    public function  staffSalarypdelete($id)
    {
        EmployeeSalary::withTrashed()->where('id', $id)->forcedelete();
        toast("Data delete permanently", "success");
        return back();
    }
    public function TeacherSalarypdelete($id)
    {
        TeacherSalary::withTrashed()->where('id', $id)->forcedelete();
        toast("Data delete permanently", "success");
        return back();
    }
    public function  expensepdelete($id)
    {
        Transection::withTrashed()->where('id', $id)->forcedelete();
        toast("Data delete permanently", "success");
        return back();
    }
    public function fundpdelete($id)
    {
        Transection::withTrashed()->where('id', $id)->forcedelete();
        toast("Data delete permanently", "success");
        return back();
    }
    public  function studentMontyFeepdelete($id)
    {
        StudentMonthlyFee::withTrashed()->where('id', $id)->forcedelete();
        toast("Data delete permanently", "success");
        return back();
    }
    public function dashboard()
    {   
        $seoTitle = 'Finance Dashboard';
        $seoDescription = 'Finance Dashboard';
        $seoKeyword = 'Finance Dashboard';
        $seo_array = [
            'seoTitle' => $seoTitle,
            'seoKeyword' => $seoKeyword,
            'seoDescription' => $seoDescription,
        ];
        $teacherSalary = Teacher::where('school_id', Auth::user()->id)->sum("salary");
        $currentMonth = Carbon::now()->month;
        $teacherPaidSalary = TeacherSalary::where('school_id', Auth::user()->id)->whereMonth('updated_at', '=', $currentMonth)->sum("amount");
        // $teacherSalary = TeacherSalary::where('school_id', Auth::user()->id)->sum("amount");
        $StaffSalary = Employee::where('school_id', Auth::user()->id)->sum("salary");
        $StaffPaidSalary = EmployeeSalary::where('school_id', Auth::user()->id)->whereMonth('updated_at', '=', $currentMonth)->sum("amount");
        $StaffAllSalary = EmployeeSalary::where('school_id', Auth::user()->id)->sum("amount");
        $Expense = Transection::where('school_id', Auth::user()->id)->where('type', '1')->sum("amount") + $teacherPaidSalary + $StaffPaidSalary;
        $ExpenseMonth = Transection::where('school_id', Auth::user()->id)->where('type', '1')->whereMonth('updated_at', '=', $currentMonth)->sum("amount");
        $TotalFees = StudentMonthlyFee::where('school_id', Auth::user()->id)->sum("amount");
        $sumFund = Transection::where('school_id', Auth::user()->id)->where('type', '2')->sum("amount");
        $colected = StudentMonthlyFee::where('school_id', Auth::user()->id)->where('status', '2')->sum("amount");
        $due = StudentMonthlyFee::where('school_id', Auth::user()->id)->where('status', '0')->sum("amount");
        $accesories = Transection::where('school_id', Auth::user()->id)->where('type', '3')->sum("amount");
        $ExpenseThisMonth = $ExpenseMonth + $StaffPaidSalary + $teacherPaidSalary;
        $totalSchoolFund = $sumFund + $colected + $accesories;
        $profit = $totalSchoolFund - $Expense;
        // $profit = abs($profit);
        return view("frontend.school.finance.dashboard.dashboard", compact('teacherSalary', 'teacherPaidSalary', 'StaffSalary', 'StaffPaidSalary', 'Expense', 'ExpenseThisMonth', 'TotalFees', 'totalSchoolFund', 'sumFund', 'colected', 'due', 'accesories', 'profit','seo_array'));
    }
    /**
     * view fees blade
     */
    public function index(Request $request)
    {
        try
        {
            $schoolId = Auth::id();
            $data['classes'] = InstituteClass::where('school_id', $schoolId)->get();
            $data['fee_types'] = $typeOfFees = FeesType::where('school_id', $schoolId)->get();
            $classes = InstituteClass::where('school_id', $schoolId)->get();
            if($typeOfFees->count() == 0)
            {
                $newTypeOfFees = FeesType::create(['school_id'=> $schoolId,'title'=>'Monthly Fee']);
                foreach($classes as $class)
                {
                    StudentFee::create(['class_id'=>$class->id, 'fees_type_id'=>$newTypeOfFees->id, 'fees'=>$class->class_fess, 'school_id'=>$schoolId]);
                }
                $data['fee_types'] = $typeOfFees = FeesType::where('school_id', $schoolId)->get();
            }
            if (isset($request['class']) && $request['class'] != 0) {
                if (InstituteClass::where('school_id', $schoolId)->where('id', $request['class'])->exists()) :
                    return view('frontend.school.finance.fees-create', compact('data'));
                else :
                    Alert::info('Sorry!', "Class does not exists. You can add more class");
                    return back();
                endif;
            }
            return view('frontend.school.finance.fees-create', compact('data'));
        }
        catch(Exception $e)
        {
            Alert::error("Server Problem", $e->getMessage());
            return back();
        }
    }
    /**
     * store fees title
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'     => 'required|regex:/^[a-zA-Z0-9\s]+$/u',
            'fees.*'    => 'numeric'
        ]);
        try {
            FeesType::updateOrCreate([
                'school_id' =>  Auth::id(),
                'title'     =>  $request['title'],
            ], []);
            return back();
        } catch (Exception $e) {
            return back()->with('status', $e->getMessage());
        }
    }
    /**
     * fees update
     */
    public function update(Request $request)
    {
        $request->validate([
            'class_id'  =>  ['required', 'integer'],
            // 'class'      =>  ['required'],
            'fees.*'      =>  'required | integer'
        ]);
        // return $request;
        try {
            if ($request['class_id'] == 0) // for all classes
            {
                $classes = InstituteClass::where('school_id', Auth::id())->get();
                foreach ($classes as $class) {
                    foreach ($request['fees_type_id'] as $key => $item) {
                        StudentFee::updateOrCreate(
                            [
                                'school_id' =>  Auth::id(),
                                'class_id'     =>  $class->id,
                                'fees_type_id'  =>  $item
                            ],
                            ['fees' =>  $request['fees'][$key] ?? 0]
                        );
                    }
                }
            } else // single class
            {
                foreach ($request['fees_type_id'] as $key => $item) {
                    StudentFee::updateOrCreate([
                        'school_id' =>  Auth::id(),
                        'class_id'     =>  $request['class_id'],
                        'fees_type_id'  =>  $item
                    ], ['fees' => $request['fees'][$key] ?? 0]);
                }
            }
            Alert::success("Great!", "Fees updated successfully");
            return back();
        } catch (Exception $e) {
            return back()->with('status', $e->getMessage());
        }
    }
    /**
     * show students list
     */
    public function userList(Request $request)
    {        
        try
        {        
            $users = User::with('class:id,class_name', 'section:id,section_name')->where('school_id', Auth::id());
            if($request->has('classId') && !empty($request->classId))
            {
                $users->where('class_id', $request->classId);
            }
            if($request->has('sectionId') && !empty($request->sectionId))
            {
                $users->where('section_id', $request->sectionId);
            }
            if($request->has('shift') && !empty($request->shift))
            {
                $users->where('shift', $request->shift);
            }
            if($request->has('groupId') && !empty($request->groupId))
            {
                $users->where('group_id', $request->groupId);
            }
            if($request->has('roll') && !empty($request->roll))
            {
                $users->where('roll_number', $request->roll);
            }
            if($request->has('limit') && !empty($request->limit))
            {
                $users->limit($request->limit);
            }
            else
            {
                $users->limit(100);
            }
            if($request->has('order') && !empty($request->order) && $request->order == "desc")
            {
                $users->latest();
            }
            else
            {
                $users->orderBy('roll_number');
            }
            $data['users'] = $users->get();
            $data['classes'] = InstituteClass::where('school_id', Auth::id())->pluck('class_name', 'id');
            if($request->ajax())
            {
                return $this->success(count($data['users']) . " record fetched", $data);
            }
            else
            {
                return view('frontend.school.finance.students-fee')->with($data);
            }
        }
        catch(Exception $e)
        {
            if($request->ajax())
            {
                return $this->error($e->getMessage());
            }
            else
            {
                // Alert::error("Server Error", $e->getMessage());
                return abort(403, $e->getMessage());
            }
        }
    }
    /**
     * get user information
     * 
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserInfo(Request $request)
    {
        try
        {
            if(Auth::check())
            {
                $schoolId = Auth::id();
                $data['allPaid'] = false;
                $records = DB::table('student_monthly_fees as smf')
                ->select('smf.id', 'smf.month_name', 'smf.amount', 'smf.paid_amount', 'ft.title', 'users.discount')
                ->join('student_fees as sf', 'sf.id', 'smf.student_fees_id')
                ->join('fees_types as ft', 'ft.id', 'sf.fees_type_id')
                ->join('users', 'users.id', 'smf.student_id')
                ->where('smf.student_id', $request->sid)
                ->where('smf.school_id', $schoolId)
                ->where('smf.status', "<", 2)
                // ->where('smf.month_id', '<', date('m'))
                ->orderBy('smf.month_id', 'ASC')
                ->get();
                $paidRecords = DB::table('student_monthly_fees as smf')
                ->select('smf.id', 'smf.month_name', 'smf.amount', 'smf.paid_amount', 'ft.title', 'users.discount')
                ->join('student_fees as sf', 'sf.id', 'smf.student_fees_id')
                ->join('fees_types as ft', 'ft.id', 'sf.fees_type_id')
                ->join('users', 'users.id', 'smf.student_id')
                ->where('smf.student_id', $request->sid)
                ->where('smf.school_id', $schoolId)
                ->where('smf.status', "=", 2)
                ->count();
                if($records->count() == 0 && $paidRecords > 0)
                {
                    $data['allPaid'] = true;
                }
                $studentMonthlyFees = $records->groupBy('month_name');
                $data['student'] = User::with('class:id,class_name', 'section:id,section_name')->find($request->sid);
                $resp = [];
                foreach($studentMonthlyFees as $key => $val)
                {
                    $array = [];
                    foreach($val as $item)
                    {
                        $feesAmount = $item->amount;
                        if($item->paid_amount > 0)
                        {
                            $feesAmount = $feesAmount - $item->paid_amount;
                        }
                        $array[] = [
                            'id' => $item->id,
                            'amount'    => abs($feesAmount),
                            'month_name'    =>  $item->month_name,
                            'title'         =>  $item->title,
                        ];
                    }
                    $resp[] = [
                        'month_name'    =>  $key,
                        'fees'          =>  $array
                    ];
                }
                $fees = [];
                foreach($records as $item)
                {
                    $feesAmount = $item->amount;
                    if($item->paid_amount > 0)
                    {
                        $feesAmount = $feesAmount - $item->paid_amount;
                    }
                    $fees[] = [
                        'id' => $item->id,
                        'amount'    => abs($feesAmount),
                        'month_name'    =>  $item->month_name,
                        'title'         =>  $item->title,
                    ];
                }
                $data['fees'] = $resp;
                $data['records'] = $fees;
                return $this->success("Record Fetched", $data);
            }
            else
            {
                return $this->error("Unauthenticated User");
            }
        }
        catch(Exception $e)
        {
            return $this->error($e->getMessage());
        }
    }
    /**
     * received fees
     */
    public function collectFees(Request $request)
    {
        try
        {
            if(isset($request->hiddenFeesId) && is_array($request->hiddenFeesId) && !empty($request->hiddenFeesId) && count($request->hiddenFeesId) > 0)
            {
                $html = "";
                foreach($request->hiddenFeesId as $key => $id)
                {
                    $paidAmount = (double) $request->feesAmount[$key];                    
                    $fee = StudentMonthlyFee::find($id);
                    $requiredAmount = abs((double)$fee->amount - (double)$fee->paid_amount);
                    if($fee->status < 2)
                    {
                        $fee->paid_amount += $paidAmount;
                        if($paidAmount < $requiredAmount)
                        {
                            $fee->status = 1; // partial
                        }
                        elseif($requiredAmount == $paidAmount)
                        {
                            $fee->status = 2; // paid
                        }
                        if($paidAmount > $requiredAmount)
                        {
                            return $this->error("Please enter valid amount", $request->all());
                        }
                        $fee->save();
                    }
                }
                $sid = $fee->student_id;
            }
            else
            {
                return $this->error("Invalid Data", $request->all());
            }
            return $this->success("Record stored successfully", $sid);
        }
        catch(Exception $e)
        {
            return $this->error($e->getMessage(), $request->all());
        }
    }
    /**domPDF */
    public function domPdf(Request $request)
    {
        $data = [
            "feesTable"      =>  $request->feesTable,
            "student"      =>  User::find($request->studentId),
            "school"      =>  Auth::user(),
        ];
        // return $data;
        set_time_limit(300);
        $pdf = Pdf::loadView("frontend.school.finance.pdf.pdf_collect_fees", $data);
        $fileName =  date("dmYHis").'.'. 'pdf' ;
        $pdf->save(public_path("collectFees") . '/' . $fileName);
        $pdf = public_path("collectFees/".$fileName);
        return response()->download($pdf);
    }
    public function studentSchoolScholarship(Request $request, $id)
    {
        $student = User::find($id);
        $student->scholarship = $request->scholarship;
        $student->save();
        Alert::success('Success student scholarship', 'Success Message');
        return back();
    }
    /**
     * received student fees
     *
     * @param Request
     * @param $request
     * @return @param \Illuminate\Contracts\View\View
     */
    public function receivedFees(Request $request)
    {
        $request->validate([
            'studentId' =>  ['required', 'exists:users,id'],
            'monthId'   =>  ['required'],
            'amount'    =>  ['required'],
            'assignFeesId'    =>  ['required']
        ]);
        try {
            $bank = Bank::where('school_id', Auth::id());
            if ($bank->count() > 0) :
                StudentMonthlyFee::updateOrCreate(
                    [
                        'school_id'     =>  Auth::id(),
                        'student_id'    =>  $request['studentId'],
                        'month_id'      =>  $request['monthId']
                    ],
                    [
                        'amount'        =>  $request['amount'],
                        'status'        =>  2 // status = paid
                    ]
                );
                // update mother account
                $bank = $bank->first();
                $bank->balance += $request['amount'];
                $bank->update(['amount' => $bank->balance]);
                Transection::create([
                    'purpose'   =>  "Collect student fee",
                    'payment_method'    => 1, // 1 for handCash
                    'amount'        =>  $request['amount'],
                    'name'          =>  'Admin',
                    'type'          =>  2, // 2 for fundad or add
                    'school_id'     =>  Auth::id()
                ]);
                $data['user'] = User::find($request['studentId']);
                $data['assignFees'] = AssignStudentFee::find($request['assignFeesId']);
                $data['studentFees'] = StudentMonthlyFee::where('school_id', Auth::id())->where('student_id', $data['user']->id)->where('month_id', $request['monthId'])->first();
                $data['html'] = view('pdf.monthly-fee', compact('data'))->render();
                $resp['status'] = true;
                $resp['message'] = "Record updated successfully";
                $resp['data'] = $data;
                $paymentSlip = $data;
            else :
                Alert::Info("Sorry!", 'Please add a bank account first');
            endif;
        } catch (Exception $e) {
            $resp['status'] = false;
            $resp['message'] = $e->getMessage();
            $resp['data'] = null;
        }
        return response()->json($paymentSlip);
    }
    /**
     * Delete Finance Fees Title
     *
     * @param Request
     * @param $request
     * @return redirector
     */
    public function financeTitleDelete($id)
    {
        StudentFee::where('fees_type_id', $id)->delete();
        FeesType::findOrFail($id)->delete();
        toast("Successfully Delete Fees Type", "success");
        return redirect()->back();
    }

    // student Finance Status
    public function studentFinanceStatus(){
        $seoTitle = 'Student Finance Status';
        $seoDescription = 'Student Finance Status';
        $seoKeyword = 'Student Finance Status';
        $seo_array = [
            'seoTitle' => $seoTitle,
            'seoKeyword' => $seoKeyword,
            'seoDescription' => $seoDescription,
        ];
        if (Auth::user()->status == 0) {
            return redirect()->route('school.payment.info');
        } elseif (Auth::user()->status == 2) {
            toast('Sorry Admin can Inactive Your Account Please Contact', 'error');
            return back();
        }
        if (Auth::user()->is_editor != 3) {
            return back();
        } else {
            $class = InstituteClass::where('school_id', Auth::user()->id)->get();
            $section = Section::where('school_id', Auth::user()->id)->get();
            $text = 'Download Student Financial Status';
            $defaultDate = Carbon::today()->format('Y-m-d');
           
            return view('frontend.school.finance.studentfinancestatus', compact('text', 'seo_array', 'class', 'section', 'defaultDate',));
        }
    }


    public function classWiseStudentFinnance(Request $request)
    {
        // return $request;
        if (Auth::user()->status == 0) {
            return redirect()->route('school.payment.info');
        } elseif (Auth::user()->status == 2) {
            toast('Sorry Admin can Inactive Your Account Please Contact', 'error');
            return back();
        }
        if (Auth::user()->is_editor != 3) {
            return back();
        } else {
            $class = $request->class_id;
            $studentList = user::where('school_id', Auth::user()->id)->where('class_id', $class)->get();
            $matchedElements = [];
            foreach ($studentList as $key => $student) {
                $matchedElements[] = StudentMonthlyFee::where('school_id', Auth::user()->id)->where('student_id', $student->id)->orderBy('month_id')->get();  
                $AssignTeacher = AssignTeacher::where('class_id',$student->class_id)->where('school_id',Auth::user()->id)->first()?->teacher_id;
                $classTeacher = Teacher::find($AssignTeacher)?->first()->full_name;
                $classTeacherPhone = Teacher::find($AssignTeacher)?->first()->phone;                        
            }
            $date = Carbon::today()->format('d-m-Y');
            
            $accountant = Teacher::where('designation', '=', "Accountant")->where('school_id', Auth::user()->id)->first()?->phone;
            //  return $matchedElements;
            // return view('frontend.school.finance.classWiseStatus', compact('class', 'studentList', 'matchedElements','date'));
            return view('frontend.school.finance.ClassWiseFinanceStatus', compact('class', 'studentList', 'matchedElements','date', 'classTeacher', 'classTeacherPhone', 'accountant'));
        }
        
    }
}