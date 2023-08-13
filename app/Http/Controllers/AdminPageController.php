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
use App\Models\FeatureList;
use App\Models\FeatureMenu;
use App\Models\LogActivity;
use Illuminate\Support\Str;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\AddonPurchase;
use App\Models\MessagePackage;
use App\Models\SchoolCheckout;
use App\Models\Shikkhabilling;
use App\Models\Testimonialimg;
use App\Models\Billingtransaction;
use App\Models\FeatureDetailsPage;
use Illuminate\Support\Facades\DB;
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
        $userActivityData = DB::table('log_activities') ->select('subject', 'count')
                                            ->orderByDesc('count')
                                            ->get();

                                            
        $groupedData = [];

        foreach ($userActivityData as $activity) {
            $subject = $activity->subject;
            $count = $activity->count;
            
            if (isset($groupedData[$subject])) {
                $groupedData[$subject] += $count; 
            } else {
                $groupedData[$subject] = $count;  
            }
        }

        $xValues = array_keys($groupedData);    
        $yValues = array_values($groupedData);
        $colors = [];
        $xCount = count($xValues);
        for($i = 0; $i < $xCount; $i++) {
            $color = '#'.str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
            $colors[] = $color;
        }
    
        return view('admin', compact('schools', 'teachers', 'students', 'stuff', 'messages', 'payment', 'school_fees','xValues', 'yValues', 'colors'));
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
         $currentMonth = Carbon::now()->format('m');
        $schools = School::with('schoolfee_Relation')->get();
        return view('backend.admin.Schoolview.Schoolview', compact('schools','currentMonth'));
    }

    // school analysis
    public function school_analysis()
    {   
        $currentMonth = Carbon::now()->format('m');
        $schools = School::with('schoolfee_Relation')->get();
        return view('backend.admin.analysis.analysis', compact('schools','currentMonth'));
    }

    // school Single analysis
    public function school_Single_Analysis($id)
    {   
        $school = School::find($id);

        $users = User::select(DB::raw("Count(*) as count"))->where('school_id', $school)->whereYear('created_at', date('Y'))
                ->groupby(DB::raw("Month(created_at)"))->pluck('count');

        $months = User::select(DB::raw("Month(created_at) as month"))->where('school_id', $school)->whereYear('created_at', date('Y'))
                ->groupby(DB::raw("Month(created_at)"))->pluck('month');
        //dd($months);
        $datas = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

        foreach ($months as $index => $month) {
            $datas[$month] = $users[$index];
        }
        return view('backend.admin.analysis.single_analysis', compact('school', 'datas'));
    }

    // school list search
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

    public function school_SingleView(Request $request, $id)
    {
        $today = Carbon::today();
        $school = School::find($id);
        $logs = LogActivity::where('school_id', $id)->wheredate('created_at', $today)->orderByDesc('count')->get();

        $userActivityData = LogActivity::where('school_id', $id )
                                            ->wheredate('created_at', $today)
                                            ->select('subject', 'count')
                                            ->orderByDesc('count')
                                            ->get();
        //return $userActivityData;
        $xValues = $userActivityData->pluck('subject')->toArray();
        $yValues = $userActivityData->pluck('count')->toArray();
        $colors = [];
        $xCount = count($xValues);
        for($i = 0; $i < $xCount; $i++) {
            $color = '#'.str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
            $colors[] = $color;
        }
        
        return view('backend.admin.Schoolview.SchoolSingleView', compact('school','logs','xValues', 'yValues', 'colors'));
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
        $schools=School::get();
        $addons = AddonModel::orderBy('title')->get();
        $paidaddons = AddonPurchase::all();
        $features =FeatureList::all();
        return view('backend.admin.addon.addonlist', compact('addons','schools','paidaddons','features'));
    }
    public function Addon_form()
    {
        $features =FeatureList::all();
        return view('backend.admin.addon.addonform',compact('features'));
    }
    public function Addon_create(Request $request)
    {
        $request->validate([
            'title' => 'required|max:25',
            'feature_id' => 'required|unique:addon_models',
            'image' => 'required',
            'price' => 'required',
            'button' => 'required',
            'status' => 'required',
            'description' => 'required|min:185|max:190', 
            'longdescription' => 'required', 
        ]);
        try {          
            $fileName = null;
            if ($request->hasFile('image')) {
                $fileName = time() . '.' . $request->file('image')->getclientOriginalExtension();
                $request->file('image')->move(public_path('/uploads/AddonImage/'), $fileName);
                $fileName = "/uploads/AddonImage/".$fileName;
            }
            AddonModel::create([
                'title' => $request->title,
                'feature_id'=>$request->feature_id,
                'image' => $fileName,
                'price' => $request->price,
                'button' => $request->button,
                'status' => $request->status,
                'description' => $request->description,
                'longdescription' => $request->longdescription,
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
        $billing = Shikkhabilling::where('school_id', $school->id)->orderBy('created_at', 'asc')->get();
        $billingtransaction = Billingtransaction::where('school_id', $school->id)->orderBy('created_at', 'asc')->get();
        return view('backend.admin.school.billingPage', compact('school', 'billing', 'currentMonth','billingtransaction'));
    }
    public function getData($id)
    {
        $data = School::find($id);
        return response()->json($data);
    }
    public function billing_store(Request $request)
    {
        $schools = School::where('subscription_status', 1)->get();

                $currentMonth = Carbon::now()->format('m');

                foreach ($schools as $school) {
                    $existingBilling = Shikkhabilling::where('school_id', $school->id)
                                                    ->where('month', $currentMonth)
                                                    ->first();

                    if (!$existingBilling) {
                        $billing = new Shikkhabilling;
                        $billing->school_id = $school->id;
                        $billing->ammount = $school->billing_add ?? 0;
                        $billing->status = 0;
                        $billing->month = $currentMonth;
                        $billing->save();
                    }
                }

                return redirect()->back();
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
        AddonPurchase::where('addon_id',$id)->delete();
        Toastr::success('Addon delete successfully');
        return back();
    }
    public function Addon_status($id)
    {
        $getstatus=AddonModel::select('status')->where('id',$id)->first();
        if($getstatus->status == 0){
            $status=1;
        }
        elseif($getstatus->status == 1){
            $status=0;
        }            
        else{
            $status=2;
        }
        AddonModel::where('id',$id)->update(['status'=>$status]);
        Toastr::success('Addon Status changed successfully');
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
            'title' => 'required|max:25',
            'price' => 'required',
            'button' => 'required',
            'description' => 'required|min:185|max:190', 
            'longdescription' => 'required',
        ]);
        $updateAddon = AddonModel::find($id);
        try {

            if ($request->hasFile('image')) {
            File::delete(public_path($updateAddon->image));
            $fileName = time() . '.' . $request->file('image')->getclientOriginalExtension();
            $request->file('image')->move(public_path('/uploads/AddonImage'), $fileName);
            $fileName = "/uploads/AddonImage/" . $fileName;
            $updateAddon->image=$fileName;
             $updateAddon->update([
                'title' => $request->title,
                'image' => $fileName,
                'price' => $request->price,
                'button' => $request->button,
                'description' => $request->description,
                'longdescription' => $request->longdescription,
                //'status' => $request->status,
            ]);
             }
             else{
                $updateAddon->update([
                'title' => $request->title,
                'price' => $request->price,
                'button' => $request->button,
                'description' => $request->description,
                'longdescription' => $request->longdescription,
                //'status' => $request->status,
            ]);
             }
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
         $logs = LogActivity::all();
        return view('backend.admin.Setting.maintainance.show',compact('logs'));
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


    public function subscription(Request $request){
        $subcript = new subscribe();

       $subcript->email = $request->email;
       $subcript->save();
       return back();
    
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

        $blog->blog_type = $request->blog_type;
        $blog->blog_design = $request->blog_design;
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


        ]);
        $fileName = null;
        if ($request->hasFile('image')) {
            $fileName = time() . '.' . $request->file('image')->getclientOriginalExtension();
            $request->file('image')->move(public_path('/uploads/blog/'), $fileName);
            $fileName = "/uploads/blog/" . $fileName;
        }
        $blog = new Blog();
        $blog->title = $request->title;
        $blog->blog_type = $request->blog_type;
        $blog->blog_design = $request->blog_design;
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

    public function testimonial_imagelist(){
        $data =Testimonialimg::all();
        return view('backend.admin.testmonialfeature.testimonialimglist',compact('data'));
    }
    
    public function testimonial_imgstore(Request $request){

        $request->validate([
            'image' => 'required'
        ]);

        $fileName = null;
        if ($request->hasFile('image')) {
            $fileName = time() . '.' . $request->file('image')->getclientOriginalExtension();
            $request->file('image')->move(public_path('/uploads/testimonialimg/'), $fileName);
            $fileName = "/uploads/testimonialimg/" . $fileName;
        }
        $testimg = new Testimonialimg();
        $testimg->image = $fileName;
        $testimg->save();
         Alert::success('Success', "image  added Successfully");
        return back();
    }

    public function testimonial_imgdelete($id){
        $data = Testimonialimg::find($id)->delete();
        Alert::success('Success', "image deleted Successfully");
        return redirect()->back();
    }

    public function data_addToLog()
    {
        LogActivity::addToLog('user_view');
        $page = 'your_page_url'; 
        $userViewCount = LogActivityService::countUserViewActivity($page);
    }
    //   public function log_ActivityLists()
    // {
    //      $logs = LogActivity::logActivityLists();
    //      return view('backend.admin.Setting.maintainance.show',compact('logs'));
    // }
    public function Addon_purchase_status($id)
    {
        $getstatus=AddonPurchase::select('status')->where('id',$id)->first();
        if($getstatus->status == 0){
            $status=1;
        }
        elseif($getstatus->status == 1){
            $status=2;
        }            
        else{
            $status=1;
        }
        AddonPurchase::where('id',$id)->update(['status'=>$status]);
        Toastr::success('Addon Purchase Status changed successfully');
        return back();
    }

    
    public function feature_status($id)
    {
        $getstatus=FeatureList::select('status')->where('id',$id)->first();
        if($getstatus->status == 1){
            $status=0;
        }
        elseif($getstatus->status == 0){
            $status=1;
        }            
        else{
            $status=1;
        }
        FeatureList::where('id',$id)->update(['status'=>$status]);
        Toastr::success('Feature Status changed successfully');
        return back();
    }



    

    public function school_ChartYesterday($id)
    {
        $yesterday = Carbon::yesterday();
        $school = School::find($id);
        $logs = LogActivity::where('school_id', $id)->wheredate('created_at', $yesterday)->get();
        $userActivityData = LogActivity::where('school_id', $id )
                                            ->wheredate('created_at', $yesterday)
                                            ->select('subject', 'count')
                                            ->orderByDesc('count')
                                            ->get();

        $xValues = $userActivityData->pluck('subject')->toArray();
        $yValues = $userActivityData->pluck('count')->toArray();
        $colors = [];
        $xCount = count($xValues);
        for($i = 0; $i < $xCount; $i++) {
            $color = '#'.str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
            $colors[] = $color;
        }
        
        return view('backend.admin.Schoolview.SchoolSingleView', compact('school','logs','xValues', 'yValues', 'colors'));
    }
    public function school_ChartLastweek($id)
    {
        $school = School::find($id);
        $last7DaysStart = Carbon::now()->subDays(7);
        $userActivityData = DB::table('log_activities')->where('school_id', $id )
                                            ->where('created_at','>=', $last7DaysStart)
                                            ->select('subject', 'count')
                                            ->orderByDesc('count')
                                            ->get();

        $groupedData = [];
        foreach ($userActivityData as $activity) {
            $subject = $activity->subject;
            $count = $activity->count;
            
            if (isset($groupedData[$subject])) {
                $groupedData[$subject] += $count; 
            } else {
                $groupedData[$subject] = $count;  
            }
        }

        $xValues = array_keys($groupedData);    
        $yValues = array_values($groupedData);
        $colors = [];
        $xCount = count($xValues);
        for($i = 0; $i < $xCount; $i++) {
            $color = '#'.str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
            $colors[] = $color;
        }
        
        return view('backend.admin.Schoolview.SchoolSingleView', compact('school','xValues', 'yValues', 'colors'));
    }
    public function school_ChartLastmonth($id)
    {
       $school = School::find($id);
        $lastMonthStart = Carbon::now()->subMonths(1);
        $userActivityData = DB::table('log_activities')->where('school_id', $id )
                                            ->where('created_at','>=', $lastMonthStart)
                                            ->select('subject', 'count')
                                            ->orderByDesc('count')
                                            ->get();
        
        $groupedData = [];
        foreach ($userActivityData as $activity) {
            $subject = $activity->subject;
            $count = $activity->count;
            
            if (isset($groupedData[$subject])) {
                $groupedData[$subject] += $count; 
            } else {
                $groupedData[$subject] = $count;  
            }
        }

        $xValues = array_keys($groupedData);    
        $yValues = array_values($groupedData);
        $colors = [];
        $xCount = count($xValues);
        for($i = 0; $i < $xCount; $i++) {
            $color = '#'.str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
            $colors[] = $color;
        }
        
        return view('backend.admin.Schoolview.SchoolSingleView', compact('school','xValues', 'yValues', 'colors'));
    }
    public function school_ChartSixmonth($id)
    {
       $school = School::find($id);
        $lastSixmonth = Carbon::now()->subMonths(6);
        $userActivityData = DB::table('log_activities')->where('school_id', $id )
                                            ->where('created_at','>=', $lastSixmonth)
                                            ->select('subject', 'count')
                                            ->orderByDesc('count')
                                            ->get();

                                            
        $groupedData = [];

        foreach ($userActivityData as $activity) {
            $subject = $activity->subject;
            $count = $activity->count;
            
            if (isset($groupedData[$subject])) {
                $groupedData[$subject] += $count; 
            } else {
                $groupedData[$subject] = $count;  
            }
        }

        $xValues = array_keys($groupedData);    
        $yValues = array_values($groupedData);
        $colors = [];
        $xCount = count($xValues);
        for($i = 0; $i < $xCount; $i++) {
            $color = '#'.str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
            $colors[] = $color;
        }
        
        return view('backend.admin.Schoolview.SchoolSingleView', compact('school','xValues', 'yValues', 'colors'));
    }
    public function school_ChartThisYear($id)
    {
       $school = School::find($id);
        $lastSixmonth = Carbon::now()->subMonths(12);
        $userActivityData = DB::table('log_activities')->where('school_id', $id )
                                            ->where('created_at','>=', $lastSixmonth)
                                            ->select('subject', 'count')
                                            ->orderByDesc('count')
                                            ->get();

                                            
        $groupedData = [];

        foreach ($userActivityData as $activity) {
            $subject = $activity->subject;
            $count = $activity->count;
            
            if (isset($groupedData[$subject])) {
                $groupedData[$subject] += $count; 
            } else {
                $groupedData[$subject] = $count;  
            }
        }

        $xValues = array_keys($groupedData);    
        $yValues = array_values($groupedData);
        $colors = [];
        $xCount = count($xValues);
        for($i = 0; $i < $xCount; $i++) {
            $color = '#'.str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
            $colors[] = $color;
        }
        
        return view('backend.admin.Schoolview.SchoolSingleView', compact('school','xValues', 'yValues', 'colors'));
    }
    public function school_ChartTotal($id)
    {
       $school = School::find($id);
        $userActivityData = DB::table('log_activities')->where('school_id', $id )
                                            ->select('subject', 'count')
                                            ->orderByDesc('count')
                                            ->get();

                                            
        $groupedData = [];

        foreach ($userActivityData as $activity) {
            $subject = $activity->subject;
            $count = $activity->count;
            
            if (isset($groupedData[$subject])) {
                $groupedData[$subject] += $count; 
            } else {
                $groupedData[$subject] = $count;  
            }
        }

        $xValues = array_keys($groupedData);    
        $yValues = array_values($groupedData);
        $colors = [];
        $xCount = count($xValues);
        for($i = 0; $i < $xCount; $i++) {
            $color = '#'.str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
            $colors[] = $color;
        }
        
        return view('backend.admin.Schoolview.SchoolSingleView', compact('school','xValues', 'yValues', 'colors'));
    }

}
