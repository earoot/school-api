<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Course;

class CoursesController extends Controller
{
    public function __construct()
    {
      $this->middleware('jwt.auth');
    }

    public function paginated()
    {
      $courses = Course::paginate(10);

      return response($courses, 200)->header('Content-Type', 'application/json');
    }

    public function all()
    {
      $courses = Course::get();

      return response($courses, 200)->header('Content-Type', 'application/json');
    }

    public function show($id)
    {
      $response['success'] = false;
      $response['message'] = "The course was not found, please try again with another ID";
      $response['data'] = null;
      $code = 404;

      $course = Course::find($id);

      if(isset($course)){
        $response['success'] = true;
        $response['message'] = "The course was successfully found, see the data below";
        $response['data'] = $course;
        $code = 200;
      }

      return response($response, $code)->header('Content-Type', 'application/json');
    }

    public function store(Request $request)
    {
      $response['success'] = false;
      $response['message'] = "The course couldn´t be created, please try again";
      $response['data'] = null;
      $code = 400;

      $this->validate($request, [
        'name' => 'required|string',
        'code' => 'required|string|max:4|unique:courses'
      ]);

      $data = $request->all();

      $course = Course::create($data);

      if($course){
        $response['success'] = true;
        $response['message'] = "The course has been successfully created";
        $response['data'] = $course;
        $code = 201;
      }

      return response($response, $code)->header('Content-Type', 'application/json');
    }

    public function update($id, Request $request)
    {
      $response['success'] = false;
      $response['message'] = "The course was not found, please try again with another ID";
      $response['data'] = null;
      $code = 404;

      $this->validate($request, [
        'name' => 'required|string',
        'code' => 'required|string|max:4|unique:courses,code,'.$id
      ]);

      $course = Course::find($id);

      if(isset($course)){
        $data = $request->all();

        $course->name = $data['name'];
        $course->code = $data['code'];

        if($course->save()){
          $response['success'] = true;
          $response['message'] = "The course was successfully updated";
          $response['data'] = $course;
          $code = 200;
        } else {
          $response['success'] = false;
          $response['message'] = "There was an error when trying to update the course";
          $response['data'] = null;
          $code = 400;
        }
      }

      return response($response, $code)->header('Content-Type', 'application/json');
    }

    public function destroy($id)
    {
      $response['success'] = false;
      $response['message'] = "The course was not found, please try again with another ID";
      $code = 404;

      $course = Course::find($id);

      if(isset($course) && $course->delete()){
        $response['success'] = true;
        $response['message'] = "The course was successfully deleted";
        $code = 200;
      }

      return response($response, $code)->header('Content-Type', 'application/json');
    }
}
