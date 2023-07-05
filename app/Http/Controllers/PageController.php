<?php

namespace App\Http\Controllers;

use App\Mail\SupportAlertMail;
use App\Models\Blog;
use App\Models\FeatureDetailsPage;
use App\Models\Otp;
use App\Models\Price;
use App\Models\User;
use Carbon\Carbon;
use App\Models\School;
use App\Models\Support;
use App\Models\SEOModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function changeLanguage($local = 'bn')
    {
        App::setLocale($local);
        
        if(Auth::guard('schools')->check())
        {
            // return "hello";
            $school=School::find(Auth::guard('schools')->id());
            $school->language = $local;
            $school->save();

            //  Store langcode in session
            session(['locale'   =>  Auth::guard('schools')->user()->language ?? "bn"]);
        }
        else
        {
            //  Store langcode in session
            session(['locale'   =>  $local]);
        }
        
        return back();
    }
    
    public function notificationData($id){
        $notificationUserId = User::where('id',$id)->first();
        return view('frontend.user.template.notification',compact('notificationUserId'));
    }
    public function home()
    {
        $seoTitle = SEOModel::where('page_no','=','1')->first()->title;
        $seoDescription = SEOModel::where('page_no','=','1')->first()->description;
        $seoKeyword = SEOModel::where('page_no','=','1')->first()->keyword;
        $seo_array = [
            'seoTitle' => $seoTitle,
            'seoKeyword' => $seoKeyword,
            'seoDescription' => $seoDescription,
        ];
        $blog=Blog::orderBy('created_at', 'desc')->take(4)->get();
        return view('frontend.pages.index', compact('seo_array','blog'));
    }

    public function contactPage()
    {
        $seoTitle = SEOModel::where('page_no','=','14')->first()->title;
        $seoDescription = SEOModel::where('page_no','=','14')->first()->description;
        $seoKeyword = SEOModel::where('page_no','=','14')->first()->keyword;
        $seo_array = [
            'seoTitle' => $seoTitle,
            'seoKeyword' => $seoKeyword,
            'seoDescription' => $seoDescription,
        ];
        return view('frontend.pages.contact', compact('seo_array'));
        // return view('frontend.pages.contact');
    }
    public function  blogView($slug){
        $blog = Blog::where('slug', 'LIKE', "%{$slug}%")->first();
        $blog1=Blog::orderBy('created_at', 'desc')->take(4)->get();

        return view('frontend.pages.blogView',compact('blog','blog1'));

    }
    public function featurePage()
    {
        return view('frontend.pages.feature');
    }

    public function featureU()
    {
        $seoTitle = SEOModel::where('page_no','=','2')->first()->title;
        $seoDescription = SEOModel::where('page_no','=','2')->first()->description;
        $seoKeyword = SEOModel::where('page_no','=','2')->first()->keyword;
        $seo_array = [
            'seoTitle' => $seoTitle,
            'seoKeyword' => $seoKeyword,
            'seoDescription' => $seoDescription,
        ];
        return view('frontend.pages.service.featureU', compact('seo_array'));
        
    }
    public function featureS()
    {
        $seoTitle = SEOModel::where('page_no','=','4')->first()->title;
        $seoDescription = SEOModel::where('page_no','=','4')->first()->description;
        $seoKeyword = SEOModel::where('page_no','=','4')->first()->keyword;
        $seo_array = [
            'seoTitle' => $seoTitle,
            'seoKeyword' => $seoKeyword,
            'seoDescription' => $seoDescription,
        ];
        return view('frontend.pages.service.featureS', compact('seo_array'));
        
    }
    public function featureA()
    {
        $seoTitle = SEOModel::where('page_no','=','3')->first()->title;
        $seoDescription = SEOModel::where('page_no','=','3')->first()->description;
        $seoKeyword = SEOModel::where('page_no','=','3')->first()->keyword;
        $seo_array = [
            'seoTitle' => $seoTitle,
            'seoKeyword' => $seoKeyword,
            'seoDescription' => $seoDescription,
        ];
        return view('frontend.pages.service.featureU', compact('seo_array'));
        // return view('frontend.pages.service.featureA');
    }
    public function featureP()
    {
        $seoTitle = SEOModel::where('page_no','=','5')->first()->title;
        $seoDescription = SEOModel::where('page_no','=','5')->first()->description;
        $seoKeyword = SEOModel::where('page_no','=','5')->first()->keyword;
        $seo_array = [
            'seoTitle' => $seoTitle,
            'seoKeyword' => $seoKeyword,
            'seoDescription' => $seoDescription,
        ];
        return view('frontend.pages.service.featureP', compact('seo_array'));
        // return view('frontend.pages.service.featureP');
    }
    public function featureO()
    {
        $seoTitle = SEOModel::where('page_no','=','7')->first()->title;
        $seoDescription = SEOModel::where('page_no','=','7')->first()->description;
        $seoKeyword = SEOModel::where('page_no','=','7')->first()->keyword;
        $seo_array = [
            'seoTitle' => $seoTitle,
            'seoKeyword' => $seoKeyword,
            'seoDescription' => $seoDescription,
        ];
        return view('frontend.pages.service.featureO', compact('seo_array'));
        // return view('frontend.pages.service.featureO');
    }
    public function featureE()
    {
        $seoTitle = SEOModel::where('page_no','=','6')->first()->title;
        $seoDescription = SEOModel::where('page_no','=','6')->first()->description;
        $seoKeyword = SEOModel::where('page_no','=','6')->first()->keyword;
        $seo_array = [
            'seoTitle' => $seoTitle,
            'seoKeyword' => $seoKeyword,
            'seoDescription' => $seoDescription,
        ];
        return view('frontend.pages.service.featureE', compact('seo_array'));
    }


    public function pricing()
    {
        $prices = Price::get();
        $seoTitle = SEOModel::where('page_no','=','8')->first()->title;
        $seoDescription = SEOModel::where('page_no','=','8')->first()->description;
        $seoKeyword = SEOModel::where('page_no','=','8')->first()->keyword;
        $seo_array = [
            'seoTitle' => $seoTitle,
            'seoKeyword' => $seoKeyword,
            'seoDescription' => $seoDescription,
        ];
        return view('frontend.pages.pricing', compact('prices', 'seo_array'));
    }
    public function pricing_Checkout(Request $request)
    {
        
        $id = $request->prices_package_id;
       $price = Price::where('id', $id)->first();
        return view('frontend.pages.pricingmodal',compact('price'));
    }



    public function getStarted(Request $request)
    {
        $email=$request-> email;
        $data = School::where('email', $email)->first();
        $seoTitle = SEOModel::where('page_no','=','17')->first()->title;
        $seoDescription = SEOModel::where('page_no','=','17')->first()->description;
        $seoKeyword = SEOModel::where('page_no','=','17')->first()->keyword;
        $seo_array = [
            'seoTitle' => $seoTitle,
            'seoKeyword' => $seoKeyword,
            'seoDescription' => $seoDescription,
        ];
        if($data)
        {
            return view('auth.login', ['url' => 'schools', 'email'=>$email]);
        }
        else
        {
            return view('frontend.pages.signup',compact('email', 'seo_array'));
        }
    }

    public function termsCondition()
    {
        $seoTitle = SEOModel::where('page_no','=','13')->first()->title;
        $seoDescription = SEOModel::where('page_no','=','13')->first()->description;
        $seoKeyword = SEOModel::where('page_no','=','13')->first()->keyword;
        $seo_array = [
            'seoTitle' => $seoTitle,
            'seoKeyword' => $seoKeyword,
            'seoDescription' => $seoDescription,
        ];
        return view('term_condition', compact('seo_array'));
    }

    public function video()
    {
        $seoTitle = SEOModel::where('page_no','=','12')->first()->title;
        $seoDescription = SEOModel::where('page_no','=','12')->first()->description;
        $seoKeyword = SEOModel::where('page_no','=','12')->first()->keyword;
        $seo_array = [
            'seoTitle' => $seoTitle,
            'seoKeyword' => $seoKeyword,
            'seoDescription' => $seoDescription,
        ];
        return view('videos', compact('seo_array'));
    }

    public function blog()
    {
        $seoTitle = SEOModel::where('page_no','=','11')->first()->title;
        $seoDescription = SEOModel::where('page_no','=','11')->first()->description;
        $seoKeyword = SEOModel::where('page_no','=','11')->first()->keyword;
        $seo_array = [
            'seoTitle' => $seoTitle,
            'seoKeyword' => $seoKeyword,
            'seoDescription' => $seoDescription,
        ];
        $blog=Blog::all();
        return view('blog', compact('seo_array','blog'));
    }

    public function getSignup(Request $request){
        $validator = Validator::make($request->all(),[
            'school_name' => 'required',
            'school_name_bn' => 'required',

            'phone_number' => 'required|min:11||unique:schools',
            // 'address' => 'required',
            'password' => 'required|string|min:6|',
            'email' => 'required|unique:schools',
        ]);
        //  dd($validator->fails());
        
        if($validator->fails())
        {
            $school = School::where('phone_number',$request->phone_number)->where('email',$request->email)->first();
            if(!is_null($school)){
              //  dd($school);
              
            $seoTitle = SEOModel::where('page_no','=','9')->first()->title;
            $seoDescription = SEOModel::where('page_no','=','9')->first()->description;
            $seoKeyword = SEOModel::where('page_no','=','9')->first()->keyword;
            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
            ];
                if($school->is_editor == 0){
                    $to = $request->phone_number;
                    $to_email = $request->email;
                    $to_password = $request->password;
                    return view('frontend.pages.otp',compact('to','to_email','to_password','seo_array'));
                }elseif ($school->is_editor == 1){
                    toast('We need More Infomation','success');
                    return redirect()->route('school.login');
                }else{
                    toast('Your Account is already have','success');
                    return redirect()->route('school.login');
                }
            }else{
                $seoTitle = SEOModel::where('page_no','=','9')->first()->title;
                $seoDescription = SEOModel::where('page_no','=','9')->first()->description;
                $seoKeyword = SEOModel::where('page_no','=','9')->first()->keyword;
                $seo_array = [
                    'seoTitle' => $seoTitle,
                    'seoKeyword' => $seoKeyword,
                    'seoDescription' => $seoDescription,
                ];
                $errors =$validator->errors();
                return view('frontend.pages.signup',compact('errors' ,'seo_array'));
            }


        }
        
        $seoTitle = SEOModel::where('page_no','=','9')->first()->title;
        $seoDescription = SEOModel::where('page_no','=','9')->first()->description;
        $seoKeyword = SEOModel::where('page_no','=','9')->first()->keyword;
        $seo_array = [
            'seoTitle' => $seoTitle,
            'seoKeyword' => $seoKeyword,
            'seoDescription' => $seoDescription,
        ];

        $school = new School();

        $school->email = $request->email;
        $school->phone_number = $request->phone_number;
        $school->address = $request->address;
        $school->password = Hash::make($request->password);
        $school->school_name = $request->school_name;
        $school->school_name_bn = $request->school_name_bn;
        $school->unique_id = uniqid();
        $trialEndDate = Carbon::now()->addDays(10);
        $school->trial_end_date = $trialEndDate;
        $school->subscription_status = $request->subscription_status;
        $school->save();

        $token   = env("GREENWEB_TOKEN");
        $code    = rand(1000, 9999);
        $to      = $school['phone_number'];
        $to_email      = $school['email'];
        $message = $code . " is your verification code on shikkha.one";

        $otp = new Otp();

        $otp->school_id = $school->id;
        $otp->otp = $code;
        $otp->phone = $to;
        $otp->email = $to_email;
        $otp->save();

        Controller::GreenWebSMS($to, $message);
        
        $to_password = $request->password;
        toast('Otp will be send , Please Wait','question');
        return view('frontend.pages.otp',compact('to','to_email','to_password' ,'seo_array'));

    }



    /**--------------------     Resend OTP 
     * =======================================================*/
    public function otpResent(Request $request)
    {
        $phone = $request->phone;
        $email = $request->email;
        $password = $request->password;

        $row = Otp::where(['phone' => $phone, 'email' => $email]);
        /** Generate 4 digit code */
        $code    = rand(1000, 9999);

        $data = [
            'to'    => $phone,
            'to_email'  => $email,
            'to_password'   =>  $password,
        ];


        if($row->exists())
        {
            $row->update([
                'otp'   => $code,
            ]);

            /** Send otp */
            if(sendOtp($phone, $code))
            {
                toast('Otp will be send , Please Wait','question');
                return view('frontend.pages.otp',$data);
            }
        }
        
        toast('Somthing went wrong , Please Wait','question');
        return view('frontend.pages.otp',$data);
        
    }


    public function otpPost(Request $request)
    {
        $request->otp = $request->otp1.$request->otp2.$request->otp3.$request->otp4 ;
        $school = School::where('phone_number',$request->phone_number)->where('email',$request->email)->first();
        $otp = Otp::where('phone',$request->phone_number)->where('email',$request->email)->first();

        if(!$otp->exists())
        {
            toast('Otp not exists','question');
            return redirect()->route('school.login');
        }

        if($otp->otp == $request->otp){
            $school->is_editor = 1;
            $school->save();
            $otp->delete();
            $school = School::where('phone_number',$request->phone_number)->where('email',$request->email)->first();

            if (Auth::guard('schools')->attempt(['email' => $request->email,'password' => $request->password,'is_editor' => 1], $request->get('remember'))) {
                return redirect()->intended('/acquisition');
            }
            else{
                return back();
            }
        }else{
            $to_password = $request->password;
            $to_email = $request->email;
            $to = $request->phone_number;
            toast('Wrong Otp','question');
            return view('frontend.pages.otp',compact('to','to_email','to_password'));
        }
    }


    /**
     * send email for contact
     */
    public function contactSuppport(Request $request)
    {
        $request->validate([
            'name'  =>  ['required', 'string'],
            'email'=>['required', 'email', 'string'],
            'subject'=>['required', 'string'],
            'message'=>['required', 'string'],
        ]);

        $data = $request->only('name', 'email', 'subject', 'message');
        

        try{
            Support::create($data);

            $data['domain'] = url('');
            // Mail::to("support@codecell.com.bd")->send(new SupportAlertMail($data));
        }
        catch(Exception $e)
        {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', "We received your message successfully.");
    }

    
}