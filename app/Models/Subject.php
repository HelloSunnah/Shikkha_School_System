<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Subject extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'class_id', 'subject_name', 'result_total_mark', 'school_id', 'active'
    ];

    public function class_name()
    {
        return $this->belongsTo(InstituteClass::class,'class_id','id');
    }

    // public function section_name()
    // {
    //     return $this->belongsTo(Section::class,'section_id','id');
    // }

    public function group_name()
    {
        return $this->belongsTo(Group::class,'group_id','id');
    }


}
