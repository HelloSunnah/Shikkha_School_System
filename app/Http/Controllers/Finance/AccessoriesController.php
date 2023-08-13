<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\AccesoriesType;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccessoriesController extends Controller
{
    use HttpResponse;

    /**
     * accessories
     * 
     * @return \Illuminate\Http\JsonResponse
     * 
     * @author Codecell Limited <support@codecell.com.bd>
     * @contributor Shahidul <contact.shahidul@gmail.com>
     * @createdAt August 06, 2023
     */
    public function index()
    {
        $school = Auth::user();

        $resp = AccesoriesType::where('school_id', $school->id)
                ->get([
                    'id',
                    'accesories as name',
                    'price',
                ])
                ->toArray();

        return $this->success('record fetched.', $resp);
    }
}
