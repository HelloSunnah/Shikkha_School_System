<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\SupportDepartment;
use App\Http\Controllers\Controller;
use App\Models\Reply;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class TicketController extends Controller
{
    public function  SupportTicketCreate()
    {
        $dept = SupportDepartment::all();
        return view('frontend.school.support.ticketCreate', compact('dept'));
    }

    public function   supportDepartment()
    {

        return view('frontend.school.support.supportDepartment');
    }
    public function   supportDepartmentPost(Request $request)
    {
        $request->validate([
            'department' => 'required',
        ]);
        $support = new SupportDepartment();
        $support->department = $request->department;

        $support->save();
        Alert::success('Department Created Succesfully', 'Success Message');
        return back();
    }
    public function ticketmessage($id)
    {
        $data = SupportDepartment::find($id);
        return view('frontend.school.support.ticketPage', compact('data'));
    }


    public function  ticketmessagePost(Request $request,$id)
    {
        $fileName = null;
        if ($request->hasFile('attachment')) {
            $fileName = time() . '.' . $request->file('attachment')->getclientOriginalExtension();
            $request->file('attachment')->move(public_path('/uploads/support/'), $fileName);
            $fileName = "/uploads/support/" . $fileName;
        }
        $ticket = Ticket::create([

            'token' => Str::random(5),
            'department_id' =>$id,
            'name' => Auth::user()->school_name,
            'email' => Auth::user()->email,
            'subject' => $request->input('subject'),
            'priority' => $request->input('priority')
        ]);

        $message = new Reply();
        $message->message = $request->message;
        $message->attachment =  $fileName;

        $ticket->replies()->save($message);
        Alert::success('token Created Succesfully', 'Success Message');

        return redirect()->route('ticketmessage.list');
    }
    public function ticketmessagelist()
    {
        $ticket = Ticket::all();
        return view('frontend.school.support.ticketlist', compact('ticket'));
    }
    public function ticketmessagelist1()
    {
        $ticket = Ticket::all();
        return view('frontend.school.support.ticketlist', compact('ticket'));
    }
    public function ticketreply($id)
    {
        $data = Ticket::find($id);
         $data1 = Reply::where('ticket_id', $id)->first();
         $data2 = Reply::where('ticket_id', $id)->latest()->take(10)->get();
        return view('frontend.school.support.replyPage', compact('data', 'data1', 'data2'));
    }
    public function ticketreplyPost(Request $request, $id)
    {
        $fileName = null;
        if ($request->hasFile('attachment')) {
            $fileName = time() . '.' . $request->file('attachment')->getclientOriginalExtension();
            $request->file('attachment')->move(public_path('/uploads/support/admin'), $fileName);
            $fileName = "/uploads/support/admin" . $fileName;
        }
        $savemessage = new Reply();
        $savemessage->message = $request->message;
        $savemessage->ticket_id = $id;
        $savemessage->assign_id = Auth::user()->id;
        $savemessage->attachment =  $fileName;

        $savemessage->save();
        Alert::success('Message Send Succesfully', 'Success Message');

        return back();
    }

   
    public function adminticketmessagelist()
    {
        $ticket = Ticket::all();
        return view('backend.admin.support.ticketlist', compact('ticket'));
    }
    public function adminticketreply($id)
    {
        $data = Ticket::find($id);
        $data1 = Reply::find($id);
        $data2 = Reply::where('ticket_id', $id)->latest()->take(5)->get();
        return view('backend.admin.support.replyPage', compact('data', 'data1', 'data2'));
    }
    public function adminticketreplyPost(Request $request, $id)
    {
        $fileName = null;
        if ($request->hasFile('attachment')) {
            $fileName = time() . '.' . $request->file('attachment')->getclientOriginalExtension();
            $request->file('attachment')->move(public_path('/uploads/support/'), $fileName);
            $fileName = "/uploads/support/" . $fileName;
        }
        $savemessage = new Reply();
        $savemessage->message = $request->message;
        $savemessage->ticket_id = $id;
        $savemessage->assign_id = Auth::user()->id;
        $savemessage->attachment =  $fileName;

        $savemessage->save();

        return back();
    }
    public function ticketDelete($id){
        $data = Ticket::find($id)->delete();
        return back();
    }
}
