<?php
use App\User;
?>
@extends('layouts.app')
@section('title', 'Announcement Log')
@section('content')
<div class="container courses">

    @foreach(auth()->user()->announcements as $announcement)
        <div style="background-color: #0A125A;border-radius: 25px;">
            <div>
                <div style="float: right"><h5 style="margin-right: 10px;margin-top: 30px">{{User::find($announcement->publisher_id)->name}}</h5></div>
                    <br>
                        <div><h2 style=" margin-left: 10px;"><b>{{$announcement->title}}</b></h2></div>
                        <p style="margin-left: 950px;color: #DAB40B">{{$announcement->created_at}}</p>
                        <h5 style="margin-left: 10px">{{$announcement->content}}</h5>
                    <br>
                </div>   
            </div>
        </div>
        <br>
    @endforeach
    
</div>
@endsection
