<?php
use App\QuestionBank;
?>
@extends('layouts.app')
@section('content')
<div class="container">
    <form action="/QB/addQuestion/{{$id}}" enctype="multipart/form-data" method="get">
    @csrf
        <div class="row pt-3" style="margin-left: 50px">
            <h1>Add Question<h1>
        </div>

        <div class="row">
            <div class="col-8 offset-2">
                <div class="d-flex">
                    <div style="float:left;width:50%;margin-right: 10px;">
                        <select class="form-control" name="parent" id="parent" style="background-color: #1A034A;color: white" >
                            <option value="null" disabled selected >Question Parent</option>
                            @foreach( QuestionBank::find($id)->questions as $question)
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
                            <select class="form-control" name="type" id="type" required style="background-color: #1A034A;color: white">
                                <option value="" disabled selected >Type</option>
                                <option value="MCQ">MCQ</option>
                                <option value="T/F">T/F</option>
                                <option value="MQ">MQ</option>
                                <option value="Eassy">Eassy</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <br>

        <div class="row">
            <div class="col-8 offset-2">

                <div class="form-group row">
                    <div><label for="Qcontent" class="col-md-4 col-form-label">QuestionContent</label>
                    </div>
                    <div style="width: 521px"><input id="Qcontent" name="Qcontent" type="text" class="form-control @error('Qcontent') is-invalid @enderror" Qcontent="Qcontent" value="{{ old('Qcontent') }}" required autocomplete="Qcontent" autofocus>
                    @error('Qcontent')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-8 offset-2">
                <div class="d-flex">
                    <div>
                        <label for="answer1" class="col-md-4 col-form-label">answer</label>
                    </div>
                    <div style="width: 2500px; margin-left: 47px"><input id="answer1" name="answer1" type="text" class="form-control @error('answer1') is-invalid @enderror" answer1="answer1" value="{{ old('answer1') }}" required autocomplete="answer1" autofocus>
                        @error('answer1')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div style="margin-top: 10px;margin-left: 20px"><h6>Correct</h6></div>
                        <input class="form-control" type="checkbox" id="ch1" name="ch1" value="correct">
                    </div>
                </div>
            </div>
            <br>
            <br>
            <div  style="margin-left: 500px;">
                <button class="btn btn-primary">ADD</button>
        </div>
    </from>
</div>
@endsection
