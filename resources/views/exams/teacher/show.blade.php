@extends('layouts.app')

@section('title', $exam->title)

@section('content')
<div class="container exams-show">
    <h2 class="title text-center">{{$exam->title}}</h2>
    @forelse ($exam->questions() as $question)
        <div class="question">
            <div class="question-header parent">
                <h4 class="question-content">{{$loop->index + 1 . ') ' . $question->content}}</h4>
                <span class="type-chapter">(Type: {{$question->type}} - Chapter: {{$question->chapter}} - Difficulty: {{$question->difficulty}} - Weight: <span class="weight">{{$exam->questions()->where('id', $question->id)->first()->examModels()->where('exam_id', $exam->id)->withPivot('weight')->first()->pivot->weight}}</span>)</span>
                <i class="fa fa-edit edit-question-btn"></i>
                <i class="fa fa-times exam-delete delete-question-btn"></i>
                <input type="number" value="{{$question->id}}" hidden>
                <input type="number" value="{{$exam->id}}" hidden>
            </div>
            <form class="edit-question-form" method="POST" hidden>
                @csrf
                @method('PUT')
                <input type="number" name="id" value="{{$question->id}}" hidden>
                <textarea class="content" name="content" cols="80">{{$question->content}}</textarea>
                <i class="fa fa-times fa-sm discard-changing-question" title="Discard changes"></i>
                <input name="weight" value="{{$question->pivot->weight}}" type="number" class="form-control mb-2" required placeholder="Weight" style="background-color: #1A034A;color: white">
                <input type="number" name="exam_id" value="{{$exam->id}}" hidden>
                <button class="btn btn-success mb-2" type="submit">Edit</button>
            </form>
            <div class="question-childs">
                @if ($question->children->count() == 0)
                    <h6>Answers:</h6>
                    <ul class="answers">
                        @foreach ($question->answers as $answer)
                            <li class="answer {{$answer->is_correct ? 'text-success' : 'text-danger'}}">{{$loop->index + 1 . ') ' . $answer->content}}
                                <i class="fa fa-edit edit-answer-btn"></i>
                                <i class="fa fa-times delete-answer-btn"></i>
                                <input type="number" value="{{$answer->id}}" hidden>
                            </li>
                            <form class="edit-answer-form" method="POST" hidden>
                                @csrf
                                @method('PUT')
                                <input type="number" name="id" value="{{$answer->id}}" hidden>
                                <textarea class="content" name="content" cols="80">{{$answer->content}}</textarea>
                                <i class="fa fa-times fa-sm discard-changing-question" title="Discard changes"></i>
                                <button class="btn btn-success" type="submit">Edit</button>
                            </form>
                        @endforeach
                    </ul>
                @else
                    @foreach ($question->children as $child)
                        <div class="question">
                            <div class="question-header">
                                <h4 class="question-content">{{$loop->index + 1 . ') ' . $child->content}}</h4>
                                <span class="type-chapter">({{$child->type}} - Chapter {{$child->chapter}})</span>
                                <i class="fa fa-edit edit-question-btn"></i>
                                <i class="fa fa-times exam-delete delete-question-btn"></i>
                                <input type="number" value="{{$child->id}}" hidden>
                                <input type="number" value="{{$exam->id}}" hidden>
                            </div>
                            <form class="edit-question-form" method="POST" hidden>
                                @csrf
                                @method('PUT')
                                <input type="number" name="id" value="{{$child->id}}" hidden>
                                <textarea class="content" name="content" cols="80">{{$child->content}}</textarea>
                                <i class="fa fa-times fa-sm discard-changing-question" title="Discard changes"></i>
                                <button class="btn btn-success" type="submit">Edit</button>
                            </form>
                            <div class="question-childs">
                                <h6>Answers:</h6>
                                <ul class="answers">
                                    @foreach ($child->answers as $answer)
                                    <li class="answer {{$answer->is_correct ? 'text-success' : 'text-danger'}}">{{$loop->index + 1 . ') ' . $answer->content}}
                                        <i class="fa fa-edit edit-answer-btn"></i>
                                        <i class="fa fa-times delete-answer-btn"></i>
                                        <input type="number" value="{{$answer->id}}" hidden>
                                    </li>
                                    <form class="edit-answer-form" method="POST" hidden>
                                        @csrf
                                        @method('PUT')
                                        <input type="number" name="id" value="{{$answer->id}}" hidden>
                                        <textarea class="content" name="content" cols="80">{{$answer->content}}</textarea>
                                        <i class="fa fa-times fa-sm discard-changing-question" title="Discard changes"></i>
                                        <button class="btn btn-success" type="submit">Edit</button>
                                    </form>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        <hr style="border-color: #AAA">
    @empty
    <p class="alert alert-warning">This exam has no questions yet</p>
    @endforelse
    <div class="text-center">
        <a class="btn add" title="Add new question" href="{{asset('exams/addQuestion/' . $exam->id)}}">Add questions <i class="fa fa-plus fa-lg"></i></a>
    </div>
    <div class="operations text-center pt-3">
        @if (\Carbon\Carbon::parse($exam->date)->lt(\Carbon\Carbon::now()))
            <a href="{{asset('exams/analysis/' . $exam->id)}}" class="btn btn-primary">Analysis</a>
            <a href="{{asset('exams/studentsGrades/' . $exam->id)}}" class="btn btn-success">Students grades</a>
        @else
            <form action="/exams/{{$exam->id}}" method="POST">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger">Delete</button>
            </form>
        @endif
    </div>
</div>
@endsection
