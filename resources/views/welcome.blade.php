@extends('layouts.master')

@section('title')
    旅遊日記
@endsection
 
@section('content')
    @include('includes.message-block')
    <div class="row">
        <div class="col-md-6">
            <h3>Sign up</h3>
            <form class="form-group" action="{{ route('signup') }}" method="POST">
                {{ csrf_field() }}
                <div class="form-group {{$errors->has('email') ? 'has-error' : ''}}">
                    <label for="email">Your Email</label>
                    <input class="form-control" type="email" name="email" id="email" value="{{ Request::old('email')}}">
                </div>
                <div class="form-group">
                    <label for="name">Your name</label>
                    <input class="form-control" type="text" name="name" id="name">
                </div>
                <div class="form-group">
                    <label for="password">Your password</label>
                    <input class="form-control" type="password" name="password" id="password">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button> 
            </form>
        </div>
        <div class="col-md-6">
            <h3>Sign in</h3>
            <form class="form-group" action="{{ route('signin') }}" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="email">Your Email</label>
                    <input class="form-control" type="email" name="email" id="email">
                </div>
                <div class="form-group">
                    <label for="password">Your password</label>
                    <input class="form-control" type="password" name="password" id="password">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection