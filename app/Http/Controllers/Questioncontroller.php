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
}
