<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Routine extends Model
{
    use HasFactory,SoftDeletes;

    public $fillable = [
        'school_id',
        'subject_id',
        'class_id',
        'section_id',
        'teacher_id',
        'note',
        'period_id',
        'shift',
        'day',
    ];


    public function period()
    {
        return $this->belongsTo(ClassPeriod::class, 'period_id');
    }

    public function class()
    {
        return $this->belongsTo(InstituteClass::class, 'class_id');
    }

    public function subject() 
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }
}
