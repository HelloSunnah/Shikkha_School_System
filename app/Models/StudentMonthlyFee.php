<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class StudentMonthlyFee extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = [];

    public function studentFees()
    {
        return $this->belongsTo(StudentFee::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'student_id', 'id');
    }
}
