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
                                <li><a class="active" href="#" title="Questions"><i class="fas fa-question fa-2x"></i></a></li>
                                <li><a  title="Answers" href="#"><i class="fas fa-reply-all fa-2x"></i></a></li>
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
                        <Questions :questions="{{$user->questions}}"></Questions>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
