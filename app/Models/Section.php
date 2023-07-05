<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Section extends Model
{
    use HasFactory,SoftDeletes;

    public function class_name()
    {
        return $this->belongsTo(InstituteClass::class,'class_id','id');
    }
    public function group_name()
    {
        return $this->belongsTo(Group::class,'id','section_id');
    }

    public function class_teacher()
    {
        return $this->belongsTo(AssignTeacher::class,'id','section_id');
    }

//    public function teacher_name()
//    {
//        return $this->belongsTo(Teacher::class,'teacher_id','id');
//    }

//    public function group_name(){
//        return $this->hasmany(Group::class,'group_id','id');
//    }
}
