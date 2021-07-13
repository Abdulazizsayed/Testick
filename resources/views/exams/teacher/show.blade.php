@extends('layouts.app')

@section('title', $exam->title)

@section('content')
<div class="container exams-show">
    <h2 class="title text-center">{{$exam->title}}</h2>
    @foreach ($exam->questions as $question)
        <div class="question-header parent">
            <h4 class="question-content">{{$loop->index + 1 . ') ' . $question->content}}</h4>
            <span class="type-chapter">({{$question->type}} - Chapter {{$question->chapter}})</span>
            <i class="fa fa-edit edit-question-btn"></i>
        </div>
        <form class="edit-question-form" method="POST" hidden>
            @csrf
            @method('PUT')
            <input type="number" name="id" value="{{$question->id}}" hidden>
            <textarea class="content" name="content" cols="80">{{$question->content}}</textarea>
            <i class="fa fa-times fa-sm discard-changing-question" title="Discard changes"></i>
            <button class="btn btn-success" type="submit">Edit</button>
        </form>
        <div class="question-childs">
            @if ($question->children->count() == 0)
                <h6>Answers:</h6>
                <ul class="answers">
                    @foreach ($question->answers as $answer)
                        <li class="answer {{$answer->is_correct ? 'text-success' : 'text-danger'}}">{{$loop->index + 1 . ') ' . $answer->content}} <i class="fa fa-edit edit-answer-btn"></i></li>
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
                    <div class="question-header">
                        <h4 class="question-content">{{$loop->index + 1 . ') ' . $child->content}}</h4>
                        <span class="type-chapter">({{$child->type}} - Chapter {{$child->chapter}})</span>
                        <i class="fa fa-edit edit-question-btn"></i>
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
                            <li class="answer {{$answer->is_correct ? 'text-success' : 'text-danger'}}">{{$loop->index + 1 . ') ' . $answer->content}} <i class="fa fa-edit edit-answer-btn"></i></li>
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
                @endforeach
            @endif
        </div>
        <hr style="border-color: #AAA">
    @endforeach
    <div class="text-center">
        <a class="btn add" title="Add new question" href="{{asset('exams/addQuestion/' . $exam->id)}}">Add question <i class="fa fa-plus fa-lg"></i></a>
    </div>
    <div class="operations text-center pt-3">
        @if (\Carbon\Carbon::parse($exam->date)->lt(\Carbon\Carbon::now()))
            <button class="btn btn-primary">Analysis</button>
            <button class="btn btn-success">Students grades</button>
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
