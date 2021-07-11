<?php

namespace App\Http\Controllers;

use  App\Answer;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function updateQuestionAnswer(Request $request, Answer $answer)
    {
        $answer->content = $request->content;
        if ($answer->update()) {
            return response()->json([
                'content' => $request->content,
                'success' => true
            ]);
        }

        return response()->json([
            'success' => false
        ]);
    }

    public function delete($data)
    {
        for ($i = 0; $i < count($data); $i++) {
            for ($j = 0; $j < count($data[$i]); $j++) {
                $deleted = Answer::find($data[$i][$j]->id)->delete();
            }
        }
    }
}
