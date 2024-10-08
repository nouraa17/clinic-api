@extends('layouts.app')

@section('title', 'Feedback Details')

@section('content')
    <div class="container">
        <h1>Feedback Details for {{ $feedback->user->name }}</h1>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">User Information</h5>
                <p class="card-text"><strong>Name:</strong> {{ $feedback->user->name }}</p>
                <p class="card-text"><strong>Type:</strong> {{ $feedback->user->type }}</p>
                <h5 class="card-title">Clinic Information</h5>
                <p class="card-text"><strong>Name:</strong> {{ $feedback->clinic->name }}</p>
                <h5 class="card-title mt-3">Feedback Details</h5>
                <p class="card-text"><strong>Feedback:</strong> {{ $feedback->feedback }}</p>
                <p class="card-text"><strong>Feedback Time:</strong> {{ \Carbon\Carbon::parse($feedback->created_at)->format('Y-m-d H:i:s') }}</p>
            </div>
        </div>

        <a href="{{ route('feedback.edit', $feedback->id) }}" class="btn btn-warning mt-3">Edit Feedback</a>
        <form action="{{ route('feedback.destroy', $feedback->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete();">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger mt-3">Delete Feedback</button>
        </form>
    </div>
@endsection
