<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donor extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    
    protected $fillable = ['title', 'name', 'address', 'phone', 'email'];
}
