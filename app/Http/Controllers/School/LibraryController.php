<?php

namespace App\Http\Controllers\School;

use Exception;
use Carbon\Carbon;

use App\Models\User;
use App\Models\Subject;
use App\Models\BorrowBook;
use App\Models\LibBookType;
use Illuminate\Http\Request;
use App\Models\LibraryBookInfo;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use RealRashid\SweetAlert\Facades\Alert;

class LibraryController extends Controller
{

    public function booksCreate()
    {
        $allData = LibraryBookInfo::all();
        $bookType = LibBookType::all();
        $bookTypes = LibBookType::all();

        
        return view('frontend.school.library.booksCreate', compact('bookType', 'bookTypes','allData'));
    }

    public function booksType()
    {
        return view('frontend.school.library.booksType');
    }

    public function booksTypePost(Request $request)
    {
        $request->validate([
            'book_type' => 'required'
        ]);
        // for create new Bookcategory
        try {
            LibBookType::create([
                'book_type' => $request->book_type
            ]);
            return redirect()->route('books.create');
        } catch (\Exception $e) {
            return redirect()->route('books.type.create')->with('error', 'data insert failed');
        }
    }




    public function booksCreatePost(Request $request)
    {
        // validate data
        $request->validate([
            'book_name' => 'required',
            'book_type_id' => 'required',
            'author_name' => 'required',
            'rack_no' => 'required',
            'quantity' => 'required',
            'available' => 'required',


        ]);
        // for image upload
        // $fileName = null;
        // if ($request->hasFile('image')) {
        //     $fileName = date('Ymdhmsis') . '.' . $request->file('image')->getclientOriginalExtension();
        //     $request->file('image')->storeAs('uploads/library/', $fileName);
        // }
        $fileName = null;
        if ($request->hasFile('image')) {
            $fileName = time() . '.' . $request->file('image')->getclientOriginalExtension();
            $request->file('image')->move(public_path('/uploads/library'), $fileName);
        }
        // Create Book
        try {
            LibraryBookInfo::create(
                [
                    'book_name' => $request->book_name,
                    'book_type_id' => $request->book_type_id,
                    'author_name' => $request->author_name,
                    'rack_no' => $request->rack_no,
                    'quantity' => $request->quantity,
                    'available' => $request->available,
                    'image' => $fileName
                ]
            );
            return back()->with('insert', 'data insert succesfully');;
        } catch (\Exception $e) {
            return redirect()->route('books.create')->with('error', 'data insert failed');
        }
    }
    // Edit form
 
    public function booksEditPost(Request $request, $id)
    {
        $request->validate([
            'book_name' => 'required',
            'book_type_id' => 'required',
            'author_name' => 'required',
            'rack_no' => 'required',
            'quantity' => 'required',
            'image' => 'required'
        ]);


        $booksEditPost = LibraryBookInfo::find($id);
        // Edit image file

        $fileName = $booksEditPost->image;
        if ($request->hasFile('image')) {
            $removeFile = public_path() . '/uploads/library/' . $fileName;
            File::delete($removeFile);
            $fileName = date('Ymdhmsis') . '.' . $request->file('image')->getclientOriginalExtension();
            $request->file('image')->storeAs('/uploads/library/', $fileName);
        }

        try {
            $booksEditPost->update([

                'book_name' => $request->book_name,
                'book_type_id' => $request->book_type_id,
                'author_name' => $request->author_name,
                'rack_no' => $request->rack_no,
                'quantity' => $request->quantity,
                'image' => $fileName
            ]);
            return redirect()->route('books.create');
        } catch (\Exception $e) {
            return redirect()->route('books.edit')->with('error', 'data insert failed');
        }
    }

    public function booksDelete($id)
    {
        LibraryBookInfo::find($id)->delete();
        return back();
    }
    public function books_Check_delete(Request $request)
    {
        $ids=$request->ids;
        LibraryBookInfo::whereIn('id',$ids)->delete();
        Alert::success('Selected books are deleted','success message');
        return response()->json(['status'=>'success']);
    }

