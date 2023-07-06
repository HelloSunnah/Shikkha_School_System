<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function assignUser()
    {
        return $this->belongsTo(School::class, 'assign_id_user', 'id');
    }
    public function assignAdmin()
    {
        return $this->belongsTo(Admin::class, 'assign_id_admin', 'id');
    }
}
