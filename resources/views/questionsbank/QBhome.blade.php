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
    </form>

    <div>
        <table> 
        <tr>
            <td>ID   </td>
            <td>Title   </td>
            <td>Subject  </td>
         </tr>
         @foreach(auth()->user()->questionBanks as $questionBank)
         <tr>
            <td>{{$questionBank->id}} </td>
            <td>{{$questionBank->title}} </td>
            <td>{{$questionBank->subject_id}} </td>
            <td>
            <form action="/QB/addQuestionToQB/{{$questionBank->id}}"  enctype="multipart/form-data" method="post"> 
            @csrf
                <button class="btn btn-primary">Add Question</button>
            </form>
            </td>
            <td>
            <form action="/QB/delete/{{$questionBank->id}}"  enctype="multipart/form-data" method="post">
            @csrf
            <button class="btn btn-primary">Delete</button>
            </form>
            </td>
            <td>
            <form action="/QB"  enctype="multipart/form-data" method="get"> 
            <button class="btn btn-primary">Update</button>
            </form>
            </td>
            
         </tr>
         @endforeach
        </table> 
        </div>

</div>
@endsection
