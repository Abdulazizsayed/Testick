<?php
use App\QuestionBank;
use App\Exam;
?>
@extends('layouts.app')
@section('title', 'Add quesiton to ' . $exam->title)
@section('content')
<div class="container add-question">

    <div class="col">
        <h2 class="title">Add Question to {{$exam->title}}</h2>
    </div>
    <br>

    <form enctype="multipart/form-data" method="POST">
        @csrf
        @method('POST')
        <div class="row">
            <div class="col-8">
                <div class="d-flex">
                    <div style="float:right;width:40%;margin-left: 10px;">
                        <select class="form-control select-question-bank" name="questionbank" id="questionbank" required style="background-color: #1A034A;color: white">
                            <option value="" disabled>Question bank</option>
                            @foreach( Auth::user()->questionBanks as $questionBank)
                                <option value="{{$questionBank->id}}" {{$loop->index == 0 ? 'selected' : ''}}>{{$questionBank->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div style="float:right;width:40%;margin-left: 10px;">
                        <select class="form-control" name="exammodels" id="exammodels" required style="background-color: #1A034A;color: white">
                            <option value="" disabled selected >Exam Models</option>
                            @foreach( Exam::find($exam->id)->examModels as $model)
                                <option value="{{$model->id}}">{{$model->id}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <br>

        <div class="row">
            <div class="col-md-4">
                <span class='label'>Filter</span>
                <select class="filter-by" name="filter-by">
                    <option value="content">Content</option>
                    <option value="type">Type</option>
                    <option value="difficulty">Difficulty</option>
                    <option value="chapter">Chapter</option>
                </select>
            </div>
            <div class="col-md-8">
                <span class='label'>Search by <span class="selected-filter">Content</span></span>
                <input class="search-filter-input" type="text" name="search_input" placeholder="Enter question content">
                <input class='question-bank-id' name='question_bank_id' type="number" value="{{Auth::user()->questionBanks()->count() > 0 ? Auth::user()->questionBanks()->first()->id : ''}}" hidden>
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
            <tbody class="questions-holder">
                @foreach(Auth::user()->questionBanks()->first()->questions as $question)
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
        <div>
            <button type="submit" class="btn btn-success">ADD</button>
        </div>
    </from>
</div>
@endsection
