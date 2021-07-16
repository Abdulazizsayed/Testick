@extends('layouts.app')
@section('title', 'Create Exam Randomlly')
@section('content')
    <div class="container">


            <div class="row pt-3" style="margin-left: 30px">
                <h1>Create Exam Randomlly<h1>
            </div>
            <br>
                    <div class="form-group row" style="margin-left: 30px">
                        <div style="float:left;">
                            <label for="title" class="col-md-4 col-form-label">Title</label>
                        </div>
                        <div style="float:right;margin-left: 70px;width: 600px;">
                            <input id="title" name="title" type="text" class="form-control @error('title') is-invalid @enderror" title="title" value="{{ old('title') }}" required  autocomplete="title" autofocus style="border-radius: 25px" placeholder="Enter the exam title">
                            @error('title')
                            <span class="invalid-feedback" role="alert">
                        <strong></strong>
                    </span>
                            @enderror
                        </div>
                        <div style="margin-left: 50px">
                            <select class="form-control" name="sub" id="ET" style="background-color: #1A034A;color: white;width: 185px" required >
                                <option value="" disabled selected >Exam Type</option>

                                    <option value="1">MCQ</option>
                                    <option value="2">ESSAY</option>
                                    <option value="3">Two</option>

                            </select>
                        </div>
                    </div>
                    <br>
        <div class="form-group row" style="margin-left: 30px">
            <div style="float:left;">
                <label for="title" class="col-md-4 col-form-label">date</label>
            </div>
            <div style="float:right;margin-left: 70px;width: 600px">
                <input id="date" name="date" type="date" class="form-control @error('date') is-invalid @enderror" title="date" value="{{ old('date') }}" required  autocomplete="date" autofocus style="border-radius: 25px;"placeholder="Enter date of the exam">
                @error('date')
                <span class="invalid-feedback" role="alert">
                        <strong></strong>
                    </span>
                @enderror
            </div>
            <div style="margin-left: 50px;width: 185px">
                <select class="form-control" name="sub" id="ET" style="background-color: #1A034A;color: white" required >
                    <option value="" disabled selected >Course</option>

                    <option value="1">Math</option>
                    <option value="2">DB</option>
                    <option value="3">DBD</option>

                </select>
            </div>
        </div>
        <br>
        <div class="form-group row" style="margin-left: 30px">
            <div style="float:left;">
                <label for="title" class="col-md-4 col-form-label">Duration</label>
            </div>
            <div style="float:right;margin-left: 44px;width: 600px">
                <input id="duration" name="duration" type="text" class="form-control @error('duration') is-invalid @enderror" title="duration" value="{{ old('duration') }}" required  autocomplete="duration" autofocus style="border-radius: 25px;"placeholder="Enter the duration of exam in mins">
                @error('duration')
                <span class="invalid-feedback" role="alert">
                        <strong></strong>
                    </span>
                @enderror
            </div>
        </div>
        <br>
        <div class="form-group row" style="margin-left: 30px">
            <div style="float:left;">
                <label for="title" class="col-md-4 col-form-label">AllowPeriod</label>
            </div>
            <div style="float:right;margin-left: 20px;width: 600px">
                <input id="allow" name="allow" type="text" class="form-control @error('allow') is-invalid @enderror" title="allow" value="{{ old('allow') }}" required  autocomplete="allow" autofocus style="border-radius: 25px;"placeholder="Enter student name">
                @error('allow')
                <span class="invalid-feedback" role="alert">
                        <strong></strong>
                    </span>
                @enderror
            </div>
        </div>
        <br>


        <div class="form-group row" style="margin-left: 30px">

            <div style="margin-left: 10px">
                <select class="form-control" name="sub" id="ET" style="background-color: #1A034A;color: white;width: 250px" required >
                    <option value="" disabled selected >Question Bank</option>

                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>

                </select>
            </div>
        </div>
        <div class="form-group row" style="margin-left: 0px;width: 1000px;border: 2px solid gray;border-radius: 10px">
            <div style="margin-left: 25px;margin-top: 20px">

                <div style="margin-left: 10px">
                    <select class="form-control" name="sub" id="ET" style="background-color: #1A034A;color: white;width: 250px" required >
                        <option value="" disabled selected >Chapter</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                    </select>
                </div>
                <br>
                <div class="form-group row" style="margin-left: 0px">
                    <div style="float:left;">
                        <label for="title" class="col-md-4 col-form-label">Weight</label>
                    </div>
                    <div style=";margin-left: 10px;">
                        <select class="form-control" name="sub" id="ET" style="background-color: #1A034A;color: white;" required >
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                    <div >
                        <label for="title" class="col-md-4 col-form-label">#Easy</label>
                    </div>
                    <div style="margin-left: 10px">
                        <select class="form-control" name="sub" id="ET" style="background-color: #1A034A;color: white;" required >
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                </div>
                <br>
                <div class="form-group row" style="margin-left: 0px">
                    <div style="float:left;">
                        <label for="title" class="col-md-4 col-form-label">Weight</label>
                    </div>
                    <div style=";margin-left: 10px;">
                        <select class="form-control" name="sub" id="ET" style="background-color: #1A034A;color: white;" required >
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                    <div >
                        <label for="title" class="col-md-4 col-form-label">#Med</label>
                    </div>
                    <div style="margin-left: 10px">
                        <select class="form-control" name="sub" id="ET" style="background-color: #1A034A;color: white;" required >
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                    <div style="margin-left: 20px">
                        <select class="form-control" name="sub" id="ET" style="background-color: #1A034A;color: white;" required >
                            <option value="" disabled selected >Question Type</option>
                            <option value="<MCQ>">MCQ</option>
                            <option value="Essay">Essay</option>
                            <option value="TF">TF</option>

                        </select>
                    </div>
                </div>
                <br>
                <div class="form-group row" style="margin-left: 0px">
                    <div style="float:left;">
                        <label for="title" class="col-md-4 col-form-label">Weight</label>
                    </div>
                    <div style=";margin-left: 10px;">
                        <select class="form-control" name="sub" id="ET" style="background-color: #1A034A;color: white;" required >
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                    <div >
                        <label for="title" class="col-md-4 col-form-label">#Hard</label>
                    </div>
                    <div style="margin-left: 10px">
                        <select class="form-control" name="sub" id="ET" style="background-color: #1A034A;color: white;" required >
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                </div>
            </div>
            <br>
        </div>
    </div>

@endsection

