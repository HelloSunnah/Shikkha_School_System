<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Teacher extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable ,SoftDeletes;

    protected $guard = 'teachers';

    protected $guarded = [];

    protected $hidden = [
        'password', 'remember_token',
    ];


    public function school()
    {
        return $this->belongsTo(School::class);
    }

}
