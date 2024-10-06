@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <div class="form">
        <h2>Login</h2>

        @if($errors->any())
            @foreach($errors->all() as $error)
                <p class="alert alert-danger">{{$error}}</p>
            @endforeach
        @endif

        @if(session('success'))
            <p class="alert alert-success">{{session('success')}}</p>
        @endif

        <form action="{{ route('login.submit') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <button type="submit" class="btn btn-primary mt-2">Login</button>
        </form>
    </div>
@endsection
