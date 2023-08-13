<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class School extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded =[];

    public function schoolfee_Relation(){
        return $this->hasMany(SchoolFee::class,'school_id','id');
    }

    // default logo
    public function getSchoolLogoAttribute($image)
    {
        if(is_null($image))
        {
            return asset('d/no-img2.jpg');
        }
        else
        {
            if(File::exists(public_path($image)))
            {
                return $image;
            }
            else
            {
                return asset('d/no-img2.jpg');
            }
        }
        
    }


    // public static function boot()
    //     {
    //         parent::boot();

    //         static::creating(function ($school) {
    //             $school->trial_end_date = Carbon::now()->addDays(1);
    //         });
    //     }
}
