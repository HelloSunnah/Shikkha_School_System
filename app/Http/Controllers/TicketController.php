<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\SupportDepartment;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Reply;
use App\Models\School;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class TicketController extends Controller
{
    public function adminticketmessagelist()
    {
        $ticket = Ticket::all();
        return view('backend.admin.support.ticketlist', compact('ticket'));
    }

    public function closeTicketShow(){
        $ticket = Ticket::where('status', '=', '1')->get();

        return view('backend.admin.support.closeReply', compact('ticket'));
    }
    public function adminticketreply()
    {
        $ticket = Ticket::where('status', '=', '0')->get();
        return view('backend.admin.support.replyPage', compact('ticket'));
    }
    public function  ticketStatus($id)
    {
        $date = Ticket::find($id);
        $date->update([
            'status' => '1'
        ]);
        return response()->json();
    }
    public function ticketmessageshowadmin($id)
    {
        return $data = Reply::with('assignUser', 'assignAdmin')->where('ticket_id', $id)->orderBy('id', 'asc')->where('message', '!=', 'null')->get();
        return response()->json($data);
    }
    public function adminticketreplyPost(Request $request)
    {
        $fileName = null;
        if ($request->hasFile('attachment')) {
            $fileName = time() . '.' . $request->file('attachment')->getclientOriginalExtension();
            $request->file('attachment')->move(public_path('/uploads/support/'), $fileName);
            $fileName = "/uploads/support/" . $fileName;
        }
        $savemessage = new Reply();
        $savemessage->message = $request->message;
        $savemessage->ticket_id = $request->ticket_id;
        $savemessage->assign_id_admin = Auth::user()->id;
        $savemessage->attachment =  $fileName;
        $savemessage->save();
        return back();
    }
    public function ticketDeleteAdmin($id)
    {
        Ticket::find($id)->delete();
        return response()->json(['message' => 'Task deleted successfully']);
    }

    //front
    public function ticketCreateSchool()
    {
        $data = SupportDepartment::all();
        $data1 = School::where('id', Auth::user()->id)->first();
        return view('frontend.school.support.TicketCreate', compact('data', 'data1'));
    }
    public function  tokenReplyPage()
    {
        $ticket = Ticket::where('school_id', Auth::user()->id)->where('status', '=', '0')->get();
        return view('frontend.school.support.TicketReply', compact('ticket'));
    }
    public function  closeTicket()
    {
        $ticket = Ticket::where('school_id', Auth::user()->id)->where('status', '=', '1')->get();
        return view('frontend.school.support.CloseTicket', compact('ticket'));
    }
    public function  tokenCreatePost(Request $request)
    {
        $fileName = null;
        if ($request->hasFile('attachment')) {
            $fileName = time() . '.' . $request->file('attachment')->getclientOriginalExtension();
            $request->file('attachment')->move(public_path('/uploads/support/'), $fileName);
            $fileName = "/uploads/support/" . $fileName;
        }
        $ticket = Ticket::create([
            'token' => Str::random(5),
            'school_id' => Auth::user()->id,
            'name' => Auth::user()->school_name,
            'email' => Auth::user()->email,
            'subject' => $request->input('subject'),
            'department_id' => $request->department_id,
            'priority' => $request->input('priority')
        ]);
        $message = new Reply();
        $message->message = $request->message;
        $message->assign_id_user = Auth::user()->id;
        $message->ticket_id = $ticket->id;
        $message->attachment =  $fileName;
        $ticket->replies()->save($message);
        return redirect()->route('token.reply.page');
    }
    public function tokenreplyPost(Request $request)
    {
        $fileName = null;
        if ($request->hasFile('attachment')) {
            $fileName = time() . '.' . $request->file('attachment')->getclientOriginalExtension();
            $request->file('attachment')->move(public_path('/uploads/support/'), $fileName);
            $fileName = "/uploads/support/" . $fileName;
        }
        $savemessage = new Reply();
        $savemessage->message = $request->message;
        $savemessage->ticket_id = $request->ticket_id;
        $savemessage->assign_id_user = Auth::user()->id;
        $savemessage->attachment =  $fileName;
        $savemessage->save();
        return response()->json(['message' => 'Reply Send']);
    }
    public function  tokenLoadShow($id)
    {
        $data = Reply::with('ticket', 'assignUser', 'assignAdmin')->where('ticket_id', $id)->orderBy('id', 'asc')->where('message', '!=', 'null')->get();
        return response()->json($data);
    }
    public function ticketDeleteSchool($id)
    {
        Ticket::find($id)->delete();
        return response()->json(['message' => 'Task deleted successfully']);
    }
    public function ticketlatestMessageSchool($id)
    {
        Reply::where('ticket_id', $id)->latest()->first();
        return response()->json(['message' => 'Message Found']);
    }
    public function supportDeptDel($id)
    {
        $data = SupportDepartment::find($id)->delete();
        return back();
    }
    public function   supportDCreate()
    {
        $dept = SupportDepartment::all();
        return view('frontend.school.support.supportDepartment', compact('dept'));
    }
    public function   supportDCreatePost(Request $request)
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
}
