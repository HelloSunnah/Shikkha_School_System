<?php 

namespace App\Http\Controllers\Rams;

use App\Http\Controllers\Controller;

class RamsController extends Controller
{
    public function viewLogin()
    {
        return view('panel.attendance.rams');
    }
}