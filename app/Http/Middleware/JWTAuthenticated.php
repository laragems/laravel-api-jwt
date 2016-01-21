<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;

class JWTAuthenticated
{
    /**
     * Check to see if there is a valid JWT token.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try
        {
            if ( ! JWTAuth::parseToken()->authenticate())
            {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User for the provided token not found'
                ], Response::HTTP_NOT_FOUND);
            }
        }
        catch (TokenExpiredException $e)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Token expired'
            ], $e->getStatusCode());
        }
        catch (TokenInvalidException $e)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid token'
            ], $e->getStatusCode());
        }
        catch (JWTException $e)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Token is missing'
            ], $e->getStatusCode());
        }

        return $next($request);
    }
}
