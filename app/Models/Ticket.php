<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory;
    protected $guarded=[];



    public static function generateToken()
    {
        $token = Str::random(10); 
        Ticket::create(['token' => $token]);

        return $token; 
    }
    public function replies()
{
    return $this->hasMany(Reply::class);
}

}
