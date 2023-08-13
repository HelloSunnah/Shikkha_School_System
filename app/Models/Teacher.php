<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class Teacher extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable ,SoftDeletes;

    protected $guard = 'teachers';

    protected $guarded = [];

    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Relation with School
     */
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    /**
     * Relation with permission
     */
    public function permission()
    {
        return $this->hasOne(Permission::class);
    }

    // default logo
    public function getImageAttribute($image)
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
}
