@extends('layouts.app')

@section('title', 'Edit Question')

@section('content')
    <div class="container mb-5">
        @if($errors->any())
            @foreach($errors->all() as $error)
                <p class="alert alert-danger mt-2">{{$error}}</p>
            @endforeach
        @endif
        <h1>Edit Question for {{ $question->user->name }}</h1>

        <form action="{{ route('question.update', $question->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="user_id">User</label>
                <select name="user_id" class="form-control" required>
                    <option value="">Select a user</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $question->user_id == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="question">Question</label>
                <textarea name="question" class="form-control" required>{{ $question->question }}</textarea>
            </div>

            <button type="submit" class="btn btn-success mt-3">Update Question</button>
        </form>
    </div>
@endsection
