<?php

namespace App\Models;

use App\Models\StudentFee;
use App\Models\StudentMonthlyFee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;


class FeesType extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = [];

    public function fees()
    {
        return $this->hasMany(StudentFee::class, 'fees_type_id', 'id');
    }
    public function studentfees()
    {
        return $this->hasMany(StudentMonthlyFee::class, 'fees_type_id', 'id');
    }
}
