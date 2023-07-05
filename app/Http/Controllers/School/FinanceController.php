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

use Exception;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use RealRashid\SweetAlert\Facades\Alert;

use App\Models\Transection;

use App\Traits\HttpResponse;

use Barryvdh\DomPDF\Facade\Pdf;

use Carbon\Carbon;

use Illuminate\Support\Facades\DB;



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



        return view("frontend.school.finance.dashboard.dashboard", compact('teacherSalary', 'teacherPaidSalary', 'StaffSalary', 'StaffPaidSalary', 'Expense', 'ExpenseThisMonth', 'TotalFees', 'totalSchoolFund', 'sumFund', 'colected', 'due', 'accesories', 'profit'));

    }


    // /**
    //  * view fees blade
    //  */
    // public function index(Request $request)
    // {
    //     try
    //     {
    //         $schoolId = Auth::id();
            
    //         if($request->ajax())
    //         {
    //             if(isset($request->classId) && !empty($request->classId))
    //             {
    //                 $data = StudentFee::join('fees_types as f', 'f.id', 'student_fees.fees_type_id')
    //                         ->join('institute_classes as class', 'class.id', 'student_fees.class_id')
    //                         ->select('student_fees.id', 'f.title', 'student_fees.fees', 'class.class_name')
    //                         ->where('student_fees.class_id', $request->classId)
    //                         ->where('student_fees.school_id', $schoolId)
    //                         ->get()->toArray();

    //                 return $this->success("data fetched", $data);
    //             }
    //             else
    //             {
    //                 return $this->error("Something went wrong. Please try again");
    //             }
    //         }
    //         else
    //         {
                
    //             $data['classes'] = InstituteClass::where('school_id', $schoolId)->get();
    //             $typeOfFees = FeesType::where('school_id', $schoolId)->get();
    //             $classes = InstituteClass::where('school_id', $schoolId)->get();

    //             if($typeOfFees->count() == 0)
    //             {
    //                 $newTypeOfFees = FeesType::create(
    //                     ['school_id'=> $schoolId,'title'=>'Monthly Fee'],
    //                     ['school_id'=> $schoolId,'title'=>'Absent Fee'],
    //                 );

    //                 foreach($classes as $class)
    //                 {
    //                     StudentFee::create(['class_id'=>$class->id, 'fees_type_id'=>$newTypeOfFees->id, 'fees'=>$class->class_fess, 'school_id'=>$schoolId]);
    //                 }

    //                 $data['fee_types'] = $typeOfFees = FeesType::where('school_id', $schoolId)->get();
    //             }
            
    //             return view('frontend.school.finance.fees-create')->with($data);
    //         }
    //     }
    //     catch(Exception $e)
    //     {
    //         if($request->ajax())
    //         {
    //             return $this->error($e->getMessage());
    //         }
    //         else
    //         {
    //             Alert::error("Server Problem", $e->getMessage());
    //             return back();
    //         }
    //     }
    // }





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


    public function showAjaxfilter(Request $request)
    {

        if (isset($request->searchdate)) {
            if (isset($request->enddate)) {
                $sumTeacher = TeacherSalary::where('school_id', Auth::user()->id)->whereBetween('updated_at', [$request->searchdate, $request->enddate])->where('amount', '!=', '0')->sum('amount');
                $sumstaff = EmployeeSalary::where('school_id', Auth::user()->id)->whereBetween('updated_at', [$request->searchdate, $request->enddate])->where('amount', '!=', '0')->sum('amount');
                $sumexpenses = Transection::where('school_id', Auth::user()->id)->whereBetween('datee', [$request->searchdate, $request->enddate])->where('type', '=', '1')->where('amount', '!=', '0')->sum('amount');
                $sumfund = Transection::where('school_id', Auth::user()->id)->where('type', '=', '2')->whereBetween('datee', [$request->searchdate, $request->enddate])->where('amount', '!=', '0')->sum('amount');
                $sumstudent = StudentMonthlyFee::where('school_id', Auth::user()->id)->whereBetween('updated_at', [$request->searchdate, $request->enddate])->where('status', '2')->sum('amount');
                $sumaccesories = Transection::where('school_id', Auth::user()->id)->where('type', '=', '3')->whereBetween('updated_at', [$request->searchdate, $request->enddate])->sum('amount');
                $profit = $sumfund + $sumstudent + $sumaccesories - $sumexpenses - $sumstaff - $sumTeacher;

                
                return response()->json( [
                    'sumexpenses'  =>  $sumexpenses,
                    'sumstaff' =>  $sumstaff, 
                    'sumTeacher' =>  $sumTeacher, 
                    'sumfund' =>  $sumfund, 
                    'sumstudent' =>  $sumstudent, 
                    'sumaccesories' =>  $sumaccesories,
                    'profit' => $profit,
                ]);

            } else {
                $sumTeacher = TeacherSalary::where('school_id', Auth::user()->id)->wheredate('updated_at', $request->searchdate)->where('amount', '!=', '0')->sum('amount');
                $sumstaff = EmployeeSalary::where('school_id', Auth::user()->id)->wheredate('updated_at', $request->searchdate)->where('amount', '!=', '0')->sum('amount');
                $sumexpenses = Transection::where('school_id', Auth::user()->id)->wheredate('datee', $request->searchdate)->where('type', '=', '1')->where('amount', '!=', '0')->sum('amount');
                $sumfund = Transection::where('school_id', Auth::user()->id)->wheredate('datee', $request->searchdate)->where('type', '=', '2')->where('amount', '!=', '0')->sum('amount');
                $sumstudent = StudentMonthlyFee::where('school_id', Auth::user()->id)->wheredate('updated_at', $request->searchdate)->where('status', '2')->sum('amount');
                $sumaccesories = Transection::where('school_id', Auth::user()->id)->where('type', '=', '3')->wheredate('updated_at', $request->searchdate)->sum('amount'); 
                $profit = $sumfund + $sumstudent + $sumaccesories - $sumexpenses - $sumstaff - $sumTeacher;               
                
                return response()->json( [
                    'sumexpenses'  =>  $sumexpenses, 
                    'sumstaff' =>  $sumstaff, 
                    'sumTeacher' =>  $sumTeacher, 
                    'sumfund' =>  $sumfund, 
                    'sumstudent' =>  $sumstudent, 
                    'sumaccesories' =>  $sumaccesories,
                    'profit' => $profit,
                ]);

            }
        } 
        elseif (isset($request->searchmonth)) {            
            $sumTeacher = TeacherSalary::where('school_id', Auth::user()->id)->whereMonth('updated_at', $request->searchmonth)->where('amount', '!=', '0')->sum('amount');
            $sumstaff = EmployeeSalary::where('school_id', Auth::user()->id)->whereMonth('updated_at', $request->searchmonth)->where('amount', '!=', '0')->sum('amount');
            $sumexpenses = Transection::where('school_id', Auth::user()->id)->whereMonth('datee', $request->searchmonth)->where('type', '=', '1')->where('amount', '!=', '0')->sum('amount');
            $sumfund = Transection::where('school_id', Auth::user()->id)->whereMonth('datee', $request->searchmonth)->where('type', '=', '2')->where('amount', '!=', '0')->sum('amount');
            $sumstudent = StudentMonthlyFee::where('school_id', Auth::user()->id)->whereMonth('updated_at', $request->searchmonth)->where('status', '2')->sum('amount');
            $sumaccesories = Transection::where('school_id', Auth::user()->id)->where('type', '=', '3')->whereMonth('updated_at', $request->searchmonth)->sum('amount');
            $profit = $sumfund + $sumstudent + $sumaccesories - $sumexpenses - $sumstaff - $sumTeacher;
            
            return response()->json( [
                'sumexpenses'  =>  $sumexpenses, 
                'sumstaff' =>  $sumstaff, 
                'sumTeacher' =>  $sumTeacher, 
                'sumfund' =>  $sumfund, 
                'sumstudent' =>  $sumstudent, 
                'sumaccesories' =>  $sumaccesories,
                'profit' => $profit,
            ]);
        } 
        else {
            $sumTeacher = TeacherSalary::where('school_id', Auth::user()->id)->where('amount', '!=', '0')->sum('amount');
            $sumstaff = EmployeeSalary::where('school_id', Auth::user()->id)->where('amount', '!=', '0')->sum('amount');
            $sumexpenses = Transection::where('school_id', Auth::user()->id)->where('type', '=', '1')->where('amount', '!=', '0')->sum('amount');
            $sumfund = Transection::where('school_id', Auth::user()->id)->where('type', '=', '2')->where('amount', '!=', '0')->sum('amount');
            $sumstudent = StudentMonthlyFee::where('school_id', Auth::user()->id)->where('status','=', '2')->sum('amount');
            $sumaccesories = Transection::where('school_id', Auth::user()->id)->where('type', '=', '3')->sum('amount');
            $profit = $sumfund + $sumstudent + $sumaccesories - $sumexpenses - $sumstaff - $sumTeacher;
            
            return response()->json( [
                'sumexpenses'  =>  $sumexpenses, 
                'sumstaff' =>  $sumstaff, 
                'sumTeacher' =>  $sumTeacher, 
                'sumfund' =>  $sumfund, 
                'sumstudent' =>  $sumstudent, 
                'sumaccesories' =>  $sumaccesories,
                'profit' => $profit,
            ]);
        }
    }

    public function showAjaxfilterMonthly(Request $request)
    {
        // return $request;
        // startDate:startDate,
        // endDate:endDate,
        // searchMonth:searchMonth,

                    
        $sumTeacher = TeacherSalary::where('school_id', Auth::user()->id)->whereMonth('updated_at', $request->searchmonth)->where('amount', '!=', '0')->sum('amount');
        $sumstaff = EmployeeSalary::where('school_id', Auth::user()->id)->whereMonth('updated_at', $request->searchmonth)->where('amount', '!=', '0')->sum('amount');
        $sumexpenses = Transection::where('school_id', Auth::user()->id)->whereMonth('datee', $request->searchmonth)->where('type', '=', '1')->where('amount', '!=', '0')->sum('amount');
        $sumfund = Transection::where('school_id', Auth::user()->id)->whereMonth('datee', $request->searchmonth)->where('type', '=', '2')->where('amount', '!=', '0')->sum('amount');
        $sumstudent = StudentMonthlyFee::where('school_id', Auth::user()->id)->whereMonth('updated_at', $request->searchmonth)->where('status', '2')->sum('amount');
        $sumaccesories = Transection::where('school_id', Auth::user()->id)->where('type', '=', '3')->whereMonth('updated_at', $request->searchmonth)->sum('amount');
        $profit = $sumfund + $sumstudent + $sumaccesories - $sumexpenses - $sumstaff - $sumTeacher;
        
        return response()->json( [
            'sumexpenses'  =>  $sumexpenses, 
            'sumstaff' =>  $sumstaff, 
            'sumTeacher' =>  $sumTeacher, 
            'sumfund' =>  $sumfund, 
            'sumstudent' =>  $sumstudent, 
            'sumaccesories' =>  $sumaccesories,
            'profit' => $profit,
        ]);
        
        
    }

    
}

