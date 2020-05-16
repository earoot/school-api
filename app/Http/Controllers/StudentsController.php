<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentsController extends Controller
{
  public function __construct()
  {
    $this->middleware('jwt.auth');
  }

  public function paginated()
  {
      return "Paginated Students";
  }

  public function all()
  {
      return "All Students";
  }

  public function show($id)
  {
      return "ID Student: " . $id;
  }

  public function store(Request $request)
  {
    $response['succes'] = true;
    $response['message'] = "Store Student OK";
    $response['data'] = $request->all();

    return response($response, 201)->header('Content-Type', 'application/json');
  }

  public function update($id, Request $request)
  {
    $response['succes'] = true;
    $response['message'] = "Update Student OK";
    $response['data'] = "ID: ".$id;

    return response($response, 200)->header('Content-Type', 'application/json');
  }

  public function destroy($id)
  {
    $response['succes'] = true;
    $response['message'] = "Delete Student OK";
    $response['data'] = "ID: ".$id;

    return response($response, 200)->header('Content-Type', 'application/json');
  }
}
