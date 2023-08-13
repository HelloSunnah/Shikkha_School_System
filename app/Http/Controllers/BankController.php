<?php
namespace App\Http\Controllers;
use App\Models\Bank;
use App\Models\EmployeeSalary;
use App\Models\TeacherSalary;
use App\Models\Transection;
use App\Models\StudentMonthlyFee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class BankController extends Controller
{
     /** --------------- bank account data table
     * =============================================*/
    public function show()
    {  
        $seoTitle = 'Bank List';
        $seoDescription = 'Bank List';
        $seoKeyword = 'Bank List';
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
        } 
        else {
            
            $teacherPaidSalary = TeacherSalary::where('school_id', Auth::user()->id)->sum("amount");            
            $StaffPaidSalary = EmployeeSalary::where('school_id', Auth::user()->id)->sum("amount");            
            $Expense = Transection::where('school_id', Auth::user()->id)->where('type', '1')->sum("amount");
            
            $sumFund = Transection::where('school_id', Auth::user()->id)->where('type', '2')->sum("amount");
            $colected = StudentMonthlyFee::where('school_id', Auth::user()->id)->where('status', '2')->sum("paid_amount");            
            $accesories = Transection::where('school_id', Auth::user()->id)->where('type', '3')->sum("amount");

            $ExpenseThisMonth = $Expense + $StaffPaidSalary + $teacherPaidSalary;
            $totalSchoolFund = $sumFund + $colected + $accesories;
            $profit = $totalSchoolFund - $ExpenseThisMonth;

            $bankadd = Bank::where('school_id', Auth::user()->id)->latest()->get();
            return view('frontend.school.bank_account.table')->with(compact('bankadd','profit','seo_array'));
        }
    }


    /** --------------- bank account data table
     * =============================================*/
    public function create()
    {   
        $seoTitle = 'Add Bank';
        $seoDescription = 'Add Bank';
        $seoKeyword = 'Add Bank';
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
        } else{
            return view('frontend.school.bank_account.form',compact('seo_array'));
        }
    }



    /** --------------- Store bank account
     * =============================================*/
    public function store(Request $request)
    {
        if (Auth::user()->status == 0) {
            return redirect()->route('school.payment.info');
        } elseif (Auth::user()->status == 2) {
            toast('Sorry Admin can Inactive Your Account Please Contact', 'error');
            return back();
        }
        if (Auth::user()->is_editor != 3) {
            return back();
        } 
        else{ 
            $request->validate([
                'bank_name'  => 'required',
                'branch'  => 'required',
                'account_number'  => 'required|unique:banks,account_number|numeric',
                'account_type'  => 'required',
                'account_holder'  => 'required',
            ]);

            $data = new Bank();
            $data -> bank_name = $request->bank_name;
            $data -> branch = $request->branch;
            $data -> account_number = $request->account_number;
            $data -> account_type = $request->account_type;
            $data -> account_holder = $request->account_holder;
            $data -> balance = (is_null($request->balance) ? '0' : $request->balance);
            $data -> routing = (is_null($request->routing) ? '0' : $request->routing);
            $data -> swift = (is_null($request->swift) ? '0' : $request->swift);
            $data -> school_id = Auth::user()->id;
            $data -> save();
            Alert::success('Successfully Bank record Add', 'Success Message');

            return redirect()->route('bankadd')->with('success', 'Record created successfully');
        }
    
    }


    
    /** --------------- bank account data edit
     * =============================================*/
    public function edit(Request $request)
    {
        if (Auth::user()->status == 0) {
            return redirect()->route('school.payment.info');
        } elseif (Auth::user()->status == 2) {
            toast('Sorry Admin can Inactive Your Account Please Contact', 'error');
            return back();
        }
        if (Auth::user()->is_editor != 3) {
            return back();
        } 
        else{
            $key = $request->key;
            $bankadd = Bank::find($key);

            return view('frontend.school.bank_account.form')->with(compact('bankadd'));
        }
    }




    /** --------------- Update bank account
     * =============================================*/
    public function update(Request $request, $key)
    {
        if (Auth::user()->status == 0) {
            return redirect()->route('school.payment.info');
        } elseif (Auth::user()->status == 2) {
            toast('Sorry Admin can Inactive Your Account Please Contact', 'error');
            return back();
        }
        if (Auth::user()->is_editor != 3) {
            return back();
        } 
        else{
           
            $request->validate([
                'bank_name'  => 'required',
                'branch'  => 'required',
                'account_number'  => 'required|numeric',
                'account_type'  => 'required',
                'account_holder'  => 'required',
            
            ]);
            
            $data = Bank::find($key);
            
            $data -> bank_name = $request->bank_name;
            $data -> branch = $request->branch;
            $data -> account_number = $request->account_number;
            $data -> account_type = $request->account_type;
            $data -> account_holder = $request->account_holder;
            $data -> balance = (is_null($request->balance) ? '0' : $request->balance);
            $data -> routing = (is_null($request->routing) ? '0' : $request->routing);
            $data -> swift = (is_null($request->swift) ? '0' : $request->swift);
            $data -> school_id = Auth::user()->id;
            $data -> save();
            Alert::success('Successfully Bank record Updated', 'Success Message');

            return redirect()->route('bankadd')->with('success', 'Record updated successfully');
    
        }
    }



    /** --------------- Update bank account
     * =============================================*/
    public function destroy(Request $request)
    {
        if (Auth::user()->status == 0) {
            return redirect()->route('school.payment.info');
        } elseif (Auth::user()->status == 2) {
            toast('Sorry Admin can Inactive Your Account Please Contact', 'error');
            return back();
        } 

        $key = $request->key;

        $bankadd = Bank::where('id',$key)->delete();
        Alert::success('Successfully Bank record Deleted', 'Success Message');

        return redirect()->route('bankadd')->with('success', 'Record deleted successfully');
    }

}
