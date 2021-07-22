<?php
use App\QuestionBank;
use App\Course;
?>
@extends('layouts.app')
@section('title', 'Create Exam Manually')
@section('content')
<div class="container Create-Exam-Manually">
    
    <div class="col">
        <h2 class="title">Create Exam Manually</h2>
    </div>
    <br>
    <form action="/exams/create/manually" enctype="multipart/form-data" method="post">
        @csrf
        <div class="form-group row" style="margin-left: 30px">
            <div style="float:left;">
                <label for="title" class="col-md-4 col-form-label">Title</label>
            </div>
            <div style="float:right;margin-left: 70px;width: 500px;">
                <input id="Etitle" name="Etitle" type="text" class="form-control @error('Etitle') is-invalid @enderror" Etitle="Etitle" value="{{ old('Etitle') }}" required  autocomplete="Etitle" autofocus style="border-radius: 25px" placeholder="Enter the exam title">
                @error('Etitle')
                <span class="invalid-feedback" role="alert">
                    <strong></strong>
                </span>
                @enderror
            </div>
            <div style="margin-left: 50px">
                <select class="form-control" name="EType" id="EType" style="background-color: #1A034A;color: white" required >
                    <option value="" disabled selected >Exam Type</option>
                    <option value="Quiz">Quiz</option>
                    <option value="Midterm">Midterm</option>
                    <option value="Final">Final</option>
                </select>
            </div>
        </div>

        <div class="form-group row" style="margin-left: 30px">
            <div style="float:left;">
                <label for="title" class="col-md-4 col-form-label">date</label>
            </div>
            <div style="float:right;margin-left: 70px;width: 500px">
                <input id="EDate" name="EDate" type="date" class="form-control @error('EDate') is-invalid @enderror" EDate="EDate" value="{{ old('EDate') }}" required  autocomplete="EDate" autofocus style="border-radius: 25px;"placeholder="Enter date of the exam">
                @error('EDate')
                <span class="invalid-feedback" role="alert">
                    <strong></strong>
                </span>
                @enderror
            </div>
            <div style="margin-left: 50px;width: 120px">
                <select class="form-control" name="ECourse" id="ECourse" style="background-color: #1A034A;color: white" required >
                    <option value="" disabled selected >Course</option>
                    @foreach( Auth::user()->courses as $course)
                        <option value="{{$course->id}}">{{$course->code}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row" style="margin-left: 30px">
            <div style="float:left;">
                <label for="title" class="col-md-4 col-form-label">Duration</label>
            </div>
            <div style="float:right;margin-left: 44px;width: 500px">
                <input id="EDuration" name="EDuration" type="number" class="form-control @error('EDuration') is-invalid @enderror" EDuration="EDuration" value="{{ old('EDuration') }}" required  autocomplete="EDuration" autofocus style="border-radius: 25px;"placeholder="Enter the duration of exam in mins">
                @error('EDuration')
                <span class="invalid-feedback" role="alert">
                        <strong></strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row" style="margin-left: 30px">
            <div style="float:left;">
                <label for="title" class="col-md-4 col-form-label">AllowPeriod</label>
            </div>
            <div style="float:right;margin-left: 20px;width: 500px">
                <input id="EAllow" name="EAllow" type="number" class="form-control @error('EAllow') is-invalid @enderror" EAllow="EAllow" value="{{ old('EAllow') }}" required  autocomplete="EAllow" autofocus style="border-radius: 25px;"placeholder="Enter Exam allow period">
                @error('EAllow')
                <span class="invalid-feedback" role="alert">
                        <strong></strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="col-8">
            <div class="d-flex">
                <div style="float:right;width:40%;margin-left: 10px;">
                    <select class="form-control" name="questionbank" id="questionbank"  style="background-color: #1A034A;color: white">
                        <option value="" disabled selected >Question bank</option>
                        @foreach( Auth::user()->questionBanks as $questionBank)
                        <option value="{{$questionBank->id}}">{{$questionBank->title}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <br>

        <div class="row">
            <div class="col-md-4">
                <span class='label'>Filter</span>
                <select class="filter-by" name="filter-by">
                    <option value="1">Type</option>
                    <option value="3">Difficulty</option>
                    <option value="3">Chapter</option>
                </select>
            </div>
            <div class="col-md-8">
                <span class='label'>Search by <span class="selected-filter">Title</span></span>
                <input class="search-filter-input" type="text" name="search_input" placeholder="Enter exam Title">
                <input class='filter-value' name='filter_value' type="text" value="title" hidden>
            </div>
        </div>

        <table class="table mt-5">
            <thead class="thead-blue">
                <tr>
                    <th scope="col">Content</th>
                    <th scope="col">Type</th>
                    <th scope="col">Difficulty</th>
                    <th scope="col">Chapter</th>
                    <th scope="col">Weight</th>
                    <th scope="col">Add to Exam</th>
                </tr>
            </thead>
            <tbody class="exams-holder">
                @foreach(QuestionBank::find(1)->questions as $question)
                <tr>
                    <td>{{$question->content}}</td>
                    <td>{{$question->type}}</td>
                    <td>{{$question->difficulty}}</td>
                    <td>{{$question->chapter}}</td>
                    <td>
                        <input id="Weight.{{$question->id}}" name="Weight.{{$question->id}}" type="number" required  autofocus style="border-radius: 25px" placeholder="Enter the Question Weight" disabled>
                    </td>
                    <td>
                        <input  type="checkbox" id="ch.{{$question->id}}" name="ch.{{$question->id}}" value="{{$question->id}}" class="add-check-box"> 
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="col-md-auto">
            <button type="submit" class="btn btn-primary">Create</button>
        </div>
    </form>



</div>
@endsection
