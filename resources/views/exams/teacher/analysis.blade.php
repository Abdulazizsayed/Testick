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
                            <h2 class="percentage text-warning">{{round($exam->maxScore(), 2)}}</h2>
                            <span>Maximum grade</span>
                        </div>
                        <div class="col-md-6 text-center analysis-component">
                            <h2 class="percentage text-warning">{{round($exam->minScore(), 2)}}</h2>
                            <span>Minimum grade</span>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6 text-center analysis-component">
                            <h2 class="percentage text-warning">{{round($exam->avgScore(), 2)}}</h2>
                            <span>Average grade</span>
                        </div>
                        <div class="col-md-6 text-center analysis-component">
                            <h2 class="percentage text-warning">{{round($exam->successPercentage(), 2)}}%</h2>
                            <span>Success percentage</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 text-center analysis-component mt-3">
                            <h2 class="percentage text-warning">{{$exam->weight()}}</h2>
                            <span>Exam weight</span>
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
                    <form class="question-analysis-form" action="" method="POST">
                        @csrf
                        <input class="exam-id" type="number" name="exam_id" value="{{$exam->id}}" hidden>
                        <select name="question_id" class="select ml-5 mb-4">
                            <option value="" disabled {{$exam->questions()->count() == 0 ? 'selected' : ''}}>Choose a question</option>
                            @foreach ($exam->questions() as $question)
                                <option value="{{$question->id}}"{{$loop->index == 0 ? ' selected' : ''}}>{{$question->content}}({{$question->difficulty}})</option>
                            @endforeach
                        </select>
                    </form>
                    <div class="row">
                        <div class="col-md-6 text-center analysis-component">
                            <h2 class="percentage text-warning solved">
                                @if ($exam->studentsSubmitted()->count() > 0)
                                    {{round(($exam->questions()->first()->studentAnswers()->where('exam_id', $exam->id)->count() / $exam->studentsSubmitted()->count()) * 100, 2)}}%
                                @else
                                    0%
                                @endif
                            </h2>
                            <span>Solved</span>
                        </div>
                        <div class="col-md-6 text-center analysis-component">
                            <h2 class="percentage text-warning avg">
                                {{round($exam->questions()->first()->studentAnswers()->where('exam_id', $exam->id)->average('score'), 2)}}
                            </h2>
                            <span>Average grades</span>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6 text-center analysis-component">
                            <h2 class="percentage text-warning question-weight">
                                {{round($exam->questions()->first()->examModels()->where('exam_id', $exam->id)->withPivot('weight')->first()->pivot->weight, 2)}}
                            </h2>
                            <span>Question weight</span>
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
                    <form class="chapter-analysis-form" action="" method="POST">
                        @csrf
                        <input class="exam-id" type="number" name="exam_id" value="{{$exam->id}}" hidden>
                        <select name="chapter" class="select ml-5 mb-4">
                            @php
                                $chapters = $exam->questions()->pluck('chapter')->unique();
                            @endphp
                            <option value="" disabled{{$chapters->count() == 0 ? ' selected' : ''}}>Choose a chapter</option>
                            @foreach ($chapters as $chapter)
                                <option value="{{$chapter}}"{{$loop->index == 0 ? ' selected' : ''}}>{{$chapter}}</option>
                            @endforeach
                        </select>
                    </form>
                    <div class="row">
                        <div class="col-md-6 text-center analysis-component">
                            <h2 class="percentage text-warning chapter-absorbtion">
                                {{round($exam->chapterAbsorbtion($chapters->first()), 2)}}%
                            </h2>
                            <span>Chapter absorbtion</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
