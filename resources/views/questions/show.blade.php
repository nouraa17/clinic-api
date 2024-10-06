@extends('layouts.app')

@section('title', 'Question Details')

@section('content')
    <div class="container">
        <h1>Question Details for {{ $question->user->name }}</h1>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">User Information</h5>
                <p class="card-text"><strong>Name:</strong> {{ $question->user->name }}</p>
                <p class="card-text"><strong>Type:</strong> {{ $question->user->type }}</p>
                <h5 class="card-title mt-3">Question Details</h5>
                <p class="card-text"><strong>Question:</strong> {{ $question->question }}</p>
                <p class="card-text"><strong>Question Time:</strong> {{ \Carbon\Carbon::parse($question->created_at)->format('Y-m-d H:i:s') }}</p>
            </div>
        </div>

        <a href="{{ route('question.edit', $question->id) }}" class="btn btn-warning mt-3">Edit Question</a>
        <form action="{{ route('question.destroy', $question->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete();">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger mt-3">Delete Question</button>
        </form>
    </div>
@endsection
