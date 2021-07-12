<?php

namespace App\Http\Controllers;

use App\Course;
use App\Exam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'teacher']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('exams.teacher.index')->with(['exams' => Auth::user()->exams]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Exam $exam)
    {
        return view('exams.teacher.show')->with('exam', $exam);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Exam $exam)
    {
        $exam->delete();
        return redirect('/exams')->with('status', 'Exam deleted successfully');
    }

    public function search(Request $request)
    {
        if ($request->filter_value == 'course code') {
            $course = Auth::user()->courses()->where('code', 'LIKE', '%' . $request->search_input . '%')->first();
            if ($course) {
                $exams = $course->exams;
            } else {
                $exams = [];
            }
        } else {
            $exams = Auth::user()->exams()->where($request->filter_value, 'LIKE', '%' . $request->search_input . '%')->get();
        }

        if ($exams) {
            return response()->json([
                'exams' => $exams->map(function ($exam) {
                    return [$exam->id, $exam->title, $exam->course->code, $exam->course->subject->name, $exam->type, $exam->duration, $exam->allow_period, $exam->date, csrf_token()];
                })
            ]);
        } else {
            return response()->json([
                'exams' => $exams,
            ]);
        }
    }
}
