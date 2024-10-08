@extends('layouts.app')

@section('title', 'History Details')

@section('content')
    <div class="container">
        <h1>History Details for {{ $history->user->name }}</h1>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">User Information</h5>
                <p class="card-text"><strong>Name:</strong> {{ $history->user->name }}</p>
                <p class="card-text"><strong>Type:</strong> {{ $history->user->type }}</p>
                <h5 class="card-title mt-3">History Details</h5>
                <p class="card-text"><strong>History:</strong> {{ $history->chronic_diseases }}</p>
                <p class="card-text"><strong>History:</strong> {{ $history->prescriptions }}</p>
                <p class="card-text"><strong>Last Visit Time:</strong> {{ \Carbon\Carbon::parse($history->last_visit)->format('Y-m-d H:i:s') }}</p>
            </div>
        </div>

        <a href="{{ route('history.edit', $history->id) }}" class="btn btn-warning mt-3">Edit History</a>
        <form action="{{ route('history.destroy', $history->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete();">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger mt-3">Delete History</button>
        </form>
    </div>
@endsection
