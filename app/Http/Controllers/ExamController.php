<?php

namespace App\Http\Controllers;

use App\Course;
use App\Exam;
use Request;
use Illuminate\Http\Request as HttpRequest;
use Validator;
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
    public function store(HttpRequest $request)
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

    public function addQuestionView(Exam $exam)
    {
        return view('exams.teacher.addQuestion')->with('exam', $exam);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(HttpRequest $request, $id)
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

    public function search(HttpRequest $request)
    {
        if ($request->filter_value == 'course code') {
            $exams = Auth::user()->courses()->where('code', 'LIKE', '%' . $request->search_input . '%')->get()->map(function ($item) {
                return $item->exams;
            })->collapse();
        } else {
            $exams = Auth::user()->exams()->where($request->filter_value, 'LIKE', '%' . $request->search_input . '%')->get();
        }

        return response()->json([
            'exams' => $exams->map(function ($exam) {
                return [$exam->id, $exam->title, $exam->course->code, $exam->course->subject->name, $exam->type, $exam->duration, $exam->allow_period, $exam->date, csrf_token()];
            })
        ]);
    }

    public function gradesSearch(HttpRequest $request)
    {
        // if ($request->filter_value == 'course code') {
        //     $exams = Auth::user()->courses()->where('code', 'LIKE', '%' . $request->search_input . '%')->get()->map(function ($item) {
        //         return $item->exams;
        //     })->collapse();
        // } else {
        //     $exams = Auth::user()->exams()->where($request->filter_value, 'LIKE', '%' . $request->search_input . '%')->get();
        // }
        $exam = Exam::find($request->exam_id);
        $students = $exam->studentsSubmitted()->where('name', 'LIKE', '%' . $request->search_input . '%')->withPivot('score')->get();

        return response()->json([
            'students' => $students->map(function ($student) {
                return [$student->name, $student->pivot->score];
            })
        ]);
    }

    public function addQuestion($examID)
    {
        if (auth()->user()->role == 1) {
            $examobj = Exam::find($examID);
            $data = request::all();
            $validatedData = Validator::make($data, [
                'question_bank' => 'required'
            ]);
            if (!$validatedData->fails()) {
                $dataKeys = array_keys($data);

                if (count($dataKeys) > 6) {
                    for ($i = 6; $i < count($dataKeys); $i++) {
                        $examobj->questions()->attach($data[$dataKeys[$i]]);
                    }
                } else {
                    echo "You should choose answers";
                }
            } else {
                return response($validatedData->messages(), 200);
            }
        } else {
            return view('errorPages/accessDenied');
        }
        return $this->addQuestionView($examobj);
    }

    public function createExamView($isManually)
    {
        if ($isManually) {
            return view('exams.teacher.createExamManually');
        } else {
            dd('Not found');
        }
    }

    public function analysis(Exam $exam)
    {
        return view('exams.teacher.analysis')->with('exam', $exam);
    }

    public function questionAnalysis(HttpRequest $request)
    {
        $exam = Exam::find($request->exam_id);
        return response()->json([
            'solved' => $exam->studentsSubmitted()->count() > 0 ? round(($exam->questions()->first()->studentAnswers()->where('exam_id', $exam->id)->count() / $exam->studentsSubmitted()->count()) * 100, 2) : 0,
            'avg' => round($exam->questions()->first()->studentAnswers()->where('exam_id', $exam->id)->average('score') * 100, 2)
        ]);
    }

    public function chapterAnalysis(HttpRequest $request)
    {
        $exam = Exam::find($request->exam_id);
        return response()->json([
            'absorbtion' => round($exam->chapterAbsorbtion($request->chapter), 2)
        ]);
    }

    public function studentsGradesView(Exam $exam)
    {
        return view('exams.teacher.studentsGrades')->with([
            'exam' => $exam
        ]);
    }
}
