<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\InstituteClass;
use App\Models\Subject;
use App\Models\Term;
use App\Models\Message;
use App\Models\User;
use App\Models\Result;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SMSController extends Controller
{
    /**
     * show form to send sms
     * 
     */
    public function index()
    {
        $data['terms'] = Term::where('school_id', Auth::id())->latest()->get();
        $data['classes'] = InstituteClass::where('school_id', Auth::id())->latest()->get();
        
        return view('frontend.school.result.form', compact('data'));
    }


    /**
     * send result by sms
     */
    public function resultSendToSms(Request $request)
    {   
        // return $request->all();
        $result = Result::query()->where('school_id', Auth::id());
        $req = $request->all();

        $smsCount = 0; // init count
        $numbers = [];
        $messages = [];

        if($request->class)
        {
            $result->whereHas('user', function($q) use ($req){
                $q->where('class_id', $req['class']);
            });
        }
        elseif($request->section)
        {
            $result->whereHas('user', function($q) use ($req){
                $q->where('section_id', $req['section']);
            });
        }
        elseif($request->subject_id)
        {
            $result->where('subject_id', $request->subject_id);
        }
        elseif($request->term)
        {
            $result->where('term_id', $request->term);
        }

        $rows = $result->get()->groupBy('student_id');

        if($rows->count() > 0)
        {
            // get top score
            $topScore = $result->select(DB::raw('(written + mcq + practical) AS total'))->orderBy('total', 'desc')->first()?->total;

            foreach($rows as $key => $items)
            {
                $inTotalMarks = 0;

                foreach($items as $subject)
                {
                    $inTotalMarks += (int)$subject->written + (int)$subject->mcq + (int)$subject->practical;
                    $term = Term::find($subject->term_id);
                }

                $student = User::find($key); // student info
                
                // send result by sms               
                $message = "{$student->name} have got $inTotalMarks marks in {$term->term_name}. And Top score for this subject is $topScore. Thanks from ". Auth::user()->school_name;

                Controller::GreenWebSMS($student->phone, $message);

                ++$smsCount; // increment sms count
                $numbers[] = $student->phone;
                $messages[] = [$student->phone => $message];
            }

            try{
                $sms = new Message();
                $sms->school_id = Auth::id();
                $sms->message = $smsCount; // number of sending sms
                $sms->send_number = json_encode($numbers);
                $sms->data = json_encode($messages);
                $sms->status = 2; // for sending sms to all user
                $sms->save();
            }
            catch(Exception $e)
            {
                Alert::error('Server Problem', $e->getMessage());
                return back();
            }

            Alert::success('Great!', 'Successfully Sms Send');
            return back();
        }
        else
        {
            Alert::info('', 'Record not found');
            return back();
        }
    }
}
