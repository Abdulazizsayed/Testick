@extends('layouts.app')

@section('title', 'Exams')

@section('content')
<div class="container exams-index">
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="row">
        <div class="col">
            <h2 class="title">Exams</h2>
        </div>
        <div class="col-md-auto">
            <a class="btn create-exam-btn" href="{{asset('exams/create/0')}}">Create manually</a>
        </div>
        <div class="col col-lg-2">
            <a class="btn create-exam-btn" href="{{asset('exams/create/1')}}">Create randomly</a>
        </div>
    </div>

    <p class="pr-5 pl-5 pt-3 desc">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi illum, architecto impedit odit fuga quia harum beatae? Tenetur perferendis culpa officia. Ut totam error eveniet quasi cum repudiandae et fugiat!</p>

    <div class="row">
        <div class="col-md-4">
            <span class='label'>Filter</span>
            <select class="filter-by" name="filter-by">
                <option value="1">Title</option>
                <option value="2">Course code</option>
                <option value="3">Type</option>
                <option value="4">Date</option>
            </select>
        </div>
        <div class="col-md-8">
            <span class='label'>Search by <span class="selected-filter">Title</span></span>
            <form id="search-form" autocomplete="off">
                @csrf
                <input class="search-filter-input" type="text" name="search_input" placeholder="Enter exam Title">
                <input class='filter-value' name='filter_value' type="text" value="title" hidden>
            </form>
        </div>
    </div>

    <table class="table mt-5">
        <thead class="thead-blue">
            <tr>
                <th class="text-center" scope="col">Title</th>
                <th class="text-center" scope="col">Course code</th>
                <th class="text-center" scope="col">Subject</th>
                <th class="text-center" scope="col">Type</th>
                <th class="text-center" scope="col">Duration(hours)</th>
                <th class="text-center" scope="col">Allow period(mins)</th>
                <th class="text-center" scope="col">Date</th>
                <th class="text-center" scope="col">Weight</th>
                <th class="text-center" scope="col">Operations</th>
            </tr>
        </thead>
        <tbody class="exams-holder">
            @foreach ($exams as $exam)
            <tr>
                <td class="text-center">
                    <a href='{{asset('exams/' . $exam->id)}}'>{{$exam->title}}</a>
                </td>
                <td class="text-center">{{$exam->course->code}}</td>
                <td class="text-center">{{$exam->course->subject->name}}</td>
                <td class="text-center">{{$exam->type}}</td>
                <td class="text-center">{{$exam->duration}}</td>
                <td class="text-center">{{$exam->allow_period}}</td>
                <td class="text-center">{{$exam->date}}</td>
                <td class="text-center">{{$exam->weight()}}</td>
                <td class="text-center">
                @if (\Carbon\Carbon::parse($exam->date)->lt(\Carbon\Carbon::now()))
                    <a class="btn btn-primary" href="{{asset('exams/analysis/' . $exam->id)}}">Analysis <i class="fa fa-pie-chart fa-lg"></i></a>
                    <a class="btn btn-success" href="{{asset('exams/studentsGrades/' . $exam->id)}}">Students grades <i class="fa fa-percent fa-lg"></i></a>
                @else
                    <form action="/exams/{{$exam->id}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">Delete <i class="fa fa-times fa-lg"></i></button>
                    </form>
                    <button class="btn edit-exam-btn">Edit <i class="fa fa-edit fa-lg"></i></button>
                @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
