<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\School;
use App\Models\Transection;
use Illuminate\Http\Request;

use App\Models\TeacherSalary;
use Illuminate\Http\Response;
use App\Models\AccesoriesType;
use App\Models\EmployeeSalary;
use App\Models\InstituteClass;
use App\Models\StudentMonthlyFee;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\AccesoriesTransaction;
use RealRashid\SweetAlert\Facades\Alert;


class ExpenseController extends Controller
{
    //expense show 

    public function expenseShow(Request $request)
    {   
        $seoTitle = 'Expenses Show';
        $seoDescription = 'Expenses Show';
        $seoKeyword = 'Expenses Show';
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

            $date = $request;
            if (isset($request->searchdate)) {
                if (isset($request->enddate)) {
                    $searchdate = $request->searchdate;
                    $enddate = $request->enddate;
                    $expense = Transection::where('school_id', Auth::user()->id)->where('status', true)->whereBetween('datee', [$request->searchdate, $request->enddate])->where('type', 1)->orderBy('created_at', 'Desc')->get();
                    $sumFund = Transection::where('school_id', Auth::user()->id)->where('status', true)->whereBetween('datee', [$request->searchdate, $request->enddate])->where('type', 1)->sum('amount');
                    $defaultDate = Carbon::today()->format('Y-m-d');
                    return view('frontend.school.expense.table')->with(compact('expense', 'sumFund', 'defaultDate', 'enddate', 'searchdate','seo_array'));
                } else {
                    $searchdate = $request->searchdate;
                    $expense = Transection::where('school_id', Auth::user()->id)->where('status', true)->wheredate('datee', $request->searchdate)->where('type', 1)->orderBy('created_at', 'Desc')->get();
                    $sumFund = Transection::where('school_id', Auth::user()->id)->where('status', true)->wheredate('datee', $request->searchdate)->where('type', 1)->sum('amount');
                    $defaultDate = Carbon::today()->format('Y-m-d');
                    return view('frontend.school.expense.table')->with(compact('expense', 'sumFund', 'defaultDate', 'searchdate','seo_array'));
                }
            } elseif (isset($request->searchmonth)) {
                
                $transectionMonth = Transection::where('school_id', Auth::user()->id)->where('status', true)->orderBy('created_at', 'asc')->get();
                $searchmonth = $request->searchmonth;
                $sumFund = Transection::where('school_id', Auth::user()->id)->where('status', true)->whereMonth('datee', $request->searchmonth)->where('type', 1)->sum('amount');
                $expense = Transection::where('school_id', Auth::user()->id)->where('status', true)->whereMonth('datee', $request->searchmonth)->where('type', 1)->orderBy('created_at', 'Desc')->get();
                $defaultDate = Carbon::today()->format('Y-m-d');
                return view('frontend.school.expense.table')->with(compact('sumFund', 'expense', 'searchmonth', 'defaultDate','seo_array'));
            } else {

                $expense = Transection::where('school_id', Auth::user()->id)->where('status', true)->where('type', 1)->latest()->get();
                $sumFund = Transection::where('school_id', Auth::user()->id)->where('status', true)->where('type', 1)->sum('amount');
                $defaultDate = Carbon::today()->format('Y-m-d');
                return view('frontend.school.expense.table', compact('expense', 'sumFund', 'defaultDate','seo_array'));
            }
        }
    }

    //expense list show
    public function expenselist(Request $request)
    {  
        $seoTitle = 'Expenses List';
        $seoDescription = 'Expenses List';
        $seoKeyword = 'Expenses List';
        $seo_array = [
            'seoTitle' => $seoTitle,
            'seoKeyword' => $seoKeyword,
            'seoDescription' => $seoDescription,
        ];
        if (Auth::user()->is_editor != 3) {
            return back();
        } else {
            $date = $request;
            if (isset($request->searchdate)) {
                if (isset($request->enddate)) {
                    $expenses = Transection::where('school_id', Auth::user()->id)->whereBetween('datee', [$request->searchdate, $request->enddate])->where('type', '=', '1')->where('amount', '!=', '0')->orderBy('datee','Desc')->paginate(20);
                    $teacher = TeacherSalary::where('school_id', Auth::user()->id)->whereBetween('updated_at', [$request->searchdate, $request->enddate])->where('amount', '!=', '0')->orderBy('updated_at','Desc')->paginate(20);
                    $sum = TeacherSalary::where('school_id', Auth::user()->id)->whereBetween('updated_at', [$request->searchdate, $request->enddate])->where('amount', '!=', '0')->sum('amount');
                    $sumstaff = EmployeeSalary::where('school_id', Auth::user()->id)->whereBetween('updated_at', [$request->searchdate, $request->enddate])->where('amount', '!=', '0')->sum('amount');
                    $sumexpenses = Transection::where('school_id', Auth::user()->id)->whereBetween('datee', [$request->searchdate, $request->enddate])->where('type', '=', '1')->where('amount', '!=', '0')->sum('amount');
                    $data = [
                        'sum' => $sum,
                        'sumstaff' => $sumstaff,
                        'sumexpenses' => $sumexpenses
                    ];
                    $sumFund = $data['sum'] + $data['sumstaff'] + $data['sumexpenses'];
                    $staff = EmployeeSalary::where('school_id', Auth::user()->id)->whereBetween('updated_at', [$request->searchdate, $request->enddate])->where('amount', '!=', '0')->orderBy('updated_at','Desc')->paginate(20);
                    $defaultDate = Carbon::today()->format('Y-m-d');
                    return view('frontend.school.expense.expenseList')->with(compact('expenses', 'sumFund', 'sum', 'teacher', 'staff', 'defaultDate','seo_array'));
                } else {
                    $expenses = Transection::where('school_id', Auth::user()->id)->wheredate('datee', $request->searchdate)->where('type', '=', '1')->where('amount', '!=', '0')->orderBy('datee','Desc')->paginate(20);
                    $teacher = TeacherSalary::where('school_id', Auth::user()->id)->wheredate('updated_at', $request->searchdate)->where('amount', '!=', '0')->orderBy('updated_at','Desc')->paginate(20);
                    $sum = TeacherSalary::where('school_id', Auth::user()->id)->wheredate('updated_at', $request->searchdate)->where('amount', '!=', '0')->sum('amount');
                    $sumstaff = EmployeeSalary::where('school_id', Auth::user()->id)->wheredate('updated_at', $request->searchdate)->where('amount', '!=', '0')->sum('amount');
                    $sumexpenses = Transection::where('school_id', Auth::user()->id)->wheredate('datee', $request->searchdate)->where('type', '=', '1')->where('amount', '!=', '0')->sum('amount');
                    $data = [
                        'sum' => $sum,
                        'sumstaff' => $sumstaff,
                        'sumexpenses' => $sumexpenses
                    ];
                    $sumFund = $data['sum'] + $data['sumstaff'] + $data['sumexpenses'];
                    $staff = EmployeeSalary::where('school_id', Auth::user()->id)->whereDate('updated_at', $request->searchdate)->where('amount', '!=', '0')->orderBy('updated_at','Desc')->paginate(20);
                    $defaultDate = Carbon::today()->format('Y-m-d');
                    return view('frontend.school.expense.expenseList')->with(compact('expenses', 'sumFund', 'sum', 'teacher', 'staff', 'defaultDate','seo_array'));
                }
            } 
            elseif (isset($request->searchmonth)) {
                $transectionMonth = Transection::where('status', true)->orderBy('created_at', 'asc')->get();
                $searchmonth = $request->searchmonth;
                $expenses = Transection::where('school_id', Auth::user()->id)->where('type', '=', '1')->whereMonth('datee', $request->searchmonth)->where('amount', '!=', '0')->orderBy('datee','Desc')->paginate(20);
                $teacher = TeacherSalary::where('school_id', Auth::user()->id)->whereMonth('updated_at', $request->searchmonth)->where('amount', '!=', '0')->orderBy('updated_at','Desc')->paginate(20);
                $sum = TeacherSalary::where('school_id', Auth::user()->id)->whereMonth('updated_at', $request->searchmonth)->where('amount', '!=', '0')->sum('amount');
                $sumstaff = EmployeeSalary::where('school_id', Auth::user()->id)->whereMonth('updated_at', $request->searchmonth)->where('amount', '!=', '0')->sum('amount');
                $sumexpenses = Transection::where('school_id', Auth::user()->id)->whereMonth('datee', $request->searchmonth)->where('type', '=', '1')->where('amount', '!=', '0')->sum('amount');
                $staff = EmployeeSalary::where('school_id', Auth::user()->id)->whereMonth('updated_at', $request->searchmonth)->where('amount', '!=', '0')->orderBy('updated_at','Desc')->paginate(20);
                $data = [
                    'sum' => $sum,
                    'sumstaff' => $sumstaff,
                    'sumexpenses' => $sumexpenses
                ];
                $sumFund = $data['sum'] + $data['sumstaff'] + $data['sumexpenses'];
                $defaultDate = Carbon::today()->format('Y-m-d');
                return view('frontend.school.expense.expenseList')->with(compact('expenses', 'sumFund', 'sum', 'teacher', 'staff', 'defaultDate','seo_array'));
            } 
            else {
                $expenses = Transection::where('school_id', Auth::user()->id)->where('type', '=', '1')->where('amount', '!=', '0')->orderBy('datee', 'desc')->paginate(20);
                $teacher = TeacherSalary::where('school_id', Auth::user()->id)->where('amount', '!=', '0')->orderBy('updated_at','Desc')->paginate(20);
                $sum = TeacherSalary::where('school_id', Auth::user()->id)->where('amount', '!=', '0')->sum('amount');
                $sumstaff = EmployeeSalary::where('school_id', Auth::user()->id)->where('amount', '!=', '0')->sum('amount');
                $sumexpenses = Transection::where('school_id', Auth::user()->id)->where('type', '=', '1')->where('amount', '!=', '0')->sum('amount');
                $data = [
                    'sum' => $sum,
                    'sumstaff' => $sumstaff,
                    'sumexpenses' => $sumexpenses
                ];
                $sumFund = $data['sum'] + $data['sumstaff'] + $data['sumexpenses'];
                $staff = EmployeeSalary::where('school_id', Auth::user()->id)->where('amount', '!=', '0')->orderBy('updated_at','Desc')->paginate(20);
                $defaultDate = Carbon::today()->format('Y-m-d');
                return view('frontend.school.expense.expenseList')->with(compact('expenses', 'sumFund', 'sum', 'teacher', 'staff', 'defaultDate','seo_array'));
            }
        }
    }




    public function  AllFundlist(Request $request)
    {   
        $seoTitle = 'Fund List';
        $seoDescription = 'Fund List';
        $seoKeyword = 'Fund List';
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

            $date = $request;
            if (isset($request->searchdate)) {
                $search = 1;
                if (isset($request->enddate)) {

                    $fund = Transection::where('school_id', Auth::user()->id)->whereBetween('datee', [$request->searchdate, $request->enddate])->where('type', '=', '2')->where('amount', '!=', '0')->orderBy('datee', 'Asc')->get();
                    $student = StudentMonthlyFee::where('school_id', Auth::user()->id)->whereBetween('updated_at', [$request->searchdate, $request->enddate])->where('status', '2')->orderBy('updated_at', 'Asc')->get();
                    $accesories = Transection::where('school_id', Auth::user()->id)->where('type', '=', '3')->whereBetween('updated_at', [$request->searchdate, $request->enddate])->orderBy('datee', 'Asc')->get();
                    $sumfund = Transection::where('school_id', Auth::user()->id)->where('type', '=', '2')->whereBetween('datee', [$request->searchdate, $request->enddate])->where('amount', '!=', '0')->sum('amount');
                    $sumstudent = StudentMonthlyFee::where('school_id', Auth::user()->id)->whereBetween('updated_at', [$request->searchdate, $request->enddate])->where('status', '>' ,'0')->sum('paid_amount');
                    $sumaccesories = Transection::where('school_id', Auth::user()->id)->where('type', '=', '3')->whereBetween('updated_at', [$request->searchdate, $request->enddate])->sum('amount');

                    $data = [
                        'sumfund' => $sumfund,
                        'sumstudent' => $sumstudent,
                        'sumaccesories' => $sumaccesories
                    ];
                    $sumAllFund = $data['sumfund'] + $data['sumstudent'] + $data['sumaccesories'];
                    return view('frontend.school.fund.fundList', compact('student', 'accesories', 'fund', 'sumAllFund', 'search','seo_array'));
                } else {


                    $fund = Transection::where('school_id', Auth::user()->id)->wheredate('datee', $request->searchdate)->where('type', '=', '2')->where('amount', '!=', '0')->orderBy('datee', 'Asc')->get();
                    $student = StudentMonthlyFee::where('school_id', Auth::user()->id)->wheredate('updated_at', $request->searchdate)->where('status', '2')->orderBy('updated_at', 'Asc')->get();
                    $accesories = Transection::where('school_id', Auth::user()->id)->where('type', '=', '3')->wheredate('updated_at', $request->searchdate)->orderBy('datee', 'Asc')->get();
                    $sumfund = Transection::where('school_id', Auth::user()->id)->wheredate('datee', $request->searchdate)->where('type', '=', '2')->where('amount', '!=', '0')->sum('amount');
                    $sumstudent = StudentMonthlyFee::where('school_id', Auth::user()->id)->wheredate('updated_at', $request->searchdate)->where('status', '>', '2')->sum('paid_amount');
                    $sumaccesories = Transection::where('school_id', Auth::user()->id)->where('type', '=', '3')->wheredate('updated_at', $request->searchdate)->sum('amount');


                    $data = [
                        'sumfund' => $sumfund,
                        'sumstudent' => $sumstudent,
                        'sumaccesories' => $sumaccesories
                    ];
                    // return $data;
                    $sumAllFund = $data['sumfund'] + $data['sumstudent'] + $data['sumaccesories'];
                    return view('frontend.school.fund.fundList', compact('student', 'accesories', 'fund', 'sumAllFund', 'search','seo_array'));
                }
            } elseif (isset($request->searchmonth)) {
                $search = 1;

                $searchmonth = $request->searchmonth;

                $fund = Transection::where('school_id', Auth::user()->id)->whereMonth('datee', $request->searchmonth)->where('type', '=', '2')->where('amount', '!=', '0')->orderBy('datee', 'Asc')->get();
                $student = StudentMonthlyFee::where('school_id', Auth::user()->id)->whereMonth('updated_at', $request->searchmonth)->where('status', '2')->orderBy('updated_at', 'Asc')->get();
                $accesories = Transection::where('school_id', Auth::user()->id)->where('type', '=', '3')->whereMonth('updated_at', $request->searchmonth)->orderBy('datee', 'Asc')->get();
                $sumfund = Transection::where('school_id', Auth::user()->id)->whereMonth('datee', $request->searchmonth)->where('type', '=', '2')->where('amount', '!=', '0')->sum('amount');
                $sumstudent = StudentMonthlyFee::where('school_id', Auth::user()->id)->whereMonth('updated_at', $request->searchmonth)->where('status', '>', '0')->sum('paid_amount');
                $sumaccesories = Transection::where('school_id', Auth::user()->id)->where('type', '=', '3')->whereMonth('updated_at', $request->searchmonth)->sum('amount');

                $data = [
                    'sumfund' => $sumfund,
                    'sumstudent' => $sumstudent,
                    'sumaccesories' => $sumaccesories
                ];
                $sumAllFund = $data['sumfund'] + $data['sumstudent'] + $data['sumaccesories'];
                return view('frontend.school.fund.fundList', compact('student', 'accesories', 'fund', 'sumAllFund', 'search','seo_array'));
            } 
            else {
                $search = 0;

                $fund = Transection::where('school_id', Auth::user()->id)->where('type', '=', '2')->where('amount', '!=', '0')->orderBy('datee', 'Desc')->paginate(20);
                $student = StudentMonthlyFee::where('school_id', Auth::user()->id)->where('paid_amount','>', '0')->orderBy('updated_at', 'Desc')->paginate(15);
                $accesories = Transection::where('school_id', Auth::user()->id)->where('type', '=', '3')->orderBy('datee', 'Desc')->paginate(20);
                $sumfund = Transection::where('school_id', Auth::user()->id)->where('type', '=', '2')->where('amount', '!=', '0')->sum('amount');
                $sumstudent = StudentMonthlyFee::where('school_id', Auth::user()->id)->where('status','>', 0)->sum('paid_amount');
                $sumaccesories = Transection::where('school_id', Auth::user()->id)->where('type', '=', '3')->sum('amount');

                $data = [
                    'sumfund' => $sumfund,
                    'sumstudent' => $sumstudent,
                    'sumaccesories' => $sumaccesories
                ];
                $sumAllFund = $data['sumfund'] + $data['sumstudent'] + $data['sumaccesories'];

                return view('frontend.school.fund.fundList', compact('student', 'accesories', 'fund', 'sumAllFund', 'search','seo_array'));
            }
        }
    }

    public function fund_check_delete(Request $request)
    {
        $ids=$request->ids;
        Transection::withTrashed()->where('id', $id)->forcedelete();
        toast("Data delete permanently", "success");
        return back();
    }


    /** --------------- expense data table
     * =============================================*/

     public function expense_check_delete(Request $request)
     {
        $ids=$request->ids;
        Transection::withTrashed()->where('id', $id)->forcedelete();
        toast("Data delete permanently", "success");
        return back();
    }


    // Create Expense
    public function expensecreate($expenseFund)
    {   
        $seoTitle = 'Expenses Create';
        $seoDescription = 'Expenses Create';
        $seoKeyword = 'Expenses Create';
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
            $expenseFund = $expenseFund;
            return view('frontend.school.expense.form', compact('expenseFund','seo_array'));
        }
    }

    /** --------------- Store expense
     * =============================================*/
    public function expensestore(Request $request)
    {
        if (Auth::user()->status == 0) {
            return redirect()->route('school.payment.info');
        } elseif (Auth::user()->status == 2) {
            toast('Sorry Admin can Inactive Your Account Please Contact', 'error');
            return back();
        }
        if (Auth::user()->is_editor != 3) {
            return back();
        } else {
            $request->validate([

                'datee'  => 'required',
                'amount'  => 'required|integer',
                'purpose'  => 'required',
                'payment_method' => 'required',
                'type' => 'required',

            ]);

            $data = $request->all();
            $data['school_id'] = Auth::user()->id;

            // return $data;

            $expense = Transection::create($data);

            if ($request->type == 1) {
                return redirect()->route('expense.show')->with('success', 'Record created successfully');
            } else {
                return redirect()->route('fund.show')->with('success', 'Record created successfully');
            }
        }
    }

    /** --------------- expense data edit
     * =============================================*/
    public function expenseedit(Request $request)
    {
        
        if (Auth::user()->status == 0) {
            return redirect()->route('school.payment.info');
        } elseif (Auth::user()->status == 2) {
            toast('Sorry Admin can Inactive Your Account Please Contact', 'error');
            return back();
        }
        if (Auth::user()->is_editor != 3) {
            return back();
        } else {
            $key = $request->key;
            $expense = Transection::find($key);
            $expenseFund = $key;
            return view('frontend.school.expense.form')->with(compact('expense', 'expenseFund'));
        }
    }


    /** --------------- Update expense
     * =============================================*/
    public function expenseupdate(Request $request)
    {
        if (Auth::user()->status == 0) {
            return redirect()->route('school.payment.info');
        } elseif (Auth::user()->status == 2) {
            toast('Sorry Admin can Inactive Your Account Please Contact', 'error');
            return back();
        }
        if (Auth::user()->is_editor != 3) {
            return back();
        } else {
            $key = $request->key;

            $request->validate([

                'datee'  => 'required',
                'amount'  => 'required|integer',
                'purpose'  => 'required',
                'payment_method' => 'required',
                'type' => 'required',
            ]);


            $data = $request->except("key");
            $data['school_id'] = Auth::user()->id;

            $expense = Transection::find($key)->update($data);

            if ($request->type == 1) {
                return redirect()->route('expense.show')->with('success', 'Record created successfully');
            } else {
                return redirect()->route('fund.show')->with('success', 'Record created successfully');
            }
        }
    }


    public function receiptDelete($id)
    {
        // syllabus delete
        AccesoriesTransaction::find($id)->delete();
        toast('opps deleted', 'danger');

        return back();
    }


    /** --------------- Delete expense
     * =============================================*/
    public function expensedestroy(Request $request)
    {
        if (Auth::user()->status == 0) {
            return redirect()->route('school.payment.info');
        } elseif (Auth::user()->status == 2) {
            toast('Sorry Admin can Inactive Your Account Please Contact', 'error');
            return back();
        }
        if (Auth::user()->is_editor != 3) {
            return back();
        } else {
            $key = $request->key;

            $expense = Transection::destroy($key);

            if ($request->type == 1) {
                return redirect()->route('expense.show')->with('success', 'Record created successfully');
            } else {
                return redirect()->route('fund.show')->with('success', 'Record created successfully');
            }
        }
    }


    // this part is for fund Control

    //Fund list show 

    public function fundlist(Request $request)
    {   
        $seoTitle = 'Fund Show';
        $seoDescription = 'Fund Show';
        $seoKeyword = 'Fund Show';
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
            $date = $request;
            if (isset($request->searchdate)) {
                if (isset($request->enddate)) {
                    $searchdate = $request->searchdate;
                    $enddate = $request->enddate;
                    $expense = Transection::where('school_id', Auth::id())->where('status', true)->whereBetween('datee', [$request->searchdate, $request->enddate])->where('type', 2)->orderBy('datee', 'desc')->get();
                    $sumFund = Transection::where('school_id', Auth::id())->where('status', true)->whereBetween('datee', [$request->searchdate, $request->enddate])->where('type', 2)->sum('amount');
                    $defaultDate = Carbon::today()->format('Y-m-d');
                    return view('frontend.school.fund.table')->with(compact('expense', 'sumFund', 'defaultDate', 'searchdate', 'enddate','seo_array'));
                } else {
                    $searchdate = $request->searchdate;
                    $expense = Transection::where('school_id', Auth::id())->where('status', true)->wheredate('datee', $request->searchdate)->where('type', 2)->orderBy('datee', 'desc')->get();
                    $sumFund = Transection::where('school_id', Auth::id())->where('status', true)->wheredate('datee', $request->searchdate)->where('type', 2)->sum('amount');
                    $defaultDate = Carbon::today()->format('Y-m-d');
                    return view('frontend.school.fund.table')->with(compact('expense', 'sumFund', 'defaultDate', 'searchdate','seo_array'));
                }
            } elseif (isset($request->searchmonth)) {
                $transectionMonth = Transection::where('school_id', Auth::id())->where('status', true)->orderBy('created_at', 'asc')->get();
                $searchmonth = $request->searchmonth;
                $sumFund = Transection::where('school_id', Auth::id())->where('status', true)->whereMonth('datee', $request->searchmonth)->where('type', 2)->sum('amount');
                $defaultDate = Carbon::today()->format('Y-m-d');
                $expense = Transection::where('school_id', Auth::id())->where('status', true)->whereMonth('datee', $request->searchmonth)->where('type', 2)->orderBy('datee', 'desc')->get();
                return view('frontend.school.fund.table')->with(compact('expense', 'searchmonth', 'sumFund', 'defaultDate'));
            } else {
                $expense = Transection::where('school_id', Auth::id())->where('status', true)->where('type', 2)->orderBy('datee', 'desc')->get();
                $sumFund = Transection::where('school_id', Auth::id())->where('status', true)->where('type', 2)->sum('amount');
                $defaultDate = Carbon::today()->format('Y-m-d');
                return view('frontend.school.fund.table', compact('expense', 'sumFund', 'defaultDate','seo_array'));
            }
        }
    }


    /** --------------- expense data table
     * =============================================*/
    public function fundcreate($expenseFund)
    {
        if (Auth::user()->status == 0) {
            return redirect()->route('school.payment.info');
        } elseif (Auth::user()->status == 2) {
            toast('Sorry Admin can Inactive Your Account Please Contact', 'error');
            return back();
        }
        if (Auth::user()->is_editor != 3) {
            return back();
        } else {
            $expenseFund = $expenseFund;
            return view('frontend.school.expense.form', compact('expenseFund'));
        }
    }

    // this oart is for accesories 

    public function  accesoriesType()
    {   
        $seoTitle = 'Accesories Type';
        $seoDescription = 'Accesories Type';
        $seoKeyword = 'Accesories Type';
        $seo_array = [
            'seoTitle' => $seoTitle,
            'seoKeyword' => $seoKeyword,
            'seoDescription' => $seoDescription,
        ];
        $data = AccesoriesType::where('school_id', Auth::id())->get();

        return view('frontend.school.Accesories.accesoriesType', compact('data','seo_array'));
    }

    /**
     *  store accesories by school
     */
    public function accesoriesTypePost(Request $request)
    {

        $request->validate([
            'accesories' => 'required',
            'price' => 'required'
        ]);

        AccesoriesType::create([
            'school_id' =>  Auth::id(),
            'accesories' => $request->accesories,
            'price' => $request->price,
        ]);

        return back();
    }
    public function accesoriesTypeListdelete($id)
    {
        AccesoriesType::find($id)->delete();
        toast('opps deleted', 'danger');

        return back();
    }


    public function  accesoriesEditPost(Request $request, $id)
    {
        $update = AccesoriesType::find($id);
        $update->update([
            'accesories' => $request->accesories,
            'price' => $request->price,
        ]);
        Alert::success('Success', "Updated Succesfully");

        return back();
    }


    public function   receiptHistoryEdit(Request $request, $id)
    {
        $update = AccesoriesTransaction::find($id);
        $update->update([
            'name' => $request->name,
            'class' => $request->class,
            'roll' => $request->roll,
            'section' => $request->section,
            'accesories' => $request->accesories,
            'amount' => $request->amount,
            'quantity' => $request->quantity
        ]);
        Alert::success('Success', "Updated Succesfully");

        return back();
    }

    public function receipt()
    {  
        $seoTitle = 'Accesories Receipt';
        $seoDescription = 'Accesories Receipt';
        $seoKeyword = 'Accesories Receipt';
        $seo_array = [
            'seoTitle' => $seoTitle,
            'seoKeyword' => $seoKeyword,
            'seoDescription' => $seoDescription,
        ];
        $class = InstituteClass::where('school_id', Auth::user()->id)->get();

        $school = School::find(Auth::user()->id);
        $orders = AccesoriesType::where('school_id', Auth::id())->get();
        return view("frontend.school.Accesories.accesories", compact('orders', 'school', 'class','seo_array'));
    }

    
    public function  receiptShow()
    {
        $seoTitle = 'Accesories History';
        $seoDescription = 'Accesories History';
        $seoKeyword = 'Accesories History';
        $seo_array = [
            'seoTitle' => $seoTitle,
            'seoKeyword' => $seoKeyword,
            'seoDescription' => $seoDescription,
        ];
        $data = AccesoriesTransaction::with('Class', 'Section')->get();
        return view('frontend.school.Accesories.receipt', compact('data','seo_array'));
    }

    public function getPrice($id)
    {
        $price  = AccesoriesType::find($id)->price;
        return $price;
    }

    public function paginator(Request $request)
    {
        if($request->ajax()){
            $page = $request->input('page', 1);

            $fund = Transection::where('school_id', Auth::user()->id)->where('type', '=', '2')->where('amount', '!=', '0')->orderBy('datee', 'Desc')->paginate(20);
            $student = StudentMonthlyFee::where('school_id', Auth::user()->id)->where('paid_amount','>', '0')->orderBy('updated_at', 'Desc')->paginate(20);
            $accesories = Transection::where('school_id', Auth::user()->id)->where('type', '=', '3')->orderBy('datee', 'Desc')->paginate(20);
            $sumfund = Transection::where('school_id', Auth::user()->id)->where('type', '=', '2')->where('amount', '!=', '0')->sum('amount');
            $sumstudent = StudentMonthlyFee::where('school_id', Auth::user()->id)->where('status','>', 0)->sum('paid_amount');
            $sumaccesories = Transection::where('school_id', Auth::user()->id)->where('type', '=', '3')->sum('amount');

            $data = [
                'sumfund' => $sumfund,
                'sumstudent' => $sumstudent,
                'sumaccesories' => $sumaccesories
            ];
            $sumFund = $data['sumfund'] + $data['sumstudent'] + $data['sumaccesories'];

            return view('frontend.school.fund.fundList', compact('student', 'accesories', 'fund', 'sumFund'))->render();
        
        }
    }
}
