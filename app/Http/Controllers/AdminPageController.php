<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Blog;
use App\Models\User;
use App\Models\Price;
use App\Models\School;
use App\Models\Ticket;
use App\Models\Message;
use App\Models\Payment;
use App\Models\Teacher;
use App\Models\Checkout;
use App\Models\Employee;
use App\Models\SEOModel;
use App\Models\Tutorial;
use App\Models\ContactUs;
use App\Models\SchoolFee;
use App\Models\AddonModel;
use App\Models\AppReleased;
use App\Models\FeatureMenu;
use Illuminate\Support\Str;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\MessagePackage;
use App\Models\SchoolCheckout;
use App\Models\Shikkhabilling;
use App\Models\FeatureDetailsPage;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use RealRashid\SweetAlert\Facades\Alert;


class AdminPageController extends Controller
{
    
    public function TicketList()
    {
        $ticket = Ticket::all();
        return view('frontend.school.support.ticketlist', compact('ticket'));
    }
    
    public function admin()
    {
        $schools = School::all()->count();
        $teachers = Teacher::all()->count();
        $students = User::all()->count();
        $stuff = Employee::all()->count();
        $messages = Message::all()->count();
        $payment = Payment::all()->count();
        $school_fees = SchoolFee::all()->sum("amount");
        return view('admin', compact('schools', 'teachers', 'students', 'stuff', 'messages', 'payment', 'school_fees'));
    }
    public function contactusIndex()
    {
        $contactuss = ContactUs::all();
        return view('backend.admin.contactus.index', compact('contactuss'));
    }

    public function contactusEdit($id)
    {
        $contactus = ContactUs::find($id);
        return view('backend.admin.contactus.edit', compact('contactus'));
    }

    public function contactusUpdate(Request $request, $id)
    {
        $rules = [
            'status'         => 'required|numeric',
        ];

        $messages = [
            'status.required'        => 'Status field required',
        ];

        $this->validate($request, $rules, $messages);
        $input = $request->all();
        $contactus = ContactUs::find($id);

        try {
            $contactus->update($input);
            Toastr::success('About us updated successfully');
            return redirect()->route('contactus.index');
        } catch (Exception $e) {
            Toastr::error('Error');
            return redirect()->route('contactus.index');
        }
    }

    public function contactusDestroy($id)
    {
        try {
            $contactus = ContactUs::find($id)->delete();
            return back()->with(Toastr::error('Deleted successfully'));
        } catch (Exception $e) {
            $error_msg = Toastr::error('Error');
            return redirect()->route('contactus.index')->with($error_msg);
        }
    }



    public function pricingIndex()
    {
        $prices = Price::all();
        return view('backend.admin.pricing.index', compact('prices'));
    }

    public function pricingCreate()
    {
        return view('backend.admin.pricing.create');
    }

    public function pricingStore(Request $request)
    {
        try {
            Price::create([
                'name'              => $request->name,
                'title'             => $request->title,
                'price'             => $request->price,
                'student'             => $request->student,
                'teachers'             => $request->teachers,
                'message'             => $request->message,
                'button_text'       => $request->button_text,
                'description'       => $request->description,
                'status'            => $request->status,
                'seo_title'         => $request->seo_title ?? 'ABC',
                'seo_keyword'       => $request->seo_keyword ?? 'ABC',
                'seo_description'   => $request->seo_description ?? 'ABC',
            ]);

            $success_msg     = 'Price added successfully';
            return redirect()->route('pricing.index')->with('success', $success_msg);
        } catch (Exception $e) {
            $error_msg         = 'Error';
            return redirect()->route('pricing.index')->with('error', $error_msg);
        }
    }

    public function pricingEdit($id)
    {
        $price = Price::find($id);
        return view('backend.admin.pricing.edit', compact('price'));
    }

    public function pricingUpdate(Request $request, $id)
    {
        $rules = [
            'status'         => 'required|numeric',
        ];

        $messages = [
            'status.required'        => 'Status field required',
        ];

        $this->validate($request, $rules, $messages);
        $input = $request->all();
        $price = Price::find($id);

        try {
            $price->update($input);
            Toastr::success('Price updated successfully');
            return redirect()->route('pricing.index');
        } catch (Exception $e) {
            Toastr::error('Error');
            return redirect()->route('pricing.index');
        }
    }

