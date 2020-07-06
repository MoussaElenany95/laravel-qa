<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h2>{{ $answersCount." ".\Illuminate\Support\Str::plural('Answer',$answersCount)}}</h2>
                </div>
                <hr>
                @foreach($answers as $answer )

                    <div class="media">
                        <div class="d-flex flex-column  vote-controls">
                            <a href="" title="This answer is useful" class="vote-up">
                                <i class="fas fa-caret-up fa-3x"></i>
                            </a>
                            <span class="votes-count">1230</span>
                            <a href="" title="This answer is not useful" class="vote-down off">
                                <i class="fas fa-caret-down fa-3x"></i>
                            </a>
                            @can('accept',$answer)
                                <a href="" title="Accept this answer ( click again to undo ) "
                                   class="mt-2 {{$answer->status ? 'vote-accepted':''}}"
                                   onclick="event.preventDefault(); document.getElementById('accept-answer-{{$answer->id}}').submit(); "
                                >
                                    <i class="fas fa-check fa-2x"></i>
                                </a>
                                {{--accept answer form--}}
                                <form id="accept-answer-{{$answer->id}}" action="{{route('answers.accept',$answer->id)}}" method="POST">
                                     @csrf
                                </form>
                            @else
                                @if($answer->status)
                                    <a title="this answer was accepted as the best answer  "
                                       class="mt-2 {{$answer->status ? 'vote-accepted':''}}">
                                        <i class="fas fa-check fa-2x"></i>
                                    </a>
                                @endif
                            @endcan
                        </div>
                        <div class="media-body">
                            {!! $answer->body_html !!}
                            <div class="row">
                                <div class="col-4 d-flex flex-row">
                                    @can('update',$answer)
                                        <div class="">
                                            <a href="{{route('questions.answers.edit',[$question->id,$answer->id])}}" class="btn btn-outline-primary btn-sm">Edit</a>
                                        </div>
                                    @endcan
                                    @can('delete',$answer)
                                        <div class="ml-2">
                                            <form method="post" action="{{route('questions.answers.destroy',[$question->id,$answer->id])}}">
                                                {{method_field('DELETE')}}
                                                @csrf
                                                <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure to delete ? ')" type="submit">Delete</button>
                                            </form>
                                        </div>
                                    @endcan
                                </div>
                                <div class="col-4"></div>
                                <div class="col-4">
                                    <span class="text-muted">{{$answer->created_date}}</span>
                                    <div class="media mt-2">
                                        <a href="{{$answer->user->url}}" class="pr-2">
                                            <img src="{{$answer->user->avatar}}" alt="">
                                        </a>
                                        <div class="media-body mt-2">
                                            <a href="{{$answer->user->url}}">
                                                {{$answer->user->name}}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <hr>
                @endforeach
            </div>
        </div>
    </div>
</div>
