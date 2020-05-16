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

    public static function getJoined()
    {
      return self::select('students.id', 'students.rut', 'students.name', 'students.last_name as lastName', 'students.age', 'courses.code as course')
                ->join('courses', 'students.course_id', '=', 'courses.id');
    }

    public static function getJoinedById($id)
    {
      return self::select('students.id', 'students.rut', 'students.name', 'students.last_name as lastName', 'students.age', 'courses.code as course')
                ->join('courses', 'students.course_id', '=', 'courses.id')
                ->where('students.id', $id)
                ->first();
    }

    public static function getByRutAndId($rut, $id)
    {
      return self::where([['rut', $rut], ['id', '<>', $id]])->first();
    }

    public static function getByRut($rut)
    {
      return self::where('rut', $rut)->first();
    }
}
