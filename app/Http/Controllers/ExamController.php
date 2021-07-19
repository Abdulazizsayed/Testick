<?php

namespace App\Http\Controllers;

use App\Course;
use App\Exam;
use App\examModels;
use Request;
use Illuminate\Http\Request as HttpRequest;
use Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Questioncontroller;
use App\Http\Controllers\courseController;
use DB;

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
                'questionbank' => 'required'
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

    public function createExamManuallyView($isManually)
    {
        if ($isManually) {
            return view('exams.teacher.createExamManually');
        } else {
            dd('Not found');
        }
    }

    public function createExamManually()
    {
        if (auth()->user()->role == 1) {
            $data = request::all();
            $validatedData = Validator::make($data, [
                'Etitle' => 'required',
                'EType' => 'required',
                'EDate' => 'required|date',
                'ECourse' => 'required',
                'EDuration' => 'required|numeric',
                'EAllow' => 'required|numeric'
            ]);
            if (!$validatedData->fails()) {
                $DExam =  ['title' => $data['Etitle'], 'type' => $data['EType'], 'date' => $data['EDate'], 'duration' => $data['EDuration'], 'allow_period' => $data['EAllow'], 'course_id' => 1 /*$data['ECourse']*/, 'creator_id' => auth()->user()->id];
                $examobj = Exam::create($DExam);
                $dataKeys = array_keys($data);
                if (count($dataKeys) > 11) {
                    for ($i = 11; $i < count($dataKeys); $i++) {
                        $examobj->questions()->attach($data[$dataKeys[$i]]);
                    }
                }
            } else {
                return response($validatedData->messages(), 200);
            }
        } else {
            return view('errorPages/accessDenied');
        }
        return $this->createExamManuallyView(1);
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

    public function createExamRandomllyView($isRandomlly)
    {
        if ($isRandomlly) {
            return view('exams.teacher.createExamRandomlly');
        } else {
            dd('Not found');
        }
    }

    public function createExamRandomlly()
    {
        if (auth()->user()->role == 1) 
        {
            $data = request::all();
            $keys = array_keys($data);
            //dd($keys);
            $validatedData = Validator::make($data, [
                'title' => 'required',
                'eType' => 'required',
                'date' => 'required|date',
                'course' => 'required',
                'duration' => 'required|numeric',
                'allow' => 'required|numeric'
            ]);
            if (!$validatedData->fails()) 
            {
                $chapterCounter = 2;
                $questionCount = 1;
                $QBid = $data[$keys[8]];
                $numberOfModels = 2;
                $Chapters = array();
                $tempChapter = array();
                $Questions = array();
                for ($i = 9; $i < count($data); $i++) {
                    if($keys[$i] == ("ch".$chapterCounter) || $i == count($data) -1 )
                    {
                        if($i == count($data) -1 ) // adding the value of last index of data
                        {
                            array_push($tempChapter , $data[$keys[$i]]);
                        }
                        array_push($Chapters , $tempChapter);
                        $tempChapter = array();
                        array_push($tempChapter , $data[$keys[$i]]); // adding the value of the next chapter
                        $chapterCounter++;
                    }
                    else{
                        array_push($tempChapter , $data[$keys[$i]]);
                    }
                }
               
                for($i = 0 ; $i < count($Chapters) ; $i++)
                {
                    $tempQuestion = array();
                    for($j = 0 ; $j < count($Chapters[$i]) ; $j = $j + 3 )
                    {
                        if($j == 0)
                        {
                            array_push($tempQuestion , $Chapters[$i][0]  , $Chapters[$i][$j+1], $Chapters[$i][$j+2] ,$Chapters[$i][$j+3]);
                            $j++;
                        }
                        else{
                            array_push($tempQuestion , $Chapters[$i][0]  , $Chapters[$i][$j], $Chapters[$i][$j+1] ,$Chapters[$i][$j+2]);
                        }
                        array_push($Questions , $tempQuestion);
                        $tempQuestion = array();
                    }
                }
                $questionObj = new Questioncontroller();
                $questionResults = $questionObj->findQuestions($Questions , $QBid);
                if(count($questionResults['errorMessage']) != 0 ) // there are questions that is not found in the DB , will send an error message
                {
                    $error = join("\n",$questionResults['errorMessage']);
                    return redirect('/exams/create/randomlly/1')->with('status',$error);
                }
                else
                {
                    $course = new courseController();
                    $foundCourseStudents = $course->findCourseStudents($data['course']); 
                    if($foundCourseStudents != null)
                    {
                        $DExam =  [ 'title' => $data['title'] , 'type' => $data['eType'] , 'date' => $data['date'] , 'duration' => $data['duration'] , 'allow_period' => $data['allow'] , 'course_id' => $data['course'] , 'creator_id' => auth()->user()->id ];
                        $examobj = Exam::create($DExam);
                        $examModels = array();
                        for($i = 0 ; $i < $numberOfModels ; $i++)
                        {
                            $newModel = examModels::create(['exam_id' => $examobj['id']]);
                            $attachedQuestions = array();
                            for($j = 0 ; $j < count($questionResults['foundQuestions']) ; $j++)
                            {
                                shuffle($questionResults['foundQuestions'][$j]['Questions']); // shuffling the question's array 
                                $selectedQuestion = $questionResults['foundQuestions'][$j]['Questions'][0]; // taking the first index after being shuffled, so that it be random
                                if($questionResults['foundQuestions'][$j]['type'] == 'Parent')
                                {
                                    for($k = 0 ; $k < count($selectedQuestion) ; $k++)
                                    {
                                        array_push($attachedQuestions , $selectedQuestion[$k]); // saving the randomly selected question
                                        DB::table('exam_models_question')->insert(
                                            ['exam_models_id' =>  $newModel['id'] , 'question_id' =>  $selectedQuestion[$k]['id'] , 'weight' => $questionResults['foundQuestions'][$j]['Weight'] ]
                                        );
                                    }    
                                }
                                else
                                {
                                    array_push($attachedQuestions , $selectedQuestion); // saving the randomly selected question
                                    DB::table('exam_models_question')->insert(
                                        ['exam_models_id' =>  $newModel['id'] , 'question_id' =>  $selectedQuestion['id'] , 'weight' => $questionResults['foundQuestions'][$j]['Weight'] ]
                                    );
                                }
                            }
                            array_push($examModels , $newModel); // savung the recently created model
                        }
                        //dd( $examModels,"all Done , connect each student to an exam now" , count($examModels) , $numberOfModels);
                        //dd($foundCourseStudents);
                        for($i = 0 ; $i < count($foundCourseStudents) ; $i++)
                        {
                            shuffle($examModels); // shuffling the question's array .
                            $selectedModel = $examModels[0]; // taking the first index after being shuffled.
                            $foundCourseStudents[$i]->examsAssigned()->attach($selectedModel['id']);
                        }
                        return redirect('/exams/create/randomlly/1')->with('success','Exam Created Successfully');
                    }
                    else
                    {
                        return redirect('/exams/create/randomlly/1')->with('status','There is no students on this course');
                    }   
                }
            }
            else
            {
                return response($validatedData->messages(), 200);
            }
        } 
        else 
        {
            return view('errorPages/accessDenied');
        }
        //return $this->createExamManuallyView(1);
    }
}
