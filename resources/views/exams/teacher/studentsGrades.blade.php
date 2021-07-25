@extends('layouts.app')

@section('title', "Students' grades of " . $exam->title)

@section('content')
<div class="container students-grades">
    <div class="row">
        <div class="col">
            <h2 class="title">Students' grades of {{$exam->title}}</h2>
        </div>
    </div>
    <p class="pr-5 pl-5 pt-3 desc">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi illum, architecto impedit odit fuga quia harum beatae? Tenetur perferendis culpa officia. Ut totam error eveniet quasi cum repudiandae et fugiat!</p>

    <div class="row">
        <div class="col-md-4">
            <span class='label'>Filter</span>
            <select class="filter-by" name="filter-by">
                <option value="name">Name</option>
            </select>
        </div>
        <div class="col-md-8">
            <span class='label'>Search by <span class="selected-filter">Name</span></span>
            <form id="search-form" autocomplete="off">
                @csrf
                <input class="search-filter-input" type="text" name="search_input" placeholder="Enter student name">
                <input class='filter-value' name='filter_value' type="text" value="title" hidden>
                <input name='exam_id' type="number" value="{{$exam->id}}" hidden>
            </form>
        </div>
    </div>

    <table class="table mt-5">
        <thead class="thead-blue">
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Grade</th>
                <th scope="col">Operations</th>
            </tr>
        </thead>
        <tbody class="students-holder">
            @foreach ($exam->studentsSubmitted()->withPivot('score')->get() as $student)
            <tr>
                <td>{{$student->name}}</td>
                <td>{{$student->pivot->score}}</td>
                <td>
                    <a class="btn btn-primary" href="{{asset('exams/answers/' . $exam->id . '/' . $student->id)}}">Answers</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
