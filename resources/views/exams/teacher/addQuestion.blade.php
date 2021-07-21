<?php
use App\QuestionBank;
?>
@extends('layouts.app')
@section('title', 'Add quesiton to ' . $exam->title)
@section('content')
<div class="container add-question">

    <div class="col">
        <h2 class="title">Add Question to {{$exam->title}}</h2>
    </div>
    <br>

    <form action="{{--asset('exams/addQuestion/' . $exam->id)--}}" enctype="multipart/form-data" method="POST">
        @csrf
        @method('POST')

        <div class="row">
            <div class="col-8">
                <div class="d-flex">
                    <div style="float:right;width:40%;margin-left: 10px;">
                        <select class="form-control" name="questionbank" id="questionbank" required style="background-color: #1A034A;color: white">
                            <option value="" disabled selected >Question bank</option>
                            @foreach( Auth::user()->questionBanks as $questionBank)
                            <option value="{{$questionBank->id}}">{{$questionBank->title}}</option>
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
        <div>
            <button type="submit" class="btn btn-success">ADD</button>
        </div>
    </from>
</div>
@endsection
