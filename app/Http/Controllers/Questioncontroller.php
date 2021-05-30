<?php

namespace App\Http\Controllers;
use  App\Question;

use Illuminate\Http\Request;

class Questioncontroller extends Controller
{
    public function store($data)
    {
        Question::create($data);
    }
}
