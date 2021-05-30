@extends('layouts.app')

@section('content')
<div class="container">
    <form action="/createQB" enctype="multipart/form-data" method="post">
    @csrf
        <div class="row pt-3">
            <h1>Create New Question Bank<h1>
        </div>
        <div class="row">
            <div class="col-8 offset-2">
        
                <div class="form-group row">
                    <label for="title" class="col-md-4 col-form-label">title</label>

                    <input id="title" name="title" type="text" class="form-control @error('title') is-invalid @enderror" title="title" value="{{ old('title') }}"  autocomplete="title" autofocus>
                    @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    
                </div>

                <div class="d-flex">
                    <input type="file" name="QBfile" id="QBfile" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" >

                    <select class="form-control" name="sub" id="sub" >
                        <option value="10">math</option>
                        <option value="saab">Saab</option>
                        <option value="mercedes">Mercedes</option>
                        <option value="audi">Audi</option>
                    </select>
                </div>

                <div class="row pt-3">
                    <div class="col-8 offset-2">
                        <button class="btn btn-primary">create</button>
                     </div>
                </div>

            </div>
        </div>

    </from>
</div>
@endsection
