<?php
    use App\Subject;
    $subjects = Subject::all();
?>
@extends('layouts.app')

@section('title', 'Create question bank')

@section('content')
<div class="container">
    <form action="/QB/create" enctype="multipart/form-data" method="post">
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
                    <div > <input type="file" name="QBfile" id="QBfile" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
                    </div>
                    <div style="float:right;width:50% ;">
                    <select class="form-control" name="sub" id="sub" style="background-color: #1A034A;color: white" required >
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

    <div class="row1" style="margin-left: 70px; margin-top: 5% ">
        <div>
            <img style="width: 90%;height: 70%" src="https://cdn.discordapp.com/attachments/632672262444679169/868256705706852352/QB-Photo.jpg">
        </div>

        <div style="margin-top: 3%;margin-left: 15%">
            <h1><b>QUESTION BANK TEMPLATE NOTES:</b></h1>
        </div>
        <div style="margin-top: 3%">
            <span>1. First row is always saved for the headings. Use the headings or not it’s your responsibility to </span>
            <span style="color:#FD6464"><b>NOT to write a question in first row.</b></span>
        </div>
        <div style="margin-top: 1%">
            <span>2. Cell Formats: A => Question content , B => Question Type , C => Chapter number , D => parent Question  </span>
            <span style="color:#FD6464"><b>(( Row number from inside the file )) </b></span>
            <span>)) ,E => question Difficulty , F => Question correct answer , G => Question false answer.</span>
        </div>
        <div style="margin-top: 1%">
            <span>3. For MCQ ( MSMCQ (Multiple choice MCQ) or SSMCQ( Single choice MCQ) ) : you can add multiple correct answers or wrong answers in the same cell . </span>
            <span style="color:#FD6464"><b> Just separate them by this character ‘ ~ ‘  . </b></span>
        </div>
        <div style="margin-top: 1%">
            <span>4. To link a Parent question correctly. Add the parent question normally, then add it’s child questions’ anywhere.</span>
            <span style="color:#FD6464"><b>. But add the parent question row number to the Parent Question cell for every child.</b></span>
        </div>
        <div style="margin-top: 1%">
            <span>5. For Essay question add the correct answer ONLY. Wrong answer cell NOT will be used</span>
            <span style="color:#FD6464"><b>ONLY</b></span>
            <span> Wrong answer cell NOT will be used</span>
            <span style="color:#FD6464"><b>NOT</b></span>
            <span> will be used.</span>
        </div>
        <div style="margin-top: 1%">
            <span>6. For T/F Question: add Yes if the correct answer is false in Canswer Cell ONLY, Wrong answer cell will NOT be used.</span>
            <span style="color:#FD6464"><b>Yes</b></span>
            <span> if the correct answer is true or </span>
            <span style="color:#FD6464"><b>No</b></span>
            <span> if the correct answer is false in Canswer Cell </span>
            <span style="color:#FD6464"><b>ONLY</b></span>
            <span>, Wrong answer cell will </span>
            <span style="color:#FD6464"><b>NOT</b></span>
            <span> be used.</span>
        </div>
        <div style="margin-top: 3%;margin-bottom: 2%">
            <h5>PLEASE note that it is very important to construct your file correctly, to avoid any errors and to work effectively in the analysis section. </h5>
        </div>


    </div>



@endsection
