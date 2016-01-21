<?php

namespace App\Http\Controllers;

use Route;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function showRoutes()
    {
        $routes = Route::getRoutes();

        $processedRoutes = [];

        foreach($routes as $key => $route)
        {
            /**
             * Remove "/" path and HEAD method from routes listing
             */

            $path = $route->getPath();

            if($path == '/')
            {
                continue;
            }

            $methods = $route->getMethods();

            $headKey = array_search('HEAD', $methods);

            if(false !== $headKey)
            {
                unset($methods[$headKey]);
            }

            $processedRoutes[] = [
                'path' => \Request::url() . '/' . $path,
                'methods' => $methods
            ];

        }

        return view('home.showRoutes')->with('routes', $processedRoutes);
    }
}
