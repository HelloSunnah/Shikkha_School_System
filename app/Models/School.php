<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Carbon\Carbon;

class School extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded =[];

    public function schoolfee_Relation(){
        return $this->hasMany(SchoolFee::class,'school_id','id');
    }
    // public static function boot()
    //     {
    //         parent::boot();

    //         static::creating(function ($school) {
    //             $school->trial_end_date = Carbon::now()->addDays(1);
    //         });
    //     }
}
