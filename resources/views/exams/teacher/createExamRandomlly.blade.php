<?php
use App\QuestionBank;
use App\Course;
?>
@extends('layouts.app')
@section('title', 'Create Exam Randomlly')
@section('content')
<div class="container create-exam-randomly">
    <form action="/exams/create/randomlly"  enctype="multipart/form-data"  method = "post" >
        @csrf
        @method('POST')
        @if (session('status'))
            <div class="alert alert-danger">
                {{ session('status') }}
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="row pt-3" style="margin-left: 30px">
            <h1>Create Exam Randomlly<h1>
        </div>
        <br>
        <div class="form-group row" style="margin-left: 30px">
            <div style="float:left;">
                <label for="title" class="col-md-4 col-form-label">Title</label>
            </div>
            <div style="float:right;margin-left: 70px;width: 600px;">
                <input id="title" name="title" type="text" class="form-control @error('title') is-invalid @enderror" title="title" value="{{ old('title') }}" required  autocomplete="title" autofocus style="border-radius: 25px" placeholder="Enter the exam title">
                @error('title')
                <span class="invalid-feedback" role="alert">
                    <strong></strong>
                </span>
                @enderror
            </div>
            <div style="margin-left: 50px">
                <select class="form-control" name="eType" id="ET" style="background-color: #1A034A;color: white;width: 185px" required >
                    <option value="" disabled selected >Exam Type</option>

                        <option value="1">Final</option>
                        <option value="2">Midterm</option>
                        <option value="3">Quiz</option>

                </select>
            </div>
        </div>
        <br>
        <div class="form-group row" style="margin-left: 30px">
            <div style="float:left;">
                <label for="title" class="col-md-4 col-form-label">date</label>
            </div>
            <div style="float:right;margin-left: 70px;width: 600px">
                <input id="date" name="date" type="datetime-local" class="form-control @error('date') is-invalid @enderror" title="date" value="{{ old('date') }}" required  autocomplete="date" autofocus style="border-radius: 25px;"placeholder="Enter date of the exam">
                @error('date')
                <span class="invalid-feedback" role="alert">
                        <strong></strong>
                    </span>
                @enderror
            </div>
            <div style="margin-left: 50px;width: 185px">
                <select class="form-control" name="course" id="course" style="background-color: #1A034A;color: white" required >
                <option value="" disabled selected >Course</option>
                @foreach( Auth::user()->courses as $course)
                    <option value="{{$course->id}}">{{$course->code}}</option>
                @endforeach
                </select>
            </div>
        </div>
        <br>
        <div class="form-group row" style="margin-left: 30px">
            <div style="float:left;">
                <label for="title" class="col-md-4 col-form-label">Duration</label>
            </div>
            <div style="float:right;margin-left: 44px;width: 600px">
                <input id="duration" name="duration" type="number" class="form-control @error('duration') is-invalid @enderror" title="duration" value="{{ old('duration') }}" required  autocomplete="duration" autofocus style="border-radius: 25px;"placeholder="Enter the duration of exam in mins">
                @error('duration')
                <span class="invalid-feedback" role="alert">
                        <strong></strong>
                    </span>
                @enderror
            </div>
            <div style="margin-left: 50px;">
                <input name = "modelsNumber" type="number" id="modelsNumber" placeholder = "Number of models" style="background-color: #1A034A;color: white;width: 185px; border:0">
            </div>
        </div>
        <br>
        <div class="form-group row" style="margin-left: 30px">
            <div style="float:left;">
                <label for="title" class="col-md-4 col-form-label">AllowPeriod</label>
            </div>
            <div style="float:right;margin-left: 20px;width: 600px">
                <input id="allow" name="allow" type="number" class="form-control @error('allow') is-invalid @enderror" title="allow" value="{{ old('allow') }}" required  autocomplete="allow" autofocus style="border-radius: 25px;"placeholder="Enter student name">
                @error('allow')
                <span class="invalid-feedback" role="alert">
                        <strong></strong>
                    </span>
                @enderror
            </div>
        </div>
        <br>
        <div class="form-group row" style="margin-left: 30px">
            <div style="margin-left: 10px">
                <select class="form-control select-question-bank" name="qBank" id="qBank" style="background-color: #1A034A;color: white;width: 250px" required >
                    @foreach( Auth::user()->questionBanks as $questionBank)
                    <option value="{{$questionBank->id}}" {{$loop->index == 0 ? 'selected' : ''}}>{{$questionBank->title}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="chapters">
            <div class="form-group row" style="margin-left: 0px;border: 2px solid gray;border-radius: 10px">
                <input type="number" class="questions-count" value="1" hidden>
                <input type="number" class="chs-count" value="1" hidden>
                <div class="random-questions" style="margin-left: 25px;margin-top: 20px">
                    <div style="margin-left: 10px">
                        <select class="form-control select-chapters first-select" name="ch1" id="ch1" style="background-color: #1A034A;color: white;width: 250px" required >
                            <option value="" disabled selected >Chapter</option>
                            @if (Auth::user()->questionBanks()->count() > 0)
                                @foreach(Auth::user()->questionBanks()->first()->questions()->select('chapter')->distinct()->get() as $question)
                                    <option value="{{$question->chapter}}">{{$question->chapter}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <br>
                    <div class="form-group row random-question" style="margin-left: 0px">
                        <div style="margin-left: 10px;">
                            <input name="ch1w1" id="ch1w1" type="number" required  autofocus class="form-control" placeholder="Enter the Weight">
                        </div>


                        <div style="margin-left: 10px">
                            <select class="form-control" name="ch1w1Q1Diff" id="ch1w1Q1Diff" style="background-color: #1A034A;color: white;" required >
                                <option value="" disabled selected >Difficulty</option>
                                <option value="Easy">Easy</option>
                                <option value="Med">Med</option>
                                <option value="Hard">Hard</option>
                            </select>
                        </div>
                        <div style="margin-left: 20px">
                            <select class="form-control" name="ch1w1Q1type" id="ch1w1Q1type" style="background-color: #1A034A;color: white;" required >
                                <option value="" disabled selected >Question Type</option>
                                <option value="MSMCQ">MSMCQ</option>
                                <option value="SSMCQ">SSMCQ</option>
                                <option value="Essay">Essay</option>
                                <option value="T/F">T/F</option>
                                <option value="Parent">Parent</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 text-center pb-3">
                    <div class="btn add add-question-randomly"><i class="fa fa-plus fa-lg"></i></div>
                </div>
            </div>
        </div>
        <div class="text-center pb-3">
            <div class="btn add add-chapter"><i class="fa fa-plus fa-lg"></i></div>
        </div>
        <div>
            <button type="submit" class="btn btn-primary">Create</button>
        </div>
    </form>
</div>
@endsection
