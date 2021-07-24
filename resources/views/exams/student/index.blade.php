<?php
use App\Course;
use Carbon\Carbon;
?>
@extends('layouts.app')
@section('title', 'Exams')
@section('content')
<div class="container exams-index">
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="row">
        <div class="col">
            <h2 class="title">Exams</h2>
        </div>
    </div>

    <p class="pr-5 pl-5 pt-3 desc">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi illum, architecto impedit odit fuga quia harum beatae? Tenetur perferendis culpa officia. Ut totam error eveniet quasi cum repudiandae et fugiat!</p>

    <div class="row">
        <div class="col">
            <h2 class="title">Upcoming Exams</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <span class='label'>Filter</span>
            <select class="filter-by" name="filter-by">
                <option value="1">Title</option>
                <option value="2">Course code</option>
                <option value="3">Type</option>
                <option value="4">Date</option>
            </select>
        </div>
        <div class="col-md-8">
            <span class='label'>Search by <span class="selected-filter">Title</span></span>
            <form id="search-form" autocomplete="off">
                @csrf
                <input class="search-filter-input" type="text" name="search_input" placeholder="Enter exam Title">
                <input class='filter-value' name='filter_value' type="text" value="title" hidden>
            </form>
        </div>
    </div>

    <table class="table mt-5">
        <thead class="thead-blue">
            <tr>
                <th scope="col">Title</th>
                <th scope="col">Course</th>
                <th scope="col">Type</th>
                <th scope="col">Date</th>
            </tr>
        </thead>
        <tbody class="exams-holder">
            @foreach (Auth::user()->exams as $exam)
                @if( \Carbon\Carbon::parse($exam->date)->addMinutes($exam->allow_period)->gte(\Carbon\Carbon::now()->addHours(2)) )
                    <tr>
                        <td><a href="{{asset('exams/student/enterExam/'.$exam->id)}}">{{$exam->title}}</a></td>
                        <td>{{Course::find($exam->course_id)->code}}</td>
                        <td>{{$exam->type}}</td>
                        <td>{{$exam->date}}</td>
                    </tr>                 
                @endif
            @endforeach
        </tbody>
    </table>
    <br>

    <div class="row">
        <div class="col">
            <h2 class="title">Finished Exams</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <span class='label'>Filter</span>
            <select class="filter-by" name="filter-by">
                <option value="1">Title</option>
                <option value="2">Course code</option>
                <option value="3">Type</option>
                <option value="4">Date</option>
            </select>
        </div>
        <div class="col-md-8">
            <span class='label'>Search by <span class="selected-filter">Title</span></span>
            <form id="search-form" autocomplete="off">
                @csrf
                <input class="search-filter-input" type="text" name="search_input" placeholder="Enter exam Title">
                <input class='filter-value' name='filter_value' type="text" value="title" hidden>
            </form>
        </div>
    </div>

    <table class="table mt-5">
        <thead class="thead-blue">
            <tr>
                <th scope="col">Title</th>
                <th scope="col">Course</th>
                <th scope="col">Type</th>
                <th scope="col">Date</th>
            </tr>
        </thead>
        <tbody class="exams-holder">
            @foreach (Auth::user()->exams as $exam)
                @if( \Carbon\Carbon::parse($exam->date)->addHours($exam->duration)->lt(\Carbon\Carbon::now()->addHours(2)) )
                    <tr>
                        <td><a href="{{asset('exams/student/answers/'.$exam->id)}}">{{$exam->title}}</a></td>
                        <td>{{Course::find($exam->course_id)->code}}</td>
                        <td>{{$exam->type}}</td>
                        <td>{{$exam->date}}</td>
                    </tr>
               @endif
            @endforeach
        </tbody>
    </table>

    
    
</div>
@endsection
