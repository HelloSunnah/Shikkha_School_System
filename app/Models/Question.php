<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Question extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        
        'question_title' => 'json',
        'question_mark'  => 'json',
        'question'      => 'json',
        'mcq_question'  => 'json',
        'cre_question'  => 'json'
    ];

    //Relation with Institute Class
    public function class()
    {
        return $this->belongsTo(InstituteClass::class, 'class_id', 'id');
    }

    //Relation with Subject Class
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    //Relation with Terms
    public function term()
    { 
        return $this->belongsTo(Term::class, 'term_id');
    }

    //Retion with School
    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }
}
