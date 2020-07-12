{{--@foreach($question->answers as $answer)--}}
{{--    @foreach($answer->votes as $vote)--}}
{{--        {{--}}
{{--            die($vote->get('id'))--}}
{{--        }}--}}
{{--    @endforeach--}}
{{--@endforeach--}}
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
                                <a href="" title="This question is useful" class="vote-up"
                                    onclick="event.preventDefault(); document.getElementById('vote-question-up-form-{{$question->id}}').submit();"
                                >
                                    <i class="fas fa-caret-up fa-3x"></i>
                                </a>
                                <span class="votes-count">{{$question->votes_count}}</span>
                                <a href="" title="This question is not useful" class="vote-down"
                                   onclick="event.preventDefault(); document.getElementById('vote-question-down-form-{{$question->id}}').submit();"
                                >
                                    <i class="fas fa-caret-down fa-3x"></i>
                                </a>
                                <favorite :question="{{$question}}"></favorite>
                                <form id="vote-question-up-form-{{$question->id}}" method="post" action="{{route('questions.vote',$question)}}">
                                    @csrf
                                    <input type="hidden" value="1" name="vote">
                                </form>
                                <form id="vote-question-down-form-{{$question->id}}" method="post" action="{{route('questions.vote',$question)}}">
                                    @csrf
                                    <input type="hidden" value="-1" name="vote">
                                </form>
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
                        @include('layouts._messages')
                        @include('answers._create')
                    </div>
                </div>
            </div>
        </div>
        @include('answers._index',[
            'answers'=>$question->answers,
            'answersCount' => $question->answers_count,
         ])
    </div>
@endsection
