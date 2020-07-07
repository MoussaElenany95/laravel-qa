@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h2> All questions</h2>
                            <div class="ml-auto">
                                <a href="{{route('questions.create')}}" class="btn btn-outline-secondary">Ask question</a>
                            </div>
                        </div>

                    </div>

                    <div class="card-body">
                        @include('layouts._messages')

                        @forelse($questions as $question )
                            <div class="media">
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
                                    <div class="d-flex align-items-center">
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
                                        Asked by <a href="{{$question->user->url}}">{{$question->user->name}}</a>
                                        <small class="text-muted">{{$question->created_date}}</small>
                                    </p>
                                    {{\Illuminate\Support\Str::limit( $question->body_html,250)}}
                                </div>
                            </div>
                            <hr>
                        @empty
                            <div class="alert alert-warning">
                                <strong>Sorry !</strong> , There are no questions available .
                            </div>
                        @endforelse
                        <div class="text-center">
                            {{$questions->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
