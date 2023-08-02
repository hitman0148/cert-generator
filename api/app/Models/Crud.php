<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crud extends Model
{
    use HasFactory;
    protected $table = 'crud';
    protected $fillable = [
        'fname','lname', 'email', 'password', 'date_created',
    ];
    public $timestamps = false;
}
