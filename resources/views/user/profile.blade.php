@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex flex-column align-items-center">
                            <a class="user-img-link"><img class="user-img" src="{{$user->avatar}}"></a>
                            <h3 class="mt-2"> {{$user->name}}</h3>
                            <h4 class="text-muted">{{"@".$user->username}}</h4>
                        </div>
                    </div>
                    <div class="media">
                        <nav class="profile-menu">
                            <ul class="d-flex flex-row justify-content-around pt-3">
                                <li><a href="#" title="Questions"><i class="fas fa-question fa-2x"></i></a></li>
                                <li><a class="active" title="Answers" href="#"><i class="fas fa-reply-all fa-2x"></i></a></li>
                                @if(auth()->id() == $user->id )
                                    <li><a href="#" title="Messages"><i class="fas fa-sms fa-2x"></i></a></li>
                                    <li><a href="#" title="Profile Settings"><i class="fas fa-user-cog fa-2x"></i></a></li>
                                @endif

                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-body">
                        @forelse($user->questions as $question )
                            <question :question="{{$question}}"></question>
                        @empty
                            <div class="alert alert-warning">
                                <strong>Sorry !</strong> , There are no questions available .
                                <a href="{{route("questions.create")}}" class="btn btn-lg btn-outline-primary">Ask question</a>
                            </div>
                        @endforelse
{{--                        @foreach($user->answers as $answer)--}}
{{--                            <div class="row align-items-center" >--}}
{{--                                <div class="col-8">--}}
{{--                                    <h3><a href="{{$user->url}}">{{$user->name}}</a> answerd {{$answer->question->user->username.'\'s '}} <a href="{{$answer->question->url}}">question</a>:</h3>--}}
{{--                                </div>--}}
{{--                                <div class="col-4">--}}
{{--                                    <h6 class="text-muted">{{$answer->created_date}}</h6>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="row">--}}
{{--                                <div class="col-12">--}}
{{--                                    <p class="lead">--}}
{{--                                        {!! $answer->body_html !!}--}}
{{--                                    </p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <hr>--}}
{{--                        @endforeach--}}
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

