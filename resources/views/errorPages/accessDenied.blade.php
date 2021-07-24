@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center text-danger mb-3"> Access denied <h1>
    <p class="lead">You have no access to the page you tried to access</p>
    <a class="btn btn-primary" href="{{asset('home')}}">Return to home</a>
</div>
@endsection
