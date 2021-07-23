<?php

namespace App\Http\Controllers;

use  App\StudentAnswer;
use Illuminate\Http\Request;

class StudentAnswerController extends Controller
{
    public function store($data)
    {
        StudentAnswer::create($data);
    }
}
