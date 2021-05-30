@extends('layouts.app')

@section('content')
<div class="container">
    <form action="/QB/create" enctype="multipart/form-data" method="get">
    @csrf

        <div class="row pt-3">
            <h1>QuestionBank Home<h1>
        </div>
        <div class="row pt-3">
            <div class="col-8 offset-2">
                <button class="btn btn-primary">create</button>
            </div>
        </div>

    </from>
</div>
@endsection
