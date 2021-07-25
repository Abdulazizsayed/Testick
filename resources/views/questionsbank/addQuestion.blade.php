<?php
use App\QuestionBank;
?>
@extends('layouts.app')
@section('title', 'Add quesiton to ' . $questionBank->title)
@section('content')
<div class="container add-question">
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <form action="/QB/addQuestion/{{$questionBank->id}}" enctype="multipart/form-data" method="POST">
    @csrf
    @method('POST')
    <h2 class="title">Add Question to {{$questionBank->title}}<h2>
    <div class="row">
            <div class="col-8">
                <div class="d-flex">
                    <div style="float:left;width:50%;margin-right: 10px;">
                        <select class="form-control" name="parent" id="parent" style="background-color: #1A034A;color: white" >
                            <option value="null" disabled selected >Question Parent</option>
                            @foreach( $questionBank->questions as $question)
                            {
                                <option value="{{$question->id}}">{{$question->content}}</option>
                            }
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <input id="chapter" name="chapter" type="text" class="form-control @error('chapter') is-invalid @enderror" chapter="chapter" value="{{ old('chapter') }}" required autocomplete="chapter" autofocus placeholder="Chapter" style="background-color: #1A034A;color: white">
                        @error('chapter')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                        <div style="float:right;width:20%;margin-left: 10px;">
                            <select class="form-control type" name="type" id="type" required style="background-color: #1A034A;color: white">
                                <option value="" disabled selected >Type</option>
                                <option value="Parent">Parent</option>
                                <option value="T/F">T/F</option>
                                <option value="SSMCQ">SSMCQ</option>
                                <option value="MSMCQ">MSMCQ</option>
                                <option value="Text Check">Text Check</option>
                                <option value="Essay">Essay</option>
                            </select>
                        </div>
                        <div style="float:right;width:20%;margin-left: 10px;">
                            <select class="form-control" name="difficulty" id="difficulty" required style="background-color: #1A034A;color: white">
                                <option value="" disabled selected >Difficulty</option>
                                <option value="Easy">Easy</option>
                                <option value="Med">Med</option>
                                <option value="Hard">Hard</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <br>

        <div class="row">
            <div class="col-8">
                <div class="form-group">
                    <label for="content">Content</label>
                    <textarea class="form-control @error('Qcontent') is-invalid @enderror" id="content" name="Qcontent" required autocomplete="Qcontent" autofocus>{{ old('Qcontent') }}</textarea>
                    @error('Qcontent')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="answers">
            <div class="row answer">
                <div class="col-8">
                    <div>
                        <div>
                            <label for="answer1">Answer 1</label>
                        </div>
                        <div>
                            <input id="answer1" name="answer1" type="text" class="form-control @error('answer1') is-invalid @enderror" answer1="answer1" value="{{ old('answer1') }}" required autocomplete="answer1" autofocus>
                            @error('answer1')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="mt-3">
                            <input class="form-check-input form-control" type="checkbox" id="ch1" name="ch1" value="1">
                            <label class="form-check-label" for="ch1">
                                Correct?
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-3">
            <button type="submit" class="btn btn-success">ADD</button>
            <div class="btn add add-answer" title="Add new question">Add answer <i class="fa fa-plus fa-lg"></i></div>
        </div>
    </from>
</div>
@endsection
