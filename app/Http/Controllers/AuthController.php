<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
  public function __construct()
  {
    $this->middleware('jwt.auth', ['except' => ['getDefaultJWT']]);
  }

  public function getDefaultJWT()
  {
      $credentials['email'] = config('app.default_api_user');
      $credentials['password'] = config('app.default_api_password');

      if((!isset($credentials['email']) || !isset($credentials['password'])) || (!$token = auth()->attempt($credentials))){
        return response()->json(['success' => false, 'message' => 'The DEFAULT_API_USER or DEFAULT_API_PASSWORD values are wrong or must be set in the .env file'], 401);
      }

      return $this->respondWithToken($token);
  }

  protected function respondWithToken($token)
  {
    return response()->json([
      'success' => true,
      'access_token' => $token,
      'token_type' => 'bearer',
      'expires_in' => auth()->factory()->getTTL() * 60
    ]);
  }
}
