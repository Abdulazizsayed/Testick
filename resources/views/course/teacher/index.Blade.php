<?php
use App\Subject;
?>
@extends('layouts.app')
@section('title', 'Courses')
@section('content')
<div class="container courses">
    <div class="row">
        <div class="col">
            <h2 class="title">Courses</h2>
        </div>
        <form action="/course/teacher/announcementLog" enctype="multipart/form-data" method="get">
            @csrf
            <div class="col-md-auto">
                <button class="btn btn-primary">Logs</button>
            </div>
        </form>
    </div>
    <p class="pr-5 pl-5 pt-3 desc">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi illum, architecto impedit odit fuga quia harum beatae? Tenetur perferendis culpa officia. Ut totam error eveniet quasi cum repudiandae et fugiat!</p>

    <div class="row">
        <div class="col-md-4">
            <span class='label'>Filter</span>
            <select class="filter-by" name="filter-by">
                <option value="1">Code</option>
                <option value="2">Semester</option>
                <option value="3">level</option>
                <option value="4">Subject</option>
            </select>
        </div>
        <div class="col-md-8">
            <span class='label'>Search by <span class="selected-filter">Code</span></span>
            <form id="search-form" autocomplete="off" method="POST">
                @csrf
                <input class="search-filter-input" type="text" name="search_input" placeholder="Enter course code">
                <input class='filter-value' name='filter_value' type="text" value="code" hidden>
            </form>
        </div>
    </div>

    <table class="table mt-5">
        <thead class="thead-blue">
            <tr>
                <th scope="col">Code</th>
                <th scope="col">Semester</th>
                <th scope="col">Level</th>
                <th scope="col">Subject</th>
            </tr>
        </thead>
        <tbody class="courses-holder">
            @foreach(auth()->user()->courses as $course)
            <tr>
                <td>
                    <a href="/course/teacher/memberList/{{$course->id}}">{{$course->code}}</a>
                </td>
                <td>{{$course->semester}}</td>
                <td>{{$course->level}}</td>
                <td>{{$course->subject->name}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <hr>
    <h3>Create Announcement</h3>
    <div class="create-announcement pl-5 pt-3">
        <form action="/course/teacher/createAnnouncement" enctype="multipart/form-data" method="post">
            @csrf
            <div class="row">
                <div class="col-8">

                    <div class="mb-3">
                        <select class="form-control" name="courseID" id="courseID" required style="background-color: #1A034A;color: white">
                            <option value="" disabled selected >Courses</option>
                            @foreach(auth()->user()->courses as $course)
                                <option value="{{$course->id}}">{{$course->code}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <div>
                            <label for="Announcement Title">Announcement Title</label>
                        </div>
                        <div>
                            <input id="ATitle" name="ATitle" type="text" class="form-control @error('ATitle') is-invalid @enderror" ATitle="ATitle" value="{{ old('ATitle') }}" required autocomplete="ATitle" autofocus>
                            @error('ATitle')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-8">
                    <div class="form-group">
                        <label for="Announcement content">Announcement Content</label>
                        <textarea class="form-control @error('AContent') is-invalid @enderror" id="AContent" name="AContent" required autocomplete="AContent" autofocus>{{ old('AContent') }}</textarea>
                        @error('AContent')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>

            <div>
                <button type="submit" class="btn btn-success">Publish</button>
            </div>
        </form>
    </div>

</div>
@endsection
