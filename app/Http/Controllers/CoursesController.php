<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CoursesController extends Controller
{
    public function __construct()
    {
      $this->middleware('jwt.auth');
    }

    public function paginated()
    {
        return "Paginated Courses";
    }

    public function all()
    {
        return "All Courses";
    }

    public function show($id)
    {
        return "ID Course: " . $id;
    }

    public function store(Request $request)
    {
      $response['succes'] = true;
      $response['message'] = "Store Course OK";
      $response['data'] = $request->all();

      return response($response, 201)->header('Content-Type', 'application/json');
    }

    public function update($id, Request $request)
    {
      $response['succes'] = true;
      $response['message'] = "Update Course OK";
      $response['data'] = "ID: ".$id;

      return response($response, 200)->header('Content-Type', 'application/json');
    }

    public function destroy($id)
    {
      $response['succes'] = true;
      $response['message'] = "Delete Course OK";
      $response['data'] = "ID: ".$id;

      return response($response, 200)->header('Content-Type', 'application/json');
    }
}
