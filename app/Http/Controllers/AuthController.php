<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use \Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    public function auth(Request $request)
    {
        $credentials = $request->only('email', 'password');

        return $this->requestToken($credentials);
    }

    /**
     * Try to authenticate using specified email & password credentials
     *
     * @param array $credentials ['email', 'password'] required
     * @return json
     */
    private function requestToken(array $credentials)
    {
        try
        {
            if ( ! $token = JWTAuth::attempt($credentials))
            {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid credentials'
                ], Response::HTTP_UNAUTHORIZED);
            }

            /**
             * Auth passed!
             */
            return response()->json([
                'status' => 'success',
                'token' => $token
            ]);
        }
        catch (JWTException $e)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Could not create token'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