    public function pricingDestroy($id)
    {
        try {
            $price = Price::find($id)->delete();
            return back()->with(Toastr::error('Deleted successfully'));
        } catch (Exception $e) {
            $error_msg = Toastr::error('Error');
            return redirect()->route('pricing.index')->with($error_msg);
        }
    }


    public function tutorialIndex()
    {
        $prices = Tutorial::all();
        return view('backend.admin.tutorial.index', compact('prices'));
    }

    public function tutorialCreate()
    {
        return view('backend.admin.tutorial.create');
    }

    public function tutorialStore(Request $request)
    {
        try {
            Tutorial::create([
                'page_info'              => $request->page_info,
                'link'             => $request->link,
            ]);

            $success_msg     = 'Tutorial added successfully';
            return redirect()->route('tutorial.index')->with('success', $success_msg);
        } catch (Exception $e) {
            $error_msg         = 'Error';
            return redirect()->route('tutorial.index')->with('error', $error_msg);
        }
    }

    public function tutorialEdit($id)
    {
        $price = Tutorial::find($id);
        return view('backend.admin.tutorial.edit', compact('price'));
    }

    public function tutorialUpdate(Request $request, $id)
    {

        //$this->validate($request, $rules, $messages);
        $input = $request->all();
        $price = Tutorial::find($id);

        try {
            $price->update($input);
            Toastr::success('Price updated successfully');
            return redirect()->route('tutorial.index');
        } catch (Exception $e) {
            Toastr::error('Error');
            return redirect()->route('tutorial.index');
        }
    }

    public function tutorialDestroy($id)
    {
        try {
            $price = Tutorial::find($id)->delete();
            return back()->with(Toastr::error('Deleted successfully'));
        } catch (Exception $e) {
            $error_msg = Toastr::error('Error');
            return redirect()->route('tutorial.index')->with($error_msg);
        }
    }

    public function messagePackageIndex()
    {
        $prices = MessagePackage::all();
        return view('backend.admin.messagePackage.index', compact('prices'));
    }

    public function messagePackageCreate()
    {
        return view('backend.admin.messagePackage.create');
    }

    public function messagePackageStore(Request $request)
    {
        try {
            MessagePackage::create([
                'package_name'              => $request->package_name,
                'quantity'             => $request->quantity,
                'price'             => $request->price,
            ]);

            $success_msg     = 'Tutorial added successfully';
            return redirect()->route('messagePackage.index')->with('success', $success_msg);
        } catch (Exception $e) {
            $error_msg         = 'Error';
            return redirect()->route('messagePackage.index')->with('error', $error_msg);
        }
    }

    public function messagePackageEdit($id)
    {
        $price = MessagePackage::find($id);
        return view('backend.admin.messagePackage.edit', compact('price'));
    }

    public function messagePackageUpdate(Request $request, $id)
    {

        //$this->validate($request, $rules, $messages);
        $input = $request->all();
        $price = MessagePackage::find($id);

        try {
            $price->update($input);
            Toastr::success('Price updated successfully');
            return redirect()->route('messagePackage.index');
        } catch (Exception $e) {
            Toastr::error('Error');
            return redirect()->route('messagePackage.index');
        }
    }

    public function messagePackageDestroy($id)
    {
        try {
            $price = MessagePackage::find($id)->delete();
            return back()->with(Toastr::error('Deleted successfully'));
        } catch (Exception $e) {
            $error_msg = Toastr::error('Error');
            return redirect()->route('messagePackage.index')->with($error_msg);
        }
    }

    public function confirmMessagePaymentIndex()
    {
        $prices = Checkout::orderby('id', 'desc')->get();
        return view('backend.admin.sell.messagePaymentCheckout', compact('prices'));
    }

    public function showallSchoolForPayment()
    {
        $school = School::orderby('id', 'desc')->where('is_editor', 3)->get();
        return view('backend.admin.school.allSchoolForPayment', compact('school'));
    }

    public function showallSchoolForPaymentDetails($id)
    {
        $school = SchoolFee::orderby('month_id', 'asc')->where('school_id', $id)->get();
        return view('backend.admin.school.allSchoolForPaymentDetails', compact('school'));
    }

    public function showallSchoolForPaymentSendDetails($id)
    {
        $school = SchoolCheckout::orderby('id', 'asc')->where('school_id', $id)->get();
        return view('backend.admin.school.allSchoolForPaymentSendDetails', compact('school'));
    }

    public function checkoutSchoolFessUpdate(Request $request, $id)
    {
        $data = SchoolCheckout::where('id', $id)->first();
        $data->status = $request->status;
        $data->save();
        return back();
    }

