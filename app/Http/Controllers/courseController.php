<?php

namespace App\Http\Controllers;

use Request;
use App\Course;
use App\Http\Controllers\subjectController;
class courseController extends Controller
{
    public function index()
    {
        return view('course/index');
    }

    public function create($newCourse)
    {
        $found = Course::where('code', '=', $newCourse[0])->first(); 
        if($found == null)
        {
            $subject = new subjectController();
            $subject_id = $subject->create($newCourse[1]);
            $course = array('code' => $newCourse[0] , 'subject_id' => $subject_id , 'level' => $newCourse[2] , 'semester' => $newCourse[3]);
            $newCreatedCourse = Course::create($course);
            //dd("New created course: " , $newCreatedCourse);
            return $newCreatedCourse;
        }
        else{ 
            // this course already exists message
            return $found;
        }
    }

    public function createAnnouncement()
    {   
        $data = request::all();
        dd($data);
    }

}
