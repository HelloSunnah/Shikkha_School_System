<?php

namespace App\Http\Controllers;

use DateTime;
use App\Mail\Reminder;
use App\Models\School;
use App\Models\Teacher;
use App\Models\Todolist;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class TaskController extends Controller
{

    public function reminderMessage()
    {
        $d = new DateTime();
        $d->format('Y:m:d');
        $t = new DateTime();
        $t->format('H:i');
        $data = Todolist::where('reminder_date', '!=', '0')->where('reminder_time', '!=', '0')->where('status_for_school', '0')->get()->toArray();
        foreach ($data as $data1) {
            if ($data1['reminder_time'] == $t || $data1['reminder_date'] == $d) {
                $userEmail = School::where('id', $data1->school_id)->first();
                Mail::to($userEmail['email'])->send(new Reminder($data1));
            }
        }
    }
    public function reminderMessage1()
    {
        $d = new DateTime();
        $d->format('Y:m:d');
        $t = new DateTime();
        $t->format('H:i');
        $data = Todolist::get()->toArray();

        foreach ($data as $data1) {
            // return $data1;
            Mail::to($data1['email'])->send(new Reminder($data1));
        }
        return "Emails sent successfully!";
    }

    public function updatePage()
    {
        return view('frontend.school.schoolProfile.todolist')->render();
    }
    public function  todoshowDone()
    {
        $Showdata = Todolist::where('school_id', Auth::user()->id)->where('status_for_school', '=', '1')->get();
        return response()->json($Showdata);
    }
    public function  todoshowView($itemId)
    {
        Todolist::find($itemId)->get();
        return response()->json();
    }
    public function todoshowpost($itemId)
    {
        Todolist::find($itemId)->delete();
        return response()->json(['message' => 'Task deleted successfully']);
    }
    public function todoStatuspost($itemId)
    {
        $data = Todolist::find($itemId);
        $data->update([
            'status_for_school' => '1'
        ]);
        return response()->json(['message' => 'Status update successfully']);
    }
    public function todoshow()
    {
        $currentDate = Carbon::now()->toDateString();
        $items['today'] = Todolist::where('school_id', Auth::user()->id)->where('date', '=', $currentDate)->where('status_for_school', '=', '0')->get();
        $items['DueDay'] = Todolist::where('school_id', Auth::user()->id)->where('date', '<', $currentDate)->where('status_for_school', '=', '0')->get();
        $items['next'] = Todolist::where('school_id', Auth::user()->id)->where('date', '>', $currentDate)->where('status_for_school', '=', '0')->get();
        $items['unschedul'] = Todolist::where('school_id', Auth::user()->id)->where('date', '=', '')->where('status_for_school', '=', '0')->get();
        return response()->json($items);
    }
    public function todoList()
    {
        $data = Todolist::where('school_id', Auth::user()->id)->where('status_for_school', '=', '1')->get();

        $doList = Todolist::where('school_id', Auth::user()->id)->get();
        $teacher = Teacher::where('school_id', Auth::user()->id)->get();
        return view('frontend.school.schoolProfile.todolist', compact('teacher', 'doList', 'data'));
    }
    public function todoListReminderpost(Request $request)
    {
        $data = Todolist::find($request->id);
        return $data->update([
            'reminder_message' => $request->reminder_message,
            'reminder_date' => $request->reminder_date ?: 0,
            'reminder_time' => $request->reminder_time ?: 0,
        ]);
        return response()->json(['message' => 'Form data with image updated successfully!']);
    }
    public function todoListpost(Request $request)
    {
        if ($request->hasFile('attachment')) {
            $imagePath = $request->file('attachment')->store('attachment', '/uploads/blog/');
        } else {
            $imagePath = null;
        }
        Todolist::create([
            'school_id' => Auth::user()->id,
            'task_name' => $request->task_name,
            'date' => $request->date,
            'assign_teacher_id' => $request->assign_teacher_id,
            'command' => $request->command,
            'attachment' => $imagePath
        ]);
        return response()->json(['message' => 'Form data with image saved successfully!']);
    }


    public function  todoListTest()
    {

        $data = Todolist::where('school_id', Auth::user()->id)->where('status_for_school', '=', '1')->get();

        $doList = Todolist::where('school_id', Auth::user()->id)->get();
        $teacher = Teacher::where('school_id', Auth::user()->id)->get();
        return view('frontend.school.schoolProfile.toDoTest', compact('teacher', 'doList', 'data'));
    }
    public function todoEventCalender()
    {
    }
}
