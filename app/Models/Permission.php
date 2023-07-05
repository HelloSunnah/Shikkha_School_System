<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
