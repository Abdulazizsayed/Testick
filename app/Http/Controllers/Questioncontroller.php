<?php

namespace App\Http\Controllers;
use  App\Question;

use Illuminate\Http\Request;

class Questioncontroller extends Controller
{
    public function store($data)
    {
        return Question::create($data);
    }
<<<<<<< Updated upstream
=======
    
    public function delete($data)
    {
        for($i = 0 ; $i < count($data) ; $i++)
        {
            $deleted = Question::find($data[$i]->id)->delete();
        }
    }
    
>>>>>>> Stashed changes
}
