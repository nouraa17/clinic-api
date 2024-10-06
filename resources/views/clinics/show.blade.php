@extends('layouts.app')

@section('title', 'Clinics Show')

@section('content')
    <div class="container">
        <h1>Clinic Details: {{ $clinic->name }}</h1>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Location</h5>
                <p class="card-text">{{ $clinic->location }}</p>
            </div>
        </div>

        <a href="{{ route('clinic.edit', $clinic->id) }}" class="btn btn-warning mt-3">Edit Clinic</a>
        <form action="{{ route('clinic.destroy', $clinic->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete();">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger mt-3">Delete Clinic</button>
        </form>
    </div>
@endsection
