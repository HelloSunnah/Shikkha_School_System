<?php

namespace App\Http\Controllers;

use PDF;
use Session;
use Exception;
use DatePeriod;
use Carbon\Carbon;
use App\Models\Otp;
use App\Models\Term;
use App\Models\User;
use App\Models\Admin;
use App\Models\Asset;
use App\Models\Group;
use App\Models\Price;
use App\Models\Notice;
use App\Models\Result;
use App\Models\School;
use App\Helper\Utility;
use App\Models\Message;
use App\Models\Payment;
use App\Models\Routine;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Checkout;
use App\Models\Employee;
use App\Models\FeesType;
use App\Models\MarkType;
use App\Models\SEOModel;
use App\Models\Transfer;
use App\Models\SchoolFee;
use App\Models\StaffType;
use App\Models\Attendance;
use App\Models\Department;
use App\Models\StudentFee;
use App\Mail\InviteTeacher;
use App\Models\ClassPeriod;
use App\Models\ExamRoutine;
use App\Models\Testimonial;
use App\Models\Transection;
use Rats\Zkteco\Lib\ZKTeco;
use App\Imports\UsersImport;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use App\Models\AssignTeacher;
use App\Models\ClassSyllabus;
use App\Models\CommonSubject;
use App\Models\TeacherSalary;
use App\Models\WorkplaceInfo;
use App\Models\EmployeeSalary;
use App\Models\InstituteClass;
use App\Models\MessagePackage;
use App\Models\SchoolCheckout;
use App\Models\AssignStudentFee;
use App\Exports\AttendanceExport;
use App\Models\StudentMonthlyFee;
use Illuminate\Support\Facades\DB;
// use Excel;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\StudentDocumentUpload;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use App\Http\Requests\ResultCreatePost;
use Maatwebsite\Excel\Concerns\ToModel;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Testing\Fluent\Concerns\Has;
use App\Models\ResultSetting as ModelsResultSetting;
use App\Models\ResultSubjectCountableMark;
use Illuminate\Contracts\Session\Session as SessionSession;
use Illuminate\Support\Facades\Session as FacadesSession;
use Maatwebsite\Excel\Validators\ValidationException;
use function PHPUnit\Framework\returnSelf;


class SchoolController extends Controller
{

    use HttpResponse;

    public function pdfShow($student_id, $class_id, $month, $amount)
    {
        return view('frontend.school.pdf.invoice', compact('student_id', 'class_id', 'month', 'amount'));
    }

    public function StatementShowMessage($id)
    {
        $data = Checkout::where('id', $id)->first();
        return view('frontend.school.pdf.messagePayment', compact('data'));
    }

    public function StatementShowSchoolCheckout($id)
    {
        $data = Payment::where('id', $id)->first();
        return view('frontend.school.pdf.paymentpdf', compact('data'));
    }


    public function pclassDelete($id)
    {
        ResultSubjectCountableMark::where('institute_class_id', $id)->delete();

        User::withTrashed()->where('class_id', $id)->forcedelete();
        Routine::withTrashed()->where('class_id', $id)->forcedelete();
        ClassSyllabus::withTrashed()->where('class_id', $id)->forcedelete();
        Section::withTrashed()->where('class_id', $id)->forcedelete();
        Subject::withTrashed()->where('class_id', $id)->forcedelete();

        InstituteClass::withTrashed()->where('id', $id)->forcedelete();

        toast("Data delete permanently", "success");
        return back();
    }
    public function restoreclass($id)
    {
        Section::withTrashed()->where('class_id', $id)->restore();
        User::withTrashed()->where('class_id', $id)->restore();
        Subject::withTrashed()->where('class_id', $id)->restore();

        InstituteClass::withTrashed()->where('id', $id)->restore();

        toast("Restore data", "success");
        return back();
    }


    public function pSectionDelete($id)
    {
        Section::withTrashed()->where('id', $id)->forcedelete();
        toast("Data delete permanently", "success");
        return back();
    }
    public function restoreSection($id)
    {
        Section::withTrashed()->where('id', $id)->restore();
        toast("Restore data", "success");
        return back();
    }


    public function UserColor(Request $request)
    {
        $id = Auth::user()->id;
        $data = School::where('id', $id)->first();
        $data->color = $request->color;
        $data->save();
        return back();
    }

