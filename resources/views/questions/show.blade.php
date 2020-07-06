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
                                <a href="" title="This question is useful" class="vote-up">
                                    <i class="fas fa-caret-up fa-3x"></i>
                                </a>
                                <span class="votes-count">1230</span>
                                <a href="" title="This question is not useful" class="vote-down off">
                                    <i class="fas fa-caret-down fa-3x"></i>
                                </a>
                                <a href="" class="favorite mt-2 {{$question->favoritted?'favorited':''}}" title="mark as favorite ( click again to undo ) "
                                   onclick="event.preventDefault(); document.getElementById('favorite-form').submit();"
                                >
                                    <i class="fas fa-star fa-2x"></i>
                                    <span class="favorite-count">{{$question->favorites_count}}</span>
                                </a>
                                <form id="favorite-form" action="{{route('questions.favorite',$question)}}" method="post">
                                    @csrf
                                </form>
                            </div>
                            <div class="media-body">
                                {!! $question->body_html !!}
                                <div class="float-right">
                                    <span class="text-muted">{{$question->created_date}}</span>
                                    <div class="media mt-2">
                                        <a href="{{$question->user->url}}" class="pr-2">
                                            <img src="{{$question->user->avatar}}" alt="">
                                        </a>
                                        <div class="media-body mt-2">
                                            <a href="{{$question->user->url}}">
                                                {{$question->user->name}}
                                            </a>
                                        </div>
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
