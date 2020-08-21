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
                                <li><a  class="active" href="#"><h4>Questions</h4></a></li>
                                <li><a  href="#"><h4>Answers</h4></a></li>
                                <li><a  href="#"><h4>Messages</h4></a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-body">
                        @forelse($user->questions as $question )
                            <div class="media post">
                                <div class="d-flex flex-column counters">
                                    <div class="vote">
                                        <strong> {{ $question->votes_count }} </strong>{{ \Illuminate\Support\Str::plural("vote",$question->votes_count) }}
                                    </div>
                                    <div class="status {{$question->status}}">
                                        <strong> {{ $question->answers_count }} </strong>{{ \Illuminate\Support\Str::plural("answer",$question->answers_count) }}
                                    </div>
                                    <div class="view">
                                        {{ $question->views ." ".\Illuminate\Support\Str::plural("view",$question->views) }}
                                    </div>
                                </div>
                                <div class="media-body">
                                    <div class="d-flex flex-row align-items-center">
                                        <h3 class="mt-0"><a href="{{$question->url}}">{{$question->title}}</a></h3>
                                        @can('update',$question)
                                            <div class="ml-auto">
                                                <a href="{{route('questions.edit',$question->id)}}" class="btn btn-outline-primary btn-sm">Edit</a>
                                            </div>
                                        @endcan
                                        @can('delete',$question)
                                            <div class="ml-2">
                                                <form method="post" action="{{route('questions.destroy',$question->id)}}">
                                                    {{method_field('DELETE')}}
                                                    @csrf
                                                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure to delete ? ')" type="submit">Delete</button>
                                                </form>
                                            </div>
                                        @endcan

                                    </div>
                                    <p class="lead">
                                        Asked by <a href="{{$user->url}}">{{$user->name}}</a>
                                        <small class="text-muted">{{$question->created_date}}</small>
                                    </p>
                                    {{\Illuminate\Support\Str::limit( $question->body_html,300)}}
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-warning">
                                <strong>Sorry !</strong> , There are no questions available .
                                <a href="{{route("questions.create")}}" class="btn btn-lg btn-outline-primary">Ask question</a>
                            </div>
                        @endforelse

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

