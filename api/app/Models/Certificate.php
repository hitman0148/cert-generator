<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Certificate extends Model
{
    use HasFactory;
    public $fillable = ['user_id','lesson_id','date_created'];
    public $timestamps = false;


    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }

    public function lesson(){
        return $this->hasOne(Lesson::class,'id','lesson_id');
    }
}
