<?php

namespace App\Http\Controllers\School;

use App\Models\School;
use App\Models\AddonModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class AddonController extends Controller
{
    public function SchoolAddon(){
        $addons=AddonModel::all();
        return view('frontend.school.AddonSchool.AddonlistSchool',compact('addons'));
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
}
