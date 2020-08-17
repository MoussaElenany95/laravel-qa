@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <div class="d-flex align-items-center">
                                <h2>{{$question->title}}</h2>
                                <div class="ml-auto">
                                    <a href="{{route('questions.index')}}" class="btn btn-outline-secondary">Back to all questions</a>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="media">
                            <div class="d-flex flex-column  vote-controls">
                                <question-vote :question="{{$question}}"></question-vote>
                                <favorite :question="{{$question}}"></favorite>
                            </div>
                            <div class="media-body">
                                {!! $question->body_html !!}
                                <div class="row mt-2">
                                    <div class="col-4"></div>
                                    <div class="col-4"></div>
                                    <div class="col-4">
                                        {{-- User info component --}}
                                        <user-info :model="{{$question}}" label="Asked "></user-info>
                                    </div>

                                </div>

                            </div>
                        </div>
                        <new-answer :question-id="{{$question->id}}"></new-answer>
                    </div>
                </div>
            </div>
        </div>
        <answers :question="{{$question}}"></answers>
    </div>
@endsection
