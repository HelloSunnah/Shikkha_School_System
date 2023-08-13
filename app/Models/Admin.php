<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\File;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $guard = 'admin';

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
    public function getAdminLogoAttribute($image)
    {
        if(is_null($image))
        {
            return asset('d/shikkha.jpg');
        }
        else
        {
            if(File::exists(public_path($image)))
            {
                return $image;
            }
            else
            {
                return asset('d/shikkha.jpg');
            }
        }
        
    }
}
