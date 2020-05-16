<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
      'rut',
      'name',
      'last_name',
      'age',
      'course_id'
    ];
}
