<?php

namespace App\Http\Controllers;
use  App\Answer;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function delete($data)
    {
        for($i = 0 ; $i < count($data) ; $i++)
        {
            for($j = 0 ; $j < count($data[$i]) ; $j++)
            {
                $deleted = Answer::find($data[$i][$j]->id)->delete();
            }
        }
    }
}
