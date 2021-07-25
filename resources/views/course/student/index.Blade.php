<?php
$counter =1
?>
@extends('layouts.app')
@section('title', 'Student Home')
@section('content')
<div class="container">

    <div style="margin-left: 30px;margin-top: 30px">
        <h1>Courses</h1>
    </div>
    
    <div style="margin-top: 30px;margin-left: 30px">
        <h3 style="word-break: break-all">Current Courses</h3>
    </div>

    <div  style="margin-top: 30px;margin-left: 30px;">
        @foreach(auth()->user()->courses as $course)
            @if( $counter % 2 == 0 )   
                <div style="margin-top: 20px;float: left;background-color: whitesmoke;border-radius: 30px;margin-left: 50px;cursor: pointer" onclick="location.href='/course/student/courseView/{{$course->id}}';">
                    <image src="https://wallpaperaccess.com/full/4492327.jpg" style="width: 450px;height: 220px;border-radius: 25px 25px 0px 0px;"></image>
                    <h3 style="color: black;margin-left: 20px;margin-top: 15px ;margin-bottom: 15px">{{ $course->code }}</h3>
                </div>     
            @else
                <div style="margin-top: 20px;float: left;background-color: whitesmoke;border-radius: 30px;cursor: pointer" onclick="location.href='/course/student/courseView/{{$course->id}}';">
                    <image src="https://wallpaperaccess.com/full/4492327.jpg" style="width: 450px;height: 220px;border-radius: 25px 25px 0px 0px;"></image>
                    <h3 style="color: black;margin-left: 20px;margin-top: 15px ;margin-bottom: 15px">{{ $course->code }}</h3>
                </div>
            @endif
            <?php
                $counter ++;
            ?>
         @endforeach
    </div>

</div>
@endsection
