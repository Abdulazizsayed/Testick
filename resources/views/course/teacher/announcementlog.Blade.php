<?php
use App\User;
use App\Course;
?>
@extends('layouts.app')
@section('title', 'Announcement Log')
@section('content')
<div class="container courses">

    @foreach(auth()->user()->announcements as $announcement)
    <div style="background-color: #0A125A;border-radius: 25px;line-height: 20px; word-wrap: break-word;margin-top: 15px">
        <br>
        <h1 style="margin-left: 3%;margin-right: 5%"><b>{{Course::find($announcement->course_id)->code}}</b></h1>
        <h2 style="margin-left: 6%;margin-top: 2%;margin-right: 5%" ><b>{{$announcement->title}}</b></h2>
        <h5 style="float: right;margin-right: 3%">{{User::find($announcement->publisher_id)->name}}</h5>
        <br> <br>
        <p style="float: right;margin-right: 3%; ">{{$announcement->created_at}}</p>
        <br> <br>
        <h5 style="margin-left: 9%;margin-right: 5%">{{$announcement->content}}</h5>
        <br>
    </div>
    @endforeach

</div>
@endsection
