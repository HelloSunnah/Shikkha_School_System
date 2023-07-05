<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomAttendanceInput extends Model
{
    use HasFactory;

    protected $table = "custom_attendance_input";

    protected $guarded = [];
}