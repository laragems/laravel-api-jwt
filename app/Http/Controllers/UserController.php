<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Validator;

class UserController extends Controller
{
    public function show()
    {
        $user = Auth::User();

        return response()->json(compact('user'));
    }

    public function store(Request $request)
    {
        $data = $request->only(['email', 'password', 'name']);

        $validator = Validator::make($request->all(), [
            'email' => 'email|unique:users',
            'password' => 'required',
            'name' => 'required'
        ]);

        if($validator->fails())
        {
            return $this->validationErrors($validator);
        }

        $data['password'] = bcrypt($data['password']);

        if(User::create($data))
        {
            /**
             * User created successfully
             */
            return response()->json([
                'status' => 'success',
                'message' => 'User created.'
            ], Response::HTTP_CREATED);
        }
        else
        {
            return response()->json([
                'status' => 'error',
                'message' => 'User not created.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Returns validation errors for user creation
     *
     * @param $validator
     * @return mixed
     */
    private function validationErrors($validator)
    {
        $response = [
            'status' => 'error',
            'message' => 'Invalid input data.'
        ];

        foreach ($validator->errors()->all() as $error) {
            $response['details'][] = $error;
        }

        return response()->json($response, Response::HTTP_BAD_REQUEST);
    }
}
