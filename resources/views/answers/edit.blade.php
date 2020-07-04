@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h2>Edit your answer</h2>
                        </div>

                    </div>

                    <div class="card-body">
                        <form action="{{route('questions.answers.update',[$question->id,$answer->id])}}" method="post">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <textarea name="body" class="form-control {{$errors->has('body')?'is-invalid':''}}"  rows="7">{{old('body',$answer->body)}}</textarea>
                                @if($errors->has('body'))
                                    <div class="invalid-feedback">
                                        <strong>{{$errors->first('body')}}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <button class="btn btn-lg btn-outline-primary">Edit this answer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
