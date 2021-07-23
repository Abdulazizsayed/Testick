<?php
use App\Course;
?>
@extends('layouts.app')
@section('title', 'Member List')
@section('content')
<div class="container courses">

    <div class="row">
        <div class="col">
            <h2 class="title">Member List</h2>
        </div>
    </div>

    <p>fdgfg fgdfgdfg fdgdfgdfg fdgfdgdfg</p>

    <table class="table mt-5">
        <thead class="thead-blue">
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Role</th>
            </tr>
        </thead>
        <tbody class="question-banks-holder">
            @foreach(Course::find($id)->users as $user)
            <tr>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>
                    @if( $user->role == 1 )
                        Doctor/T.A
                    @else
                        Student
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection