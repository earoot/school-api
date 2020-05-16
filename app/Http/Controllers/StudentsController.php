<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\Course;

class StudentsController extends Controller
{
  public function __construct()
  {
    $this->middleware('jwt.auth');
  }

  public function paginated()
  {
    $students = Student::getJoined()->paginate(10);

    return response($students, 200)->header('Content-Type', 'application/json');
  }

  public function all()
  {
    $students = Student::getJoined()->get();

    return response($students, 200)->header('Content-Type', 'application/json');
  }

  public function show($id)
  {
    $response['success'] = false;
    $response['message'] = "The student was not found, please try again with another ID";
    $response['data'] = null;
    $code = 404;

    $student = Student::getJoinedById($id);

    if(isset($student)){
      $response['success'] = true;
      $response['message'] = "The student was successfully found, see the data below";
      $response['data'] = $student;
      $code = 200;
    }

    return response($response, $code)->header('Content-Type', 'application/json');
  }

  public function store(Request $request)
  {
    $response['success'] = false;
    $response['message'] = "The student couldn´t be created, please try again";
    $response['data'] = null;
    $code = 400;

    $this->validate($request, [
      'rut' => [
        'required',
        'string',
        'min:8',
        function ($attribute, $value, $fail) {
            if(!validateRut($value)){
              $fail("The " . $attribute . ' is invalid, the verification digit is not correct.');
            }

            if(Student::getByRut(clearRut($value)) !== null){
              $fail("This " . $attribute . ' number is already registered');
            }
        },
      ],
      'name' => 'required|string',
      'lastName' => 'required|string',
      'age' => 'required|integer|gte:18',
      'course' => 'exists:courses,code'
    ]);

    $data = $request->all();

    $student = Student::create([
      'rut' => clearRut($data['rut']),
      'name' => $data['name'],
      'last_name' => $data['lastName'],
      'age' => $data['age'],
      'course_id' => Course::getByCode($data['course'])->id
    ]);

    if($student){
      $response['success'] = true;
      $response['message'] = "The student has been successfully created";
      $response['data'] = $student;
      $code = 201;
    }

    return response($response, $code)->header('Content-Type', 'application/json');
  }

  public function update($id, Request $request)
  {
    $response['success'] = false;
    $response['message'] = "The student was not found, please try again with another ID";
    $response['data'] = null;
    $code = 404;

    $request->request->add(['rut_number' => clearRut($request->get('rut'))]);

    $this->validate($request, [
      'rut_number' => [
        'required',
        'string',
        'min:8',
        'unique:students,rut,'.$id,
        function ($attribute, $value, $fail) {
            if(!validateRut($value)){
              $fail("The " . $attribute . ' is invalid, the verification digit is not correct.');
            }
        },
      ],
      'name' => 'required|string',
      'lastName' => 'required|string',
      'age' => 'required|integer|gte:18',
      'course' => 'exists:courses,code'
    ]);

    $student = Student::find($id);

    if(isset($student)){
      $data = $request->all();

      $student->rut = clearRut($data['rut']);
      $student->name = $data['name'];
      $student->last_name = $data['lastName'];
      $student->age = $data['age'];
      $student->course_id = Course::getByCode($data['course'])->id;

      if($student->save()){
        $response['success'] = true;
        $response['message'] = "The student was successfully updated";
        $response['data'] = $student;
        $code = 200;
      } else {
        $response['success'] = false;
        $response['message'] = "There was an error when trying to update the student";
        $response['data'] = null;
        $code = 400;
      }
    }

    return response($response, $code)->header('Content-Type', 'application/json');
  }

  public function destroy($id)
  {
    $response['success'] = false;
    $response['message'] = "The student was not found, please try again with another ID";
    $code = 404;

    $student = Student::find($id);

    if(isset($student) && $student->delete()){
      $response['success'] = true;
      $response['message'] = "The student was successfully deleted";
      $code = 200;
    }

    return response($response, $code)->header('Content-Type', 'application/json');
  }
}
