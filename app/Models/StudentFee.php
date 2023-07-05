<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class StudentFee extends Model
{
    use HasFactory;

    protected $guarded= [];

    public function class_name(): BelongsTo
    {
        return $this->belongsTo(InstituteClass::class, 'class_id', 'id');

    }

    public function feesType()
    {
        return $this->belongsTo(FeesType::class);   
    }

}
