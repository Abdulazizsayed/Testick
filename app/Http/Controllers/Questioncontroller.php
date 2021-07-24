<?php

namespace App\Http\Controllers;

use App\Question;
use App\QuestionBank;
use Illuminate\Http\Request;

use Illuminate\Http\Request as HttpRequest;

class Questioncontroller extends Controller
{
    public function store($data)
    {
        return Question::create($data);
    }

    public function delete($data)
    {
        for ($i = 0; $i < count($data); $i++) {
            $deleted = Question::find($data[$i]->id);
            if ($deleted != null) {
                $deleted->delete();
            }
        }
    }

    public function updateExamQuestion(Request $request, Question $question)
    {
        $question->update($request->all());

        if ($request->has('exam_id')) {
            $question->exams()->updateExistingPivot($request->exam_id, [
                'weight' => $request->weight,
            ]);
        }

        if ($question->update()) {
            if ($request->has('weight')) {
                return response()->json([
                    'content' => $request->content,
                    'chapter' => $request->chapter,
                    'difficulty' => $request->difficulty,
                    'type' => $request->type,
                    'weight' => $request->weight,
                    'success' => true
                ]);
            } else {
                return response()->json([
                    'content' => $request->content,
                    'chapter' => $request->chapter,
                    'difficulty' => $request->difficulty,
                    'type' => $request->type,
                    'success' => true
                ]);
            }
        }

        return response()->json([
            'success' => false
        ]);
    }

    public function destroy(Question $question)
    {
        if ($question->delete()) {
            return response()->json([
                'status' => 'success'
            ]);
        }

        return response()->json([
            'status' => 'fail'
        ]);
    }
    public function findQuestions($data, $QBid)
    {
        $Questions = array();
        $notFoundMessage = array();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i][3] == 'Parent') {
                $QfromDB =  Question::where('question_bank_id', '=', $QBid)->where('chapter', '=', $data[$i][0])
                    ->where('difficulty', '=', $data[$i][2])
                    ->where('type', '=', $data[$i][3])->get();
                if ($QfromDB->isEmpty()) {
                    array_push($notFoundMessage, ("There is no question that it's chapter: " .  $data[$i][0] . " , type: " . $data[$i][3] . " , difficulty: " . $data[$i][2] . " , in this question bank.  "));
                } else {
                    for ($j = 0; $j < count($QfromDB); $j++) {
                        $childQuestions = Question::where('question_bank_id', '=', $QBid)->where('chapter', '=', $data[$i][0])
                            ->where('parent_id', '=', $QfromDB[$j]['id'])->get();
                        if (!$childQuestions->isEmpty()) {
                            $tempArray = array();
                            array_push($tempArray, $QfromDB[$j]);
                            for ($k = 0; $k < count($childQuestions); $k++) {
                                array_push($tempArray, $childQuestions[$k]);
                            }
                            array_push($Questions, [
                                'Questions' => array($tempArray),
                                'Weight' => $data[$i][1],
                                'type' => $data[$i][3]
                            ]);
                        }
                    }
                }
            } else {
                $QfromDB =  Question::where('question_bank_id', '=', $QBid)->where('chapter', '=', $data[$i][0])
                    ->where('difficulty', '=', $data[$i][2])
                    ->where('type', '=', $data[$i][3])
                    ->whereNull('parent_id')->get();
                if ($QfromDB->isEmpty()) {
                    array_push($notFoundMessage, ("There is no question that it's chapter: " .  $data[$i][0] . " , type: " . $data[$i][3] . " , difficulty: " . $data[$i][2] . " , in this question bank.  "));
                } else {
                    $tempArray = array();
                    for ($j = 0; $j < count($QfromDB); $j++) {
                        array_push($tempArray, $QfromDB[$j]);
                    }
                    array_push($Questions, [
                        'Questions' => $tempArray,
                        'Weight' => $data[$i][1],
                        'type' => $data[$i][3]
                    ]);
                }
            }
        }
        return ['foundQuestions' => $Questions, 'errorMessage' => $notFoundMessage];
    }

    public function search(HttpRequest $request, $filterBy, $searchValue, $questionBankId)
    {

        if ($searchValue != '0') {
            $questions = QuestionBank::find($questionBankId)->questions()->where($filterBy, 'LIKE', '%' . $searchValue . '%')->get();
        } else {
            $questions = QuestionBank::find($questionBankId)->questions()->get();
        }

        return response()->json([
            'questions' => $questions->map(function ($question) {
                return [$question->id, $question->content, $question->type, $question->difficulty, $question->chapter];
            })
        ]);
    }
}
