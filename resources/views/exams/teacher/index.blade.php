@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="row">
        <div class="col">
            <h2>Exams</h2>
        </div>
        <div class="col-md-auto">
            <button class="btn btn-primary create-exam-btn">Create randomly</button>
        </div>
        <div class="col col-lg-2">
            <button class="btn btn-primary create-exam-btn">Create randomly</button>
        </div>
    </div>
    <p class="pr-5 pl-5 pt-3 lead">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi illum, architecto impedit odit fuga quia harum beatae? Tenetur perferendis culpa officia. Ut totam error eveniet quasi cum repudiandae et fugiat!</p>

    <div class="row">
        <div class="col-md-4">
            <span>Filter</span>
            <select name="filter-by">
                <option value="1">Title</option>
                <option value="2">Course</option>
                <option value="3">Type</option>
                <option value="4">Date</option>
            </select>
        </div>
        <div class="col-md-4">
            <span>Search by title</span>
            <input type="text" name="search">
        </div>
    </div>

    <table class="table mt-5">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Title</th>
                <th scope="col">Code</th>
                <th scope="col">Subject</th>
                <th scope="col">Type</th>
                <th scope="col">Duration</th>
                <th scope="col">Allow period</th>
                <th scope="col">Date</th>
                <th scope="col">Operations</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($exams as $exam)
            <tr>
                <td>{{$exam->title}}</td>
                <td>{{$exam->course->code}}</td>
                <td>{{$exam->course->subject->name}}</td>
                <td>{{$exam->type}}</td>
                <td>{{$exam->duration}}</td>
                <td>{{$exam->allow_period}}</td>
                <td>{{$exam->date}}</td>
                <td>
                @if (\Carbon\Carbon::parse($exam->date)->lt(\Carbon\Carbon::now()))
                    <button class="btn btn-primary">Analysis</button>
                    <button class="btn btn-success">Students grades</button>
                @else
                    <form action="/exams/{{$exam->id}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">Delete</button>
                    </form>
                    <button class="btn edit-exam-btn">Students grades</button>
                @endif
                </td>
            </tr>
            @endforeach
        </tbody>
      </table>
</div>
@endsection
