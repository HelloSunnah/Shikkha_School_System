<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\EmployeeSalary;
use App\Models\Message;
use App\Models\Teacher;
use App\Models\TeacherSalary;
use App\Traits\HttpResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SalaryController extends Controller
{
    use HttpResponse;

    /**
     * get salary history for Teacher
     * 
     * @param mixed $stafId
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     * 
     * @author Codecell Limited <support@codecell.com.bd>
     * @contributor Shahidul <contact.shahidul@gmail.com>
     * @createdAt July 10, 2023
     */
    public function getTeacherHistory($id)
    {
        try
        {
            $data = TeacherSalary::join('teachers as t', 't.id', 'teacher_salaries.teacher_id')
            ->select(
                't.salary as fixed_salary', 
                'teacher_salaries.month_name as month',
                'teacher_salaries.amount as paid_amount',
                'teacher_salaries.id',
                DB::raw('DATE_FORMAT(teacher_salaries.updated_at, "%d-%m-%Y") as last_updated_at')
            )
            ->where('teacher_salaries.school_id', Auth::id())
            ->where('teacher_salaries.teacher_id', $id)
            ->get()
            ->toArray();


            return $this->success('Data fetched successfully', $data);
        }
        catch(Exception $e)
        {
            return $this->error($e->getMessage());
        }
    }


    /**
     * update salary record for teacher
     * 
     * @param \Illuminate\Http\Request $request
     * @param mixed $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     * 
     * @author Codecell Limited <support@codecell.com.bd>
     * @contributor Shahidul <contact.shahidul@gmail.com>
     * @createdAt July 10, 2023
     * 
     */
    public function schoolTeacherSalaryUpdate(Request $request)
    {
        if (Auth::user()->status == 0) {
            return redirect()->route('school.payment.info');
        } elseif (Auth::user()->status == 2) {
            toast('Sorry Admin can Inactive Your Account Please Contact', 'error');
            return back();
        }
        
        try
        {
            $request->validate([
                'amount' => 'required'
            ]);
            
            $row = TeacherSalary::findOrFail($request->id);
            $teacher = Teacher::findOrFail($row->teacher_id);

            if($request->amount > $teacher->salary)
            {
                return $this->error('Invalid Amount', $request->except('_token'));
            }

            $row->amount += $request->amount;
            $row->save(); // update amount of salary

            // send notification to user phone
            $to = $teacher->phone;
            $message = "You received $request->amount tk from " . '(' . Auth::user()->school_name . ')';
            // Controller::GreenWebSMS($to, $message); // send sms

            $dataMessage = new Message();
            $dataMessage->school_id = Auth::user()->id;
            $dataMessage->message = 1;
            $dataMessage->send_number = $to;
            $dataMessage->save();

            return $this->success("Record updated successfully", ['id'=>$teacher->id]);
        }
        catch(Exception $e)
        {
            return $this->error($e->getMessage());
        }
    }



    /**
     * get salary history for staff
     * 
     * @param mixed $stafId
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     * 
     * @author Codecell Limited <support@codecell.com.bd>
     * @contributor Shahidul <contact.shahidul@gmail.com>
     * @createdAt July 09, 2023
     */
    public function getStaffHistory($stafId)
    {
        try
        {
            $data = EmployeeSalary::join('employees as e', 'e.id', 'employee_salaries.employee_id')
            ->select(
                'e.salary as fixed_salary', 
                'employee_salaries.month_name as month',
                'employee_salaries.amount as paid_amount',
                'employee_salaries.id',
                DB::raw('DATE_FORMAT(employee_salaries.updated_at, "%d-%m-%Y") as last_updated_at')
            )
            ->where('employee_salaries.school_id', Auth::id())
            ->where('employee_salaries.employee_id', $stafId)
            ->get()
            ->toArray();


            return $this->success('Data fetched successfully', $data);
        }
        catch(Exception $e)
        {
            return $this->error($e->getMessage());
        }
    }


    /**
     * update salary record
     * 
     * @param \Illuminate\Http\Request $request
     * @param mixed $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     * 
     * @author Codecell Limited <support@codecell.com.bd>
     * @contributor Shahidul <contact.shahidul@gmail.com>
     * @createdAt July 10, 2023
     * 
     */
    public function schoolStaffSalaryUpdate(Request $request)
    {
        if (Auth::user()->status == 0) {
            return redirect()->route('school.payment.info');
        } elseif (Auth::user()->status == 2) {
            toast('Sorry Admin can Inactive Your Account Please Contact', 'error');
            return back();
        }
        
        try
        {
            $payStaffSalary = EmployeeSalary::findOrFail($request->id);
            $staff = Employee::findOrFail($payStaffSalary->employee_id);

            if($request->amount > $staff->salary)
            {
                return $this->error('Invalid Amount', $request->except('_token'));
            }

            $payStaffSalary->amount += $request->amount;
            $payStaffSalary->save();

            
            $to = $staff->phone_number;
            $message = "You received $request->amount tk from " . '(' . Auth::user()->school_name . ')';
            Controller::GreenWebSMS($to, $message); // send sms

            $dataMessage = new Message();
            $dataMessage->school_id = Auth::user()->id;
            $dataMessage->message = 1;
            $dataMessage->send_number = $to;
            $dataMessage->save();

            return $this->success("Record updated successfully", ['staffId'=>$staff->id]);
        }
        catch(Exception $e)
        {
            return $this->error($e->getMessage());
        }
    }
}
