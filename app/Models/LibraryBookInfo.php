<?php

namespace App\Models;

use App\Models\LibBookType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;


class LibraryBookInfo extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded=[];

    public function bookRelation(){
        return $this->belongsTo(LibBookType::class, 'book_type_id', 'id');
    }

}
