@extends('layouts.app')

@section('title', 'Create Question')

@section('content')
    <div class="container mb-5">
        <h1>Create New Question</h1>
        @if($errors->any())
            @foreach($errors->all() as $error)
                <p class="alert alert-danger mt-2">{{$error}}</p>
            @endforeach
        @endif
        <form action="{{ route('question.store') }}" method="POST">
            @csrf
            <div class="form-group mb-2">
                <label for="user_id">User</label>
                <select name="user_id" class="form-control" required>
                    <option value="">Select a user</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-2">
                <label for="question">Question</label>
                <textarea name="question" class="form-control" required></textarea>
            </div>

            <button type="submit" class="btn btn-success mt-3">Create Question</button>
        </form>
    </div>
@endsection
