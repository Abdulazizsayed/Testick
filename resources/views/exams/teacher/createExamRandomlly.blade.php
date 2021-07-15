@extends('layouts.app')
@section('title', 'Create Exam Manually')
@section('content')
    <div class="container Create-Exam-Manually">

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



    </div>
@endsection
