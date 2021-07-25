@extends('layouts.app')

@section('title', $student->name . 'answers on ' . $exam->exam->title)

@section('content')
<div class="container exams-show">
    <div class="timer">
        {{$student->examsSubmitted()->where('exam_id', $exam->exam->id)->withPivot('score')->first()->pivot->score . '/' . $exam->exam->weight()}}
    </div>
    <h2 class="title text-center">{{$exam->exam->title}}</h2>
    @foreach ($exam->questions()->withPivot('weight')->get() as $question)
            @if ($question->parent)
                @if($exam->questions()->contains('id', $question->parent->id))
                    @continue
                @endif
            @endif
        <div class="question">
            <div class="question-header parent">
                <h4 class="question-content">{{$loop->index + 1 . ') ' . $question->content}}</h4>
                <span class="type-chapter">(Type: {{$question->type}} - Chapter: {{$question->chapter}} - Difficulty: {{$question->difficulty}} - Weight: <span class="weight">{{$question->pivot->weight}}</span>)</span>
            </div>
            <div class="question-childs">
                @if ($question->children->count() == 0)
                    <h6>Answers:</h6>
                    <ul class="answers">
                        @foreach ($question->answers as $answer)
                            <li class="answer {{$answer->is_correct ? 'text-success' : 'text-danger'}}">
                                {{$loop->index + 1 . ') ' . $answer->content}}
                            </li>
                        @endforeach
                    </ul>
                    @php
                        $myAnswer = $student->studentAnswers()->where('exam_models_id', $exam->id)->where('question_id', $question->id)->first();
                    @endphp
                    <h6 class="font-weight-bold">Your answer: {{$myAnswer->content}} ({{$myAnswer->score}})</h6>
                @else
                    @foreach ($question->children as $child)
                        <div class="question">
                            <div class="question-header">
                                <h4 class="question-content">{{$loop->index + 1 . ') ' . $child->content}}</h4>
                                <span class="type-chapter">({{$child->type}} - Chapter {{$child->chapter}})</span>
                            </div>
                            <div class="question-childs">
                                <h6>Answers:</h6>
                                <ul class="answers">
                                    @foreach ($child->answers as $answer)
                                    <li class="answer {{$answer->is_correct ? 'text-success' : 'text-danger'}}">
                                        {{$loop->index + 1 . ') ' . $answer->content}}
                                    </li>
                                    @endforeach
                                </ul>
                                @php
                                    $myAnswer = $student->studentAnswers()->where('exam_models_id', $exam->id)->where('question_id', $child->id)->first()
                                @endphp
                                <h6 class="font-weight-bold">Your answer: {{$myAnswer->content}} ({{$myAnswer->score}})</h6>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        <hr style="border-color: #AAA">
    @endforeach
</div>
@endsection
