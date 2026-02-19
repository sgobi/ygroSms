<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Caregiver extends Model
{
    protected $fillable = [
        'title',
        'name',
        'address',
        'mobile',
        'email',
        'occupation',
        'relationship_to_student',
    ];
}
