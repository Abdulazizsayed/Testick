<?php

namespace App\Http\Controllers;

use  App\Answer;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function updateQuestionAnswer(Request $request, Answer $answer)
    {
        $answer->content = $request->content;
        $answer->is_correct = $request->has('is_correct');
        if ($answer->update()) {
            return response()->json([
                'content' => $request->content,
                'is_correct' => $request->has('is_correct'),
                'success' => true
            ]);
        }

        return response()->json([
            'success' => false
        ]);
    }

    public function store($data)
    {
        Answer::create($data);
    }

    public function delete($data)
    {
        for ($i = 0; $i < count($data); $i++) {
            for ($j = 0; $j < count($data[$i]); $j++) {
                $deleted = Answer::find($data[$i][$j]->id);
                if ($deleted != null) {
                    $deleted->delete();
                }
            }
        }
    }

    public function destroy(Answer $answer)
    {
        if ($answer->delete()) {
            return response()->json([
                'status' => 'success'
            ]);
        }

        return response()->json([
            'status' => 'fail'
        ]);
    }
}