    public function bookstypeDelete($id)
    {
        LibBookType::find($id)->delete();
        Alert::error('Opps!', "Record deleted");

        return back();
    }


    public function pdeleteBooktype($id)
    {
       
        LibBookType::withTrashed()->where('id', $id)->forcedelete();
        toast("Data delete permanently", "success");
        return back();
    }
    public function restoreBookType($id)
    {
        LibBookType::withTrashed()->where('id', $id)->restore();
        toast("Restore data", "success");
        return back();
    }

    public function pdeleteBook($id)
    {
       
        LibraryBookInfo::withTrashed()->where('id', $id)->forcedelete();
        toast("Data delete permanently", "success");
        return back();
    }
    public function restoreBook($id)
    {
        LibraryBookInfo::withTrashed()->where('id', $id)->restore();
        toast("Restore data", "success");
        return back();
    }

    public function pdeleteBorrower($id)
    {
        BorrowBook::withTrashed()->where('id', $id)->forcedelete();
        toast("Data delete permanently", "success");
        return back();
    }
    public function restoreBorrower($id)
    {
        BorrowBook::withTrashed()->where('id', $id)->restore();
        toast("Restore data", "success");
        return back();
    }



    //borrowrerController start



    public function borrowerinfo()
    {
        $borrowlist = BorrowBook::with('bookRelation', 'studentRelation')->orderBy('id', 'desc')->get();
        return view('frontend.school.library.borrowerPage', compact('borrowlist'));
    }
    public function borrowerCreate()
    {
        $books = LibraryBookInfo::all();
        $students = User::where('school_id', Auth::id())->get();
        $defaultDate = Carbon::today()->format('Y-m-d');
        return view('frontend.school.library.borroerCreate', compact('books', 'students', 'defaultDate'));
    }
    public function borrower_store(Request $request)
    {
        $request->validate([
            'book_id' => 'required',
            'student_id' => 'required',
            'borrow_date' => 'required',
            'possible_borrow_date' => 'required'
        ]);

        $book = LibraryBookInfo::find($request->book_id);
        $book->available -= 1;
        $book->save();
        try {
            BorrowBook::create([
                'book_id' => $request->book_id,
                'Student_id' => $request->student_id,
                'borrow_date' => $request->borrow_date,
                'return_date' => $request->return_date,
                'possible_borrow_date' => $request->possible_borrow_date
            ]);
            return redirect()->route('borrowerinfo')->with('insert', 'data has been insert successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    public function borrower_delete($id)
    {
        BorrowBook::find($id)->delete();
        return back();
    }
    public function borrower_Edit($id)
    {
        $books = LibraryBookInfo::all();
        $students = User::all();
        $borrowrer = BorrowBook::find($id);
        $defaultDate = Carbon::today()->format('Y-m-d');
        return view('frontend.school.library.borrowrerEdit', compact('books', 'students', 'borrowrer', 'defaultDate'));
    }
    public function borrower_Update(Request $request, $id)
    {
        $request->validate([
            // 'subject_name'=>'required',
            // 'name'=>'required',
            'borrow_date' => 'required',
            'return_date' => 'required'

        ]);
        $borrowrer = BorrowBook::find($id);
        try {
            $borrowrer->update([
                'book_id' => $request->book_id,
                'Student_id' => $request->Student_id,
                'borrow_date' => $request->borrow_date,
                'return_date' => "$request->return_date",
                'possible_borrow_date' => $request->possible_borrow_date
            ]);
            if ($request->has('return_date')) {
                $book = LibraryBookInfo::find($request->book_id);
                $book->available += 1;
                $book->save();
            }
            return redirect()->route('borrowerinfo')->with('insert', 'data insert successfully');
        } catch (\Exception $e) {
            return redirect()->route('borrower.Edit', $id)->with('error', $e->getmessage());
        }
    }
}
