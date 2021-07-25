<?php

namespace App\Http\Controllers;

use App\Course;
use App\Exam;
use App\examModels;
use App\Question;
use App\Answer;
use App\StudentAnswer;
use Carbon\Carbon;
use Request;
use Illuminate\Http\Request as HttpRequest;
use Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Questioncontroller;
use App\Http\Controllers\courseController;
use App\User;
use DB;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('exams.teacher.index')->with(['exams' => Auth::user()->exams]);
    }

    public function studentIndexView()
    {
        return view('exams/student/index');
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

    public function deleteQuestion($questionId, $examId)
    {
        if (Exam::find($examId)->questions()->detach($questionId)) {
            return response()->json([
                'status' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 'fail'
            ]);
        }
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
                return [$exam->id, $exam->title, $exam->course->code, $exam->course->subject->name, $exam->type, $exam->duration, $exam->allow_period, $exam->date, round($exam->weight(), 2), csrf_token()];
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
            $data = request::all();
            $validatedData = Validator::make($data, [
                'questionbank' => 'required',
                'exammodels' => 'required'
            ]);
            if (!$validatedData->fails()) {
                $examobj = Exam::find($examID);
                $modelobj = examModels::find($data['exammodels']);
                $dataKeys = array_keys($data);
                if (count($dataKeys) > 7) {
                    for ($i = 8; $i < count($dataKeys); $i = $i + 2) {
                        if (Question::find($data[$dataKeys[$i]])->type != "Parent") {
                            if (count($modelobj->questions()->where('question_id', $data[$dataKeys[$i]])->get()) == 0) {
                                $examModelQuestion = ['exam_models_id' => $data['exammodels'], 'question_id' => $data[$dataKeys[$i]], 'weight' => $data[$dataKeys[$i - 1]]];
                                DB::table('exam_models_question')->insert($examModelQuestion);
                            }
                        } else {
                            if (count($modelobj->questions()->where('question_id', $data[$dataKeys[$i]])->get()) == 0) {
                                $examModelQuestion = ['exam_models_id' => $data['exammodels'], 'question_id' => $data[$dataKeys[$i]], 'weight' => $data[$dataKeys[$i - 1]]];
                                DB::table('exam_models_question')->insert($examModelQuestion);
                            }

                            $subQuestions = Question::where('parent_id', $data[$dataKeys[$i]])->get();
                            foreach ($subQuestions as $subQuestion) {
                                if (count($modelobj->questions()->where('question_id', $subQuestion['id'])->get()) == 0) {
                                    $examModelQuestion = ['exam_models_id' => $data['exammodels'], 'question_id' => $subQuestion['id'], 'weight' => $data[$dataKeys[$i - 1]]];
                                    DB::table('exam_models_question')->insert($examModelQuestion);
                                }
                            }
                        }
                    }
                } else {
                    echo "Your should choose questions";
                }
            } else {
                return response($validatedData->messages(), 200);
            }
        } else {
            return view('errorPages/accessDenied');
        }
        return $this->addQuestionView($examobj);
    }

    public function createExamView($isRandomlly)
    {
        if ($isRandomlly) {
            return view('exams.teacher.createExamRandomlly');
        } else {
            return view('exams.teacher.createExamManually');
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
                'EDuration' => 'required|between:0,99.99|numeric',
                'EAllow' => 'required|between:0,99.99|numeric',
                'questionbank' => 'required'
            ]);
            if (!$validatedData->fails()) {
                $examData =  ['title' => $data['Etitle'], 'type' => $data['EType'], 'date' => $data['EDate'], 'duration' => $data['EDuration'], 'allow_period' => $data['EAllow'], 'course_id' => $data['ECourse'], 'creator_id' => auth()->user()->id];
                $dataKeys = array_keys($data);
                if (\Carbon\Carbon::parse($data['EDate'])->gte(\Carbon\Carbon::now())) {
                    if (count($dataKeys) > 11) {
                        $examobj = Exam::create($examData);
                        $newModel = examModels::create(['exam_id' => $examobj['id']]);
                        for ($i = 12; $i < count($dataKeys); $i = $i + 2) {
                            if (Question::find($data[$dataKeys[$i]])->type != "Parent") {
                                if (count($newModel->questions()->where('question_id', $data[$dataKeys[$i]])->get()) == 0) {
                                    $examModelQuestion = ['exam_models_id' => $newModel['id'], 'question_id' => $data[$dataKeys[$i]], 'weight' => $data[$dataKeys[$i - 1]]];
                                    DB::table('exam_models_question')->insert($examModelQuestion);
                                }
                            } else {
                                if (count($newModel->questions()->where('question_id', $data[$dataKeys[$i]])->get()) == 0) {
                                    $examModelQuestion = ['exam_models_id' => $newModel['id'], 'question_id' => $data[$dataKeys[$i]], 'weight' => $data[$dataKeys[$i - 1]]];
                                    DB::table('exam_models_question')->insert($examModelQuestion);
                                }

                                $subQuestions = Question::where('parent_id', $data[$dataKeys[$i]])->get();
                                foreach ($subQuestions as $subQuestion) {
                                    if (count($newModel->questions()->where('question_id', $subQuestion['id'])->get()) == 0) {
                                        $examModelQuestion = ['exam_models_id' => $newModel['id'], 'question_id' => $subQuestion['id'], 'weight' => $data[$dataKeys[$i - 1]] / count($subQuestions)];
                                        DB::table('exam_models_question')->insert($examModelQuestion);
                                    }
                                }
                            }
                        }
                    } else {
                        return redirect('exams/create/0')->with('fail', 'Your should choose questions');
                    }
                } else {
                    return redirect('exams/create/0')->with('fail', 'Your should choose date in future or at least today');
                }
            } else {
                return redirect('exams/create/0')->with('fail', $validatedData->messages());
            }
        } else {
            return view('errorPages/accessDenied');
        }
        return redirect('exams/create/0')->with('success', 'Exam created successfully');;
    }


    public function analysis(Exam $exam)
    {
        return view('exams.teacher.analysis')->with('exam', $exam);
    }

    public function questionAnalysis(HttpRequest $request)
    {
        $exam = Exam::find($request->exam_id);
        return response()->json([
            'solved' => $exam->studentsSubmitted()->count() > 0 ? round(($exam->questions()->where('id', $request->question_id)->first()->studentAnswers()->where('exam_id', $exam->id)->count() / $exam->studentsSubmitted()->count()) * 100, 2) : 0,
            'avg' => round($exam->questions()->where('id', $request->question_id)->first()->studentAnswers()->where('exam_id', $exam->id)->average('score'), 2),
            'weight' => round($exam->questions()->where('id', $request->question_id)->first()->examModels()->where('exam_id', $exam->id)->withPivot('weight')->first()->pivot->weight, 2),
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

    public function createExamRandomlly()
    {
        if (auth()->user()->role == 1) {
            $data = request::all();
            $keys = array_keys($data);
            $validatedData = Validator::make($data, [
                'title' => 'required',
                'eType' => 'required',
                'date' => 'required|date',
                'course' => 'required',
                'duration' => 'required|between:0,99.99|numeric',
                'allow' => 'required|between:0,99.99|numeric',
            ]);
            if (!$validatedData->fails()) {
                if (\Carbon\Carbon::parse($data['date'])->gte(\Carbon\Carbon::now())) {
                    $chapterCounter = 2;
                    $questionCount = 1;
                    $QBid = $data[$keys[9]];
                    $numberOfModels = $data[$keys[7]];
                    $Chapters = array();
                    $tempChapter = array();
                    $Questions = array();
                    for ($i = 10; $i < count($data); $i++) {
                        if ($keys[$i] == ("ch" . $chapterCounter) || $i == count($data) - 1) {
                            if ($i == count($data) - 1) // adding the value of last index of data
                            {
                                array_push($tempChapter, $data[$keys[$i]]);
                            }
                            array_push($Chapters, $tempChapter);
                            $tempChapter = array();
                            array_push($tempChapter, $data[$keys[$i]]); // adding the value of the next chapter
                            $chapterCounter++;
                        } else {
                            array_push($tempChapter, $data[$keys[$i]]);
                        }
                    }

                    for ($i = 0; $i < count($Chapters); $i++) {
                        $tempQuestion = array();
                        for ($j = 0; $j < count($Chapters[$i]); $j = $j + 3) {
                            if ($j == 0) {
                                array_push($tempQuestion, $Chapters[$i][0], $Chapters[$i][$j + 1], $Chapters[$i][$j + 2], $Chapters[$i][$j + 3]);
                                $j++;
                            } else {
                                array_push($tempQuestion, $Chapters[$i][0], $Chapters[$i][$j], $Chapters[$i][$j + 1], $Chapters[$i][$j + 2]);
                            }
                            array_push($Questions, $tempQuestion);
                            $tempQuestion = array();
                        }
                    }

                    $questionObj = new Questioncontroller();
                    $questionResults = $questionObj->findQuestions($Questions, $QBid);

                    if (count($questionResults['errorMessage']) != 0) // there are questions that is not found in the DB , will send an error message
                    {
                        $error = join("\n", $questionResults['errorMessage']);
                        return redirect('/exams/create/1')->with('status', $error);
                    } else {
                        $course = new courseController();
                        $foundCourseStudents = $course->findCourseStudents($data['course']);

                        if ($foundCourseStudents != null) {
                            $DExam =  ['title' => $data['title'], 'type' => $data['eType'], 'date' => $data['date'], 'duration' => $data['duration'], 'allow_period' => $data['allow'], 'course_id' => $data['course'], 'creator_id' => auth()->user()->id];
                            $examobj = Exam::create($DExam);
                            $examModels = array();
                            for ($i = 0; $i < $numberOfModels; $i++) { // creating new models
                                $newModel = examModels::create(['exam_id' => $examobj['id']]);
                                $attachedQuestions = array();
                                for ($j = 0; $j < count($questionResults['foundQuestions']); $j++) {
                                    shuffle($questionResults['foundQuestions'][$j]['Questions']); // shuffling the question's array
                                    $selectedQuestion = $questionResults['foundQuestions'][$j]['Questions'][0]; // taking the first index after being shuffled, so that it be random

                                    if ($questionResults['foundQuestions'][$j]['type'] == 'Parent') {
                                        if (in_array($selectedQuestion[0]['id'], $attachedQuestions)) {
                                            $j--;
                                        } else {
                                            $childWeight =  $questionResults['foundQuestions'][$j]['Weight'] / (count($selectedQuestion) - 1); // dividng the total weight of the parent question to all of the childs equally
                                            $WeightCount = 0;

                                            for ($k = 0; $k < count($selectedQuestion); $k++) {
                                                array_push($attachedQuestions, $selectedQuestion[$k]['id']); // saving the randomly selected question
                                                if ($k == 0) // weight for the parent only
                                                {

                                                    DB::table('exam_models_question')->insert(
                                                        ['exam_models_id' =>  $newModel['id'], 'question_id' =>  $selectedQuestion[$k]['id'], 'weight' => $questionResults['foundQuestions'][$j]['Weight']]
                                                    );
                                                } else { // weight of the child
                                                    DB::table('exam_models_question')->insert(
                                                        ['exam_models_id' =>  $newModel['id'], 'question_id' =>  $selectedQuestion[$k]['id'], 'weight' => $childWeight]
                                                    );
                                                }
                                            }
                                        }
                                    } else {
                                        if (in_array($selectedQuestion['id'], $attachedQuestions)) {
                                            $j--;
                                        } else {
                                            array_push($attachedQuestions, $selectedQuestion['id']); // saving the randomly selected question
                                            DB::table('exam_models_question')->insert(
                                                ['exam_models_id' =>  $newModel['id'], 'question_id' =>  $selectedQuestion['id'], 'weight' => $questionResults['foundQuestions'][$j]['Weight']]
                                            );
                                        }
                                    }
                                }
                                array_push($examModels, $newModel); // saving the recently created model
                            }
                            return redirect('/exams/create/1')->with('success', 'Exam Created Successfully');
                        } else {
                            return redirect('/exams/create/1')->with('status', 'There is no students on this course');
                        }
                    }
                } else {
                    return redirect('/exams/create/1')->with('status', "Your should choose date in future or at least today");
                }
            } else {
                return response($validatedData->messages(), 200);
            }
        } else {
            return view('errorPages/accessDenied');
        }
    }

    public function enterExam($examId)
    {
        $exam = Exam::find($examId);
        $now = Carbon::now()->addHours(2);
        $examDate = Carbon::parse($exam->date);
        $examAllowedDate = Carbon::parse($exam->date)->addMinutes($exam->allow_period);

        if ($now->between($examDate, $examAllowedDate)) {
            if ($exam->studentsEntered->contains('id', Auth::id())) {
                return redirect('home')->with([
                    'status' => 'You can\'t enter the exam Again',
                    'class' => 'alert-danger'
                ]);
            }

            $model = $exam->examModels()->inRandomOrder()->first();

            $exam->studentsEntered()->attach(Auth::id());
            Auth::user()->assignedModels()->attach($model->id);

            return view('exams.student.solveExam')->with('exam', $model);
        } else {
            return redirect('home')->with([
                'status' => 'The time of this exam was expired!',
                'class' => 'alert-danger'
            ]);
        }
    }

    public function studentAnswers($examId, $studentId)
    {
        $student = User::find($studentId);

        if ($student->role != 0) {
            return redirect('home')->with([
                'status' => 'Invalid student id',
                'class' => 'alert-danger'
            ]);
        }

        $model = $student->assignedModels()->where('exam_id', $examId)->first();
        return view('exams.studentAnswers')->with([
            'exam' => $model,
            'student' => $student
        ]);
    }

    public function myAnswers($examId)
    {
        $student = Auth::user();

        if ($student->role != 0) {
            return redirect('home')->with([
                'status' => 'Invalid student id',
                'class' => 'alert-danger'
            ]);
        }

        $model = $student->assignedModels()->where('exam_id', $examId)->first();
        return view('exams.studentAnswers')->with([
            'exam' => $model,
            'student' => $student
        ]);
    }

    public function markExam($examModelId)
    {
        if (auth()->user()->role == 0) {
            $data = Request::all();
            $keys = array_keys($data);
            $newKeys = array();
            $remenderOfKeys = array();
            for ($i = 1; $i < count($keys); $i++) {
                if (strpos($keys[$i], '-') !== false) {
                    $pieces = explode("-", $keys[$i]);
                    array_push($newKeys, $pieces[0]);
                    array_push($remenderOfKeys, $pieces[1]);
                } else {
                    array_push($newKeys, $keys[$i]);
                }
            }

            for ($i = 1; $i < count($data); $i++) {
                if ($data[$keys[$i]] == null) {
                    $studentAnswer = ['content' => "null", 'score' => 0.0, 'question_id' => $keys[$i], 'student_id' => auth()->user()->id, 'exam_models_id' => $examModelId];
                    $studentAnswerController = new StudentAnswerController();
                    $studentAnswerController->store($studentAnswer);
                }
            }

            $examModel = examModels::find($examModelId);
            foreach ($examModel->questions as $question) {
                if (in_array($question["id"], $newKeys)) {
                    $questionRightAnswers = Answer::where("question_id", $question["id"])->where("is_correct", 1)->get();
                    if ($question["type"] == "T/F" || $question["type"] == "SSMCQ") {
                        $flag = 0;
                        foreach ($questionRightAnswers as $Answers) {
                            if ($data[$question["id"]] == $Answers["content"]) {
                                $flag = 1;
                            }
                        }
                        if ($flag == 1) {
                            $questionWeight = DB::table('exam_models_question')->where('exam_models_id', $examModelId)->where('question_id', $question["id"])->get()[0];
                            $studentAnswer = ['content' => $data[$question["id"]], 'score' => $questionWeight->weight, 'question_id' => $question["id"], 'student_id' => auth()->user()->id, 'exam_models_id' => $examModelId];
                        } else {
                            $studentAnswer = ['content' => $data[$question["id"]], 'score' => 0.0, 'question_id' => $question["id"], 'student_id' => auth()->user()->id, 'exam_models_id' => $examModelId];
                        }
                        $studentAnswerController = new StudentAnswerController();
                        $studentAnswerController->store($studentAnswer);
                    } elseif ($question["type"] == "Essay" && $data[$question["id"]] != null) {
                        $similarty = ExamController::connectToFlaskAPI($data[$question["id"]], $questionRightAnswers[0]['content']);
                        $questionWeight = DB::table('exam_models_question')->where('exam_models_id', $examModelId)->where('question_id', $question["id"])->get()[0];
                        if ($similarty > 0.9) {
                            $studentAnswer = ['content' => $answerString, 'score' => $questionWeight->weight, 'question_id' => $question["id"], 'student_id' => auth()->user()->id, 'exam_models_id' => $examModelId];
                        } else {
                            $studentAnswer = ['content' => $answerString, 'score' => $similarty * $questionWeight->weight, 'question_id' => $question["id"], 'student_id' => auth()->user()->id, 'exam_models_id' => $examModelId];
                        }
                        $studentAnswerController = new StudentAnswerController();
                        $studentAnswerController->store($studentAnswer);
                    } elseif ($question["type"] == "MSMCQ") {
                        $counter = 0;
                        $answerString = "";
                        $pieces = explode("*", $data[$question["id"]]);
                        for ($i = 0; $i < count($remenderOfKeys); $i++) {
                            foreach ($questionRightAnswers as $Answer) {
                                if ($Answer['content'] == $data[$question["id"] . "-" . $remenderOfKeys[$i]]) {
                                    $answerString .= $data[$question["id"] . "-" . $remenderOfKeys[$i]] . " ";
                                    $counter++;
                                }
                            }
                        }
                        if ($counter == $pieces[2]) {
                            $questionWeight = DB::table('exam_models_question')->where('exam_models_id', $examModelId)->where('question_id', $question["id"])->get()[0];
                            $studentAnswer = ['content' => $answerString, 'score' => $questionWeight->weight, 'question_id' => $question["id"], 'student_id' => auth()->user()->id, 'exam_models_id' => $examModelId];
                        } else {
                            $studentAnswer = ['content' => $answerString, 'score' => 0.0, 'question_id' => $question["id"], 'student_id' => auth()->user()->id, 'exam_models_id' => $examModelId];
                        }
                        $studentAnswerController = new StudentAnswerController();
                        $studentAnswerController->store($studentAnswer);
                    } elseif ($question["type"] == "Text Check" && $data[$question["id"]] != null) {
                        $teacherAnswer = str_replace(' ', '', $questionRightAnswers[0]['content']);
                        $studentAnswer = str_replace(' ', '', $data[$question["id"]]);

                        $teacherAnswer = preg_replace("#[[:punct:]]#", "", $teacherAnswer);
                        $studentAnswer = preg_replace("#[[:punct:]]#", "", $studentAnswer);

                        $teacherAnswer = strtolower($teacherAnswer);
                        $studentAnswer = strtolower($studentAnswer);

                        if ($teacherAnswer == $studentAnswer) {
                            $questionWeight = DB::table('exam_models_question')->where('exam_models_id', $examModelId)->where('question_id', $question["id"])->get()[0];
                            $studentAnswer = ['content' => $studentAnswer, 'score' => $questionWeight->weight, 'question_id' => $question["id"], 'student_id' => auth()->user()->id, 'exam_models_id' => $examModelId];
                        } else {
                            $studentAnswer = ['content' => $studentAnswer, 'score' => 0.0, 'question_id' => $question["id"], 'student_id' => auth()->user()->id, 'exam_models_id' => $examModelId];
                        }
                        $studentAnswerController = new StudentAnswerController();
                        $studentAnswerController->store($studentAnswer);
                    }
                } else {
                    $studentAnswer = ['content' => "null", 'score' => 0.0, 'question_id' => $question["id"], 'student_id' => auth()->user()->id, 'exam_models_id' => $examModelId];
                    $studentAnswerController = new StudentAnswerController();
                    $studentAnswerController->store($studentAnswer);
                }
            }
            $sumOfScores = 0;
            foreach (StudentAnswer::where('student_id', auth()->user()->id)->where('exam_models_id', $examModelId)->get() as $studentAnswer) {
                $sumOfScores += $studentAnswer->score;
            }
            DB::table('submit_exam')->insert(['score' => $sumOfScores, 'student_id' => auth()->user()->id, 'exam_id' => examModels::find($examModelId)->exam_id]);
        } else {
            return view('errorPages/accessDenied');
        }
        return redirect('exams/student/index');
    }

    public function connectToFlaskAPI($studentAnswer, $teacherAnswer)
    {
        $client = new \GuzzleHttp\Client();

        $url = "http://127.0.0.1:5000/correct";

        $response = $client->post($url, [
            'json' => [
                'studentAnswer' => $studentAnswer,
                'teacherAnswer' => $teacherAnswer
            ]
        ]);
        $contents = json_decode($response->getBody(), true);
        return $contents['similarity'];
    }
}
