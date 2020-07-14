@if($answersCount > 0)
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h2>{{ $answersCount." ".\Illuminate\Support\Str::plural('Answer',$answersCount)}}</h2>
                    </div>
                    <hr>
                    @foreach($answers as $answer )
                        {{-- Answer template --}}
                        <answer :answer="{{$answer}}" inline-template v-cloak>
                            <div class="media post">
                                <div class="d-flex flex-column  vote-controls">
                                    <answer-vote :answer="{{$answer}}"></answer-vote>
                                    @can('accept',$answer)
                                        <answer-accept :answer="{{$answer}}"></answer-accept>
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
                                    <form v-if="editing" @submit.prevent="update">
                                        <div class="form-group">
                                            <textarea  class="form-control" v-model="body" rows="7"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-primary" :disabled="isInvalid"  type="submit">Update</button>
                                            <button class="btn btn-danger" @click="cancel"  type="button">Cancel</button>
                                        </div>
                                    </form>
                                    <div v-if="!editing">
                                        <div v-html="bodyHtml"></div>
                                        <div class="row">
                                            <div class="col-4 d-flex flex-row">
                                                @can('update',$answer)
                                                    <div class="">
                                                        <a @click.prevent="edit" class="btn btn-outline-primary btn-sm">Edit</a>
                                                    </div>
                                                @endcan
                                                @can('delete',$answer)
                                                    <div class="ml-2">
                                                        <button class="btn btn-sm btn-outline-danger" @click.prevent="destroy">Delete</button>
                                                    </div>
                                                @endcan
                                            </div>
                                            <div class="col-4"></div>
                                            <div class="col-4">
                                                {{-- User info component --}}
                                                <user-info :model="{{$answer}}" label="Answered "></user-info>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </answer>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endif
