<?php
use App\Subject;
?>
@extends('layouts.app')
@section('title', 'Question banks')
@section('content')
<div class="container question-banks">
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="row">
        <div class="col">
            <h2 class="title">Question Bank</h2>
        </div>
        <form action="/QB/create" enctype="multipart/form-data" method="get">
            @csrf
            <div class="col-md-auto">
                <button class="btn btn-primary">Create</button>
            </div>
        </form>
    </div>
    <p class="pr-5 pl-5 pt-3 desc">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi illum, architecto impedit odit fuga quia harum beatae? Tenetur perferendis culpa officia. Ut totam error eveniet quasi cum repudiandae et fugiat!</p>

    <div class="row">
        <div class="col-md-4">
            <span class='label'>Filter</span>
            <select class="filter-by" name="filter-by">
                <option value="1">Title</option>
                <option value="3">Subject</option>
            </select>
        </div>
        <div class="col-md-8">
            <span class='label'>Search by <span class="selected-filter">Title</span></span>
            <form id="search-form" autocomplete="off">
                @csrf
                <input class="search-filter-input" type="text" name="search_input" placeholder="Enter question bank Title">
                <input class='filter-value' name='filter_value' type="text" value="title" hidden>
            </form>
        </div>
    </div>

    <table class="table mt-5">
        <thead class="thead-blue">
            <tr>
                <th scope="col">Title</th>
                <th scope="col">Subject</th>
                <th scope="col">Operations</th>
            </tr>
        </thead>
        <tbody class="question-banks-holder">
            @foreach(auth()->user()->questionBanks as $questionBank)
            <tr>
                <td>{{$questionBank->title}}</td>
                <td>{{$questionBank->subject->name}}</td>
                <td>
                    <a class="btn btn-success" href="/QB/addQuestion/{{$questionBank->id}}">Add Question <i class="fa fa-plus fa-lg"></i></a>
                    <form action="#"  enctype="multipart/form-data" method="post">
                    @csrf
                        <button class="btn btn-primary">Update <i class="fa fa-edit fa-lg"></i></button>
                    </form>
                    <form action="/QB/delete/{{$questionBank->id}}"  enctype="multipart/form-data" method="post">
                    @csrf
                        <button class="btn btn-danger">Delete <i class="fa fa-times fa-lg"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