    public function checkoutSchoolCheckoutUpdate(Request $request, $id)
    {
        $data = SchoolFee::where('id', $id)->first();
        $data->status = $request->status;
        $data->amount = $request->amount;
        $data->save();
        return back();
    }

    public function featurePageIndex()
    {
        $prices = FeatureMenu::all();
        return view('backend.admin.feature.index', compact('prices'));
    }

    public function featurePageCreate()
    {
        return view('backend.admin.feature.create');
    }

    public function featurePageStore(Request $request)
    {
        try {
            FeatureMenu::create([
                'menu_name'              => $request->menu_name,
                'menu_slug'              => Str::slug($request->menu_name),
            ]);

            $success_msg     = 'Menu added successfully';
            return redirect()->route('featurePage.index')->with('success', $success_msg);
        } catch (Exception $e) {
            $error_msg         = 'Error';
            return redirect()->route('tutorial.index')->with('error', $error_msg);
        }
    }

    public function featurePageEdit($id)
    {
        $price = FeatureMenu::find($id);
        return view('backend.admin.feature.edit', compact('price'));
    }

    public function featurePageUpdate(Request $request, $id)
    {

        //$this->validate($request, $rules, $messages);
        $price = FeatureMenu::find($id);
        try {
            $price->menu_name = $request->menu_name;
            $price->menu_slug = Str::slug($request->menu_name);
            $price->save();
            Toastr::success('Price updated successfully');
            return redirect()->route('featurePage.index');
        } catch (Exception $e) {
            Toastr::error('Error');
            return redirect()->route('featurePage.index');
        }
    }

    public function featurePageDestroy($id)
    {
        try {
            $price = FeatureMenu::find($id)->delete();
            return back()->with(Toastr::error('Deleted successfully'));
        } catch (Exception $e) {
            $error_msg = Toastr::error('Error');
            return redirect()->route('featurePage.index')->with($error_msg);
        }
    }

    public function featureDetailsInput()
    {
        return view('backend.admin.feature.details.create');
    }

    public function featureDetailsPageStore(Request $request)
    {
        //dd($request->all());
        $data = new FeatureDetailsPage();
        $data->header_text_1 = $request->header_text_1;
        $data->header_text_2 = $request->header_text_2;
        $data->header_p_text_1 = $request->header_p_text_1;
        $data->header_p_text_1 = $request->header_p_text_1;
        $data->header_p_text_2 = $request->header_p_text_2;
        $data->header_label_text_1 = $request->header_label_text_1;
        $data->header_label_text_2 = $request->header_label_text_2;
        $data->header_label_text_3 = $request->header_label_text_3;
        $data->second_section_face_title_1 = $request->second_section_face_title_1;
        $data->second_section_face_paragraph_1 = $request->second_section_face_paragraph_1;
        $data->second_section_face_title_2 = $request->second_section_face_title_2;
        $data->second_section_face_paragraph_2 = $request->second_section_face_paragraph_2;
        $data->slug = $request->slug;
        // dd($request->file('header_image'));
        if ($request->file('header_image')) {
            $header_image      = $request->file('header_image');
            $filename = time() . '.' . $header_image->getClientOriginalExtension();
            $header_image_name =  $request->header_image->move('storage/uploads/feature1/', $filename);
            $data->header_image = $header_image_name;
        }
        if ($request->file('second_section_face_image_1')) {
            $second_section_face_image_1      = $request->file('second_section_face_image_1');
            $filename = time() . '.' . $second_section_face_image_1->getClientOriginalExtension();
            $second_section_face_image_1_name =  $request->second_section_face_image_1->move('storage/uploads/feature2/', $filename);
            $data->second_section_face_image_1 = $second_section_face_image_1_name;
        }
        if ($request->file('second_section_face_image_2')) {
            $second_section_face_image_2     = $request->file('second_section_face_image_2');
            $filename = time() . '.' . $second_section_face_image_2->getClientOriginalExtension();
            $second_section_face_image_2_name =  $request->second_section_face_image_2->move('storage/uploads/feature3/', $filename);
            $data->second_section_face_image_2 = $second_section_face_image_2_name;
        }

        $data->save();
        return back();
    }

    public function showAllSchool()
    {
        $school = School::orderby('id', 'desc')->get();
        return view('backend.admin.school.showSchool', compact('school'));
    }

    public function SchoolStatusUpdate(Request $request, $id)
    {
        // dd($request->all());
        $school = School::find($id);
        $school->status = $request->status;
        $school->save();
        return back();
    }


    //liza

    public function school_view()
    {
        $schools = School::with('schoolfee_Relation')->get();
        return view('backend.admin.Schoolview.Schoolview', compact('schools'));
    }
    public function SchoolListsearch(Request $request)
    {
        //dd($request->all());
        $search_key = $request->search_key;
        $schools = School::where('school_name', 'LIKE', '%' . $search_key . '%')
            ->orwhere('email', 'LIKE', '%' . $search_key . '%')
            ->get();
        return view('backend.admin.Schoolview.Schoolview', compact('schools'));
    }
    public function SchoolRegisterPage()
    {
        return view('backend.admin.Schoolview..SchoolRegisterPage');
    }
    public function school_Register(Request $request)
    {
        $this->validate($request, [
            'school_name' => 'required|unique',
            'email' => 'required|unique:schools',
            'phone_number' => 'required|unique:schools',
            'password' => 'required|string|min:6|',
        ]);
        $imageName = null;
        if ($request->has('school_logo')) {

            $imageName = date('ysis') . '.' . $request->file('school_logo')->getClientOriginalExtension();
            $request->file('school_logo')->storeAs('/uploads/SchoolLogo', $imageName);
        }
        School::create([
            'school_name' => $request->school_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'state' => $request->state,
            'city' => $request->city,
            'postcode' => $request->postcode,
            'address' => $request->address,
            'school_logo' => $imageName
        ]);
        return back();
    }

    public function school_SingleView($id)
    {
        $school = School::find($id);
        return view('backend.admin.Schoolview.SchoolSingleView', compact('school'));
    }

    public function changestatus($id)
    {
        $getstatus = SchoolFee::select('status')->where('id', $id)->first();

        if ($getstatus->status == 0) {
            $status = 1;
        } elseif ($getstatus->status == 1) {
            $status = 2;
        } else {
            $status = 2;
        }
        SchoolFee::where('id', $id)->update(['status' => $status]);

        Alert::success("Great!", "Updated successfully");
        return back();
    }

