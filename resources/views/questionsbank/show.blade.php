@extends('layouts.app')

@section('title', $questionBank->title)

@section('content')
<div class="container exams-show">
    <h2 class="title text-center">{{$questionBank->title}}</h2>
    @foreach ($questionBank->questions as $question)
        <div class="question">
            <div class="question-header parent">
                <h4 class="question-content">{{$loop->index + 1 . ') ' . $question->content}}</h4>
                <span class="type-chapter">(Type: <span class="type">{{$question->type}}</span> - Chapter: <span class="chapter">{{$question->chapter}}</span> - Difficulty: <span class="difficulty">{{$question->difficulty}}</span>)</span>
                <i class="fa fa-edit edit-question-btn"></i>
                <i class="fa fa-times question-bank-delete delete-question-btn"></i>
                <input type="number" value="{{$question->id}}" hidden>
            </div>
            <form class="edit-question-form" method="POST" hidden>
                @csrf
                @method('PUT')
                <input type="number" name="id" value="{{$question->id}}" hidden>
                <textarea class="content" name="content" cols="80">{{$question->content}}</textarea>
                <i class="fa fa-times fa-sm discard-changing-question" title="Discard changes"></i>
                <input name="chapter" value="{{$question->chapter}}" type="text" class="form-control mb-2" required placeholder="Chapter" style="background-color: #1A034A;color: white">
                <select class="type form-control mb-2" name="type" id="type" required style="background-color: #1A034A;color: white">
                    <option value="" disabled selected >Type</option>
                    <option value="Parent" {{$question->type == 'Parent' ? 'selected' : ''}}>Parent</option>
                    <option value="T/F" {{$question->type == 'T/F' ? 'selected' : ''}}>T/F</option>
                    <option value="SSMCQ" {{$question->type == 'SSMCQ' ? 'selected' : ''}}>SSMCQ</option>
                    <option value="MSMCQ" {{$question->type == 'MSMCQ' ? 'selected' : ''}}>MSMCQ</option>
                    <option value="Text Check" {{$question->type == 'Text Check' ? 'selected' : ''}}>Text Check</option>
                    <option value="Eassay" {{$question->type == 'Eassay'}}>Eassay</option>
                </select>
                <select class="form-control mb-2" name="difficulty" id="difficulty" required style="background-color: #1A034A;color: white">
                    <option value="" disabled selected >Difficulty</option>
                    <option value="Easy" {{$question->difficulty == 'Easy' ? 'selected' : ''}}>Easy</option>
                    <option value="Med" {{$question->difficulty == 'Med' ? 'selected' : ''}}>Med</option>
                    <option value="Hard" {{$question->difficulty == 'Hard' ? 'selected' : ''}}>Hard</option>
                </select>
                <button class="btn btn-success mb-3 btn-block" type="submit">Edit</button>
            </form>
            <div class="question-childs">
                @if ($question->children->count() == 0)
                    <h6>Answers:</h6>
                    <ul class="answers">
                        @foreach ($question->answers as $answer)
                            <li class="answer {{$answer->is_correct ? 'text-success' : 'text-danger'}}">
                                {{$loop->index + 1 . ') ' . $answer->content}}
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
                                <label class="form-check-label pl-4" for="is_correct{{$answer->id}}">
                                    <input class="form-check-input" type="checkbox" name="is_correct" id="is_correct{{$answer->id}}"{{$answer->is_correct ? ' checked' : ''}}>
                                    Is correct?
                                </label>
                                <button class="btn btn-success btn-block" type="submit">Edit</button>
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
                            </div>
                            <form class="edit-question-form" method="POST" hidden>
                                @csrf
                                @method('PUT')
                                <input type="number" name="id" value="{{$child->id}}" hidden>
                                <textarea class="content" name="content" cols="80">{{$child->content}}</textarea>
                                <i class="fa fa-times fa-sm discard-changing-question" title="Discard changes"></i>
                                <button class="btn btn-success btn-block" type="submit">Edit</button>
                            </form>
                            <div class="question-childs">
                                <h6>Answers:</h6>
                                <ul class="answers">
                                    @foreach ($child->answers as $answer)
                                    <li class="answer {{$answer->is_correct ? 'text-success' : 'text-danger'}}">
                                        {{$loop->index + 1 . ') ' . $answer->content}}
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
                                        <label class="form-check-label pl-4" for="is_correct{{$answer->id}}">
                                            <input class="form-check-input" type="checkbox" name="is_correct" value="1" id="is_correct{{$answer->id}}"{{$answer->is_correct ? ' checked' : ''}}>
                                            Is correct?
                                        </label>
                                        <button class="btn btn-success btn-block" type="submit">Edit</button>
                                    </form>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <hr style="border-color: #AAA">
        </div>
    @endforeach
    <div class="text-center">
        <a class="btn add" title="Add new question" href="{{asset('QB/addQuestion/' . $questionBank->id)}}">Add question <i class="fa fa-plus fa-lg"></i></a>
    </div>
    <div class="operations text-center pt-3">
        <form action="/QB/delete/{{$questionBank->id}}" method="POST">
            @csrf
            <button class="btn btn-danger">Delete</button>
        </form>
    </div>
</div>
@endsection
