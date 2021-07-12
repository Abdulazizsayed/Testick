<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subject;
class subjectController extends Controller
{
    public function create($subjectName)
    {
        $found = Subject::where('name', '=', $subjectName)->first();
        if($found == null)
        {
            $subject = array('name' => $subjectName); 
            $newSubject = Subject::create($subject);
            return $newSubject['id'];
        } 
        else{
            return $found['id'];
        }
    }
}
