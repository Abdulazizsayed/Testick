@extends('layouts.app')

@section('content')
<div class="container">
    <form action="/addQuestionToQB" enctype="multipart/form-data" method="post">
    @csrf
        <div class="row pt-3">
            <h1>Add Question to Question Bank<h1>
        </div>
        <div class="row">
            <div class="col-8 offset-2">
                <select class="form-control" name="QB" id="QB" required>
                    <option value=></option>
                    <option value="1">math120</option>
                    <option value="saab">Saab</option>
                    <option value="mercedes">Mercedes</option>
                    <option value="audi">Audi</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-8 offset-2">
                <div class="d-flex">
                    <select class="form-control" name="parent" id="parent" >
                        <option value=></option>
                        <option value="1">parent</option>
                        <option value="saab">Saab</option>
                        <option value="mercedes">Mercedes</option>
                    <option value="audi">Audi</option>
                    </select>
                    <select class="form-control" name="chapter" id="chapter" required>
                        <option value=></option>
                        <option value="1">chapter</option>
                        <option value="saab">Saab</option>
                        <option value="mercedes">Mercedes</option>
                    <option value="audi">Audi</option>
                    </select>
                    <select class="form-control" name="type" id="type" required>
                        <option value=></option>
                        <option value="0">type</option>
                        <option value="saab">Saab</option>
                        <option value="mercedes">Mercedes</option>
                    <option value="audi">Audi</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-8 offset-2">
        
                <div class="form-group row">
                    <label for="Qcontent" class="col-md-4 col-form-label">Qcontent</label>

                    <input id="Qcontent" name="Qcontent" type="text" class="form-control @error('Qcontent') is-invalid @enderror" Qcontent="Qcontent" value="{{ old('Qcontent') }}" required autocomplete="Qcontent" autofocus>
                    @error('Qcontent')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-8 offset-2">
                <div class="d-flex">
                    <label for="answer1" class="col-md-4 col-form-label">answer1</label>

                    <input id="answer1" name="answer1" type="text" class="form-control @error('answer1') is-invalid @enderror" answer1="answer1" value="{{ old('answer1') }}" required autocomplete="answer1" autofocus>
                    @error('answer1')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <input class="form-control" type="checkbox" id="ch1" name="ch1" value="correct">
                </div>
            </div>

            <div class="col-8 offset-2">
                <div class="d-flex">
                    <label for="answer2" name="answer2" class="col-md-4 col-form-label">answer2</label>

                    <input id="answer2" type="text" class="form-control @error('answer2') is-invalid @enderror" answer2="answer2" value="{{ old('answer2') }}" required autocomplete="answer2" autofocus>
                    @error('answer2')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <input class="form-control" type="checkbox" id="ch2" name="ch2" value="correct">
                </div>
            </div>
        </div>

        <div class="row pt-3">
            <div class="col-8 offset-2">
                <button class="btn btn-primary">ADD</button>
            </div>
        </div>
       
                         

    </from>
</div>
@endsection
