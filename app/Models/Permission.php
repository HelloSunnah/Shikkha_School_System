<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $casts   = [
        'permission'    => 'json'
    ];
    
    /**
     * Relation with Role
     * 
     * @contributor Sajjad <sajjad.develpr@gmail.com>
     * @created 17-07-23
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    /**
     * Relation with Teacher
     * 
     * @contributor Sajjad <sajjad.develpr@gmail.com>
     * @created 17-07-23
     */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }
    /**
     * Relation with Employee
     * 
     * @contributor Sajjad <sajjad.develpr@gmail.com>
     * @created 17-07-23
     */

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
