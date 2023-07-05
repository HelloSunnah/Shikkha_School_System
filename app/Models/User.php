<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function result(): BelongsTo
    {
        return $this->belongsTo(Result::class,'id','student_id');
    }

    public function clasRelation(){
        return $this->belongsTo(InstituteClass::class,'class_id','id');
    }

    public function sectionRelation(){
        return $this->belongsTo(Section::class, 'section_id', 'id');
    }
    
    public function schoolRelation(){
        return $this->belongsTo(Section::class,'school_id','id');
    }
    /**
     * Relation with School
     * 
     * @return \Illuminate\Database
     */
    public function school(){
        return $this->belongsTo(School::class, 'school_id', 'id');
    }
    
    public function attendance()
    {
        return $this->belongsTo(Attendance::class, 'id', 'student_id');
    }


    public function monthlyFees()
    {
        return $this->hasMany(StudentMonthlyFee::class, 'student_id', 'id');
    }


    public function assignMonthlyFees()
    {
        return $this->hasMany(AssignStudentFee::class, 'class_id', 'class_id');
    }


    public function class()
    {
        return $this->hasOne(InstituteClass::class, 'id', 'class_id');
    }

    public function section()
    {
        return $this->hasOne(Section::class, 'id', 'section_id');
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

}
