<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class EmployeeSalary extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = [];

    public function scopeWhereSchool($query)
    {
        return $query->where('school_id', Auth::id());
    }
}
