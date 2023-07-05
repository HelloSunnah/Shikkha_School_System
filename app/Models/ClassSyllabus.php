<?php

namespace App\Models;

use App\Models\Term;
use App\Models\Subject;
use App\Models\InstituteClass;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;



class ClassSyllabus extends Model
{
use HasFactory,SoftDeletes;
protected $guarded = [];

public function classRelation()
{
return $this->belongsTo(InstituteClass::class, 'class_id', 'id');
}
public function subjectRelation()
{
return $this->belongsTo(Subject::class, 'subject_id', 'id');
}
public function termRelation(){
return $this->belongsTo(Term::class, 'term_id', 'id');

}

}











