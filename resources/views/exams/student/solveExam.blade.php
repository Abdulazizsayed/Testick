@extends('layouts.app')

@section('title', $exam->creator->title)

@section('scripts')
<script src="{{ asset('js/solveExam.js') }}" defer></script>
@endsection

@section('content')
<div class="container exams-show">
    <input type="number" class="duration" value="{{$exam->creator->duration}}" hidden>
    <div class="timer">
        <span class="hours">00</span>:<span class="mins">00</span>:<span class="seconds">00</span>
    </div>
    <h2 class="title text-center">{{$exam->creator->title}}</h2>

    <form action="/exams/student/markExam/{{$exam->id}}" enctype="multipart/form-data" method="POST" onsubmit="setFormSubmitting()">
     @csrf
        @foreach ($exam->questions()->inRandomOrder()->withPivot('weight')->get() as $question)
            @if ($question->parent)
                @if($exam->questions->contains('id', $question->parent->id))
                    @continue
                @endif
            @endif
            <div class="question">
                <div class="question-header parent">
                    <h4 class="question-content">{{$question->content}}</h4>
                    <span class="type-chapter">(Type: {{$question->type}} - Weight: <span class="weight">{{$question->pivot->weight}}</span>)</span>
                </div>
                <div class="question-childs">
                    @if ($question->children->count() == 0)
                        <h6>Answer:</h6>
                        <ul class="answers">
                            @if ($question->type == 'Essay' or $question->type == 'Text Check')
                                <input type="text" class="form-control" name="{{$question->id}}">
                            @elseif($question->type == 'T/F')
                                @foreach ($question->answers()->inRandomOrder()->get() as $answer)
                                <li>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="{{$question->id}}" id="answer{{$question->id . $loop->index}}" value="{{$answer->content}}">
                                        <label class="form-check-label" for="answer{{$question->id . $loop->index}}">
                                            {{$answer->content}}
                                        </label>
                                    </div>
                                </li>
                                @endforeach
                            @elseif($question->type == 'SSMCQ')
                                @php
                                    $rand = random_int(1, 4);
                                    $trueAnswer = $question->answers()->where('is_correct', 1)->inRandomOrder()->first();
                                @endphp
                                @foreach ($question->answers()->whereNotIn('id', [$trueAnswer->id])->where('is_correct', 0)->inRandomOrder()->limit(4)->get() as $answer)
                                    <li>
                                        @if ($loop->index == $rand)
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="{{$question->id}}" id="answer{{$question->id . $loop->index}}" value="{{$trueAnswer->content}}">
                                                <label class="form-check-label" for="answer{{$question->id . $loop->index}}">
                                                    {{$trueAnswer->content}}
                                                </label>
                                            </div>
                                        @else
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="{{$question->id}}" id="answer{{$question->id . $loop->index}}" value="{{$answer->content}}">
                                                <label class="form-check-label" for="answer{{$question->id . $loop->index}}">
                                                    {{$answer->content}}
                                                </label>
                                            </div>
                                        @endif
                                    </li>
                                @endforeach
                            @elseif($question->type == 'MSMCQ')
                                @php
                                    $rand1 = random_int(1, 5);
                                    while( in_array( ($rand2 = mt_rand(1,5)), array($rand1) ) );
                                    $trueAnswer = $question->answers()->where('is_correct', 1)->inRandomOrder()->first();
                                    $falseAnswer = $question->answers()->where('is_correct', 0)->inRandomOrder()->first();
                                    $trueAnswersCount = 0;
                                @endphp
                                @foreach ($question->answers()->whereNotIn('id', [$trueAnswer->id, $falseAnswer->id])->inRandomOrder()->limit(5)->get() as $answer)
                                    <li>
                                        @if ($loop->index == $rand1)
                                                @php
                                                    $trueAnswersCount++;
                                                @endphp
                                            <div class="form-check">
                                                <input class="form-check-input" name="{{$question->id .'-'. $loop->index}}" type="checkbox" value="{{$trueAnswer->content}}" id="answer{{$question->id . $loop->index}}">
                                                <label class="form-check-label" for="answer{{$question->id . $loop->index}}">
                                                    {{$trueAnswer->content}}
                                                </label>
                                            </div>
                                        @elseif($loop->index == $rand2)
                                            <div class="form-check">
                                                <input class="form-check-input" name="{{$question->id .'-'. $loop->index}}" type="checkbox" value="{{$falseAnswer->content}}" id="answer{{$question->id . $loop->index}}">
                                                <label class="form-check-label" for="answer{{$question->id . $loop->index}}">
                                                    {{$falseAnswer->content}}
                                                </label>
                                            </div>
                                        @else
                                            @if ($answer->is_correct)
                                                @php
                                                    $trueAnswersCount++;
                                                @endphp
                                            @endif
                                            <div class="form-check">
                                                <input class="form-check-input" name="{{$question->id .'-'. $loop->index}}" type="checkbox" value="{{$answer->content}}" id="answer{{$question->id . $loop->index}}">
                                                <label class="form-check-label" for="answer{{$question->id . $loop->index}}">
                                                    {{$answer->content}}
                                                </label>
                                            </div>
                                        @endif
                                    </li>
                                @endforeach
                                <input type="text" name="{{$question->id}}" value="{{$trueAnswersCount+3}}*{{$trueAnswersCount-5}}*{{$trueAnswersCount}}" hidden>
                            @endif
                        </ul>
                    @else
                        @foreach ($question->children()->inRandomOrder()->get() as $child)
                            <div class="question">
                                <div class="question-header parent">
                                    <h4 class="question-content">{{$loop->index + 1 . ') ' . $child->content}}</h4>
                                    <span class="type-chapter">(Type: {{$child->type}} - Weight: <span class="weight">{{$exam->questions()->where('question_id', $child->id)->withPivot('weight')->first()->pivot->weight}}</span>)</span>
                                </div>
                                <div class="question-childs">
                                    <h6>Answer:</h6>
                                    <ul class="answers">
                                        @if ($child->type == 'Essay' or $child->type == 'Text Check')
                                            <input type="text" class="form-control" name="{{$child->id}}">
                                        @elseif($child->type == 'T/F')
                                            @foreach ($child->answers()->inRandomOrder()->get() as $answer)
                                            <li>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="{{$child->id}}" id="child-answer{{$child->id . $loop->index}}" value="{{$answer->content}}">
                                                    <label class="form-check-label" for="child-answer{{$child->id . $loop->index}}">
                                                        {{$answer->content}}
                                                    </label>
                                                </div>
                                            </li>
                                            @endforeach
                                        @elseif($child->type == 'SSMCQ')
                                            @php
                                                $rand = random_int(1, 4);
                                                $trueAnswer = $child->answers()->where('is_correct', 1)->inRandomOrder()->first();
                                            @endphp
                                            @foreach ($child->answers()->whereNotIn('id', [$trueAnswer->id])->where('is_correct', 0)->inRandomOrder()->limit(4)->get() as $answer)
                                                <li>
                                                    @if ($loop->index == $rand)
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="{{$child->id}}" id="child-answer{{$child->id . $loop->index}}" value="{{$trueAnswer->content}}">
                                                            <label class="form-check-label" for="child-answer{{$child->id . $loop->index}}">
                                                                {{$trueAnswer->content}}
                                                            </label>
                                                        </div>
                                                    @else
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="{{$child->id}}" id="child-answer{{$child->id . $loop->index}}" value="{{$answer->content}}">
                                                            <label class="form-check-label" for="child-answer{{$child->id . $loop->index}}">
                                                                {{$answer->content}}
                                                            </label>
                                                        </div>
                                                    @endif
                                                </li>
                                            @endforeach
                                        @elseif($child->type == 'MSMCQ')
                                            @php
                                                $rand1 = random_int(1, 5);
                                                while( in_array( ($rand2 = mt_rand(1,5)), array($rand1) ) );
                                                $trueAnswer = $child->answers()->where('is_correct', 1)->inRandomOrder()->first();
                                                $falseAnswer = $child->answers()->where('is_correct', 0)->inRandomOrder()->first();
                                                $trueAnswersCount = 0;
                                            @endphp
                                            @foreach ($child->answers()->whereNotIn('id', [$trueAnswer->id, $falseAnswer->id])->inRandomOrder()->limit(5)->get() as $answer)
                                                <li>
                                                    @if ($loop->index == $rand1)
                                                        @php
                                                            $trueAnswersCount++;
                                                        @endphp
                                                        <div class="form-check">
                                                            <input class="form-check-input" name="{{$child->id.'-'.$loop->index }}" type="checkbox" value="{{$trueAnswer->content}}" id="child-answer{{$child->id . $loop->index}}">
                                                            <label class="form-check-label" for="child-answer{{$child->id . $loop->index}}">
                                                                {{$trueAnswer->content}}
                                                            </label>
                                                        </div>
                                                    @elseif($loop->index == $rand2)
                                                        <div class="form-check">
                                                            <input class="form-check-input" name="{{$child->id.'-'.$loop->index }}" type="checkbox" value="{{$falseAnswer->content}}" id="child-answer{{$child->id . $loop->index}}">
                                                            <label class="form-check-label" for="child-answer{{$child->id . $loop->index}}">
                                                                {{$falseAnswer->content}}
                                                            </label>
                                                        </div>
                                                    @else
                                                        @if ($answer->is_correct)
                                                            @php
                                                                $trueAnswersCount++;
                                                            @endphp
                                                        @endif
                                                        <div class="form-check">
                                                            <input class="form-check-input" name="{{$child->id.'-'.$loop->index }}" type="checkbox" value="{{$answer->content}}" id="child-answer{{$child->id . $loop->index}}">
                                                            <label class="form-check-label" for="child-answer{{$child->id . $loop->index}}">
                                                                {{$answer->content}}
                                                            </label>
                                                        </div>
                                                    @endif
                                                </li>
                                            @endforeach
                                            <input type="text" name="{{$question->id}}" value="{{$trueAnswersCount+3}}*{{$trueAnswersCount-5}}*{{$trueAnswersCount}}" hidden>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
            <hr style="border-color: #AAA">
        @endforeach
        <div class="operations text-center pt-3">
            <button type="submit" class="btn btn-success">Submit Exam</button>
        </div>
    </form>
</div>
@endsection
