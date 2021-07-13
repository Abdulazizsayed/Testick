<?php
    use App\Subject;
    $subjects = Subject::all();
?>
@extends('layouts.app')

@section('title', 'Create question bank')

@section('content')
<div class="container">
    <form action="/createQB" enctype="multipart/form-data" method="post">
    @csrf
        <div class="row pt-3" style="margin-left: 50px">
            <h1>Create New Question Bank<h1>
        </div>
        <div class="row">
            <div class="col-8 offset-2">

                <div class="form-group row">
                    <div style="float:left;">
                        <label for="title" class="col-md-4 col-form-label">Title</label>
                    </div>
                    <div style="float:right;width:76.5%;margin-left: 90px">
                    <input id="title" name="title" type="text" class="form-control @error('title') is-invalid @enderror" title="title" value="{{ old('title') }}" required  autocomplete="title" autofocus>
                    @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    </div>

                </div>


                <div class="d-flex">
                    <div style="float: left; margin-right: 50px"><h6>QuestionFile</h6></div>
                    <div > <input type="file" name="QBfile" id="QBfile" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" >
                    </div>
                    <div style="float:right;width:50% ;">
                    <select class="form-control" name="sub" id="sub" style="background-color: #1A034A;color: white" >
                        <option value="" disabled selected >Subject</option>
                        @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}">{{$subject->name}}</option> 
                        @endforeach
                    </select>
                </div>
                </div>
                <br>
            </div>
        </div>

    </from>

</div>


    <div  style="margin-left: 500px;">
        <button class="btn btn-primary">create</button>
    </div>



@endsection