    public function school()
    {   
        if (Auth::user()->is_editor == 3) {
            $seoTitle = 'School Dashboard';
            $seoDescription = 'School Dashboard' ;
            $seoKeyword = 'School Dashboard' ;
            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
            ];
            $users = User::select(DB::raw("Count(*) as count"))->where('school_id', Auth::user()->id)->whereYear('created_at', date('Y'))
                ->groupby(DB::raw("Month(created_at)"))->pluck('count');

            $months = User::select(DB::raw("Month(created_at) as month"))->where('school_id', Auth::user()->id)->whereYear('created_at', date('Y'))
                ->groupby(DB::raw("Month(created_at)"))->pluck('month');
            //dd($months);
            $datas = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

            foreach ($months as $index => $month) {
               $datas[$month] = $users[$index];
            }
            $defaultDate = Carbon::today()->format('d-M-Y');
            $incomeAmount = StudentMonthlyFee::select(DB::raw("sum(amount) as sum"))
                ->where('school_id', Auth::user()->id)
                ->whereYear('created_at', date('Y'))
                ->groupBy('month_name')
                // ->orderBy('id','asc')
                ->pluck('sum');
            $totalTeacher=Teacher::where('school_id',Auth::user()->id)->get()->count();
             $totalAuthor=School::where('id',Auth::user()->id)->get()->count();
            $totalStudent=User::where('school_id',Auth::user()->id)->get()->count();
            $incomeMonths = StudentMonthlyFee::select(DB::raw("month_name as month"))
                ->where('school_id', Auth::user()->id)
                ->whereYear('created_at', date('Y'))
                // ->orderby('id','asc')
                ->groupby('month_name')->pluck('month');

            $incomeDatas = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

            foreach ($incomeMonths as $index => $incomeMonth) {
                $incomeDatas[date("n", strtotime($incomeMonth)) - 1] = $incomeAmount[$index];
            }
               $exAmount = EmployeeSalary::select(DB::raw("sum(amount) as sum"))
                ->where('school_id', Auth::user()->id)
                ->whereYear('created_at', date('Y'))
                // ->orderby('id','desc')
                ->groupby('month_name')->pluck('sum');
                   $staffAmount = TeacherSalary::select(DB::raw("sum(amount) as sum"))
                ->where('school_id', Auth::user()->id)
                ->whereYear('created_at', date('Y'))
                // ->orderby('id','desc')
                ->groupby('month_name')->pluck('sum');
             $transection=Transection::where('school_id', Auth::user()->id)->where('type',1)
            ->whereYear('created_at', date('Y'))->get()->sum('amount');
            $exMonths = EmployeeSalary::select(DB::raw("month_name as month"))
                ->where('school_id', Auth::user()->id)
                ->whereYear('created_at', date('Y'))
                // ->orderby('id','desc')
                ->groupby('month_name')->pluck('month');
            $exDatas = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

            foreach ($exMonths as $index => $exMonth) {
                $exDatas[date("n", strtotime($exMonth)) - 1] = $exAmount[$index] + $staffAmount[$index];
            }
            //  dd($exDatas);

            return view('school', compact('datas','totalStudent','totalAuthor','totalTeacher', 'incomeDatas', 'exDatas', 'defaultDate','seo_array'));
        } else {
            return back();
        }
    }

    public function schoolPaymentShow()
    {
        return view('frontend.school.payment');
    }

    public function schoolPackageAfter()
    {
        return view('frontend.school.school_package.package');
    }

    public function schoolPackageAfterPost(Request $request)
    {
        $id = $request->message_package_id;
        $messagePackageInfo = WorkplaceInfo::where('school_id', Auth::user()->id)->first();
        $messagePackageInfo->price_id = $id;
        $messagePackageInfo->save();
        return redirect()->route('school.payment.info');
    }

    public function schoolPaymentStatementShow()
    {
        $rows = Payment::where('school_id', Auth::user()->id)->latest()->get();
        return view('frontend.school.paymentStatus', compact('rows'));
    }


    public function schoolMessage()
    {   
        $seoTitle = 'SMS Purchase';
        $seoDescription = 'SMS Purchase' ;
        $seoKeyword = 'SMS Purchase' ;
        $seo_array = [
            'seoTitle' => $seoTitle,
            'seoKeyword' => $seoKeyword,
            'seoDescription' => $seoDescription,
        ];
        return view('frontend.school.message.package',compact('seo_array'));
    }

    public function schoolMessagePost(Request $request)
    {
        $school = school::find(Auth::user()->id);

        // $school->update([
        //     'message_package_id'=>$request->message_package_id],
        // );

        $id = $request->message_package_id;
        $messagePackageInfo = MessagePackage::where('id', $id)->first();
        return view('frontend.school.message.packageCheckoutShow', compact('messagePackageInfo'));
    }

    public function schoolMessagePostCheckout(Request $request)
    {
        $data = new Checkout();
        $data->school_id = Auth::user()->id;
        $data->package_name = $request->package_name;
        $data->package_price = $request->package_price;
        $data->package_quantity = $request->package_quantity;
        $data->gateway_type = $request->select;
        $data->gateway_number = $request->gateway_number;
        $data->transaction_number = $request->transaction_number;

        $messageData = $data->save();

        if ($messageData) {
            Alert::success('Successfully Payment Submitted', 'Success Message');
        }
        return redirect()->route('school.dashboard');
    }

    public function StatementShow()
    {
        if (Auth::user()->is_editor != 3) {
            return back();
        } else {
            $classText = 'Payment Details';
            $seoTitle = 'Payment Details';
            $seoDescription = 'Payment Details' ;
            $seoKeyword = 'Payment Details' ;
            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
            ];
            $class = Checkout::orderby('id', 'desc')->where('school_id', Auth::user()->id)->get();
            return view('frontend.school.message.statementShow', compact('class', 'seo_array', 'classText'));
        }
    }

    public function otpLogin()
    {
        $data = School::where('email', Auth::user()->email)->first();
        $to_email = $data->email;
        $to = $data->phone_number;
        $to_password = $data->password;
        return view('frontend.pages.otpLogin', compact('to', 'to_email', 'to_password'));
    }

    public function otpPostLogin(Request $request)
    {
        $request->otp = $request->otp1 . $request->otp2 . $request->otp3 . $request->otp4;
        //dd($request->otp);
        $school = School::where('phone_number', $request->phone_number)->where('email', $request->email)->first();
        $otp = Otp::where('phone', $request->phone_number)->where('email', $request->email)->first();
        if ($otp->otp == $request->otp) {
            $school->is_editor = 1;
            $school->save();
            $otp->delete();

            // store month for school
            $month = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

            foreach ($month as $iteration => $data) {
                $monthFunction = date('m');
                if ($iteration + 1 > $monthFunction) {
                    $fees = new SchoolFee();
                    $fees->month_name = $data;
                    $fees->month_id = $iteration + 1;
                    $fees->school_id = Auth::user()->id;
                    $fees->save();
                }
            }

            // store class
            // for($i=1;$i<11;$i++){
            //     $class = new InstituteClass();
            //     $class->class_name = 'class '.$i;
            //     $class->class_fees = 0;
            //     $class->active = 1;
            //     $class->school_id = Auth::user()->id;
            //     $class->save();

            //     // store section
            //         $section = new Section();
            //         $section->section_name ='Section A';
            //         $section->class_id = $class->id;
            //         $section->active = 1;
            //         $section->school_id = Auth::user()->id;
            //         $section->save();
            // }

            // $department = defaultSubject();

            // foreach($department as $dept)
            // {
            //     $department = new Department();
            //     $department->department_name = $dept;
            //     $department->active = 1;
            //     $department->school_id = Auth::user()->id;
            //     $department->save();
            // }

            return redirect()->route('acquisition');
        } else {
            return redirect()->route('otp.login');
        }
    }

    public function acquisition()
    {
        if (Auth::user()->is_editor != 1) {
            return back();
        } else {
            $seoTitle = SEOModel::where('page_no','=','18')->first()->title;
            $seoDescription = SEOModel::where('page_no','=','18')->first()->description;
            $seoKeyword = SEOModel::where('page_no','=','18')->first()->keyword;
            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
            ];
            return view('frontend.pages.acquisition', compact('seo_array'));
        }
    }

    public function acquisitionPost(Request $request)
    {

        $workplaceinfo = new WorkplaceInfo();

        $workplaceinfo->workspace_name = $request->workspace_name;
        $workplaceinfo->student = $request->student;
        $workplaceinfo->teachers = $request->teachers;
        $workplaceinfo->hear_us = $request->hear_us;
        $workplaceinfo->school_id = Auth::user()->id;

        $workplaceinfo->save();

        $school = School::where('id', Auth::user()->id)->first();
        $school->is_editor = 2;
        $school->save();

        toast('Success Workplace Uploaded', 'success');
        return redirect()->route('price.suggest', $workplaceinfo->id);
    }

    public function selectPricePost(Request $request)
    {

        $request->validate([
            'select' => 'required',
        ]);

        // set workplace
        $workPlace = WorkplaceInfo::where('id', $request->id)->first();
        $workPlace->price_id = is_null($request->select) ? 0 : $request->select;
        $workPlace->save();
        $school = School::where('id', Auth::user()->id)->first();
        $school->is_editor = 3;
        $school->save();

        toast('Success Workplace Uploaded', 'success');
        return redirect()->route('settings');
    }

    public function priceSuggest($id)
    {
        if (getSchoolData()->is_editor == 2) {
            $workplace = WorkplaceInfo::where('id', $id)->first();
            $student = substr($workplace->student, 2);
            $teachers = substr($workplace->teachers, 2);
            //$price = Price::orwhere('student','>=', (int)$student)->where('id','!=',0)->orderby('student','desc')->get();
            $price = Price::get();
            $seoTitle = SEOModel::where('page_no','=','8')->first()->title;
            $seoDescription = SEOModel::where('page_no','=','8')->first()->description;
            $seoKeyword = SEOModel::where('page_no','=','8')->first()->keyword;
            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
            ];
            return view('frontend.pages.selectPricePage', compact('price', 'id','seo_array'));
        } else {
            return redirect()->route('acquisition');
        }
    }

    public function termCreate()
    {
        if (Auth::user()->status == 0) {
            return redirect()->route('school.payment.info');
        } elseif (Auth::user()->status == 0) {
            toast('Sorry Admin can Inactive Your Account Please Contact', 'error');
        }
        if (Auth::user()->is_editor != 3) {
            return back();
        } else {
            $url = url()->previous();
            $urlTeacherData = url('/') . '/school/' . session('dataSession');
            if ($url == $urlTeacherData) {
                $urlTeacher = $urlTeacherData;
            } else {
                $urlTeacher = '';
            }
            $classText = 'Term Input create';
            $seoTitle = 'Term Create';
            $seoDescription = 'Term Create';
            $seoKeyword = 'Term Create';
            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
                'urlTeacher' => $urlTeacher,
            ];
            return view('frontend.school.student.result.term.create', compact('classText', 'seo_array'));
        }
    }

    public function termCreatePost(Request $request)
    {
        // dd($request->url_check);
        $request->validate([
            'term_name' => 'required',
        ]);
        $class = new Term();

        $class->term_name = $request->term_name;
        $class->active = (is_null($request->active) ? 0 : $request->active);
        $class->school_id = Auth::user()->id;
        $class->save();
        toast('Successfully Term Created', 'success');
        return redirect()->route('term.show');
    }

    public function termShow()
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
            $classText = 'Term Show';
            $seoTitle = 'Term Show';
            $seoDescription = 'Term Show';
            $seoKeyword = 'Term Show';
            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
            ];
            $class = Term::orderby('id', 'desc')->where('school_id', Auth::user()->id)->get();
            return view('frontend.school.student.result.term.show', compact('class', 'seo_array', 'classText'));
        }
    }

    public function termEdit($id)
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
            $classText = 'Class Input Edit';
            $seoTitle = 'Term Show';
            $seoDescription = 'Term Show';
            $seoKeyword = 'Term Show';
            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
            ];
            $classEdit = Term::find($id);
            return view('frontend.school.student.result.term.create', compact('classEdit', 'seo_array', 'classText'));
        }
    }

    public function termUpdatePost(Request $request, $id)
    {
        if (Auth::user()->status == 0) {
            return redirect()->route('school.payment.info');
        } elseif (Auth::user()->status == 2) {
            toast('Sorry Admin can Inactive Your Account Please Contact', 'error');
            return back();
        }
        $request->validate([
            'term_name' => 'required',
        ]);
        $class = Term::find($id);

        $class->term_name = $request->term_name;
        $class->active = (is_null($request->active) ? 0 : $request->active);
        $class->school_id = Auth::user()->id;
        $class->save();
        Alert::success('Success Term Updated', 'Success Message');
        return redirect()->route('term.show');
    }

    public function termDelete($id)
    {
        if (Auth::user()->status == 0) {
            return redirect()->route('school.payment.info');
        } elseif (Auth::user()->status == 2) {
            toast('Sorry Admin can Inactive Your Account Please Contact', 'error');
            return back();
        }
        //   $studentFees = StudentFee::where('class_id',$id)->delete();
        $class = Term::where('id', $id)->delete();
        Alert::error('Success Term Deleted', 'Success Message');
        return back();
    }

    public function classCreate()
    {
        if (Auth::user()->status == 0) {
            return redirect()->route('school.payment.info');
        } elseif (Auth::user()->status == 0) {
            toast('Sorry Admin can Inactive Your Account Please Contact', 'error');
        }
        if (Auth::user()->is_editor != 3) {
            return back();
        } else {
            $url = url()->previous();
            $urlTeacherData = url('/') . '/school/' . session('dataSession');
            if ($url == $urlTeacherData) {
                $urlTeacher = $urlTeacherData;
            } else {
                $urlTeacher = '';
            }
            $classText = 'Class Input create';
            $seoTitle = 'Class Create';
            $seoDescription = 'Class Create';
            $seoKeyword = 'Class Create';
            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
                'urlTeacher' => $urlTeacher,
            ];
            return view('frontend.school.class.create', compact('classText', 'seo_array'));
        }
    }

    public function classCreatePost(Request $request)
    {
        // dd($request->url_check);
        $request->validate([
            'class_name' => 'required',
            'class_name_bn' => 'required',

        ]);
        $class_name = 'Class ' . $request->class_name;
        $dataClass = InstituteClass::where('class_name', $class_name)->where('school_id', Auth::user()->id)->count();
        if ($dataClass == 0) {
            $class = new InstituteClass();

            $class->class_name = $request->class_name;
            $class->class_name_bn = $request->class_name_bn;
            $class->class_fees = $request->class_fees;
            $class->active = (is_null($request->active) ? 0 : $request->active);
            $class->school_id = Auth::user()->id;
            $class->save();
            toast('Successfully Class Created', 'success');
            if (!is_null($request->url_check)) {
                if ($request->url_check == url('/') . '/school/section/create') {
                    return redirect()->route('section.create');
                } else {
                    return redirect()->route('group.create');
                }
            } else {
                return redirect()->route('class.show');
            }
        } else {
            toast('This class name already exits', 'error');
            return redirect()->route('class.show');
        }
    }

    public function classShow()
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
            $classText = 'Class Show';
            $seoTitle = 'Class Show  ';
            $seoDescription = 'Class Show ';
            $seoKeyword = 'Class Show  ';
            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
            ];
            $class = InstituteClass::orderby('id', 'Asc')->where('school_id', Auth::user()->id)->get();
            return view('frontend.school.class.show', compact('class', 'seo_array', 'classText'));
        }
    }

    public function classEdit($id)
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
            $classText = 'Class Input Edit';
            $seoTitle = 'Class Show';
            $seoDescription = 'Class Show';
            $seoKeyword = 'Class Show';
            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
            ];
            $classEdit = InstituteClass::find($id);
            return view('frontend.school.class.create', compact('classEdit', 'seo_array', 'classText'));
        }
    }

    public function classUpdatePost(Request $request, $id)
    {
        //  return request();
        if (Auth::user()->status == 0) {
            return redirect()->route('school.payment.info');
        } elseif (Auth::user()->status == 2) {
            toast('Sorry Admin can Inactive Your Account Please Contact', 'error');
            return back();
        }
        $request->validate([
            'class_name' => 'required',
        ]);
        $class_name = $request->class_name;
        $dataClass = InstituteClass::where('id', '!=', $id)->where('class_name', $class_name)->where('school_id', Auth::user()->id)->count();
        if ($dataClass == 0) {
            $class = InstituteClass::find($id);
            $class->class_name = $request->class_name;
            $class->class_name_bn = $request->class_name_bn ?? $class->class_name_bn;
            $class->class_fees = $request->class_fees;
            $class->active = (is_null($request->active) ? 0 : $request->active);
            $class->school_id = Auth::user()->id;
            $class->save();
            Alert::success('Success Class Updated', 'Success Message');
            return redirect()->route('class.show');
        } else {
            toast('This class name already exits', 'error');
            return redirect()->route('class.show');
        }
    }

    public function classDelete($id)
    {
        if (Auth::user()->status == 0) {
            return redirect()->route('school.payment.info');
        } elseif (Auth::user()->status == 2) {
            toast('Sorry Admin can Inactive Your Account Please Contact', 'error');
            return back();
        }
        $resultcount = ResultSubjectCountableMark::where('institute_class_id', $id)->delete();

        $student = User::where('class_id', $id)->delete();
        $routine = Routine::where('class_id', $id)->delete();
        $syllabus = ClassSyllabus::where('class_id', $id)->delete();
        $section = Section::where('class_id', $id)->delete();
        $studentFees = StudentFee::where('class_id', $id)->delete();

        $class = InstituteClass::where('id', $id)->delete();
        Alert::error('Successfully Class Deleted', 'Success Message');
        return back();
    }
    public function class_Check_Delete(Request $request)
    {
        $ids=$request->ids;
        StudentFee::whereIn('class_id',$ids)->delete();
        InstituteClass::whereIn('id', $ids)->delete();
        Alert::success(' Selected Class are deleted', 'Success Message');
        return response()->json(['status'=>'success']);
    }

    public function sectionCreate()
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
            $url = url()->previous();
            $urlTeacherData = url('/') . '/school/' . session('dataSession');
            if ($url == $urlTeacherData) {
                $urlTeacher = $urlTeacherData;
            } else {
                $urlTeacher = '';
            }
            $class = InstituteClass::where('school_id', Auth::user()->id)->where('school_id', Auth::user()->id)->get();
            $sectionText = 'Section Input create';
            $seoTitle = 'Section Create';
            $seoDescription = 'Section Create';
            $seoKeyword = 'Section Create';
            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
                'urlTeacher' => $urlTeacher,
            ];
            return view('frontend.school.section.create', compact('sectionText', 'seo_array', 'class'));
        }
    }

    public function sectionCreatePost(Request $request)
    {
        if (Auth::user()->status == 0) {
            return redirect()->route('school.payment.info');
        } elseif (Auth::user()->status == 2) {
            toast('Sorry Admin can Inactive Your Account Please Contact', 'error');
            return back();
        }
        if ($request->url_check_section == 'section/create') {
            $value = $request->session()->put('dataSession', $request->url_check_section);
            return redirect()->route('class.create');
        } else {
            $request->validate([
                'class_id' => 'required',
                'section_name' => 'required',
            ]);
            $section_name = $request->section_name;
            $sectionData = Section::where('class_id', $request->class_id)->where('section_name', 'LIKE', "%{$section_name}%")->first();
            if (isset($sectionData)) {
                toast('Oops ! Class name and section must be different', 'error');
                return back();
            } else {
                $class = new Section();

                $class->class_id = $request->class_id;
                $class->section_name = 'Section ' . $request->section_name;
                $class->active = (is_null($request->active) ? 0 : $request->active);
                $class->school_id = Auth::user()->id;
                $class->save();
                Alert::success('Success Section Created', 'Success Message');
                if ($request->url_check == url('/') . '/school/group/create') {
                    return redirect()->route('group.create');
                } else {
                    return redirect()->route('section.show');
                }
            }
        }
    }

    /**
     * Save Section with ajax
     * 
     * @author CodeCell <support@codecell.com.bd>
     * @contributor Sajjad <sajjad.develpr@gmail.com>
     * @param Request
     * @param $request
     * @modified 05-07-23
     * @return \Illuminate\Http\Response|
     */
    public function sectionCreatePostAjax(Request $request)
    {   
        $validator = Validator::make($request->all(),[
            'class_id' => 'required',
            'section_name' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $section_name = 'Section ' . $request->section_name;
        $sectionData = Section::where('class_id', $request->class_id)->where('section_name', 'LIKE', "%{$section_name}%")->first();
        if (isset($sectionData)) {
            return response()->json(['status' => "available"]);
        } else {
            $class = new Section();

            $class->class_id = $request->class_id;
            $class->section_name = 'Section ' . $request->section_name;
            $class->active = (is_null($request->active) ? 0 : $request->active);
            $class->school_id = Auth::user()->id;
            $class->save();
            
            return response()->json(['status' => 'success']);
        }
    }

    public function sectionShow()
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
            $sectionText = 'Section Show';
            $seoTitle = 'Section Show';
            $seoDescription = 'Section Show';
            $seoKeyword = 'Section Show';
            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
            ];
           $section = Section::orderby('id', 'desc')->where('school_id', Auth::user()->id)->get();
            return view('frontend.school.section.show', compact('section', 'seo_array', 'sectionText'));
        }
    }

    public function sectionEdit($id)
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
            $sectionText = 'Section Input Edit';
            $seoTitle = 'Section Show';
            $seoDescription = 'Section Show';
            $seoKeyword = 'Section Show';
            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
            ];
            $class = InstituteClass::where('school_id', Auth::user()->id)->get();
            $sectionEdit = Section::find($id);
            return view('frontend.school.section.create', compact('class', 'sectionEdit', 'seo_array', 'sectionText'));
        }
    }

    public function sectionUpdatePost(Request $request, $id)
    {
        if (Auth::user()->status == 0) {
            return redirect()->route('school.payment.info');
        } elseif (Auth::user()->status == 2) {
            toast('Sorry Admin can Inactive Your Account Please Contact', 'error');
            return back();
        }
        $request->validate([
            'class_id' => 'required',
            'section_name' => 'required',
        ]);
        $class = Section::find($id);

        $class->class_id = $request->class_id;
        $class->section_name = $request->section_name;
        $class->active = (is_null($request->active) ? 0 : $request->active);
        $class->school_id = Auth::user()->id;
        $class->save();
        toast('Successfully Section Updated', 'success');
        return redirect()->route('section.show');
    }

    public function sectionDelete($id)
    {
        if (Auth::user()->status == 0) {
            return redirect()->route('school.payment.info');
        } elseif (Auth::user()->status == 2) {
            toast('Sorry Admin can Inactive Your Account Please Contact', 'error');
            return back();
        }
        $class = Section::where('id', $id)->delete();
        Alert::error('Success Section Deleted', 'Success Message');
        return back();
    }

    public function groupCreate()
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

            $class = InstituteClass::where('school_id', Auth::user()->id)->get();
            $section = Section::where('school_id', Auth::user()->id)->get();
            $groupText = 'Group Input create';
            $seoTitle = 'Group Create';
            $seoDescription = 'Group Create';
            $seoKeyword = 'Group Create';
            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
            ];
            return view('frontend.school.group.create', compact('groupText', 'seo_array', 'class', 'section'));
        }
    }

    /**
     * Create Group (Sajjad Devel)
     *
     * @param Request
     * @param $request
     * @return \Illuminate\Routing\Redirector
     */
    public function groupCreatePost(Request $request)
    {
        if (Auth::user()->status == 0) {
            return redirect()->route('school.payment.info');
        } elseif (Auth::user()->status == 2) {
            toast('Sorry Admin can Inactive Your Account Please Contact', 'error');
            return back();
        }
        if ($request->url_check == 'group/create/class') {
            $request->url_check = 'group/create';
            $value = $request->session()->put('dataSession', $request->url_check);
            return redirect()->route('class.create');
        } elseif ($request->url_check2 == 'group/create/section') {
            $request->url_check2 = 'group/create';
            $value = $request->session()->put('dataSession', $request->url_check2);
            return redirect()->route('section.create');
        } else {

            $request->validate([
                'class_id' => 'required',
                'group_name' => 'required',
            ]);

            $sectionData = Group::where('class_id', $request->class_id)->where('section_id', $request->section_id)->where('group_name', 'LIKE', "%{$request->group_name}%")->first();
            if (isset($sectionData)) {
                toast('Oops ! Class Name , Section Name and Group Name must be different', 'error');
                return back();
            }

            $class = new Group();

            $class->class_id = $request->class_id;
            $class->group_name = $request->group_name;
            $class->school_id = Auth::user()->id;
            $class->save();
            toast('Successfully Group Created', 'success');
            return redirect()->route('group.show');
        }
    }

    public function groupShow()
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
            $groupText = 'Group Show';
            $seoTitle = 'Group Show';
            $seoDescription = 'Group Show';
            $seoKeyword = 'Group Show';
            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
            ];
            $group = Group::orderby('id', 'desc')->where('school_id', Auth::user()->id)->get();
            return view('frontend.school.group.show', compact('group', 'seo_array', 'groupText'));
        }
    }

    public function groupEdit($id)
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
            $groupText = 'Section Input Edit';
            $seoTitle = 'Group Show';
            $seoDescription = 'Group Show';
            $seoKeyword = 'Group Show';
            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
            ];
            $class = InstituteClass::where('school_id', Auth::user()->id)->where('school_id', Auth::user()->id)->get();
            $sectionEdit = Group::find($id);
            return view('frontend.school.group.create', compact('class', 'sectionEdit', 'seo_array', 'groupText'));
        }
    }

    /**
     * Update Group (Sajjad Devel)
     *
     * @param Request
     * @param $request
     * @param $id
     * @return \Illuminate\Routing\Redirector
     */
    public function groupUpdatePost(Request $request, $id)
    {
        if (Auth::user()->status == 0) {
            return redirect()->route('school.payment.info');
        } elseif (Auth::user()->status == 2) {
            toast('Sorry Admin can Inactive Your Account Please Contact', 'error');
            return back();
        }
        $request->validate([
            'class_id' => 'required',
            'group_name' => 'required',
        ]);
        $class = Group::find($id);

        $class->class_id = $request->class_id;
        $class->group_name = $request->group_name;
        $class->school_id = Auth::user()->id;
        $class->save();
        toast('Group Updated Successfully', 'success');
        return redirect()->route('group.show');
    }

    public function groupDelete($id)
    {
        if (Auth::user()->status == 0) {
            return redirect()->route('school.payment.info');
        } elseif (Auth::user()->status == 2) {
            toast('Sorry Admin can Inactive Your Account Please Contact', 'error');
            return back();
        }
        $class = Group::where('id', $id)->delete();
        Alert::error('Success Group Delete', 'Success Message');
        return back();
    }


    public function subjectCreateShow()
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
            $class = InstituteClass::where('school_id', Auth::user()->id)->get();
            $section = Section::where('school_id', Auth::user()->id)->get();
            $group = Group::where('school_id', Auth::user()->id)->get();
            $subjectText = 'Subject Show';
            $seoTitle = 'Subject Show';
            $seoDescription = 'Subject Show';
            $seoKeyword = 'Subject Show';
            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
            ];
            return view('frontend.school.subject.createShow', compact('subjectText', 'seo_array', 'class', 'section', 'group'));
        }
    }

    public function subjectCreateShowPost(Request $request)
    {
        if (Auth::user()->status == 0) {
            return redirect()->route('school.payment.info');
        } elseif (Auth::user()->status == 2) {
            toast('Sorry Admin can Inactive Your Account Please Contact', 'error');
            return back();
        }
        //dd($request->all());
        if (Auth::user()->is_editor != 3) {
            return back();
        } else {
            $request->validate([
                'class_id' => 'required',

            ]);
            $class_id = $request->class_id;
            // $section_id = $request->section_id;
            // $group_id = is_null($request->group_id) ? 0 : $request->group_id;

            return redirect()->route('subject.subjectShow', ['class_id' => $class_id]);
        }
    }

    /**
     * Show Subject
     * 
     * @author CodeCell <support@codecell.com.bd>
     * @contributor Sajjad <sajjad.develpr@gmail.com>
     * @param int $class_id
     * @modified 06-07-23
     * 
     * @return \Illuminate\Contracts\View\View
     */
    public function subjectShow($class_id)
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
            // $group_id = ($group_id == 0) ? NULL : $group_id;
            $thisClass = InstituteClass::findOrFail($class_id);
            $dataShow = Subject::where('class_id', $class_id)->get();
            $subjectText = 'Subject Input create';
            $seoTitle = 'Subject Show';
            $seoDescription = 'Subject Show';
            $seoKeyword = 'Subject Show';
            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
            ];
            
            return view('frontend.school.subject.show', compact('subjectText', 'seo_array', 'dataShow', 'class_id', 'thisClass'));
        }
    }

    /**
     * Save Subject 
     * 
     * @param Request 
     * @param $request
     * @author CodeCell <support@codecell.com.bd>
     * @contributor Sajjad <sajjad.develpr@gmail.com>
     * @return mixed
     */
    public function subjectCreatePost(Request $request)
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
            $class = InstituteClass::findOrFail($request->class_id);
            if (in_array($class->class_name, classFilter())) {
                $request->validate([
                    "subject_name"  => 'required',
                    "subject_code"  => 'required|numeric',
                    "group_id"      => 'required'
                ]);
            }

            $request->validate([
                'subject_name' => 'required',
            ]);

            if ($request->subject_code != null) {
                $request->validate([
                    'subject_code' => 'required|numeric',
                ]);

                $existCode = Subject::where(['class_id' => $request->class_id, 'subject_code' => $request->subject_code, "school_id" => Auth::user()->id])->exists();
                if ($existCode) {
                    toast("This subject code is already exist", "info");
                    return back()->withInput();
                }
            }

            $data = Subject::where('class_id', $request->class_id)->where('section_id', $request->section_id)->where('group_id', $request->group_id)->where('subject_name', $request->subject_name)->count();
            if ($data == 0) {
                $class = new Subject();
                $class->class_id = $request->class_id;
                $class->section_id = $request->section_id;
                $class->group_id = $request->group_id;
                $class->subject_code = $request->subject_code;
                $class->subject_name = $request->subject_name;
                $class->active = (is_null($request->active) ? 0 : $request->active);
                $class->school_id = Auth::user()->id;
                $class->save();

                $class_id = $request->class_id;
                $section_id = $request->section_id;
                $group_id = is_null($request->group_id) ? 0 : $request->group_id;

                toast('Subject Save Successfully', 'success');
                return redirect()->route('subject.subjectShow', ['class_id' => $class_id, 'section_id' => $section_id, 'group_id' => $group_id]);
            } else {
                toast('This subject already exits', 'error');
                return back();
            }
        }
    }

    /**
     * Subject Update
     * 
     * @author CodeCell <suppor@codecell.com.bd>
     * @contributor Sajjad <sajjad.develpr@gmail.com>
     * @param Request
     * @param $request
     * @param int $id
     * @modified 05-07-23
     * @modifier 05-07-2023
     * 
     * @return mixed
     */
    public function subjectUpdatePost(Request $request, $id)
    {   
        if (Auth::user()->status == 0) {
            return redirect()->route('school.payment.info');
        } elseif (Auth::user()->status == 2) {
            toast('Sorry Admin can Inactive Your Account Please Contact', 'error');
            return back();
        }

        $request->validate([
            'subject_name' => 'required',
            'class_id'     => 'required',
        ]);

        $subject = Subject::find($id);

        if ($request->subject_code != null) {
            $request->validate([
                'subject_code' => 'required|numeric',
            ]);

            $existCode = Subject::where('class_id', $request->class_id)
                                ->where('subject_code', $request->subject_code)
                                ->where('subject_code', '!=', $subject->subject_code)
                                ->exists();
                               
            if ($existCode) {
                toast("This subject code is already exist", "info");
                return back();
            }
        }

        $subject->class_id = $request->class_id;
        $subject->subject_code = $request->subject_code;
        $subject->group_id     = $request->group_id;
        $subject->subject_name = $request->subject_name;
        $subject->school_id = Auth::user()->id;
        $subject->save();

        $class_id = $request->class_id;
        Alert::success('Subject Update Successfully', 'Success Message');
        return redirect()->route('subject.subjectShow', ['class_id' => $class_id]);
    }

    /**
     * Edit Subject
     * 
     * @param int $id
     * @author CodeCell <support@codecell.com.bd>
     * @contributor Sajjad <sajjad.develpr@gmai.com>
     * @modified 05-07-23
     * @return \Illuminate\Contracts\View\View
     */
    public function subjectEditPost($id)
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
            $subject = Subject::where('id', $id)->first();
            
            $section = Section::where('school_id', Auth::user()->id)->get();
            $group = Group::where('school_id', Auth::user()->id)->get();
            $thisClass = InstituteClass::findOrFail($subject->class_id); 
            $subjectText = 'Subject Input create';
            $seoTitle = 'Subject Show';
            $seoDescription = 'Subject Show';
            $seoKeyword = 'Subject Show';
            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
            ];

            return view('frontend.school.subject.edit', compact('subject', 'seo_array', 'subjectText', 'thisClass', 'section', 'group'));
        }
    }

    public function subjectDeletePost($id, $class_id)
    {
        if (Auth::user()->status == 0) {
            return redirect()->route('school.payment.info');
        } elseif (Auth::user()->status == 2) {
            toast('Sorry Admin can Inactive Your Account Please Contact', 'error');
            return back();
        }

        $delete = Subject::where('id', $id)->delete();
        $class_ids = $class_id;
        Alert::error('Success Subject deleted', 'Success Message');
        return redirect()->route('subject.subjectShow', ['class_id' => $class_ids]);
    }


    public function departmentCreate()
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
            $url = url()->previous();
            $urlTeacherData = url('/') . '/school/' . session('dataSession');
            if ($url == $urlTeacherData) {
                $urlTeacher = $urlTeacherData;
            } else {
                $urlTeacher = '';
            }
            $classText = 'department Input create';
            $seoTitle = 'department';
            $seoDescription = 'department';
            $seoKeyword = 'department';
            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
                'urlTeacher' => $urlTeacher,
            ];


            return view('frontend.school.department.create', compact('classText', 'seo_array'));
        }
    }


    public function departmentCreatePost(Request $request)
    {
        if (Auth::user()->status == 0) {
            return redirect()->route('school.payment.info');
        } elseif (Auth::user()->status == 2) {
            toast('Sorry Admin can Inactive Your Account Please Contact', 'error');
            return back();
        }
        $request->validate([
            'department_name' => 'required',
        ]);
        $class = new Department();

        $class->department_name = $request->department_name;
        $class->active = (is_null($request->active) ? 0 : $request->active);
        $class->school_id = Auth::user()->id;
        $class->save();
        toast('Success Department created', 'success');
        if (!is_null($request->url_check)) {
            return redirect()->route('teacher.create');
        } else {
            return redirect()->route('department.show');
        }
    }

    public function departmentShow()
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
            $classText = 'Department Show';
            $seoTitle = 'Department';
            $seoDescription = 'Department';
            $seoKeyword = 'Department';
            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
            ];
            $class = Department::orderby('id', 'desc')->where('school_id', Auth::user()->id)->get();
            return view('frontend.school.department.show', compact('class', 'seo_array', 'classText'));
        }
    }

    public function departmentEdit($id)
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
            $classText = 'Department Input Edit';
            $seoTitle = 'Department';
            $seoDescription = 'Department';
            $seoKeyword = 'Department';
            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
            ];
            $classEdit = Department::find($id);
            return view('frontend.school.department.create', compact('classEdit', 'seo_array', 'classText'));
        }
    }

    public function departmentUpdatePost(Request $request, $id)
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
                'department_name' => 'required',
            ]);
            $class = Department::find($id);

            $class->department_name = $request->department_name;
            $class->active = (is_null($request->active) ? 0 : $request->active);
            $class->school_id = Auth::user()->id;
            $class->save();
            toast('Success Department updated', 'success');
            return redirect()->route('department.show');
        }
    }

    public function departmentDelete($id)
    {
        if (Auth::user()->status == 0) {
            return redirect()->route('school.payment.info');
        } elseif (Auth::user()->status == 2) {
            toast('Sorry Admin can Inactive Your Account Please Contact', 'error');
            return back();
        }
        $class = Department::where('id', $id)->delete();
        toast('Success Department deleted', 'error');
        return back();
    }

    public function teacherCreate()
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
            $class = InstituteClass::where('school_id', Auth::user()->id)->get();
            $section = Section::where('school_id', Auth::user()->id)->get();
            $department = Department::where('active', 1)->get();
            $teacherText = 'Teacher Show';
            $seoTitle = 'Teacher Create';
            $seoDescription = 'Teacher Create';
            $seoKeyword = 'Teacher Create';
            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
            ];
            return view('frontend.school.teacher.create', compact('teacherText', 'seo_array', 'class', 'section', 'department'));
        }
    }


    /**-------------------  Create School Teacher
     * =================================================*/
    public function teacherCreatePost(Request $request)
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
            if ($request->url_check == 'teacher/create') {
                $value = $request->session()->put('dataSession', $request->url_check);
                return redirect()->route('department.create');
            }
            $request->validate([
                'full_name' => 'required',
                'email' => 'required|unique:teachers,email,'.Auth::id().'school_id|email',
                'phone' => 'required|unique:teachers,phone,'.Auth::id().'school_id|numeric|digits:11',
                'address' => 'required',
                'salary' => 'numeric',
                'designation' => 'required',
                'gender' => 'required',
            ]);

            $fileName = null;
            if ($request->hasFile('image')) {
                $fileName = time() . '.' . $request->file('image')->getclientOriginalExtension();
                $request->file('image')->move(public_path('/uploads/teacher'), $fileName);
                $fileName = "/uploads/teacher/" . $fileName;
            }

            try {

                $password = 123456789;
                $link = 'shikka' . rand(10, 100) . Auth::user()->id . substr($request->phone, 3);

                $uniqueId = Utility::createUniqueId(Auth::id(), 'teacher');

                $teacher = new Teacher();
                $teacher->full_name = $request->full_name;
                $teacher->unique_id = $uniqueId;
                $teacher->email = $request->email;
                $teacher->phone = $request->phone;
                $teacher->address = $request->address;
                $teacher->Nationality = $request->Nationality;
                $teacher->gender = $request->gender;
                $teacher->image = $fileName;
                $teacher->salary = $request->salary;
                $teacher->blood_group = $request->blood_group ? $request->blood_group : "";
                $teacher->shift = $request->shift;
                $teacher->link_id = $link;
                $teacher->designation = $request->designation;
                $teacher->active = 1;
                $teacher->department_name = $request->department_name;
                $teacher->M_status = $request->M_status ? $request->M_status : "";
                $teacher->password = Hash::make($password);
                $teacher->school_id = Auth::user()->id;
                $teacher->save();
            } catch (Exception $e) {
                Alert::error($e->getMessage(), 'Server Error');
                return back();
            }

            $month = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

            foreach ($month as $data) {
                try {
                    $fees = new TeacherSalary();
                    $fees->month_name = $data;
                    $fees->teacher_id = $teacher->id;
                    $fees->school_id = Auth::user()->id;
                    $fees->save();
                } catch (Exception $e) {
                    break;
                    Alert::error($e->getMessage(), 'Server Error');
                    return back();
                }
            }


            Alert::success('Success Teacher created', 'Success Message');
            return redirect()->route('teacher.Show');
        }
    }

    public function teacherPassChange(Request $request)
    {

        $request->validate([

            'password' => ['required', 'min:5', 'confirmed']
        ]);

        Teacher::where('id', $request->id)->update([
            'password' => bcrypt($request->password)
        ]);
        Alert::success('Successfully Teacher Password Changed', 'Success Message');

       return back();
    }

    public function singleView($id)
    {
        $data = Teacher::find($id);
        return view('frontend.school.teacher.teacherDetails', compact('data'));
    }

    public function teacherUpdate(Request $request, $id)
    {
        //  dd($request->all());
        if (Auth::user()->status == 0) {
            return redirect()->route('school.payment.info');
        } elseif (Auth::user()->status == 2) {
            toast('Sorry Admin can Inactive Your Account Please Contact', 'error');
            return back();
        }
        if (Auth::user()->is_editor != 3) {
            return back();
        } else {
            if ($request->url_check == 'teacher/create') {
                $value = $request->session()->put('dataSession', $request->url_check);
                return redirect()->route('department.create');
            }
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'phone' => 'required|unique:teachers,phone,' . $id . 'id|numeric|digits:11',
                'full_name' => 'required',
                'address' => 'required',
                'designation' => 'required',
                'gender' => 'required',
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors();
                $class = InstituteClass::where('school_id', Auth::user()->id)->get();
                $section = Section::where('school_id', Auth::user()->id)->get();
                $department = Department::where('school_id', Auth::user()->id)->get();
                $teacherText = 'Teacher Input create';
                $seoTitle = 'Teacher Show';
                $seoDescription = 'Teacher Show';
                $seoKeyword = 'Teacher Show';
                $seo_array = [
                    'seoTitle' => $seoTitle,
                    'seoKeyword' => $seoKeyword,
                    'seoDescription' => $seoDescription,
                ];
                $teacherEdit = Teacher::find($id);
                return view('frontend.school.teacher.create', compact('teacherText', 'seo_array', 'class', 'section', 'department', 'teacherEdit', 'errors'));
            } else {

                $teacher = Teacher::find($id);
                if ($request->hasFile('image')) {
                    File::delete(public_path($teacher->image));
                    $fileName = time() . '.' . $request->file('image')->getclientOriginalExtension();
                    $request->file('image')->move(public_path('/uploads/teacher'), $fileName);
                    $fileName = "/uploads/teacher/" . $fileName;
                    $teacher->image = $fileName;
                }
                $teacher->full_name = $request->full_name;
                $teacher->email = $request->email;
                $teacher->phone = $request->phone;
                $teacher->active = 1;
                $teacher->department_name = $request->department_name;
                $teacher->Nationality = $request->Nationality;
                $teacher->gender = $request->gender;
                $teacher->designation = $request->designation;
                $teacher->address = $request->address;
                $teacher->blood_group = $request->blood_group ? $request->blood_group : "";
                $teacher->M_status = $request->M_status ? $request->M_status : "";
                $teacher->salary = $request->salary;
                $teacher->shift = $request->shift;
                $teacher->school_id = Auth::user()->id;
                $teacher->active = (is_null($request->active) ? 1 : $request->active);
                $teacher->save();

                Alert::success('Success Teacher Updated', 'Success Message');
                return redirect()->route('teacher.Show');
            }

        }
    }
    public function teacherShowget(){
        $salary = EmployeeSalary::where('school_id', Auth::user()->id)->where('id', $staffId)->get();
        return response()->json($salary);

    }

    public function teacherShow()
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
            $teacherText = 'Teacher Show';
            $seoTitle = 'Teacher Show';
            $seoDescription = 'Teacher Show';
            $seoKeyword = 'Teacher Show';
            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
            ];
            $teacher = Teacher::where('school_id', Auth::user()->id)->orderby('active', 'desc')->get();
            $studentFees = TeacherSalary::where('school_id', Auth::user()->id)->get();
            return view('frontend.school.teacher.show', compact('studentFees','teacher', 'seo_array', 'teacherText'));
        }
    }

    public function teacherDelete($id)
    {
        $teacherSalary = TeacherSalary::where('teacher_id', $id)->delete();
        $teacher = Teacher::find($id);
        File::delete(public_path($teacher->image));
        $teacher->delete();
        Alert::success('Successfully Teacher Deleted', 'Success Message');
        return back();
    }

    /**
     * Delete All Teacher
     * 
     * @param Request
     * @param $request
     */
    public function teacher_Check_Delete(Request $request){
        $ids = $request->ids;
        Teacher::whereIn('id', $ids)->delete();
        Alert::success(' Selected Teachers are deleted', 'Success Message');
        return response()->json(['status'=>'success']);
    }

    public function restoreteacher($id)
    {
        TeacherSalary::withTrashed()->where('teacher_id', $id)->restore();
        Teacher::withTrashed()->where('id', $id)->restore();
        toast("Restore data", "success");
        return back();
    }
    public function Pdelete_teacher($id)
    {
        TeacherSalary::withTrashed()->where('teacher_id', $id)->forcedelete();

        Teacher::withTrashed()->where('id', $id)->forcedelete();
        toast("Data delete permanently", "success");
        return back();
    }

    public function teacherEdit($id)
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
            $class = InstituteClass::where('school_id', Auth::user()->id)->get();
            $section = Section::where('school_id', Auth::user()->id)->get();
            $department = Department::where('school_id', Auth::user()->id)->get();
            $teacherText = 'Teacher Input create';
            $seoTitle = 'Teacher Show';
            $seoDescription = 'Teacher Show';
            $seoKeyword = 'Teacher Show';
            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
            ];
            $teacherEdit = Teacher::find($id);
            return view('frontend.school.teacher.create', compact('teacherText', 'seo_array', 'class', 'section', 'department', 'teacherEdit'));
        }
    }

    public function teacherActiveInactive(Request $request, $id)
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
            $teacher = Teacher::find($id);
            $teacher->active = $request->active;
            $teacher->save();
            Alert::success('Success Teacher Activated', 'Success Message');
            return back();
        }
    }
    public function teacher_multiple_ActiveInactive(Request $request)
    {
        $ids = $request->ids;
        $teacher = Teacher::whereIn('id', $ids);
        $teacher->active = $request->active;
        $teacher->save();
        Alert::success(' Selected Teachers are Activation Changed', 'Success Message');
        return response()->json(['status' => 'success']);
    }

    public function assignCreateShow()
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

            $class = InstituteClass::where('school_id', Auth::user()->id)->get();
            $section = Section::where('school_id', Auth::user()->id)->get();
            $group = Group::where('school_id', Auth::user()->id)->get();
            $teachers = Teacher::where('school_id', Auth::user()->id)->where('active', 1)->get();
            $subjects = subject::where('school_id', Auth::user()->id)->get();

            //return $subjects;

            $subjectText = 'Teacher Show';
            $seoTitle = 'Teacher Assign ';
            $seoDescription = 'Teacher Assign ';
            $seoKeyword = 'Teacher Assign ';

            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
            ];

            return view('frontend.school.teacher.createShow',
                compact(
                    'subjectText',
                    'seo_array',
                    'class',
                    'section',
                    'group',
                    'teachers',
                    'subjects'
                )
            );
        }
    }

    public function assignCreateShowPost(Request $request)
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
            // return $request;
            $request->validate([
                'class_id' => 'required',
                'section_id' => 'required',
                'subject_id' => 'required',
                'teacher_id' => 'required',
            ]);

            $class_id = $request->class_id;
            $section_id = $request->section_id;
            $group_id = isset($request->group_id) ? 0 : $request->group_id;

            $classTeacher = AssignTeacher::where('class_id', $class_id)
                ->where('section_id', $section_id)
                ->where('group_id', $group_id)
                ->where('teacher_id', $request->teacher_id)
                ->where('class_teacher', true);

            if ($classTeacher->exists()) {
                toast('One Class Have One Class Teacher , This Class have already a Class Teacher', 'error');
                return back();
            } else {
                $class = new AssignTeacher();
                $class->class_id = $class_id;
                $class->section_id = $section_id;
                $class->group_id = $group_id ?? null;
                $class->subject_id = $request->subject_id;
                $class->department_id = $request->subject_id;
                $class->teacher_id = $request->teacher_id;
                $class->class_teacher = (int)true;
                $class->school_id = Auth::user()->id;
                $class->save();
                toast('Successfully Assigned Teacher', 'success');
                return back();
            }
        }
    }

    public function assignCreateShowPostNew(Request $request)
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
                'class_id' => 'required',
                'section_id' => 'required',
                'month_name' => 'required',
            ]);
            $class_id = $request->class_id;
            $section_id = $request->section_id;
            $month_name = $request->month_name;
            $group_id = is_null($request->group_id) ? 0 : $request->group_id;
            if ($request->url_data == 'student') {
                return redirect()->route('assign.student.dataShow', ['class_id' => $class_id, 'section_id' => $section_id, 'group_id' => $group_id]);
            } elseif ($request->url_data == 'finance') {
                return redirect()->route('assign.student.finance.dataShow.new', ['class_id' => $class_id, 'section_id' => $section_id, 'group_id' => $group_id, 'month_name' => $month_name]);
            } else {
                return redirect()->route('assign.teacher.dataShow', ['class_id' => $class_id, 'section_id' => $section_id, 'group_id' => $group_id]);
            }
        }
    }

    public function assignCreateShowPostData(Request $request)
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

            if (!is_null($request->id)) {

                $group_id = is_null($request->group_id) ? 0 : $request->group_id;
                $dataShow = AssignTeacher::where('subject_id', $request->subject_id)->get();
                $active = is_null($request->active) ? 0 : $request->active;
                $dataShowClassTeacher = AssignTeacher::where('class_id', $request->class_id)
                    ->where('section_id', $request->section_id)
                    ->where('group_id', $request->group_id)
                    ->pluck('class_teacher')->toArray();

                $arraySearch = array_search(1, $dataShowClassTeacher);
                if ($arraySearch === 0 and is_null($request->active)) {
                    $class = AssignTeacher::where('id', $request->id)->first();
                    $class->subject_id = $request->subject_id;
                    $class->teacher_id = $request->teacher_id;
                    $class->class_teacher = (is_null($request->active) ? 0 : $request->active);
                    $class->school_id = Auth::user()->id;
                    $class->save();
                    toast('Successfully Uploaded', 'success');
                    return back();
                } else {
                    $ClassTeacher = AssignTeacher::where('class_id', $request->class_id)
                        ->where('section_id', $request->section_id)
                        ->where('group_id', $request->group_id)
                        ->where('subject_id', $request->subject_id)->first();
                    //  dd($ClassTeacher->class_teacher);
                    if (($ClassTeacher->class_teacher == 1)) {
                        $class = AssignTeacher::where('id', $request->id)->first();
                        $class->subject_id = $request->subject_id;
                        $class->teacher_id = $request->teacher_id;
                        $class->class_teacher = (is_null($request->active) ? 0 : $request->active);
                        $class->school_id = Auth::user()->id;
                        $class->save();
                        toast('Successfully Uploaded', 'success');
                        return back();
                    } else {
                        toast('One Class Have One Class Teacher , This Class have already a Class Teacher', 'error');
                        return back();
                    }
                }
            } else {

                $request->validate([
                    'subject_id' => 'required',
                    'teacher_id' => 'required',
                ]);
                $group_id = is_null($request->group_id) ? 0 : $request->group_id;
                $dataShow = AssignTeacher::where('subject_id', $request->subject_id)->get();

                $dataShowClassTeacher = AssignTeacher::where('class_id', $request->class_id)
                    ->where('section_id', $request->section_id)
                    ->where('group_id', $request->group_id)
                    ->where('class_teacher', $request->active)
                    ->count();

                if (count($dataShow) < 1) {

                    if (($dataShowClassTeacher) >= 1) {
                        toast('One Class Have One Class Teacher , This Class have already a Class Teacher', 'error');
                        return back();
                    } else {

                        // return $request;
                        $class = new AssignTeacher();
                        $class->class_id = $request->class_id;
                        $class->section_id = $request->section_id;
                        $class->group_id = $request->group_id;
                        $class->subject_id = $request->subject_id;
                        $class->teacher_id = $request->teacher_id;
                        $class->class_teacher = (is_null($request->active) ? 0 : $request->active);
                        $class->school_id = Auth::user()->id;
                        $class->save();
                        toast('Successfully Uploaded', 'success');
                        return back();
                    }
                } else {
                    toast('This Subject have already , You may edit ', 'error');
                    return back();
                }
            }
            $class_id = $request->class_id;
            $section_id = $request->section_id;
            $group_id = is_null($request->group_id) ? 0 : $request->group_id;

            return redirect()->route('assign.teacher.dataShow', ['class_id' => $class_id, 'section_id' => $section_id, 'group_id' => $group_id]);
        }
    }

    public function assignTeacherDataShow($class_id, $section_id, $group_id)
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
            $group_id = ($group_id == 0) ? NULL : $group_id;
            $dataShow = AssignTeacher::where('class_id', $class_id)->where('section_id', $section_id)->where('group_id', $group_id)->get();
            $dataSubject = Subject::where('class_id', $class_id)->where('section_id', $section_id)->where('group_id', $group_id)->get();
            $dataTeacher = Teacher::where('school_id', Auth::user()->id)->get();
            $teacherText  = 'Assign Teacher Input create';
            $seoTitle = 'Assign Teacher';
            $seoDescription = 'Assign Teacher';
            $seoKeyword = 'Assign Teacher';
            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
            ];
            return view('frontend.school.teacher.dataShow', compact('teacherText', 'seo_array', 'dataShow', 'class_id', 'section_id', 'group_id', 'dataSubject', 'dataTeacher'));
        }
    }


    public function assignTeacherEditShow($id)
    {
        $teacherText  = 'Assign Teacher Input create';
        $seoTitle = 'Assign Teacher';
        $seoDescription = 'Assign Teacher';
        $seoKeyword = 'Assign Teacher';
        $seo_array = [
            'seoTitle' => $seoTitle,
            'seoKeyword' => $seoKeyword,
            'seoDescription' => $seoDescription,
        ];

        $dataEdit = AssignTeacher::where('id', $id)->first();
        $dataSubject = Subject::where('class_id', $dataEdit->class_id)->where('section_id', $dataEdit->section_id)->where('group_id', $dataEdit->group_id)->get();
        $dataTeacher = Teacher::where('school_id', Auth::user()->id)->get();
        $dataEdit = AssignTeacher::where('id', $id)->first();
        return view('frontend.school.teacher.editShow', compact('teacherText', 'seo_array', 'dataEdit', 'dataSubject', 'dataTeacher'));
    }

    /**
     * Show Student List
     * 
     * @author CodeCell <support@codecell.com.bd>
     * @contributor Shohidul 
     * @modifier Sajjad <sajjad.develpr@gmail.com>
     * @modified 05-07-23
     * @return \Illuminate\Contracts\View\View|
     */
    public function studentCreateShow()
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
            $class = InstituteClass::where('school_id', Auth::user()->id)->get();
            $section = Section::where('school_id', Auth::user()->id)->get();
            $group = Group::where('school_id', Auth::user()->id)->get();
            $subjectText = 'Student Input create';
            $seoTitle = 'Students Show';
            $seoDescription = 'Student Show';
            $seoKeyword = 'Student Show';
            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
            ];

            $count = User::where(['school_id'=>auth()->id()])->count();
            if($count > 0){
                $dataShow =  User::where(['school_id'=>auth()->id()])->where('class_id', $class->first()->id)->latest()->get();
                return view('frontend.school.student.createShow', compact('subjectText', 'seo_array', 'class', 'section', 'group', 'dataShow'));
            }
            else{
                $dataShow = User::where(['school_id'=>auth()->id()])->get();
                return view('frontend.school.student.createShow', compact('subjectText', 'seo_array', 'class', 'section', 'group', 'dataShow'));
            }

           
        }
    }

    /**------------------   Find Student
     * =====================================================*/
    public function findStudents(Request $request)
    {   
        if ($request->class_id) {
            
            if ($request->section_id) {

                if ($request->shift_id) {
                    
                    if ($request->group_id) {
                        $shift = $request->shift_id;
                        $class = $request->class_id;
                        $section = $request->section_id;
                        $group = $request->group_id;
                        
                        $dataShow = User::where([
                            'school_id'     =>  auth()->id(),
                            'class_id'      =>  $class,
                            'section_id'    =>  $section,
                            'shift'         =>  $shift,
                            'group_id'    =>  $group,
                        ])->orderBy('roll_number', 'asc')->get();
                    } else {
                        $shift = $request->shift_id;
                        $class = $request->class_id;
                        $section = $request->section_id;
                        
                        $dataShow = User::where([
                            'school_id'     =>  auth()->id(),
                            'class_id'      =>  $class,
                            'section_id'    =>  $section,
                            'shift'         =>  $shift,
                        ])->orderBy('roll_number', 'asc')->get();
                    }
                } else if ($request->group_id) {

                    $class = $request->class_id;
                    $section = $request->section_id;
                    $group = $request->group_id;
                    
                    $dataShow = User::where([
                        'school_id'     =>  auth()->id(),
                        'class_id'      =>  $class,
                        'section_id'    =>  $section,
                        'group_id'    =>  $group,
                    ])->orderBy('roll_number', 'asc')->get();
                } else {

                    $class = $request->class_id;
                    $section = $request->section_id;
                   
                    $dataShow = User::where([
                        'school_id'     =>  auth()->id(),
                        'class_id'      =>  $class,
                        'section_id'    =>  $section,
                    ])->orderBy('roll_number', 'asc')->get();
                }
            } else if ($request->shift_id) {

                if ($request->group_id) {
                    
                    $class = $request->class_id;
                    $shift = $request->shift_id;
                    $group = $request->group_id;

                    $dataShow = User::where([
                        'school_id'   =>  auth()->id(),
                        'class_id'    =>  $class,
                        'shift'    =>  $shift,
                        'group_id'    =>  $group,

                    ])->orderBy('roll_number', 'asc')->get();
                } else {
                    $shift = $request->shift_id;
                    $class = $request->class_id;
                    $dataShow = User::where([
                        'school_id'     =>  auth()->id(),
                        'shift'         =>  $shift,
                        'class_id'      =>  $class,
                    ])->orderBy('roll_number', 'asc')->get();
                }
            } else if ($request->group_id) {

                $class = $request->class_id;
                $group = $request->group_id;
                $dataShow = User::where([
                    'school_id'     =>  auth()->id(),
                    'class_id'      =>  $class,
                    'group_id'    =>  $group,

                ])->orderBy('roll_number', 'asc')->get();
            } else {
                $class = $request->class_id;
                
                $dataShow = User::where([
                    'school_id'     =>  auth()->id(),
                    'class_id'      =>  $class,
                ])->orderBy('roll_number', 'asc')->get();
            }
        } else if ($request->shift_id) {

            if ($request->group_id) {

                $shift = $request->shift_id;
                $group = $request->group_id;

                $dataShow = User::where([
                    'school_id'     =>  auth()->id(),
                    'shift_id'    =>  $shift,
                    'group_id'    =>  $group,

                ])->orderBy('roll_number', 'asc')->get();
            } else {
                $shift = $request->shift_id;
                $class = $request->class_id;

                $dataShow = User::where([
                    'school_id'     =>  auth()->id(),
                    'shift'         =>  $shift,
                ])->orderBy('roll_number', 'asc')->get();
            }
        } else if ($request->group_id) {

            $group = $request->group_id;

            $dataShow = User::where([
                'school_id'     =>  auth()->id(),
                'group_id'    =>  $group,

            ])->orderBy('roll_number', 'asc')->get();
        } else {
            $shift = $request->shift_id;
            $class = $request->class_id;
            $section = $request->section_id;
            $group = $request->group_id;

            $dataShow = User::where([
                'school_id'     =>  auth()->id(),

            ])->orderBy('roll_number', 'asc')->get();
        }

        $class = InstituteClass::where('school_id', Auth::user()->id)->get();
        $section = Section::where('school_id', Auth::user()->id)->get();
        $group = Group::where('school_id', Auth::user()->id)->get();
        $subjectText = 'Students';
        $seoTitle = 'student Show';
        $seoDescription = 'student Show';
        $seoKeyword = 'student Show';
        $seo_array = [
            'seoTitle' => $seoTitle,
            'seoKeyword' => $seoKeyword,
            'seoDescription' => $seoDescription,
        ];
        return view('frontend.school.student.createShow', compact('subjectText', 'seo_array', 'class', 'section', 'group', 'dataShow'));
    }

    /**
     * View Student Create Form
     * 
     * @author CodeCell <support@codecell.com.bd>
     * @contributor Sajjad <sajjad.develpr@gmail.com>
     * 
     * @return \Illuminate\Contracts\View\View|
     */
    public function studentCreate()
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
            $studentText = 'Student Input create';
            $seoTitle = 'Student Create';
            $seoDescription = 'Student Create';
            $seoKeyword = 'Student Create';

            $class = InstituteClass::where('school_id', Auth::user()->id)->get();
            $section = Section::where('school_id', Auth::user()->id)->get();
            $group = Group::where('school_id', Auth::user()->id)->get();
            $subjects = Subject::where('school_id', Auth::user()->id)->where('class_id', 95)->get();
            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
            ];
            
            return view('frontend.school.student.create', compact('studentText', 'seo_array', 'class', 'section', 'group', 'subjects'));
        }
    }

    /**----------------------   Register a user into database
     * =============================================================*/
    /**
     * Save Student Data In Database
     * 
     * @author CodeCell <suppor@codecell.com.bd>
     * @contributor Sajjad <sajjad.develpr@gmail.com>
     * @param Request
     * @param $request
     * @modified 05-07-23
     * 
     * @return \Illuminate\Routing\Redirector
     */
    public function studentCreatePost(Request $request)
    {   
        if (Auth::user()->status == 0) {
            return redirect()->route('school.payment.info');
        } elseif (Auth::user()->status == 2) {
            toast('Sorry Admin can Inactive Your Account Please Contact', 'error');
            return back();
        }

        $userExist = User::where('email', $request->email)->whereNull('unique_id');
        $userUp = User::where('email', $request->email)->whereNull('unique_id')->first();
        
        if($userExist->exists()) {
            $request->validate([
                'discount' => 'nullable',
                'name' => 'required|string',
                'email' => 'required|email|',
                'phone' => 'nullable|numeric',
                'roll_number' => 'required|numeric',
                'gender' => 'nullable',
                'dob' => 'nullable',
                'father_name' => 'nullable|string',
                'mother_name' => 'nullable|string',
                'class_id' => 'nullable|integer',
                'section_id' => 'nullable|integer',
            ]);
        } else {
            $request->validate([
                'discount' => 'nullable',
                'name' => 'required|string',
                'email' => 'required|email|unique:users',
                'phone' => 'nullable|numeric',
                'roll_number' => 'required|numeric',
                'gender' => 'nullable',
                'dob' => 'nullable',
                'father_name' => 'nullable|string',
                'mother_name' => 'nullable|string',
                'class_id' => 'nullable|integer',
                'section_id' => 'nullable|integer',
            ]);
        }

        $userRoll = User::where('class_id', $request->class_id)
            ->where('section_id', $request->section_id)
            ->where('roll_number', $request->roll_number);

        if ($userRoll->exists()) {
            toast('This roll number already Exits', 'error');

            return back()->withInput()
                ->withErrors(['roll_number.required' => 'This roll number already Exits']);
        } else {

            if($userExist->exists()) {
                $uniqueId = Utility::createUniqueId(Auth::id(), 'student');
                
                $userUp->unique_id = $uniqueId;
                $userUp->name = $request->name;
                $userUp->father_name = $request->father_name ?? null;
                $userUp->mother_name = $request->mother_name ?? null;
                $userUp->email = $request->email;
                $userUp->roll_number = (int)$request->roll_number;
                $userUp->address = $request->address ?? null;
                $userUp->phone = $request->phone;
                $userUp->discount = $request->discount ?? 0;
    
                $userUp->gender = $request->gender ?? null;
                $userUp->dob = $request->dob ?? null;
                $userUp->blood_group = $request->blood_group ?? null;
                $userUp->class_id = $request->class_id;
                $userUp->section_id = $request->section_id;
                $userUp->group_id = $request->group_id;
                $userUp->shift = $request->shift ?? 2; // default is day shift
                $userUp->school_id = Auth::user()->id;
                $userUp->password = Hash::make(123456789);
    
                $image = $request->file('image');
                if ($request->hasfile('image')) {
                    $new_name = 'profile/img/' . rand() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('profile/img'), $new_name);
                    $userUp->image = $new_name;
                }
                $userUp->save();
    
                session(['user' => $userUp]);
                
                return redirect()->route('student.create');
            }

            $uniqueId = Utility::createUniqueId(Auth::id(), 'student');

            $user = new User();
            $user->unique_id = $uniqueId;
            $user->name = $request->name;
            $user->father_name = $request->father_name ?? null;
            $user->mother_name = $request->mother_name ?? null;
            $user->email = $request->email;
            $user->roll_number = (int)$request->roll_number;
            $user->address = $request->address ?? null;
            $user->phone = $request->phone;
            $user->discount = $request->discount ?? 0;

            $user->gender = $request->gender ?? null;
            $user->dob = $request->dob ?? null;
            $user->blood_group = $request->blood_group ?? null;
            $user->class_id = $request->class_id;
            $user->section_id = $request->section_id;
            $user->group_id = $request->group_id;
            $user->shift = $request->shift ?? 2; // default is day shift
            $user->school_id = Auth::user()->id;
            $user->password = Hash::make(123456789);

            $image = $request->file('image');
            if ($request->hasfile('image')) {
                $new_name = 'profile/img/' . rand() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('profile/img'), $new_name);
                $user->image = $new_name;
            }
            $user->save();

            \App\Http\Controllers\Finance\Utility::assignFeesToNewStudent($user);

            session(['user' => $user]);
            return redirect()->route('student.create');
        }
    }

    /**
     * Student Update
     * 
     * @author CodeCell <support@codecell.com.bd>
     * @contributor Sajjad <sajjad.develpr@gmail.com>
     * @param Request
     * @param $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function studentUpdatePost(Request $request, $id)
    {
        if (Auth::user()->status == 0) {
            return redirect()->route('school.payment.info');
        } elseif (Auth::user()->status == 2) {
            toast('Sorry Admin can Inactive Your Account Please Contact', 'error');
            return back();
        }
        $user = User::find($id);
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'nullable|numeric|digits:11',
            'roll_number' => 'required|numeric',
            'gender' => 'nullable',
            'dob' => 'nullable',
            'discount' => 'nullable',
            'father_name' => 'nullable|string',
            'mother_name' => 'nullable|string',
            'class_id' => 'nullable|integer',
            'section_id' => 'nullable|integer',
        ]);

        $userRollCount = User::where('id', '!=', $id)
            ->where('class_id', $request->class_id)
            ->where('section_id', $request->section_id)
            ->where('group_id', $request->group_id)
            ->where('roll_number', $request->roll_number)
            ->count();

        if ($userRollCount > 0) {
            toast('This roll number already Exits', 'error');
            return back();
        } else {
            $user->name = $request->name;
            $user->father_name = $request->father_name;
            $user->mother_name = $request->mother_name;
            $user->email = $request->email;
            $user->discount = $request->discount;

            $user->roll_number = $request->roll_number;
            $user->address = $request->address;
            $user->phone = $request->phone;
            $user->gender = $request->gender;
            $user->dob = $request->dob;
            $user->shift = $request->shift;
            $user->blood_group = $request->blood_group;
            $user->class_id = $request->class_id;
            $user->section_id = $request->section_id;
            $user->group_id = $request->group_id;
            $user->school_id = Auth::user()->id;
            $image = $request->file('image');
            if ($request->hasfile('image')) {
                $new_name = rand() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('profile/img'), $new_name);
                $user->image = 'profile/img/' . $new_name;
            }
            $user->save();


            if($user->discount > 0)
            {
                $updateStudentMonthlyFees = \App\Http\Controllers\Finance\CollectFeesController::updateStudentMonthlyFees($user->id);
                
                if($updateStudentMonthlyFees['status'] == false)
                {
                    Alert::error('Server Error', $updateStudentMonthlyFees['message']);
                    return back();
                }
            }


            Alert::success('Success User Updated', 'Success Message');
            return back();
        }
    }

    public function studentDelete($id)
    {   
        if (Auth::user()->status == 0) {
            return redirect()->route('school.payment.info');
        } elseif (Auth::user()->status == 2) {
            toast('Sorry Admin can Inactive Your Account Please Contact', 'error');
            return back();
        }

        $result = Result::where('student_id', $id)->delete();
        $fee = StudentMonthlyFee::where('student_id', $id)->delete();
        $data = User::where('id', $id)->delete();
        Alert::success('Success student deleted', 'Success Message');
        return back();
    }

    public function student_Check_Delete(Request $request)
    {   
        $ids = $request->ids;
        User::whereIn('id', $ids)->delete();
        DB::table('results')->whereIn('student_id', $ids)->delete();

        Alert::success(' Selected students are deleted', 'Success Message');
        return response()->json(['status'=>'success']);
    }

    public function restorestudent($id)
    {   
        try {
            StudentMonthlyFee::withTrashed()->where('student_id', $id)->restore();
            Result::withTrashed()->where('student_id', $id)->restore();
            User::withTrashed()->where('id', $id)->restore();
            
            $users = User::onlyTrashed()->where('school_id', Auth::user()->id)->orderBy('deleted_at', 'desc')->get();
            return response()->json(['message' => 'student Data restored successfully', 
                'data' => $users
            ]);
                            
        }
        catch (\Exception $e) {
            return response()->json(['error' => 'Failed to restore Student data'], 500);
        }
        
    }

    public function Pdelete_student($id)
    {
        try{
            StudentMonthlyFee::withTrashed()->where('student_id', $id)->forcedelete();
            Result::withTrashed()->where('student_id', $id)->forcedelete();
            User::withTrashed()->where('id', $id)->forcedelete();
            
            $users = User::onlyTrashed()->where('school_id', Auth::user()->id)->orderBy('deleted_at', 'desc')->get();
            return response()->json(['message' => 'Student data deleted Permanently.',
                'data' => $users
            ]);
        }
        catch(\Exception $e){
            return response()->json(['message' => 'Failed to delete student data.'], 500);
        }
        
    }

    //upload Excel file for student

    public function studentUpload(Request $request)
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
            $class = InstituteClass::where('school_id', Auth::user()->id)->get();
            return view('frontend.school.student.upload', compact('class'));
        }
    }

    //upload post student info

    public function studentUploadPost(Request $request)
    {
        $request->validate([
            'class_id' => 'required',
            'section_id' => 'required',
            'file' => 'required|mimes:xlsx,xls',
        ]);

        try {
            Excel::import(new UsersImport($request->class_id, $request->section_id, auth()->user()->id), $request->file);
            Alert::success('Student uploaded Succesfully', 'Success Message');

            return redirect()->route('student.teacher.create.show');
        } catch (ValidationException $e) {
            $failures = $e->failures();
            return back()->with('import errors', $failures);
        }
    }


    public function assignStudentDataShow($class_id, $section_id, $group_id)
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
            $group_id = ($group_id == 0) ? NULL : $group_id;
            $dataShow = User::where('class_id', $class_id)->where('section_id', $section_id)->where('group_id', $group_id)->get();
            $teacherText  = 'Student Input create';
            $seoTitle = 'Student Show';
            $seoDescription = 'Student Show';
            $seoKeyword = 'Student Show';
            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
            ];
            return view('frontend.school.student.dataShow', compact('teacherText', 'seo_array', 'dataShow'));
        }
    }

    public function assignSubjectDelete($id)
    {
        if (Auth::user()->status == 0) {
            return redirect()->route('school.payment.info');
        } elseif (Auth::user()->status == 2) {
            toast('Sorry Admin can Inactive Your Account Please Contact', 'error');
            return back();
        }
        $data = AssignTeacher::where('id', $id)->delete();
        Alert::error('Success Assigned Teacher deleted', 'Success Message');
        return back();
    }

    // Student singleShow
    public function singleShow($id)
    {
        $seoTitle = 'Student SingleShow';
        $seoDescription = 'Student SingleShow';
        $seoKeyword = 'Student SingleShow';
        $seo_array = [
            'seoTitle' => $seoTitle,
            'seoKeyword' => $seoKeyword,
            'seoDescription' => $seoDescription,
        ];
        $date = Carbon::now();
        $testimonial = Testimonial::where('user_id', $id)->first();
        $transfer = Transfer::where('user_id', $id)->first();
        $user = User::with('clasRelation', 'sectionRelation')->find($id);
        $data['fees'] = StudentMonthlyFee::where('student_id', $id)->get();
        $studentMonthlyFees = StudentMonthlyFee::where('student_id', $id)->orderBy('month_id','asc')->get();
        $total = StudentMonthlyFee::where('student_id', $id)->sum('amount');
        $totalPaid = StudentMonthlyFee::where('student_id', $id)->sum('paid_amount');
        $totalDue = $total - $totalPaid;
        $alldocuments = StudentDocumentUpload::where('school_id', Auth::user()->id)->where('student_id', $id)->get();
        $AssignTeacher = AssignTeacher::where('class_id',$user->class_id)->where('school_id',Auth::user()->id)->first()?->teacher_id;
        $classTeacher = Teacher::find($AssignTeacher)?->first()->full_name;
        $classTeacherPhone = Teacher::find($AssignTeacher)?->first()->phone;
        $accountant = Teacher::where('designation', '=', "Accountant")->where('school_id', Auth::user()->id)->first()?->phone;

        return view('frontend.school.student.singleShow', compact('user', 'testimonial', 'transfer', 'data', 'studentMonthlyFees', 'alldocuments','date','totalDue','classTeacher','accountant','totalPaid','classTeacherPhone','seo_array'));
    }

    public function singlePassword(Request $request)
    {

        $request->validate([
            'password' => ['required', 'min:5', 'confirmed']
        ]);
        User::where('id', $request->id)->update([
            'password' => bcrypt($request->password)
        ]);
        Alert::success('Successfully Student Password Changed ', 'Success Message');

        return response()->json([
            'status' => 'success'
        ]);
    }


    public function studentAttendanceShow()
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
            $class = InstituteClass::where('school_id', Auth::user()->id)->get();
            $section = Section::where('school_id', Auth::user()->id)->get();
            $text = 'Student Attendance ';
            $defaultDate = Carbon::today()->format('Y-m-d');
            $seoTitle = 'Student Take/View Attendance';
            $seoDescription = 'Student  Attendance';
            $seoKeyword = 'Student Attendance';
            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
            ];
            return view('frontend.school.student.attendanceShow', compact('text', 'seo_array', 'class', 'section', 'defaultDate'));
        }
    }

    public function studentAttendanceShowPost(Request $request)
    {
        if (Auth::user()->status == 0) {
            return redirect()->route('school.payment.info');
        } elseif (Auth::user()->status == 2) {
            toast('Sorry Admin can Inactive Your Account Please Contact', 'error');
            return back();
        }
        //dd($request->all());
        if (Auth::user()->is_editor != 3) {
            return back();
        } else {
            $request->validate([
                'class_id' => 'required',
                'section_id' => 'required',
            ]);
            $class_id = $request->class_id;
            $section_id = $request->section_id;
            $group_id = is_null($request->group_id) ? 0 : $request->group_id;

            return redirect()->route('student.attendanceShow', ['class_id' => $class_id, 'section_id' => $section_id, 'group_id' => $group_id]);
        }
    }

    public function studentAttendanceShowPostDate(Request $request)
    {
        if (Auth::user()->status == 0) {
            return redirect()->route('school.payment.info');
        } elseif (Auth::user()->status == 2) {
            toast('Sorry Admin can Inactive Your Account Please Contact', 'error');
            return back();
        }
        //dd($request->all());
        if (Auth::user()->is_editor != 3) {
            return back();
        } else {
            $request->validate([
                'class_id' => 'required',
                'section_id' => 'required',
                'date' => 'required',
            ]);
            $class_id = $request->class_id;
            $section_id = $request->section_id;
            $group_id = is_null($request->group_id) ? 0 : $request->group_id;
            $date = $request->date;
            return redirect()->route('student.attendanceShowDate', ['class_id' => $class_id, 'section_id' => $section_id, 'group_id' => $group_id, 'date' => $date]);
        }
    }

    public function studentAttendanceShowPostDateAll(Request $request)
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
                'class_id' => 'required',
                'section_id' => 'required',
                'month_id' => 'required',
            ]);
            $class_id = $request->class_id;
            $section_id = $request->section_id;
            $group_id = is_null($request->group_id) ? 0 : $request->group_id;
            $date = $request->month_id;

            return redirect()->route('student.attendanceShowDateAll', ['class_id' => $class_id, 'section_id' => $section_id, 'group_id' => $group_id, 'date' => $date]);
        }
    }

    public function attendanceShowDate($class_id, $section_id, $group_id, $date)
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

            $dataAttendance = Attendance::join('users', 'users.id', 'attendances.student_id')
            ->select('attendances.*')
            ->where("attendances.school_id", Auth::user()->id)
            ->where('attendances.class_id', $class_id)
            ->where('attendances.section_id', $section_id)
            ->whereDate('attendances.created_at', $date)
            ->orderBy('users.roll_number', 'ASC')
            ->get()
            ->unique('student_id');
            
            $dataShow = User::where("school_id", Auth::user()->id)->where('class_id', $class_id)
                ->where('section_id', $section_id)
                ->orderBy('roll_number')
                ->get();

            $Text = 'Attendance Input create';
            $seoTitle = 'Student Attendance';
            $seoDescription = 'Student Attendance ';
            $seoKeyword = 'Student Attendance';
            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
            ];

            return view('frontend.school.student.attendance', compact('Text', 'seo_array', 'dataShow', 'class_id', 'section_id', 'group_id', 'dataAttendance', 'date'));
        }
    }

    public function attendanceShowDateAll($class_id, $section_id, $group_id, $date)
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
            $group_id = ($group_id == 0) ? NULL : $group_id;
            $dataAttendance = Attendance::where('class_id', $class_id)->where('section_id', $section_id)->whereDate('created_at', $date)->get();
            $dataShow = User::where('class_id', $class_id)->where('section_id', $section_id)->get();
            $Text = 'Attendance Input create';
            $seoTitle = 'Student Attendance Monthly';
            $seoDescription = 'Student Attendance Monthly';
            $seoKeyword = 'Student Attendance Monthly';
            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
            ];
            return view('frontend.school.student.attendanceAll', compact('Text', 'seo_array', 'dataShow', 'class_id', 'section_id', 'group_id', 'dataAttendance', 'date'));
        }
    }

    public function exportPdfAttendance($class_id, $section_id, $group_id, $date)
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
            $group_id = ($group_id == 0) ? NULL : $group_id;
            $dataAttendance = Attendance::where('class_id', $class_id)->where('section_id', $section_id)->where('group_id', $group_id)->whereDate('created_at', $date)->get();
            $dataShow = User::where('class_id', $class_id)->where('section_id', $section_id)->where('group_id', $group_id)->get();
            return view('frontend.school.pdf.attendance', compact('dataAttendance', 'dataShow', 'class_id', 'section_id', 'group_id', 'date'));
        }
    }

    public function exportCSVAttendance($class_id, $section_id, $group_id, $date)
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
            $group_id = ($group_id == 0) ? NULL : $group_id;
            return Excel::download(new AttendanceExport($class_id, $section_id, $group_id, $date), 'attendance.xlsx');
        }
    }

    public function attendanceShow($class_id, $section_id, $group_id)
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
            $group_id = ($group_id == 0) ? NULL : $group_id;
            $dataAttendance = Attendance::where('class_id', $class_id)->where('section_id', $section_id)->where('group_id', $group_id)->whereDate('created_at', date('d-m-Y'))->get();
            $dataShow = User::where('class_id', $class_id)->where('section_id', $section_id)->where('group_id', $group_id)->get();
            $Text = 'Subject Input create';
            $seoTitle = 'Student Attendance';
            $seoDescription = 'Student Attendance';
            $seoKeyword = 'Student Attendance';
            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
            ];
            return view('frontend.school.student.attendance', compact('Text', 'seo_array', 'dataShow', 'class_id', 'section_id', 'group_id', 'dataAttendance'));
        }
    }
    /**
     * Save Attendance in Database (Sajjad Devel)
     *
     * @param Request
     * @param $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function attendanceCreatePost(Request $request)
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

            // return $request;
            foreach ($request->student_id as $index => $code) {
                $attend = Attendance::where("school_id", Auth::user()->id)
                    ->where('class_id', getUserName($code)->class_id)
                    ->where('section_id', getUserName($code)->section_id)
                    ->where('student_id', $code)
                    ->whereDate('created_at', $request->segment_date)->delete();

                $attendance = Attendance::create(
                    [
                        "student_id"    => $code,
                        "class_id"      => getUserName($code)->class_id,
                        "section_id"    => getUserName($code)->section_id,
                        "school_id"     => Auth::user()->id,
                        "created_at"    => $request->segment_date . " " . "15:41:51",
                        "attendance"    => $request->attendance[$code][0],
                        "comment"       => $request->comment[$index],
                        "group_id"      => getUserName($code)->group_id
                    ]
                );

                if ($request->attendance[$code][0] == 0) {

                    $message = 'Student Name:' . getUserName($code)->name . ' is Absent';
                    $to      = getUserName($code)->phone;

                    Controller::GreenWebSMS($to, $message); // send sms for absent

                    $dataMessage = new Message();
                    $dataMessage->school_id = Auth::user()->id;
                    $dataMessage->message = 1;
                    $dataMessage->send_number = getUserName($code)->phone;
                    $dataMessage->save();
                }
            }
            toast("Attendance Save Successfully", "success");
            return back();
        }
    }

    public function confirmAbsentPresent(Request $request, $id)
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
            $data = Attendance::find($id);
            $data->attendance = $request->attendance;
            $data->save();

            // if ($request->attendance == 1) {
            //     $token   = "8371b733bd239059f940b857e94d4cf2";
            //     $code    = getUserName($data->student_id)->id;
            //     $to      = getUserName($data->student_id)->phone;
            //     $message = 'Student Name:' . getUserName($data->student_id)->name . ' is now Present';

            //     $url = "http://api.greenweb.com.bd/api.php?json";

            //     $data = [
            //         'to'      => "$to",
            //         'message' => "$message",
            //         'token'   => "$token"
            //     ];

            //     $ch = curl_init();
            //     curl_setopt($ch, CURLOPT_URL, $url);
            //     curl_setopt($ch, CURLOPT_ENCODING, '');
            //     curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            //     $smsresult = curl_exec($ch);
            // }

            return back();
        }
    }

    public function studentAttendanceShowDate()
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
            $class = InstituteClass::where('school_id', Auth::user()->id)->get();
            $section = Section::where('school_id', Auth::user()->id)->get();
            $group = Group::where('school_id', Auth::user()->id)->get();
            $text = 'Student Attendance Show';
            $seoTitle = 'Student Attendance Show';
            $seoDescription = 'Student Attendance Show';
            $seoKeyword = 'Student Attendance Show';
            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
            ];
            return view('frontend.school.student.attendanceShowDate', compact('text', 'seo_array', 'class', 'section', 'group'));
        }
    }

    public function studentAttendanceShowDateAll()
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
            $class = InstituteClass::where('school_id', Auth::user()->id)->get();
            $section = Section::where('school_id', Auth::user()->id)->get();
            $group = Group::where('school_id', Auth::user()->id)->get();
            $text = 'Student Attendance Show';
            $seoTitle = 'Student Attendance Monthly';
            $seoDescription = 'Student Attendance Monthly';
            $seoKeyword = 'Student Attendance Monthly';
            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
            ];
            return view('frontend.school.student.allAttendance', compact('text', 'seo_array', 'class', 'section', 'group'));
        }
    }

    public function studentFeesCreate()
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
            $studentText = 'Fees Input create';
            $seoTitle = 'Fees Create';
            $seoDescription = 'Fees Create';
            $seoKeyword = 'Fees Create';

            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
            ];
            return view('frontend.school.student.fees.create', compact('studentText', 'seo_array'));
        }
    }

    public function studentFeesShow()
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
            $studentText = 'Fees Input create';
            $seoTitle = 'Fees Show';
            $seoDescription = 'Fees Show';
            $seoKeyword = 'Fees Show';
            $fees = StudentFee::where('school_id', Auth::user()->id)->get();
            $feesclass = InstituteClass::where('school_id', Auth::user()->id)->get();
            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
            ];
            return view('frontend.school.student.fees.show', compact('studentText', 'fees', 'feesclass', 'seo_array'));
        }
    }


    public function  studentPaymentPost(Request $request)
    {
        // dd($request->all());

        $student = User::where('school_id', Auth::id())->where('id', $request->student_id);
        $data['student'] = $student->first();

        $discount = $data['student']->discount;
        $data['monthlyFee'] = InstituteClass::where('school_id', Auth::id())->where('id', $data['student']->class_id)->first()->class_fees;
        $discountCount = $data['monthlyFee'] - ($discount * $data['monthlyFee']) / 100;

        $data['studentFees'] = StudentMonthlyFee::where('school_id', Auth::id())->where('student_id', $data['student']->id)->where('month_name', $request->month_name)->sum('amount');

        $TotalAmount = $discountCount + $data['studentFees'];
        $datastudent = StudentMonthlyFee::where('school_id', Auth::id())->where('student_id', $data['student']->id)->get();


        $update = StudentMonthlyFee::where('month_name', $request->month_name)->where('student_id', $request->student_id)->get();
        // return $update;
        $payment = StudentMonthlyFee::find($update[0]->id);
        $newAmount = $request->paid_amount + $payment->paid_amount;

        if ($newAmount == $TotalAmount) {
            $payment->update([
                'status' => '2',
                'paid_amount' => $payment->paid_amount + $request->paid_amount,
            ]);
        } elseif ($newAmount == 0) {
            $payment->update([
                'status' => '0',
                'paid_amount' => $payment->paid_amount + $request->paid_amount,
            ]);
        } else {

            $payment->update([
                'status' => '1',
                'paid_amount' => $payment->paid_amount + $request->paid_amount,
            ]);
        }

        Alert::success('Payment succesful', 'Success Message');
        
        session(['printKey' => $request->student_id]);
        return back()->with('printDiv', "YES");
        
        // return redirect()->route('student.monthly.payment.domPDF',["student_id"=>$request->student_id, 'paid_amount' => $request->paid_amount, 'month_name'=> $request->month_name]);
    }

    
    
    public function studentMonthlyPaymentDomPdf($student_id, $paid_amount, $month_name)
    {
        $student = User::where('school_id', Auth::id())->where('id', $student_id);
        $data['student'] = $student->first();

        $discount = User::where('school_id', Auth::id())->where('id', $student_id)->first()->discount;
        $data['monthlyFee'] = InstituteClass::where('school_id', Auth::id())->where('id', $data['student']->class_id)->first()->class_fees;
        $discountCount = $data['monthlyFee'] - ($discount * $data['monthlyFee']) / 100;

        $data['studentFees'] = StudentMonthlyFee::where('school_id', Auth::id())->where('student_id', $data['student']->id)->where('month_name', $month_name)->sum('amount');
        $data['studentFeesType'] = StudentMonthlyFee::where('school_id', Auth::id())->where('student_id', $data['student']->id)->where('month_name', $month_name)->get();
        $TotalAmount = $discountCount + $data['studentFees'];
        $datastudent = StudentMonthlyFee::where('school_id', Auth::id())->where('student_id', $data['student']->id)->get();

        $update = StudentMonthlyFee::where('month_name', $month_name)->where('student_id', $student_id)->get();
        $payment = StudentMonthlyFee::find($update[0]->id);

        $newAmount = $paid_amount + $payment->paid_amount;

        if ($newAmount == $TotalAmount) {
                $status = '2';
                $paid_amount = $payment->paid_amount + $paid_amount;           
        } 
        elseif ($newAmount == 0) {
                $status = '0';
                $paid_amount = $payment->paid_amount + $paid_amount;

        } else {
                $status = '1';
                $paid_amount = $payment->paid_amount + $paid_amount;
        }
        
        if ($month_name == 'January') {$monthKey = 0; }           
        elseif ($month_name == 'February') {$monthKey = 1;}
        elseif ($month_name == 'March') {$monthKey = 2;}
        elseif ($month_name == 'April') {$monthKey = 3;}
        elseif ($month_name == 'MAy') {$monthKey = 4;}
        elseif ($month_name == 'June') {$monthKey = 5;}
        elseif ($month_name == 'July') {$monthKey = 6;}
        elseif ($month_name == 'August') {$monthKey = 7;}
        elseif ($month_name == 'September') {$monthKey = 8;}
        elseif ($month_name == 'October') {$monthKey = 9;}
        elseif ($month_name == 'November') {$monthKey = 10;}
        else {$monthKey = 11;}            
        
        $data['monthKey']= $monthKey;
        $data['status']= $status;
        $data['discountCount'] = $discountCount;
        $data['paid_amount'] = $paid_amount;
        $data['month_name'] = $month_name;
        // dd($data);
        
        // return view('frontend.school.pdf.studentPayment', $data);
        $pdf = PDF::loadView('frontend.school.pdf.studentPayment', $data);
        return $pdf->download($data['student']->unique_id.'.'.'pdf');
    }

    public function studentFeesCreatePost(Request $request)
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
                'class_id' => 'required',
            ]);
            $fees = new StudentFee();

            $fees->monthly_fee = $request->monthly_fee ?? 0;
            $fees->absent = $request->absent ?? 0;
            $fees->absent_after_break = $request->absent_after_break ?? 0;
            $fees->term_fees = $request->term_fees ?? 0;
            $fees->exam_center = $request->exam_center ?? 0;
            $fees->library = $request->library ?? 0;
            $fees->sport = $request->sport ?? 0;
            $fees->penalty = $request->penalty ?? 0;
            $fees->admission_form = $request->admission_form ?? 0;
            $fees->registration = $request->registration ?? 0;
            $fees->development = $request->development ?? 0;
            $fees->session = $request->session ?? 0;
            $fees->coaching = $request->coaching ?? 0;
            $fees->dairy = $request->dairy ?? 0;
            $fees->transport = $request->transport ?? 0;
            $fees->syllabus = $request->syllabus ?? 0;
            $fees->testimonial = $request->testimonial ?? 0;
            $fees->scout = $request->scout ?? 0;
            $fees->tour = $request->tour ?? 0;

            $fees->extra_fees = $request->extra_fees ?? 0;
            $fees->extra_fees_title = $request->extra_fees_title ?? 'null';
            $fees->class_id = $request->class_id;
            $fees->school_id = Auth::user()->id;
            $fees->save();
            toast('Successfully Uploaded', 'success');
            return redirect()->route('student.fees.show');
        }
    }

    public function studentFeesEdit($id)
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
            $studentText = 'Fees Input Edit';
            $seoTitle = 'Fees Show';
            $seoDescription = 'Fees Show';
            $seoKeyword = 'Fees Show';
            $feesEdit = StudentFee::where('id', $id)->first();
            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
            ];
            return view('frontend.school.student.fees.create', compact('studentText', 'feesEdit', 'seo_array'));
        }
    }

    public function studentFeesUpdate(Request $request, $id)
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
            $fees = StudentFee::find($id);

            $fees->monthly_fee = $request->monthly_fee ?? 0;
            $fees->absent = $request->absent ?? 0;
            $fees->absent_after_break = $request->absent_after_break ?? 0;
            $fees->term_fees = $request->term_fees ?? 0;
            $fees->exam_center = $request->exam_center ?? 0;
            $fees->library = $request->library ?? 0;
            $fees->sport = $request->sport ?? 0;
            $fees->penalty = $request->penalty ?? 0;
            $fees->admission_form = $request->admission_form ?? 0;
            $fees->registration = $request->registration ?? 0;
            $fees->development = $request->development ?? 0;
            $fees->session = $request->session ?? 0;
            $fees->coaching = $request->coaching ?? 0;
            $fees->dairy = $request->dairy ?? 0;
            $fees->transport = $request->transport ?? 0;
            $fees->syllabus = $request->syllabus ?? 0;
            $fees->testimonial = $request->testimonial ?? 0;
            $fees->scout = $request->scout ?? 0;
            $fees->tour = $request->tour ?? 0;

            $fees->extra_fees = $request->extra_fees ?? 0;
            $fees->extra_fees_title = $request->extra_fees_title ?? 'null';
            $fees->class_id = $request->class_id;
            $fees->school_id = Auth::user()->id;
            $fees->save();
            toast('Successfully Uploaded', 'success');
            return redirect()->route('student.fees.show');
        }
    }

    public function studentFeesDelete($id)
    {
        if (Auth::user()->status == 0) {
            return redirect()->route('school.payment.info');
        } elseif (Auth::user()->status == 2) {
            toast('Sorry Admin can Inactive Your Account Please Contact', 'error');
            return back();
        }
        $fees = StudentFee::where('id', $id)->delete();
        return redirect()->route('student.fees.show');
    }

    //finance ...

    public function assignStudentFinanceDataShow($class_id, $section_id, $group_id)
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
            $group_id = ($group_id == 0) ? NULL : $group_id;
            $dataShow = User::where('class_id', $class_id)->where('section_id', $section_id)->where('group_id', $group_id)->get();
            $teacherText  = 'Student Input create';
            $seoTitle = 'Finance DataShow';
            $seoDescription = 'Finance DataShow';
            $seoKeyword = 'Finance DataShow';
            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
            ];
            return view('frontend.school.student.finance.dataShow', compact('teacherText', 'seo_array', 'dataShow'));
        }
    }

    public function assignStudentFinanceDataShowNew($class_id, $section_id, $group_id, $month_name)
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
            $group_id = ($group_id == 0) ? NULL : $group_id;
            $dataShow = User::where('class_id', $class_id)->where('section_id', $section_id)->where('group_id', $group_id)->get();
            $teacherText  = 'Student Input create';
            $seoTitle = 'Finance DataShow';
            $seoDescription = 'Finance DataShow';
            $seoKeyword = 'Finance DataShow';
            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
            ];
            return view('frontend.school.student.finance.dataShowNew', compact('teacherText', 'seo_array', 'dataShow'));
        }
    }

    public function studentFinanceCreateShow()
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
            $class = InstituteClass::where('school_id', Auth::user()->id)->get();
            $section = Section::where('school_id', Auth::user()->id)->get();
            $group = Group::where('school_id', Auth::user()->id)->get();
            $subjectText = 'student Input create';
            $seoTitle = 'Finance DataShow';
            $seoDescription = 'Finance DataShow';
            $seoKeyword = 'Finance DataShow';
            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
            ];
            return view('frontend.school.student.finance.createShow', compact('subjectText', 'seo_array', 'class', 'section', 'group'));
        }
    }

    public function studentFinanceCreateShowNew()
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
            $class = InstituteClass::where('school_id', Auth::user()->id)->get();
            $section = Section::where('school_id', Auth::user()->id)->get();
            $group = Group::where('school_id', Auth::user()->id)->get();
            $subjectText = 'student Input create';
            $seoTitle = 'Finance DataShow';
            $seoDescription = 'Finance DataShow';
            $seoKeyword = 'Finance DataShow';
            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
            ];
            return view('frontend.school.student.finance.createShowNew', compact('subjectText', 'seo_array', 'class', 'section', 'group'));
        }
    }

    public function studentFinanceAddFees($id, $class_id, $section_id, $group_id)
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
            $subjectText = 'student Fees Input create';
            $seoTitle = 'Finance DataShow';
            $seoDescription = 'Finance DataShow';
            $seoKeyword = 'Finance DataShow';
            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
            ];
            $studentFees = StudentMonthlyFee::where('student_id', $id)->get();
            return view('frontend.school.student.finance.classFees', compact('class_id', 'studentFees', 'section_id', 'group_id', 'seo_array', 'subjectText'));
        }
    }

    public function studentFinanceEditFees($id, $student_id, $class_id, $section_id, $group_id)
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
            $subjectText = 'student Fees Input Edit';
            $seoTitle = 'Finance DataShow';
            $seoDescription = 'Finance DataShow';
            $seoKeyword = 'Finance DataShow';
            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
            ];
            $studentFeesEdit = StudentMonthlyFee::where('id', $id)->first();
            return view('frontend.school.student.finance.classFeesEdit', compact('class_id', 'studentFeesEdit', 'section_id', 'group_id', 'seo_array', 'subjectText'));
        }
    }

    public function studentFinanceUpdateFees(Request $request, $id)
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
            // here status = 2 means full paid and status == 1 means pertials paid and status == 0 means non-paid
            $studentFeesEdit = StudentMonthlyFee::where('id', $id)->first();
            $studentFeesEdit->amount = $studentFeesEdit->amount + $request->amount;
            if ($request->total == $studentFeesEdit->amount) {
                $studentFeesEdit->status = 2;
            } else {
                $studentFeesEdit->status = 1;
            }
            $studentFeesEdit->save();
            return redirect()->route('add.fees.show', ['id' => $request->student_id, 'class_id' => $request->class_id, 'section_id' => $request->section_id, 'group_id' => is_null($request->group_id) ? 0 : $request->group_id]);
        }
    }







    //expense list show

    public function expenselist()
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
            $expense = Transection::where('status', true)->where('type', 1)->latest()->get();
            return view('frontend.school.expense.table', compact('expense'));
        }
    }

    /** --------------- expense data table
     * =============================================*/
    public function expensecreate()
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
            return view('frontend.school.expense.form');
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

                'date'  => 'required',
                'amount'  => 'required|integer',
                'purpose'  => 'required',
                'payment_method' => 'required',
                'type' => 'required',
                'name' => 'required',


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

            return view('frontend.school.expense.form')->with(compact('expense'));
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

                'date'  => 'required',
                'amount'  => 'required|integer',
                'purpose'  => 'required',
                'payment_method' => 'required',
                'type' => 'required',
                'name' => 'required',
            ]);


            $data = $request->all();
            $data['school_id'] = Auth::user()->id;

            $expense = Transection::find($key)->update($data);

            if ($request->type == 1) {
                return redirect()->route('expense.show')->with('success', 'Record created successfully');
            } else {
                return redirect()->route('fund.show')->with('success', 'Record created successfully');
            }
        }
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

    //Fund list show

    public function fundlist()
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
            $expense = Transection::where('status', true)->where('type', 2)->latest()->get();
            return view('frontend.school.fund.table', compact('expense'));
        }
    }

    /** --------------- expense data table
     * =============================================*/
    public function fundcreate()
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
            return view('frontend.school.expense.form');
        }
    }


    /** --------------- Store expense
     * =============================================*/
    public function fundstore(Request $request)
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

                'date'  => 'required',
                'amount'  => 'required|integer',
                'purpose'  => 'required',
                'payment_method' => 'required',
                'type' => 'required',
                'name' => 'required',


            ]);

            $data = $request->all();
            $data['school_id'] = Auth::user()->id;

            // return $data;

            $expense = Transection::create($data);

            if ($request->type == 1) {
                return redirect()->route('expense.show')->with('success', 'Record created successfully');
            } elseif ($request->type == 2) {
                return redirect()->route('fund.show')->with('success', 'Record created successfully');
            }
        }
    }



    /** --------------- expense data edit
     * =============================================*/
    public function fundedit(Request $request)
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

            return view('frontend.school.expense.form')->with(compact('expense'));
        }
    }



    /** --------------- Update expense
     * =============================================*/
    public function fundupdate(Request $request)
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

                'date'  => 'required',
                'amount'  => 'required|integer',
                'purpose'  => 'required',
                'payment_method' => 'required',
                'type' => 'required',
                'name' => 'required',
            ]);


            $data = $request->all();
            $data['school_id'] = Auth::user()->id;

            $expense = Transection::find($key)->update($data);

            if ($request->type == 1) {
                return redirect()->route('expense.show')->with('success', 'Record created successfully');
            } else {
                return redirect()->route('fund.show')->with('success', 'Record created successfully');
            }
        }
    }



    /** --------------- delete fund
     * =============================================*/
    public function funddestroy(Request $request)
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



    /** --------------- assets data table
     * =============================================*/
    public function show()
    {
        $asset = Asset::where('status', true)->latest()->get();

        return view('frontend.school.asset.table')->with(compact('asset'));
    }


    /** --------------- assets data table
     * =============================================*/
    public function create()
    {
        return view('inventory.asset.form');
    }



    /** --------------- Store assets
     * =============================================*/
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required',
            'quantity' => 'required|integer',
            'image' => 'nullable | mimes: jpg,jpeg,png,webp'
        ]);

        $data = $request->all();


        if ($request->hasFile('image')) {
            $FileName = $request->image->hashName(); // Generate a unique, random name...

            // save into folder
            $request->image->move(public_path('asset'), $FileName);

            // save into database
            $path = 'asset/' . $FileName;

            $data['image'] = $path;
        }

        $asset = Asset::create($data);

        return redirect()->route('asset')->with('success', 'Record created successfully');
    }



    /** --------------- edit assets data
     * =============================================*/
    public function edit(Request $request)
    {
        $key = $request->key;
        $asset = Asset::find($key);
        return view('frontend.school.asset.form')->with(compact('asset'));
    }




    /** --------------- Update assets
     * =============================================*/
    public function update(Request $request)
    {
        $key = $request->key;

        $request->validate([
            'name'  => 'required',
            'image' => 'nullable | mimes: jpg,jpeg,png,webp',
            'quantity' => 'required|integer',
        ]);


        $data = $request->all();


        if ($request->hasFile('image')) {
            $FileName = $request->image->hashName(); // Generate a unique, random name...

            // save into folder
            $request->image->move(public_path('asset'), $FileName);

            // save into database
            $path = 'asset/' . $FileName;

            $data['image'] = $path;
        }

        $asset = Asset::find($key)->update($data);

        return redirect()->route('asset')->with('success', 'Record updated successfully');
    }



    /** --------------- delete asset
     * =============================================*/
    public function destroy(Request $request)
    {
        $key = $request->key;

        $asset = Asset::destroy($key);

        return redirect()->route('asset')->with('success', 'Record deleted successfully');
    }


    //sms send ....users
    public function smsUsagesData()
    {
        if (Auth::user()->is_editor != 3) {
            return back();
        } else {
            $classText = 'Message UseageData';
            $seoTitle = 'Message UseageData';
            $seoDescription = 'Message UseageData';
            $seoKeyword = 'Message UseageData';
            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
            ];
            $class = Message::where('school_id', Auth::user()->id)->get();
            return view('frontend.school.message.messageUseageData', compact('class', 'seo_array', 'classText'));
        }
    }

    public function sendFeesDueSms()
    {
        if (Auth::user()->status == 0) {
            return redirect()->route('school.payment.info');
        } elseif (Auth::user()->status == 2) {
            toast('Sorry Admin can Inactive Your Account Please Contact', 'error');
            return back();
        }
        $month_id = date('m');
        $data = StudentMonthlyFee::where('school_id', Auth::user()->id)->where('status', '<', 2)->groupby('student_id')->pluck('student_id');
        $dataMessageCount = StudentMonthlyFee::where('school_id', Auth::user()->id)->where('status', '<', 2)->groupby('student_id')->count();
        $testData = StudentMonthlyFee::where('student_id', 5)->where('amount', 0)->pluck('month_name')->toArray();
        $result = "'" . implode("', '", $testData) . " . Fees is Pending,Please try to Clear this Fees As early as Possible. thank you (" . Auth::user()->school_name . ' )';

        $smsCount = 0; // init count
        $numbers = [];
        $messages = [];
        $startOfWeek = Carbon::now()->startOfWeek(Carbon::SUNDAY)->format("Y-m-d");
        $endOfWeek = Carbon::now()->endOfWeek(Carbon::FRIDAY)->format("Y-m-d");

        if (Message::whereBetween('created_at', [$startOfWeek, $endOfWeek])->where(['school_id' => Auth::id(), 'status' => 2])->count() >= 2) :
            Alert::info('Sorry!', 'SMS can\'t be sent more than two times to all students per week. But single SMS can be sent unlimited times');
            return back();
        endif;

        foreach ($data as $student) {
            $user = User::where('id', $student)->first();
            $code    = $user->name . ' And ' . $user->roll_number;
            $to      = $user['phone'];
            $testData = StudentMonthlyFee::where('student_id', $student)->where('amount', 0)->where('month_id', $month_id - 1)->pluck('month_name')->toArray();
            $message = "'" . implode("', '", $testData) . " . Fees is Pending,Please try to Clear this Fees As early as Possible. thank you (" . Auth::user()->school_name . ' )';

            Controller::GreenWebSMS($to, $message);

            ++$smsCount; // increment sms count

            $numbers[] = $to;
            $messages[] = [$to => $message];
        }

        $sms = new Message();
        $sms->school_id = Auth::id();
        $sms->message = $smsCount; // number of sending sms
        $sms->send_number = json_encode($numbers);
        $sms->data = json_encode($messages);
        $sms->status = 2; // for sending sms to all user
        $sms->save();

        Alert::success('Success Send All Due Messages', 'Success Message');

        return back();
    }

    /**
     * send sms to office staff
     */
    public function sendSmsToEmployee()
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
            $url = url()->previous();
            $urlEmployeeData = url('/') . '/school/' . session('dataSession');
            if ($url == $urlEmployeeData) {
                $urlEmployee = $urlEmployeeData;
            } else {
                $urlEmployee = '';
            }
            $classText = 'Employee Sms Send';
            $seoTitle = 'Employee SMS';
            $seoDescription = 'Employee SMS';
            $seoKeyword = 'Employee SMS';
            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
                'urlEmployee' => $urlEmployee,
            ];
            return view('frontend.school.message.employeeSms', compact('classText', 'seo_array'));
        }
    }

    public function  sendSmsToEmployeePost(Request $request)
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
            // $messageAccount = getMessageAccount();
            if ($request->id == 'all_employee') {
                $smsCount = 0; // init count
                $numbers = []; // init array
                $messages = []; // init array

                $employee = Employee::where('school_id', Auth::user()->id);

                if ($employee->count() > 0) {
                    foreach ($employee->get() as $data) {

                        $to = $data['phone_number'];
                        $message = $request['message'] . ". Thanks from " . Auth::user()->school_name;

                        Controller::GreenWebSMS($to, $message);

                        ++$smsCount; // increment sms count
                        $numbers[] = $to;
                        $messages[] = [$to => $message];
                    }

                    $sms = new Message();
                    $sms->school_id = Auth::id();
                    $sms->message = $smsCount; // number of sending sms
                    $sms->send_number = json_encode($numbers);
                    $sms->data = json_encode($messages);
                    $sms->status = 2; // for sending sms to all user
                    $sms->save();
                } else {
                    Alert::error("Oops!", 'Record does not exists');
                    return back();
                }
            } else {
                $to = $request['id'];
                $message = $request['message'] . ". Thanks from " . Auth::user()->school_name;

                Controller::GreenWebSMS($to, $message);

                $dataMessage = new Message();
                $dataMessage->school_id = Auth::user()->id;
                $dataMessage->message = 1; // for single SMS
                $dataMessage->send_number = $to;
                $dataMessage->save();
            }

            Alert::success('Successfully Sms Send', 'Success Message');
            return redirect()->route('send.sms.employee');
        }
    }

    public function sendSmsToTeacher()
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
            $url = url()->previous();
            $urlTeacherData = url('/') . '/school/' . session('dataSession');
            if ($url == $urlTeacherData) {
                $urlTeacher = $urlTeacherData;
            } else {
                $urlTeacher = '';
            }
            $classText = 'Teacher Sms Send';
            $seoTitle = 'Teacher SMS';
            $seoDescription = 'Teacher SMS';
            $seoKeyword = 'Teacher SMS';
            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
                'urlTeacher' => $urlTeacher,
            ];
            return view('frontend.school.message.teacherSms', compact('classText', 'seo_array'));
        }
    }

    public function sendSmsToTeacherPost(Request $request)
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

            if ($request->id == 'all_teacher') // send sms to all teacher
            {
                $smsCount = 0; // init count
                $numbers = [];
                $messages = [];
                $startOfWeek = Carbon::now()->startOfWeek(Carbon::SUNDAY)->format("Y-m-d");
                $endOfWeek = Carbon::now()->endOfWeek(Carbon::FRIDAY)->format("Y-m-d");

                if (Message::whereBetween('created_at', [$startOfWeek, $endOfWeek])->where(['school_id' => Auth::id(), 'status' => 2])->count() >= 2) :
                    Alert::info('Sorry!', 'SMS can\'t be sent more than two times to all students per week. But single SMS can be sent unlimited times');
                    return back();
                endif;

                $teacher = Teacher::where('school_id', Auth::user()->id);

                if ($teacher->count() > 0) {
                    foreach ($teacher->get() as $data) {
                        $to = $data['phone'];
                        $message = $request['message'] . " Thanks from " . Auth::user()->school_name;
                        Controller::GreenWebSMS($to, $message); // send sms

                        ++$smsCount;
                        $numbers[] = $to;
                        $messages[] = [$to => $message];
                    }

                    // save records
                    $sms = new Message();
                    $sms->school_id = Auth::id();
                    $sms->message = $smsCount; // number of sending sms
                    $sms->send_number = json_encode($numbers);
                    $sms->data = json_encode($messages);
                    $sms->status = 2; // for sending sms to all user
                    $sms->save();
                } else {
                    Alert::error('Sorry!', 'Record does not exists');
                    return back();
                }
            } else {
                $to = $request['id'];
                // return ($to);
                $message = $request['message'] . " Thanks from " . Auth::user()->school_name;
                Controller::GreenWebSMS($to, $message); // send sms

                // save records
                $dataMessage = new Message();
                $dataMessage->school_id = Auth::user()->id;
                $dataMessage->message = 1;
                $dataMessage->send_number = $to;
                $dataMessage->save();
            }
            Alert::success('Successfully Sms Send', 'Success Message');
            return redirect()->route('send.sms.teacher');
        }
    }

    public function sendSmsToStudent()
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
            $url = url()->previous();
            $urlTeacherData = url('/') . '/school/' . session('dataSession');
            if ($url == $urlTeacherData) {
                $urlTeacher = $urlTeacherData;
            } else {
                $urlTeacher = '';
            }
            $classText = 'Student Sms Send';
            $seoTitle = 'Student SMS';
            $seoDescription = 'Student SMS';
            $seoKeyword = 'Student SMS';
            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
                'urlTeacher' => $urlTeacher,
            ];
            return view('frontend.school.message.studentSms', compact('classText', 'seo_array'));
        }
    }

    public function sendSmsToStudentPost(Request $request)
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
            // $messageAccount = getMessageAccount();

            if ($request->has('all_students')) // sending sms to the all student
            {
                $smsCount = 0; // init count
                $numbers = [];
                $messages = [];
                $startOfWeek = Carbon::now()->startOfWeek(Carbon::SUNDAY)->format("Y-m-d");
                $endOfWeek = Carbon::now()->endOfWeek(Carbon::FRIDAY)->format("Y-m-d");

                if (Message::whereBetween('created_at', [$startOfWeek, $endOfWeek])->where(['school_id' => Auth::id(), 'status' => 2])->count() >= 2) :
                    Alert::info('Sorry!', 'SMS can\'t be sent more than two times to all students per week. But single SMS can be sent unlimited times');
                    return back();
                endif;

                foreach (User::where('school_id', Auth::user()->id)->get() as $data) {

                    $to = $data['phone'];
                    $message = $request['message'] . '(' . Auth::user()->school_name . ')';

                    Controller::GreenWebSMS($to, $message);

                    ++$smsCount; // increment sms count

                    $numbers[] = $to;
                    $messages[] = [$to => $message];
                }

                $sms = new Message();
                $sms->school_id = Auth::id();
                $sms->message = $smsCount; // number of sending sms
                $sms->send_number = json_encode($numbers);
                $sms->data = json_encode($messages);
                $sms->status = 2; // for sending sms to all user
                $sms->save();
            } elseif ($request->has('student_id') && $request->student_id == 0) // send sms to selected class student
            {
                $users = User::where(['school_id' => Auth::id(), 'shift' => $request->shift, 'class_id' => $request->class])->get();

                $smsCount = 0; // init count
                $numbers = [];
                $messages = [];
                $startOfWeek = Carbon::now()->startOfWeek(Carbon::SUNDAY)->format("Y-m-d");
                $endOfWeek = Carbon::now()->endOfWeek(Carbon::FRIDAY)->format("Y-m-d");

                if (Message::whereBetween('created_at', [$startOfWeek, $endOfWeek])->where(['school_id' => Auth::id(), 'status' => 2])->count() >= 2) :
                    Alert::info('Sorry!', 'SMS can\'t be sent more than two times to all students per week. But single SMS can be sent unlimited times');
                    return back();
                endif;

                foreach ($users as $data) {

                    $to = $data['phone'];
                    $message = $request['message'] . '(' . Auth::user()->school_name . ')';

                    Controller::GreenWebSMS($to, $message);

                    ++$smsCount; // Increasing sms count

                    $numbers[] = $to;
                    $messages[] = [$to => $message];
                }

                $sms = new Message();
                $sms->school_id = Auth::id();
                $sms->message = $smsCount; // number of sending sms
                $sms->send_number = json_encode($numbers);
                $sms->data = json_encode($messages);
                $sms->status = 2; // for sending sms to all user
                $sms->save();
            } else // send sms to single student
            {
                $to = $request['student_id'];
                $message = $request['message'] . '(' . Auth::user()->school_name . ')';

                Controller::GreenWebSMS($to, $message);

                $dataMessage = new Message();
                $dataMessage->school_id = Auth::user()->id;
                $dataMessage->message = 1;
                $dataMessage->send_number = $to;
                $dataMessage->save();
            }

            Alert::success('Successfully Sms Send', 'Success Message');
            return redirect()->route('send.sms.student');
        }
    }

    //fees ....

    public function schoolStaffCreate()
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
            $studentText = 'Staff Input create';
            $seoTitle = 'Staff TypeCreate';
            $seoDescription = 'Staff TypeCreate';
            $seoKeyword = 'Staff TypeCreate';

            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
            ];
            return view('frontend.school.staff.type.create', compact('studentText', 'seo_array'));
        }
    }

    public function schoolStaffEdit($id)
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
            $studentText = 'Staff Input Edit';
            $seoTitle = 'Staff Show';
            $seoDescription = 'Staff Show';
            $seoKeyword = 'Staff Show';
            $feesEdit = StaffType::where('id', $id)->first();
            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
            ];
            return view('frontend.school.staff.type.create', compact('studentText', 'feesEdit', 'seo_array'));
        }
    }

    public function schoolStaffShow()
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
            $studentText = 'Staff Input create';
            $seoTitle = 'Staff Type List';
            $seoDescription = 'Staff Type List';
            $seoKeyword = 'Staff Type List';
            $fees = StaffType::where('school_id', Auth::user()->id)->get();
            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
            ];
            return view('frontend.school.staff.type.show', compact('studentText', 'fees', 'seo_array'));
        }
    }

    public function schoolStaffCreatePost(Request $request)
    {
        if (Auth::user()->status == 0) {
            return redirect()->route('school.payment.info');
        } elseif (Auth::user()->status == 2) {
            toast('Sorry Admin can Inactive Your Account Please Contact', 'error');
            return back();
        }
        $request->validate([
            'position_name' => 'required',
            'position_name_bn' => 'required',
        ]);
        $fees = new StaffType();

        $fees->position_name = $request->position_name;
        $fees->position_name_bn = $request->position_name_bn;
        $fees->school_id = Auth::user()->id;

        $fees->save();
        Alert::success('Success Create Staff Type', 'Success Message');
        return redirect()->route('school.staff.show');
    }

    public function schoolStaffUpdate(Request $request, $id)
    {
        if (Auth::user()->status == 0) {
            return redirect()->route('school.payment.info');
        } elseif (Auth::user()->status == 2) {
            toast('Sorry Admin can Inactive Your Account Please Contact', 'error');
            return back();
        }
        $fees = StaffType::find($id);
        $fees->position_name = $request->position_name;
        $fees->position_name_bn = $request->position_name_bn;
        $fees->school_id = Auth::user()->id;
        $fees->save();

        Alert::success('Success Update Staff Type', 'Success Message');

        return redirect()->route('school.staff.show');
    }

    public function schoolStaffTypeDelete($id)
    {
        if (Auth::user()->status == 0) {
            return redirect()->route('school.payment.info');
        } elseif (Auth::user()->status == 2) {
            toast('Sorry Admin can Inactive Your Account Please Contact', 'error');
            return back();
        }
        if ($row = StaffType::find($id)) :
            $row->delete();
            Alert::success('Great!', "Staff type deleted successfully");
        else :
            Alert::success('Sorry', "Staff type not found");
        endif;
        return back();
    }
    public function stafftype_Check_delete(Request $request)
    {
        $ids = $request->ids;
        StaffType::whereIn('id',$ids)->delete();
        Alert::success(' Selected Staff-Type are deleted', 'Success Message');
        return response()->json(['status'=>'success']);
    }
    public function getSalaryStaff($staffId)
{
    $salary = EmployeeSalary::where('school_id', Auth::user()->id)->where('id', $staffId)->get();
    return response()->json($salary);
}   

 public function schoolStaffList()
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
            $studentText = 'Staff Data Show';
            $seoTitle = 'Staff List';
            $seoDescription = 'Staff List';
            $seoKeyword = 'Staff List';
            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
            ];
            $position_name = StaffType::where('school_id', Auth::user()->id)->get();
            $employee = Employee::where('school_id', Auth::user()->id)->get();
            $staffSalary = EmployeeSalary::where('school_id', Auth::user()->id)->get();
            // $staffMonthlySalary = Employee::where('id', $employee->id)->first();
            return view('frontend.school.staff.details.show', compact('studentText', 'position_name', 'employee','staffSalary', 'seo_array'));
        }
    }
    public function schoolStaffListEdit($id)
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
            $studentText = 'Staff Data Show';
            $seoTitle = 'Staff Show';
            $seoDescription = 'Staff Show';
            $seoKeyword = 'Staff Show';
            $position = StaffType::where('school_id', Auth::user()->id)->get();
            $employeeEdit = Employee::where('school_id', Auth::user()->id)->where('id', $id)->first();
            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
            ];
            return view('frontend.school.staff.details.create', compact('studentText', 'employeeEdit', 'position', 'seo_array'));
        }
    }

    public function schoolStaffListCreate()
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
            $studentText = 'Staff Details create';
            $seoTitle = 'Staff Create';
            $seoDescription = 'Staff Create';
            $seoKeyword = 'Staff Create';
            $position = StaffType::where('school_id', Auth::user()->id)->get();
            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
            ];
            return view('frontend.school.staff.details.create', compact('studentText', 'position', 'seo_array'));
        }
    }

    public function schoolStaffListCreatePost(Request $request)
    {
        try {
            if (Auth::user()->status == 0) {
                return redirect()->route('school.payment.info');
            } elseif (Auth::user()->status == 2) {
                toast('Sorry Admin can Inactive Your Account Please Contact', 'error');
                return back();
            }
            $request->validate([
                'employee_name' => 'required',
                'position_name' => 'required',
                'shift' => 'required',
                'gender' => 'required',
                'phone_number' => 'required|unique:employees|min:11',
                'salary' => 'numeric',
            ]);

            $employee = new Employee();
            $employee->phone_number = $request->phone_number;
            $employee->employee_id = $request->employee_id;
            $employee->employee_name = $request->employee_name;
            $employee->address = $request->address;
            $employee->salary = $request->salary;
            $employee->position = $request->position_name;
            $employee->school_id = Auth::user()->id;
            $employee->save();

            $month = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

            foreach ($month as $data) {
                $fees = new EmployeeSalary();
                $fees->month_name = $data;
                $fees->employee_id = $employee->id;
                $fees->school_id = Auth::user()->id;
                $fees->save();
            }

            return redirect()->route('school.staff.List');
        } catch (Exception $e) {
            toast($e->getMessage(), 'error');
        }
        return back();
    }

    public function schoolStaffListCreateUpdate(Request $request, $id)
    {
        if (Auth::user()->status == 0) {
            return redirect()->route('school.payment.info');
        } elseif (Auth::user()->status == 2) {
            toast('Sorry Admin can Inactive Your Account Please Contact', 'error');
            return back();
        }
        $request->validate([
            'employee_name' => 'required',
            'position_name' => 'required',
            'phone_number' => 'required|min:11',
            'shift' => 'required',
            'gender' => 'required',
            'salary' => 'numeric',
        ]);

        try {

            $employee = Employee::find($id);

            if ($request->hasFile('image')) {
                File::delete(public_path($employee->image));

                $fileName = date('Ymdhmsis') . '.' . $request->file('image')->extension();
                $request->file('image')->move(public_path('uploads/staff'), $fileName);
                $filePath = "uploads/staff/" . $fileName;
                $employee->image = $filePath;
            }

            $employee->phone_number = $request->phone_number;
            $employee->employee_name = $request->employee_name;
            $employee->shift = $request->shift;
            $employee->gender = $request->gender;
            $employee->address = $request->address;
            $employee->salary = $request->salary;
            $employee->position = $request->position_name;
            $employee->school_id = Auth::user()->id;

            $employee->save();
            Alert::success('Staff Updated Success', 'Success Message');
            return redirect()->route('school.staff.List');
        } catch (Exception $e) {
            toast($e->getMessage(), 'error');
        }
        return back();
    }

    public function schoolStaffDelete($id)
    {
        if (Auth::user()->status == 0) {
            return redirect()->route('school.payment.info');
        } elseif (Auth::user()->status == 2) {
            toast('Sorry Admin can Inactive Your Account Please Contact', 'error');
            return back();
        }
        $Employee = EmployeeSalary::where('employee_id', $id)->delete();

        if ($row = Employee::find($id)) :
            $row->delete();
            Alert::success('Great!', "Staff Record deleted successfully");
        else :
            Alert::success('Sorry', "Staff Record not found");
        endif;
        return back();
    }
    public function staff_Check_Delete(Request $request)
    {
        $ids = $request->ids;
        Employee::whereIn('id',$ids)->delete();
        Alert::success(' Selected staffs are deleted', 'Success Message');
        return response()->json(['status'=>'success']);
    }


    /**
     * Result Setting View Page
     *
     * @author CodeCell <support@codecell.com.bd>
     * @distributor Sajjad <sajjad.develpr@com.bd>
     * @return \Illuminate\Contracts\View\View
     */
    public function resultCreateShow()
    {   
        $seoTitle = 'Result Setting';
        $seoDescription = 'Result Setting' ;
        $seoKeyword = 'Result Setting';
        $seo_array = [
            'seoTitle' => $seoTitle,
            'seoKeyword' => $seoKeyword,
            'seoDescription' => $seoDescription,
        ];
        $schoolExist = School::where('id', Auth::user()->id)->exists();
        $layout = $schoolExist ? 'layouts.school.master' : 'layouts.teacher.master';
        $school_id = $schoolExist ? Auth::user()->id : Auth::user()->school_id;

        $resultSettings = ModelsResultSetting::where('school_id', $school_id)->orderBy('id', 'asc')->get();

        return view('frontend.school.student.result.createShow', compact('resultSettings', 'layout','seo_array'));
    }

    /**
     * Result Upload First Step (Select Class, Section, Term)
     * 
     * @author CodeCell <support@codecell.com.bd>
     * @contributor Sajjad <sajjad.develpr@gmail.com>
     * @param int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function resultUpFirstStep($id)
    {   
        $resultSettingId = $id;
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
            $group = Group::where('school_id', Auth::user()->id)->get();
            $term = Term::where('school_id', Auth::user()->id)->orderBy('id', 'desc')->get();
            $subjectText = 'Result Setting';
            $seoTitle = 'Result Setting';
            $seoDescription = 'Result Setting';
            $seoKeyword = 'Result Setting';
            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
            ];

            return view('frontend.school.student.result.resultUpload', compact('subjectText', 'seo_array', 'class', 'section', 'group', 'resultSettingId', 'term'));
        }
    }


    public function resultCreateShowPost(Request $request)
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
            // dd($request->all());
            if ($request->subject == '1') {
                $request->validate(
                    [
                        'class_id' => 'required',
                        'section_id' => 'required',
                        // 'term_id' => 'required',
                    ],
                    [
                        'class_id.required' => 'Class Required',
                        'section_id.required' => 'Section Required',
                        // 'term_id.required' => 'Term Required',
                    ]
                );
                $class_id = $request->class_id;
                $section_id = $request->section_id;
                
                $term_id = $request->resultSettingId ?? '';

                return redirect()->route('school.result.dataShowAll', ['class_id' => $class_id, 'section_id' => $section_id, 'term_id' => $term_id]);
            } else {
                $request->validate([
                    'class_id' => 'required',
                    'section_id' => 'required',
                    'subject_id' => 'required',
                    // 'term_id' => 'required',
                ]);
                $class_id = $request->class_id;
                $section_id = $request->section_id;
                //$group_id = is_null($request->group_id) ? 0 : $request->group_id;
                $subject_id = $request->subject_id;
                $term_id = $request->resultSettingId ?? '';
                return redirect()->route('school.result.dataShow', ['class_id' => $class_id, 'section_id' => $section_id, 'subject_id' => $subject_id, 'term_id' => $term_id]);
            }
        }
    }

    /**
     * Show Student and Input Result
     * 
     * @author CodeCell <support@codecell.com.bd>
     * @contributor Sajjad <sajjad.develpr@gmail.com>
     * @param int $class_id
     * @param int $section_id
     * @param int $term_id
     * 
     * @return \Illuminate\Contracts\View\View
     */
    public function resultStudentDataShowAll($class_id, $section_id, $term_id)
    {   
        $seoTitle = 'Result Setting';
        $seoDescription = 'Result Setting' ;
        $seoKeyword = 'Result Setting';
        $seo_array = [
            'seoTitle' => $seoTitle,
            'seoKeyword' => $seoKeyword,
            'seoDescription' => $seoDescription,
        ];
        ini_set('max_execution_time', 600); 
        
        // $dataShow = User::where('school_id', Auth::user()->id)->where('class_id', $class_id)->where('section_id', $section_id)->orderBy('roll_number', 'asc')->get();
        $termName = ModelsResultSetting::where('id', $term_id)->first();
        $subjectName = Subject::where('class_id', $class_id)->get();
        $markTypes = MarkType::where('institute_classes_id', $class_id)->where('school_id', Auth::user()->id)->orderBy('id', 'asc')->get();
        
        return view('frontend.school.student.result.dataShowAll', compact( 'termName', 'subjectName', 'markTypes', 'section_id', 'class_id','seo_array'));
    }

    public function resultStudentDataShow($class_id, $section_id, $group_id, $subject_id, $term_id)
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
            // dd($subject_id);
            $group_id = ($group_id == 0) ? NULL : $group_id;
            $dataShow = User::where('class_id', $class_id)->where('section_id', $section_id)->where('group_id', $group_id)->get();
            $dataShowTeacher = AssignTeacher::where('class_id', $class_id)->where('section_id', $section_id)->where('group_id', $group_id)->where('subject_id', $subject_id)->first();
            $subjectName = Subject::where('id', $subject_id)->first();
            $termName = Term::where('id', $term_id)->first();
            $teacherText  = 'Result Setting';
            $seoTitle = 'Result Setting';
            $seoDescription = 'Result Setting';
            $seoKeyword = 'Result Setting';
            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
            ];

            return view('frontend.school.student.result.dataShow', compact('teacherText', 'seo_array', 'dataShow', 'dataShowTeacher', 'subjectName', 'termName'));
        }
    }

    /**
     * Update Student Result
     *
     * @author CodeCell <support@codecell.com.bd>
     * @contributor Sajjad <sajjad.develpr@gmail.com>
     * @param Request
     * @param $request
     * @param int $id
     * @return Response
     */
    public function resultmarkSet(Request $request, $id)
    {   
        $seoTitle = 'Result Setting';
        $seoDescription = 'Result Setting' ;
        $seoKeyword = 'Result Setting';
        $seo_array = [
            'seoTitle' => $seoTitle,
            'seoKeyword' => $seoKeyword,
            'seoDescription' => $seoDescription,
        ];
        $resultSettingId = $id;
        $class = InstituteClass::where('school_id', Auth::user()->id)->get();
        
        return view('frontend.school.student.result.resultSet', compact('class','resultSettingId','seo_array'));
    }

    public function resultCreatePost(ResultCreatePost $request)
    {   
        $request->validated();
        if (is_array($request->student_id) && count($request->student_id) > 0) :
            try {
                foreach ($request->student_id as $key => $data) {
                    
                    $practical =  is_array($request->Practical) ? $request->Practical[$key] : 199;
                    $written = is_array($request->Written) ? $request->Written[$key] : 199;
                    $mcq =  is_array($request->MCQ) ? $request->MCQ[$key] : 199;
                    
                    $dataHave = Result::where('student_id', $data)->where('subject_id', $request->subject_id)->where('term_id', $request->term_id)->first();
                    if (isset($dataHave)) {
                        $result = Result::where('id', $dataHave->id)->first();
                    } else {
                        $result = new Result();
                    }
                    $result->school_id = Auth::user()->id;
                    $result->student_id = $data;
                    $result->student_roll_number = $request->student_roll_number[$key];
                    $result->institute_class_id  = $request->class_id;
                    $result->section_id          = $request->section_id;
                    $result->subject_id = $request->subject_id;
                    $result->term_id = $request->term_id;
                    $result->attendance =  is_null($request->Attendance) ? 0 : $request->Attendance[$key] ?? 0;
                    $result->assignment =  is_null($request->Assignment) ? 0 : $request->Assignment[$key] ?? 0;
                    $result->class_test =  is_null($request->Class_Test) ? 0 : $request->Class_Test[$key] ?? 0;
                    $result->presentation =  is_null($request->Presentation) ? 0 : $request->Presentation[$key] ?? 0;
                    $result->quiz =  is_null($request->Quiz) ? 0 : $request->Quiz[$key] ?? 0;
                    $result->practical =  is_null($request->Practical) ? 0 : $request->Practical[$key] ?? 0;
                    $result->written = is_null($request->Written) ? 0 : $request->Written[$key] ?? 0;
                    $result->mcq =  is_null($request->MCQ) ? 0 : $request->MCQ[$key] ?? 0;
                    $result->others =  is_null($request->Others) ? 0 : $request->Others[$key] ?? 0;
                    $result->total  = totalMark($result);
                    $result->grade  = grade($mcq, $written, $practical, $result->total, $request->term_id, $request->class_id, $request->subject_id);
                    $result->gpa  = gpa($mcq, $written, $practical, $result->total, $request->term_id, $request->class_id, $request->subject_id);
                    $result->save();
                }

                toast('Mark Save Sucessfully', 'success');
            } catch (Exception $e) {
                toast($e->getMessage(), 'error');
            }

        else :
            toast('Please select at least one item', 'error');
        endif;
        return back();
    }

    public function resultUpdatePost(Request $request, $id)
    {
        $result = Result::find($id);
        $result->student_id = $request->student_id;
        $result->student_roll_number = $request->student_roll_number;
        $result->subject_id = $request->subject_id;
        $result->term_id = $request->term_id;
        $result->subject_marks = $request->subject_marks;
        $result->school_id = Auth::user()->id;

        $result->save();

        return back();
    }

    public function noticeCreateShow()
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
            $teacherText  = 'Notice Input create';
            $seoTitle = 'Notice';
            $seoDescription = 'Notice';
            $seoKeyword = 'Notice';
            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
            ];
            $dataNotice = Notice::orderby('id', 'desc')->where('school_id', Auth::user()->id)->get();
            return view('frontend.school.notice.indexShow', compact('teacherText', 'seo_array', 'dataNotice'));
        }
    }

    public function noticeCreate()
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
            $teacherText  = 'Notice Input create';
            $seoTitle = 'Notice';
            $seoDescription = 'Notice';
            $seoKeyword = 'Notice';
            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
            ];
            return view('frontend.school.notice.index', compact('teacherText', 'seo_array'));
        }
    }

    public function noticeCreatePost(Request $request)
    {
        $data = new Notice();
        $data->topic = $request->topic;
        $data->description = $request->description;
        $data->class_id = $request->class_id;
        $data->school_id = Auth::user()->id;
        $data->save();
        toast('Successfully Notice Uploaded', 'success');
        return redirect()->route('notice.school.admin.create.show');
    }

    public function noticeCreateDelete($id)
    {
        $data = Notice::where('id', $id)->delete();
        toast('Successfully Noticed Deleted', 'success');
        return back();
    }

    public function notice_Check_Delete(Request $request)
    {
        $id = $request->id;
        Notice::withTrashed()->where('id', $id)->forcedelete();
        toast("Data delete permanently", "success");
        return back();
    }
    public function onlineClass($id)
    {
        $teacher = Teacher::where('id', $id)->first();
        return view('frontend.school.teacher.meet', compact('teacher'));
    }

    public function schoolStaffAddData(Request $request)
    {
        $request->validate([
            'employee_name' => 'required',
            'phone_number' => 'required|unique:employees|digits:11|numeric',
            'position_name' => 'required',
            'address' => 'required',
            'salary' => 'required|integer',
        ]);

        $uniqueId = Utility::createUniqueId(Auth::id(), 'employee');

        $data = new Employee();

        if ($request->hasFile('image')) {
            $fileName = date('Ymdhmsis') . '.' . $request->file('image')->extension();
            $request->file('image')->move(public_path('uploads/staff'), $fileName);
            $filePath = "uploads/staff/" . $fileName;
            $data->image = $filePath;
        }
        $data->employee_name = $request->employee_name;
        $data->phone_number = $request->phone_number;
        $data->employee_id = $uniqueId;
        $data->position = $request->position_name;
        $data->shift = $request->shift;
        $data->gender = $request->gender;
        $data->address = $request->address;
        $data->salary = $request->salary;
        $data->school_id = Auth::user()->id;

        $data->save();

        $month = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        foreach ($month as $iteration => $datas) {
            $monthFunction = date('m');
            if ($iteration + 2 > $monthFunction) {
                $fees = new EmployeeSalary();
                $fees->month_name = $datas;
                $fees->employee_id = $data->id;
                $fees->school_id = Auth::user()->id;
                $fees->save();
            }
        }
        toast('Employee Add Successfully Uploaded', 'success');
        return redirect()->route('school.staff.List');
    }
    public function staffview($id)
    {
        $data = Employee::find($id);
        return view('frontend.school.staff.details.singleview', compact('data'));
    }



    public function pDeleteStaff($id)
    {
        EmployeeSalary::withTrashed()->where('employee_id', $id)->forcedelete();
        Employee::withTrashed()->where('id', $id)->forcedelete();
        toast("Data delete permanently", "success");
        return back();
    }
    public function restoreStaff($id)
    {
        EmployeeSalary::withTrashed()->where('employee_id', $id)->restore();
        Employee::withTrashed()->where('id', $id)->restore();
        toast("Restore data", "success");
        return back();
    }

    /**
     * Get Subjects
     * @author CodeCell<-support@codecell.com.bd->
     * @contributor Sajjad <sajjad.develpr.gmail.com>
     * @created 18-06-2023
     * @return \Illuminate\Http\Response
     */
    public function groupWiseSubject(Request $request)
    {   
        $studentSubjects = User::where('id', $request->student_id)->value('subject_list');
        $takenOptional = User::where('id', $request->student_id)->value('optional_subject');
        
        $subjects = Subject::where('school_id', Auth::user()->id)
                           ->where('class_id', $request->class_id)
                           ->whereIn('group_id', [4, $request->group_id])
                           ->get();
        
        $optionSubjects = Subject::where('school_id', Auth::user()->id)
                           ->where('class_id', $request->class_id)
                           ->where('group_id', 4)
                           ->get();
        
        return response()->json(['success' => ['subjects' => $subjects, 'optionSubjects' => $optionSubjects, 'studentSubjects' => $studentSubjects, 'takenOptional' => $takenOptional]]);
    }

    /**
     * Save Subjects Student Table
     * 
     * @param Request
     * @param $request
     * @author CodeCell <-support@codecell.com.bd->
     * @contributor Sajjad <sajjad.develpr.gmail.com>
     * @created 18-06-2023
     * 
     * @return \Illuminate\Http\Response
     */
    public function saveGroupWiseSubject(Request $request)
    {   
        if (Auth::user()->status == 0) {

            return response()->json(['status' => 0]);

        } elseif (Auth::user()->status == 2) {

            return response()->json(['status' => 2]);
        }

        if(isset($request->subject_student_id)) {
            
            $validator = Validator::make($request->all(), [
                'group_id' => 'required',
                'subjects'  => 'required',
                'optional_subject'  => 'array|required|max:2',
            ]);

            if($validator->fails()) {

                return response()->json(['error' => $validator->errors()->all()]);
            }

            $user = DB::table('users')->where('id', $request->subject_student_id);
            $user->update([
                'subject_list'      =>  $request->subjects,
                "optional_subject"  =>  $request->optional_subject,
                "group_id"          =>  $request->group_id
            ]);

            return response()->json(['status' => 'edit-success']);
            
        } else {

            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'email' => 'required|email|unique:users',
                'phone' => 'required|numeric',
                'roll_number' => 'required|numeric',
                'shift' => 'required',
                'group_id' => 'required',
                'class_id' => 'required|integer',
                'section_id' => 'required|integer',
                'subjects'  => 'required',
                'optional_subject'  => 'array|required|max:2'
            ]);
        

            if($validator->fails()) {

                return response()->json(['error' => $validator->errors()->all()]);
            }
            
            $userRoll = User::where('class_id', $request->class_id)
                ->where('section_id', $request->section_id)
                ->where('roll_number', $request->roll_number);

            if ($userRoll->exists()) {
                
                return response()->json(['status' => 'exist']);
                
            } else {
                User::create([
                    'name'              => $request->name,
                    'email'             => $request->email,
                    'phone'             => $request->phone,
                    'class_id'          => $request->class_id,
                    'section_id'        => $request->section_id,
                    'group_id'          => $request->group_id,
                    'shift'             => $request->shift,
                    'subject_list'      => $request->subjects,
                    'optional_subject'  => $request->optional_subject,
                    'discount'          => $request->discount ?? 0,
                    'school_id'         => Auth::user()->id,
                    'password'          => Hash::make(123456789)
                ]);
            }
        }    
    }

    /**
     * Pass Section HTML and Group Value
     * 
     * @author CodeCell <support@codecell.com.bd>
     * @contributor Shahidul
     * @param Request
     * @param $request
     * @modifier Sajjad <sajjad.develpr@gmail.com>
     * @modified 11-07-23
     * 
     * @return mixed
     */
    public function showAjaxSection(Request $request)
    {
        $classes = InstituteClass::find($request->class_id)->class_name;
        $section = Section::orderby('id', 'asc')->where('class_id', $request->class_id)->where('school_id', Auth::user()->id)->get();
        $class = InstituteClass::where('id', $request->class_id)->first();
        $group = 0;
        if (in_array($classes, classFilter())) {
            $group = 1;
        }
        $html = "<option value=''>Select One";
        $html .= "</option>";
        foreach ($section as $data) {
            $html .= "<option value='$data->id' {{ (old('section_id') == $data->id) ? 'selected' : ''}}>";
            $html .= $data->section_name;
            $html .= "</option>";
        }

        $return = [
            'html'  =>  $html, 'class' =>  $class, 'group' =>  $group,
        ];

        return  $return;
    }

    public function showAjaxSubjects(Request $request)
    {
        $classes = InstituteClass::find($request->class_id)->class_name;
        // $class = (int)trim(str_replace("class ", "", strtolower($class)));
        $subject = Subject::orderby('id', 'desc')->where('class_id', $request->class_id)->where('school_id', Auth::user()->id)->get();
        $class = InstituteClass::where('id', $request->class_id)->first();



        //dd($class->class_name);
        $html = "<option value=''>Select One";
        $html .= "</option>";
        foreach ($subject as $data) {
            $html .= "<option value='$data->id' {{ (old('subject_id') == $data->id) ? 'selected' : ''}}>";
            $html .= $data->subject_name;
            $html .= "</option>";
        }

        $return = [
            'html'  =>  $html,
            'class' =>  $class,
        ];
        return  $return;
    }

    public function getSubjectTeacher(Request $request)
    {

        $subjectId = $request->subject_id;
        $schoolId = auth()->id();
        $subject = Department::find($subjectId)->department_name;

        $teacher = Teacher::where('school_id', $schoolId)
            ->where('department_name', 'like', "%{$subject}%")
            ->get();

        $html = "<option value=''>Select One";
        $html .= "</option>";
        foreach ($teacher as $data) {
            $html .= "<option value='$data->id' selected>";
            $html .= $data->full_name;
            $html .= "</option>";
        }
        echo  $html;
    }

    public function showAjaxSubject(Request $request)
    {

        $section = Subject::orderby('id', 'desc')->where('class_id', $request->class_id)->where('section_id', $request->section_id)->where('group_id', $request->group_id)->where('school_id', Auth::user()->id)->get();
        $html = "<option value=''>Select One";
        $html .= "</option>";
        foreach ($section as $data) {
            $html .= "<option value='$data->id'>";
            $html .= $data->subject_name;
            $html .= "</option>";
        }
        echo  $html;
    }

    public function pdeletesubject($id)
    {

        Subject::withTrashed()->where('id', $id)->forcedelete();
        toast("Data delete permanently", "success");
        return back();
    }
    public function restoreSubject($id)
    {
        Subject::withTrashed()->where('id', $id)->restore();
        toast("Restore data", "success");
        return back();
    }
}
