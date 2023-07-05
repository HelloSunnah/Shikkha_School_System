<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class OnlineAdmission extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded=[];

    public function Classrelation(){
        return $this->belongsTo(InstituteClass::class,'class_id','id');

    }
}
