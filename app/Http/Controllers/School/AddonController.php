<?php

namespace App\Http\Controllers\School;

use Auth;
use App\Models\School;
use App\Models\AddonModel;
use Illuminate\Http\Request;
use App\Models\AddonPurchase;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class AddonController extends Controller
{
    public function SchoolAddon(){
         $seoTitle = 'School Addon';
        $seoDescription = 'School Addon' ;
        $seoKeyword = 'School Addon' ;
        $seo_array = [
            'seoTitle' => $seoTitle,
            'seoKeyword' => $seoKeyword,
            'seoDescription' => $seoDescription,
        ];
        $addons=AddonModel::all();
        return view('frontend.school.AddonSchool.AddonlistSchool',compact('addons','seo_array'));
    }
    
    public function SchoolAddonCheckout(Request $request)
    {
        $school = School::find(Auth::user()->id);
        
        $id = $request->addon_package_id;
       $addoncheckoutinfo = AddonModel::where('id', $id)->first();
        return view('frontend.school.AddonSchool.AddonCheckoutShow', compact('addoncheckoutinfo'));
      }

      
//      public function SchoolAddonCheckout($id){
//         $school = school::find(Auth::user()->id);
//         $addoncheckoutinfo = AddonModel::find($id);
//         return view('frontend.school.AddonSchool.AddonCheckoutShow', compact('addoncheckoutinfo','school'));
//     }


  public function SchoolAddonPurchase(Request $request){

        try {
            // $addoncheckoutinfo = AddonModel::where('id', $id)->first();
            AddonPurchase::create([
                'school_id' => $request->school_id,
                'addon_id' => $request->addon_id,
                'feature_id' => $request->feature_id,
                'price' => $request->price,
                'status' => $request->status,
            ]);
            Alert::success(' Addon purchase added.We contact with you very soon', 'Success Message');
            return redirect()->route('SchoolAddon');
        } catch (Exception $e) {
            Alert::error('Error');
            return redirect()->route('SchoolAddon');
        }
     }
}
