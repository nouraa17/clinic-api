@extends('layouts.app')

@section('title', 'Edit Feedback')

@section('content')
    <div class="container mb-5">
        @if($errors->any())
            @foreach($errors->all() as $error)
                <p class="alert alert-danger mt-2">{{$error}}</p>
            @endforeach
        @endif
        <h1>Edit Feedback for {{ $feedback->user->name }}</h1>

        <form action="{{ route('feedback.update', $feedback->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="user_id">User</label>
                <select name="user_id" class="form-control" required>
                    <option value="">Select a user</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $feedback->user_id == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="clinic_id">Clinic</label>
                <select name="clinic_id" class="form-control" required>
                    <option value="">Select a clinic</option>
                    @foreach($clinics as $clinic)
                        <option value="{{ $clinic->id }}" {{ $feedback->clinic_id == $clinic->id ? 'selected' : '' }}>
                            {{ $clinic->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="feedback">Feedback</label>
                <textarea name="feedback" class="form-control" required>{{ $feedback->feedback }}</textarea>
            </div>

            <button type="submit" class="btn btn-success mt-3">Update Feedback</button>
        </form>
    </div>
@endsection
