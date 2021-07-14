<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;

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
            if( $deleted != null )
            {
                $deleted->delete();
            }
        }
    }

    public function updateExamQuestion(Request $request, Question $question)
    {
        $question->content = $request->content;
        if ($question->update()) {
            return response()->json([
                'content' => $request->content,
                'success' => true
            ]);
        }

        return response()->json([
            'success' => false
        ]);
    }
}
