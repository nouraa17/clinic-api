@extends('layouts.app')

@section('title', 'Reservation Details')

@section('content')
    <div class="container">
        <h1>Reservation Details for {{ $reservation->user->name }} at {{ $reservation->clinic->name }}</h1>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">User Information</h5>
                <p class="card-text"><strong>Name:</strong> {{ $reservation->user->name }}</p>
                <p class="card-text"><strong>Age:</strong> {{ $reservation->age }}</p>
                <p class="card-text"><strong>Gender:</strong> {{ $reservation->gender }}</p>

                <h5 class="card-title mt-3">Clinic Information</h5>
                <p class="card-text"><strong>Clinic Name:</strong> {{ $reservation->clinic->name }}</p>
                <p class="card-text"><strong>Location:</strong> {{ $reservation->clinic->location }}</p>

                <h5 class="card-title mt-3">Reservation Details</h5>
                <p class="card-text"><strong>Specialization:</strong> {{ $reservation->specialization }}</p>
                <p class="card-text"><strong>Reservation Time:</strong> {{ \Carbon\Carbon::parse($reservation->time)->format('Y-m-d H:i') }}</p>
            </div>
        </div>

        <a href="{{ route('reservation.edit', $reservation->id) }}" class="btn btn-warning mt-3">Edit Reservation</a>
        <form action="{{ route('reservation.destroy', $reservation->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete();">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger mt-3">Delete Reservation</button>
        </form>
    </div>
@endsection
