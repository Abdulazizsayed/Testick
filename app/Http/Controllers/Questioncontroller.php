<?php

namespace App\Http\Controllers;
use  App\Question;
use DB;
use Illuminate\Http\Request;

class Questioncontroller extends Controller
{
    public function store($data)
    {
        Question::create($data);
    }
    public function delete($data)
    {
        for($i = 0 ; $i < count($data) ; $i++)
        {
            $deleted = Question::find($data[$i]->id)->delete();
        }
    }
    
}
