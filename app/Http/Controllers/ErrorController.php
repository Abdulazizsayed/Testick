<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErrorController extends Controller
{
    public function accessDenied()
    {
        return view('errorPages.accessDenied');
    }
}
