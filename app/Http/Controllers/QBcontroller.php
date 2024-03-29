<?php

namespace App\Http\Controllers;

use App\User;
use App\QuestionBank;
use App\Http\Controllers\Questioncontroller;
use App\Http\Controllers\AnswerController;
use PhpOffice\PhpSpreadsheet;
use Validator;
use Request;
use App\Question;
use App\Answer;
use App\Subject;
use DB;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Auth;

class QBcontroller extends Controller
{
    public function index()
    {
        return view('questionsbank/index');
    }

    public function show($questionBankId)
    {
        return view('questionsbank.show')->with('questionBank', QuestionBank::findOrFail($questionBankId));
    }

    public function QBcreateView()
    {
        return view('questionsbank/create');
    }

    public function addQuestionView($id)
    {
        return view('questionsbank/addQuestion', ['questionBank' => QuestionBank::find($id)]);
    }

    public function QBcreate()
    {
        if (auth()->user()->role == 1) {
            $data = request::all();
            $validatedData = Validator::make($data, [
                'QBfile' => 'mimes:xls,xlsx,csv',
                'title' => 'required',
                'sub' => 'required'
            ]);
            if (!$validatedData->fails()) {
                $QuestionBankData = ['title' => $data['title'], 'instructor_id' => auth()->user()->id, 'subject_id' => $data['sub']];
                $newQuestionBank = QuestionBank::create($QuestionBankData); // creating the new question bank
                $path = $data['QBfile']->getRealPath();
                $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($path);
                $excel_Obj = $reader->load($path);
                $worksheet = $excel_Obj->getActiveSheet();
                $lastRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestDataColumn();
                $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);
                $Questions = array(); // total questions

                for ($row = 2; $row <= $lastRow; $row++) {
                    $QuestionObj = new Question();
                    $QuestionFromDataBase;
                    for ($col = 'A'; $col <= $highestColumn; $col++) {
                        $Answers = array(); // total answers
                        $cellValue = $worksheet->getCell($col . $row)->getValue();

                        if ($col == 'A') // Question
                        {
                            $QuestionObj['content'] = $cellValue;
                        } else if ($col == 'B') // Type
                        {
                            $QuestionObj['type'] = $cellValue;
                        } else if ($col == 'C') // Chapter
                        {
                            $QuestionObj->chapter = $cellValue;
                        } else if ($col == 'D') // parent id
                        {
                            if ($cellValue != null)
                                $QuestionObj['parent_id'] = $Questions[$cellValue - 2]['id'];
                        } else if ($col == 'E') // Question Difficulity
                        {
                            $QuestionObj['difficulty'] = $cellValue;
                            $questionController = new Questioncontroller();
                            $insertQuestion = ['content' => $QuestionObj['content'], 'type' => $QuestionObj['type'], 'chapter' => $QuestionObj['chapter'], 'parent_id' => $QuestionObj['parent_id'], 'question_bank_id' => $newQuestionBank['id'], 'difficulty' =>  $QuestionObj['difficulty']];
                            $QuestionFromDataBase = $questionController->store($insertQuestion);
                            array_push($Questions, $QuestionFromDataBase);
                        } else if ($col == 'F') // Correct Answer - the question ID is missing :)
                        {

                            if ($QuestionObj['type'] == "Essay") {
                                $insertAnswer = ['content' => $cellValue, 'is_correct' => 1, 'question_id' => $QuestionFromDataBase->id];
                                $answerController = new AnswerController();
                                $answerController->store($insertAnswer);
                            } else if ($QuestionObj['type'] == "MSMCQ" ||  $QuestionObj['type'] == "SSMCQ") {
                                $answersArray = explode("~", $cellValue); // cutting string on ~ char
                                for ($ans = 0; $ans < count($answersArray); $ans++) {
                                    $insertAnswer = ['content' => $answersArray[$ans], 'is_correct' => 1, 'question_id' => $QuestionFromDataBase->id];
                                    $answerController = new AnswerController();
                                    $answerController->store($insertAnswer);
                                }
                            } else if ($QuestionObj['type'] == "T/F") {
                                $correct = -1;
                                $addedValue = '';
                                if ($cellValue == 'true') {
                                    $correct = 1;
                                    $addedValue = 'True';
                                } else if ($cellValue == false) {
                                    $correct = 0;
                                    $addedValue = 'False';
                                }
                                $insertAnswer = ['content' => $addedValue, 'is_correct' => $correct, 'question_id' => $QuestionFromDataBase->id];
                                $answerController = new AnswerController();
                                $answerController->store($insertAnswer);
                            }
                        } else if ($col == 'G') // Wrong Answer -  the question ID is missing :)
                        {
                            if ($QuestionObj['type'] == "T/F") {
                                $addedValue = '';
                                $correct = -1;
                                if ($cellValue == 'true') {
                                    $correct = 1;
                                    $addedValue = 'True';
                                } else if ($cellValue == false) {
                                    $correct = 0;
                                    $addedValue = 'False';
                                }
                                $insertAnswer = ['content' => $addedValue, 'is_correct' => $correct, 'question_id' => $QuestionFromDataBase->id];
                                $answerController = new AnswerController();
                                $answerController->store($insertAnswer);
                            } else if ($QuestionObj['type'] != "Essay" &&  $QuestionObj['type'] != "T/F") {
                                $answersArray = explode("~", $cellValue); // cutting string on ~ char
                                for ($ans = 0; $ans < count($answersArray); $ans++) {
                                    $insertAnswer = ['content' => $answersArray[$ans], 'is_correct' => 0, 'question_id' => $QuestionFromDataBase->id];
                                    $answerController = new AnswerController();
                                    $answerController->store($insertAnswer);
                                }
                            }
                        }
                    }
                }
            } else {
                return redirect('/QB/index')->with('fail', $validatedData->messages());
            }
        } else {
            return view('errorPages/accessDenied');
        }
        return redirect('/QB/index')->with('status', "QuestionBank created successfully");
    }

    public function destroy($QuestionBankID)
    {
        $QBObj = QuestionBank::find($QuestionBankID);
        $Q = new Questioncontroller();
        $A = new AnswerController();
        $Questions = Question::where('question_bank_id', $QuestionBankID)->get(); // getting all questions

        $Answers = array();
        if ($Questions != null) {
            for ($i = 0; $i < count($Questions); $i++) // getting all answers for the above questions
            {
                $answer = Answer::where('question_id', $Questions[$i]->id)->get();
                array_push($Answers, $answer);
            }
            $A->delete($Answers);
            $Q->delete($Questions);
            $QBObj = QuestionBank::find($QuestionBankID);
            if ($QBObj != null) {
                $QBObj->delete();
            }
        }
        return redirect('/QB/index')->with('status', 'َThe question bank deleted successfully');
    }

    public function addQuestion($QuestionBankID)
    {
        if (auth()->user()->role == 1) {
            $data = request::all();
            $validatedData = Validator::make($data, [
                'chapter' => 'required',
                'type' => 'required',
                'difficulty' => 'required',
                'Qcontent' => 'required'
            ]);
            if (!$validatedData->fails()) {
                if (array_key_exists("parent", $data)) {
                    $Qdata = ['content' => $data['Qcontent'], 'type' => $data['type'], 'difficulty' => $data['difficulty'], 'chapter' => $data['chapter'], 'parent_id' => $data['parent'], 'question_bank_id' => $QuestionBankID];
                    $forLoopLenght = count($data) - 7;
                } else {
                    $Qdata = ['content' => $data['Qcontent'], 'type' => $data['type'], 'difficulty' => $data['difficulty'], 'chapter' => $data['chapter'], 'parent_id' => NULL, 'question_bank_id' => $QuestionBankID];
                    $forLoopLenght = count($data) - 6;
                }

                $QC = new Questioncontroller();
                $question_obj = $QC->store($Qdata);

                for ($i = 1; $i <= $forLoopLenght; $i++) {
                    if (array_key_exists("answer" . $i, $data) && $data["answer" . $i] != null) {
                        $answersData['answer' . $i] = $data['answer' . $i];
                        if (array_key_exists("ch" . $i, $data)) {
                            $answersData["ch" . $i] = $data['ch' . $i];
                        } else {
                            $answersData["ch" . $i] = 0;
                        }
                    }
                }

                if ($data['type'] != "Parent") {
                    $QC = new AnswerController();
                    for ($i = 1; $i <= count($answersData) / 2; $i++) {
                        $temp['content'] = $answersData['answer' . $i];
                        $temp['is_correct'] = $answersData["ch" . $i];
                        $temp['question_id'] = $question_obj['id'];
                        $QC->store($temp);
                    }
                }
            } else {
                return response($validatedData->messages(), 200);
            }
        } else {
            return view('errorPages/accessDenied');
        }
        return view('questionsbank/addQuestion')->with([
            'questionBank' => QuestionBank::find($QuestionBankID),
            'status' => 'Question added successfully'
        ]);
    }

    public function search(HttpRequest $request)
    {
        if ($request->filter_value == 'subject') {
            $questionBanks = Subject::where('name', 'like', '%' . $request->search_input . '%')->get()->map(function ($item) {
                return Auth::user()->questionBanks()->where('subject_id', $item->id)->get();
            })->collapse();
        } else {
            $questionBanks = Auth::user()->questionBanks()->where($request->filter_value, 'LIKE', '%' . $request->search_input . '%')->get();
        }

        return response()->json([
            'questionBanks' => $questionBanks->map(function ($questionBank) {
                return [$questionBank->id, $questionBank->title, $questionBank->subject->name, csrf_token()];
            })
        ]);
    }

    public function chapters(HttpRequest $request, $questionBankId)
    {
        return response()->json([
            'chapters' => QuestionBank::find($questionBankId)->questions()->select('chapter')->distinct()->get()
        ]);
    }

    public function getQuestions(HttpRequest $request, $questionBankId)
    {
        return response()->json([
            'questions' => QuestionBank::find($questionBankId)->questions->map(function ($question) {
                return [$question->id, $question->content, $question->type, $question->difficulty, $question->chapter];
            })
        ]);
    }
}