    public function AppReleased()
    {
        return view('backend.admin.popup.AppReleased');
    }
    public function AppReleased_store(Request $request)
    {
        $request->validate([
            'version' => 'required',
            'note' => 'required'
        ]);
        try {
            AppReleased::create([
                'version' => $request->version,
                'note' => $request->note,
            ]);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
        return redirect()->route('AppReleased.List');

        //return back();
    }
    public function AppReleased_List()
    {
        $appreleased = AppReleased::all();
        return view('backend.admin.popup.AppReleasedList', compact('appreleased'));
    }
    public function AppReleased_Delete($id)
    {
        $data = AppReleased::find($id)->delete();
        return back();
    }
    public function AppReleased_Edit($id)
    {
        $Editdata = AppReleased::find($id);
        return view('backend.admin.popup.AppReleased', compact('Editdata'));
    }
    public function AppReleased_Update(Request $request, $id)
    {
        $request->validate([
            'version' => 'required',
            'note' => 'required'
        ]);
        $updatedata = AppReleased::find($id);
        try {
            $updatedata->update([
                'version' => $request->version,
                'note' => $request->note,
            ]);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
        return redirect()->route('AppReleased.List');
    }

    public function AddonList()
    {
        $addons = AddonModel::all();
        return view('backend.admin.addon.addonlist', compact('addons'));
    }
    public function Addon_form()
    {
        return view('backend.admin.addon.addonform');
    }
    public function Addon_create(Request $request)
    {
        $request->validate([
            'title' => 'required|min:18|max:25',
            'price' => 'required',
            'month' => 'required',
        ]);
        try {
            AddonModel::create([
                'title' => $request->title,
                'price' => $request->price,
                'month' => $request->month,
                'description' => $request->description,
            ]);
            Toastr::success('Addon Create successfully');
            return redirect()->route('AddonList');
        } catch (Exception $e) {
            Toastr::error('Error');
            return redirect()->route('Addon.Form');
        }
    }
    public function school_edit($id)
    {
        $school = School::find($id);
        $SchoolEdit = School::find($id);
        return view('backend.admin.Schoolview.SchoolSingleView', compact('school', 'SchoolEdit'));
    }
    public function school_update(Request $request, $id)
    {
        $Schoolupdate = School::find($id);

        $request->validate([
            'school_logo' => 'image|mimes:jpeg,png,jpg|dimensions:width=640,height=640'
        ]);


        if ($request->hasFile('school_logo')) {
            File::delete(public_path($Schoolupdate->school_logo));

            $fileName = date('Ymdhmsis') . '.' . $request->file('school_logo')->extension();
            $request->file('school_logo')->move(public_path('uploads/SchoolLogo'), $fileName);
            $filePath = "uploads/SchoolLogo/" . $fileName;
            $filePath = $filePath;
        }


        $Schoolupdate->update([
            'school_name' => $request->school_name,
            'school_name_bn'    => $request->school_name_bn,
            'email' => $request->email,
            'address' => $request->address,
            // 'address_bn' => $request->address_bn,
            'phone_number' => $request->phone_number,
            'state' => $request->state,
            'city' => $request->city,
            'postcode' => $request->postcode,
            'slogan' => $request->slogan,
            'slogan_bn' => $request->slogan_bn,
            'billing_add' => $request->billing_add,
            'school_logo' => $filePath ?? $Schoolupdate->school_logo,
        ]);
        Toastr::success('School Update successfully');
        return redirect()->route('School.SingleView', [$id]);
    }

    public function billing_page($id)
    {
        $currentMonth = Carbon::now()->format('m');
        $school = School::find($id);
        $billing = Shikkhabilling::where('school_id', $school->id)->orderBy('created_at', 'desc')->get();
        return view('backend.admin.school.billingPage', compact('school', 'billing', 'currentMonth'));
    }
    public function getData($id)
    {
        $data = School::find($id);
        return response()->json($data);
    }
    public function billing_store(Request $request)
    {
        // $request->validate([
        //     'title' => 'required|min:18|max:25',
        //     'price' => 'required',
        //     'month' => 'required',
        // ]);
        try {
            Shikkhabilling::create([
                'month' => $request->month,
                'school_id' => $request->school_id,
                'ammount' => $request->ammount,
                'status' => $request->status,
            ]);
            Toastr::success('billing Create successfully');
            return redirect()->back();
        } catch (Exception $e) {
            Toastr::error('Error');
            return redirect()->route('Addon.Form');
        }
    }
    // where('school_id',Auth::user()->id)
    public function billing_status(Request $request, $id)
    {
        $getstatus = Shikkhabilling::select('status')->where('id', $id)->first();

        if ($getstatus->status == 0) {
            $status = 1;
        } else {
            $status = 2;
        }
        Shikkhabilling::where('id', $id)->update(['status' => $status]);

        Alert::success("Great!", "Updated successfully");
        return back();
    }



    public function Addon_Delete($id)
    {
        AddonModel::find($id)->delete();
        Toastr::success('Addon delete successfully');
        return back();
    }
    public function Addon_Edit($id)
    {
        $editAddon = AddonModel::find($id);
        return view('backend.admin.addon.addonform', compact('editAddon'));
    }
    public function Addon_Update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|min:18|max:25',
            'price' => 'required',
            'month' => 'required',
            'description' => 'max:255',
        ]);
        $updateAddon = AddonModel::find($id);
        try {
            $updateAddon->update([
                'title' => $request->title,
                'price' => $request->price,
                'month' => $request->month,
                'description' => $request->description,
            ]);
            Toastr::success('Addon Update successfully');
            return redirect()->route('AddonList');
        } catch (Exception $e) {
            Toastr::error('Error');
            return redirect()->route('Addon.Edit');
        }
    }

    // SEO Tools

    public function SEO_Tool_List()
    {
        $seo = SEOModel::all();
        // return $seo;
        return view('backend.admin.seo.seolist', compact('seo'));
    }

    public function SEO_form()
    {
        return view('backend.admin.seo.seoform');
    }
    public function SEO_create(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'keyword' => 'required',
            'page_no' => 'required',
            'description' => 'required',
        ]);
        try {
            SEOModel::create([
                'title' => $request->title,
                'keyword' => $request->keyword,
                'page_no' => $request->page_no,
                'description' => $request->description,
            ]);
            Toastr::success('SEO tool kit added successfully');
            return redirect()->route('seo.tool');
        } catch (Exception $e) {
            Toastr::error('Error');
            return redirect()->route('SEO.Form');
        }
    }
    public function SEO_Delete($id)
    {
        SEOModel::find($id)->delete();
        Toastr::success('SEO tool kit delete successfully');
        return back();
    }
    public function SEO_Edit($id)
    {
        $editseo = SEOModel::find($id);
        return view('backend.admin.seo.seoform', compact('editseo'));
    }
    public function SEO_Update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'keyword' => 'required',
            'page_no' => 'required',
            'description' => 'required',
        ]);
        $updateAddon = SEOModel::find($id);
        try {
            $updateAddon->update([
                'title' => $request->title,
                'keyword' => $request->keyword,
                'page_no' => $request->page_no,
                'description' => $request->description,
            ]);
            Toastr::success('SEO tool kit update successfully');
            return redirect()->route('seo.tool');
        } catch (Exception $e) {
            Toastr::error('Error');
            return redirect()->route('SEO.Edit');
        }
    } 

    public function showMaintainance(){
        return view('backend.admin.Setting.maintainance.show');
    }
    
    public function setMaintenanceMode()
    {
        $excludedTestAccountIds = [1,3,4,8,9,10,13,14,15,17,18,19,23]; 
        $users = \App\Models\School::all();
        
        foreach ($users as $user) {
            
            if (!in_array($user->id, $excludedTestAccountIds)) {
               
                $user->update([
                    'is_down' => 1,
                ]);
            }                        
        }
        
        return view('backend.admin.Setting.maintainance.show');;
    }

    // up site from mainmenance mode
    public function resetsetMaintenanceMode()
    {

        $excludedTestAccountIds = [1,3]; 
        $users = \App\Models\School::all();

        foreach ($users as $user) {
            $user->update([
                'is_down' => 0,
            ]);         
        }
        
        return view('backend.admin.Setting.maintainance.show');;
    }
    
    // public function school_subscriptionstore(Request $request){
        
    //             Subscription::create([
    //                 'school_id'=>$request->school_id,
    //                 'status'=>$request->status,
    //             ]);
    //             Toastr::success('Subscription Added successfully');
    //             return redirect()->back(); 
            
    // }

    public function subscription_status(Request $request ,$id){
            $getstatus=School::select('subscription_status')->where('id',$id)->first();

            if($getstatus->subscription_status == 0){
                $status=1;
            }
            elseif($getstatus->subscription_status == 2){
                $status=1;
            }            
            else{
                $status=2;
            }
            School::where('id',$id)->update(['subscription_status'=>$status]);
    
            Toastr::success('Subscription Status Changed successfully');
              return back(); 
        }
      

    public function blogList()
    {
        $blog = Blog::all();
        return view('backend.admin.blog.bloglist', compact('blog'));
    }
    public function  blogCreate()
    {

        return view('backend.admin.blog.blogcreate');
    }
    public function  blogedit($id)
    {
         $blogEdit = Blog::find($id);
        return view('backend.admin.blog.blogcreate', compact('blogEdit'));
    }
    public function  blogeditPost(Request $request, $id)
    {
        $blog= Blog::find($id);
        if ($request->hasFile('image')) {
            File::delete(public_path($blog->image));
            $fileName = time() . '.' . $request->file('image')->getclientOriginalExtension();
            $request->file('image')->move(public_path('/uploads/blog'), $fileName);
            $fileName = "/uploads/blog/" . $fileName;
            $blog->image=$fileName;
        }
        $blog->title = $request->title;
        $blog->content = $request->content;
        $blog->slug = Str::slug($request->title);
        $blog->written_by = Auth::guard('admin')->user()->id;
        $blog->save();
        Alert::success('Success', "Blog Updated Successfully");

        return redirect()->route('bloglist');
    }

    
    public function blogCreatepost(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'required',


        ]);
        $fileName = null;
        if ($request->hasFile('image')) {
            $fileName = time() . '.' . $request->file('image')->getclientOriginalExtension();
            $request->file('image')->move(public_path('/uploads/blog/'), $fileName);
            $fileName = "/uploads/blog/" . $fileName;
        }
        $blog = new Blog();
        $blog->title = $request->title;
        $blog->content = $request->content;
        $blog->slug = Str::slug($request->title);
        $blog->written_by = Auth::guard('admin')->user()->id;
        $blog->image = $fileName;
        $blog->save();
            Alert::success('Success', "Blog Create Successfully");

        return redirect(route('bloglist'))->with('success', 'Blog Created Successfully');
    }
    public function blogdelete($id)
    {
        $data = Blog::find($id)->delete();
        Alert::success('oppss', "Blog deleted");

        return redirect(route('bloglist'))->with('success', 'Blog Created Successfully');
    }
}
