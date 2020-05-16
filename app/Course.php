<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
      'name',
      'code'
    ];

    public static function getByCode($code)
    {
      return self::where('code', $code)->first();
    }
}
