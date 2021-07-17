@extends('layouts.app')

@section('title', 'Analysis of ')

@section('content')
<div class="container analysis">
    <h2 class="title text-center">{{$exam->title}} analysis</h2>
    <div class="accordion mt-5" id="accordionExample">
        <div class="card">
            <div class="card-header" id="headingOne">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Exam analysis
                    </button>
                </h2>
            </div>

            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 text-center analysis-component">
                            <h2 class="percentage text-warning">98%</h2>
                            <span>Maximum grade</span>
                        </div>
                        <div class="col-md-6 text-center analysis-component">
                            <h2 class="percentage text-warning">98%</h2>
                            <span>Maximum grade</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="headingTwo">
                <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    Question analysis
                </button>
                </h2>
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                <div class="card-body">
                    <select class="select ml-5 mb-4">
                        <option value="" disabled selected>Choose a question</option>
                        @foreach ($exam->questions as $question)
                            <option value="{{$question->id}}">{{$question->content}}</option>
                        @endforeach
                    </select>
                    <div class="row">
                        <div class="col-md-6 text-center analysis-component">
                            <h2 class="percentage text-warning">98%</h2>
                            <span>Maximum grade</span>
                        </div>
                        <div class="col-md-6 text-center analysis-component">
                            <h2 class="percentage text-warning">98%</h2>
                            <span>Maximum grade</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="headingThree">
                <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    Curriculam analysis
                </button>
                </h2>
            </div>
            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                <div class="card-body">
                    <select class="select ml-5 mb-4">
                        <option value="" disabled selected>Choose a chapter</option>
                        @foreach ($exam->questions()->select('chapter')->distinct()->get() as $question)
                            <option value="{{$question->chapter}}">{{$question->chapter}}</option>
                        @endforeach
                    </select>
                    <div class="row">
                        <div class="col-md-6 text-center analysis-component">
                            <h2 class="percentage text-warning">98%</h2>
                            <span>Maximum grade</span>
                        </div>
                        <div class="col-md-6 text-center analysis-component">
                            <h2 class="percentage text-warning">98%</h2>
                            <span>Maximum grade</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
