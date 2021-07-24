<?php

namespace App\Http\Controllers;

use App\Http\Controllers\subjectController;
use Illuminate\Support\Facades\Mail;

use App\Announcement;
use App\Course;
use App\Mail\Gmail;
use App\Subject;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Auth;
use Request;
use Validator;

class courseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('course/teacher/index');
    }

    public function announcementLogView()
    {
        return view('course/teacher/announcementlog');
    }

    public function studentindex()
    {
        return view('course/student/index');
    }

    public function memberlistView($cousreID)
    {
        return view('course/teacher/memberlist', ['id' => $cousreID]);
    }

    public function studentCourseView($courseID)
    {
        return view('/course/student/studentCourseView', ['course' => Course::find($courseID)]);
    }

    public function create($newCourse)
    {
        $found = Course::where('code', '=', $newCourse[0])->first();
        if ($found == null) {
            $subject = new subjectController();
            $subject_id = $subject->create($newCourse[1]);
            $course = array('code' => $newCourse[0], 'subject_id' => $subject_id, 'level' => $newCourse[2], 'semester' => $newCourse[3]);
            $newCreatedCourse = Course::create($course);
            return $newCreatedCourse;
        } else {
            // this course already exists message
            return $found;
        }
    }

    public function createAnnouncement()
    {
        if (auth()->user()->role == 1) {
            $data = request::all();
            $validatedData = Validator::make($data, [
                'ATitle' => 'required',
                'AContent' => 'required',
                'courseID' => 'required',
            ]);
            if (!$validatedData->fails()) {
                $Adata = ['title' => $data['ATitle'], 'content' => $data['AContent'], 'publisher_id' => auth()->user()->id, 'course_id' => $data['courseID']];
                $an = new Announcement();
                $an::create($Adata);

                $emailBody = $Adata['content'];
                $details = ['title' => 'Announcement in Course ' . Course::find($Adata['course_id'])->code, 'body' => $emailBody];

                $courseUsers = Course::find($Adata['course_id'])->users;

                foreach ($courseUsers as $user) {
                    Mail::to($user['email'])->send(new Gmail($details));
                }
            } else {
                return response($validatedData->messages(), 200);
            }
        } else {
            return view('errorPages/accessDenied');
        }
        return $this->index();
    }


    public function findCourseStudents($data)
    {
        $found = Course::find($data);
        $courseUsers = $found->users;
        $courseStudents = array();
        for ($i = 0; $i < count($courseUsers); $i++) {
            if ($courseUsers[$i]['role'] == 0) {
                array_push($courseStudents, $courseUsers[$i]);
            }
        }
        return $courseStudents;
    }

    public function search(HttpRequest $request)
    {
        if ($request->filter_value == 'subject') {
            $courses = Subject::where('name', 'like', '%' . $request->search_input . '%')->get()->map(function ($item) {
                return Auth::user()->courses()->where('subject_id', $item->id)->get();
            })->collapse();
        } else {
            $courses = Auth::user()->courses()->where($request->filter_value, 'LIKE', '%' . $request->search_input . '%')->get();
        }

        return response()->json([
            'courses' => $courses->map(function ($course) {
                return [$course->id, $course->code, $course->semester, $course->level, $course->subject->name, csrf_token()];
            })
        ]);
    }
}
