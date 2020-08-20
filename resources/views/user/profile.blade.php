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
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
