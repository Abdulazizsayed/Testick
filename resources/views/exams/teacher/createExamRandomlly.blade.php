<?php
use App\QuestionBank;
use App\Course;
?>
@extends('layouts.app')
@section('title', 'Create Exam Randomlly')
@section('content')
<div class="container">
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
                    <input name = "modelsNumber" id="modelsNumber" placeholder = "Models Number" style="background-color: #1A034A;color: white;width: 185px">
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
                    <select class="form-control" name="qBank" id="qBank" style="background-color: #1A034A;color: white;width: 250px" required >
                        <option value="" disabled selected >Question Bank</option>
                        @foreach( Auth::user()->questionBanks as $questionBank)
                        <option value="{{$questionBank->id}}">{{$questionBank->title}}</option>
                        @endforeach

                    </select>
                </div>
            </div>
            <div class="form-group row" style="margin-left: 0px;width: 1000px;border: 2px solid gray;border-radius: 10px">
                <div style="margin-left: 25px;margin-top: 20px">

                    <div style="margin-left: 10px">
                        <select class="form-control" name="ch1" id="ch1" style="background-color: #1A034A;color: white;width: 250px" required >
                            <option value="" disabled selected >Chapter</option>
<<<<<<< HEAD
                            @foreach(Auth::user()->questionBanks()->first()->questions()->select('chapter')->distinct()->get() as $question)
=======
                            @foreach(QuestionBank::find(2)->questions()->select('chapter')->distinct()->get() as $question)
>>>>>>> 6f3402ec04cfde0f306d8324498c7be9e71993a4
                            <option value="{{$question->chapter}}">{{$question->chapter}}</option>
                            @endforeach
                        </select>
                    </div>
                    <br>
                    <div class="form-group row" style="margin-left: 0px">
                        <div style=";margin-left: 10px;">
<<<<<<< HEAD
                            <select class="form-control" name="ch1w1" id="ch1w1" style="background-color: #1A034A;color: white;" required >
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>

                            </select>
=======
                        <input name="ch1w1" id="ch1w1" type="number" required  autofocus style="border-radius: 25px" placeholder="Enter the Question Weight">
>>>>>>> 6f3402ec04cfde0f306d8324498c7be9e71993a4
                        </div>

                        <div style="margin-left: 10px">
                            <select class="form-control" name="ch1w1Q1Diff" id="ch1w1Q1Diff" style="background-color: #1A034A;color: white;" required >
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
                    <br>
                    <div class="form-group row" style="margin-left: 0px">
<<<<<<< HEAD
                        <div style=";margin-left: 10px;">
                            <select class="form-control" name="ch1w2" id="ch1w2" style="background-color: #1A034A;color: white;" required >
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>

=======
                        <div style="float:left;">
                            <label for="title" class="col-md-4 col-form-label">Weight</label>
                        </div>
                        <input name="ch1w2" id="ch1w2" type="number" required  autofocus style="border-radius: 25px" placeholder="Enter the Question Weight">
                        
>>>>>>> 6f3402ec04cfde0f306d8324498c7be9e71993a4
                        <div style="margin-left: 10px">
                            <select class="form-control" name="ch1w2Q2Diff" id="ch1w2Q2Diff" style="background-color: #1A034A;color: white;" required >
                                <option value="Easy">Easy</option>
                                <option value="Med">Med</option>
                                <option value="Hard">Hard</option>
                            </select>
                        </div>
                        <div style="margin-left: 20px">
                            <select class="form-control" name="ch1w2Q2type" id="ch1w2Q2type" style="background-color: #1A034A;color: white;" required >
                                <option value="" disabled selected >Question Type</option>
                                <option value="MSMCQ">MSMCQ</option>
                                <option value="SSMCQ">SSMCQ</option>
                                <option value="Essay">Essay</option>
                                <option value="T/F">T/F</option>
                                <option value="Parent">Parent</option>

                            </select>
                        </div>
<<<<<<< HEAD
=======
                        
                    </div>
                    <br>
                </div>  
                <br>
            </div>
            <div class="form-group row" style="margin-left: 0px;width: 1000px;border: 2px solid gray;border-radius: 10px">
                <div style="margin-left: 25px;margin-top: 20px">

                    <div style="margin-left: 10px">
                        <select class="form-control" name="ch2" id="ch2" style="background-color: #1A034A;color: white;width: 250px" required >
                            <option value="" disabled selected >Chapter</option>
                            @foreach(QuestionBank::find(2)->questions()->select('chapter')->distinct()->get() as $question)
                            <option value="{{$question->chapter}}">{{$question->chapter}}</option>
                            @endforeach
                        </select>
                    </div>
                    <br>
                    <div class="form-group row" style="margin-left: 0px">
                        <div style="float:left;">
                            <label for="title" class="col-md-4 col-form-label">Weight</label>
                        </div>
                        <div style=";margin-left: 10px;">
                        <input name="ch2w1" id="ch2w1" type="number" required  autofocus style="border-radius: 25px" placeholder="Enter the Question Weight">
                        </div>

                        <div style="margin-left: 10px">
                            <select class="form-control" name="ch2w1Q2Diff" id="ch2w1Q2Diff" style="background-color: #1A034A;color: white;" required >
                                <option value="Easy">Easy</option>
                                <option value="Med">Med</option>
                                <option value="Hard">Hard</option> 
                            </select>
                        </div>
                        <div style="margin-left: 20px">
                            <select class="form-control" name="ch2w1Q1type" id="ch2w1Q1type" style="background-color: #1A034A;color: white;" required >
                            <option value="MSMCQ">MSMCQ</option>
                                <option value="SSMCQ">SSMCQ</option>
                                <option value="Essay">Essay</option>
                                <option value="T/F">T/F</option>
                                <option value="Parent">Parent</option>
>>>>>>> 6f3402ec04cfde0f306d8324498c7be9e71993a4

                    </div>
                    <br>
<<<<<<< HEAD

=======
                    <div class="form-group row" style="margin-left: 0px">
                        <div style="float:left;">
                            <label for="title" class="col-md-4 col-form-label">Weight</label>
                        </div>
                        <div style=";margin-left: 10px;">
                        <input name="ch2w2" id="ch2w2" type="number" required  autofocus style="border-radius: 25px" placeholder="Enter the Question Weight">
                        </div>
                        
                        <div style="margin-left: 10px">
                            <select class="form-control" name="ch2w2Q2Diff" id="ch2w2Q2Diff" style="background-color: #1A034A;color: white;" required >
                                <option value="Easy">Easy</option>
                                <option value="Med">Med</option>
                                <option value="Hard">Hard</option> 
                            </select>
                        </div>
                        <div style="margin-left: 20px">
                            <select class="form-control" name="ch2w2Q2type" id="ch2w2Q2type" style="background-color: #1A034A;color: white;" required >
                            <option value="MSMCQ">MSMCQ</option>
                                <option value="SSMCQ">SSMCQ</option>
                                <option value="Essay">Essay</option>
                                <option value="T/F">T/F</option>
                                <option value="Parent">Parent</option>

                            </select>
                        </div>
                        
                    </div>
                    <br>
                </div>   
>>>>>>> 6f3402ec04cfde0f306d8324498c7be9e71993a4
                <br>
            </div>

            <div class="col-md-auto"  style="margin-top: 170">
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </form>
    </div>
</div>
@endsection
