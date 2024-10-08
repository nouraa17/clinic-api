@extends('layouts.app')

@section('title', 'Create Feedback')

@section('content')
    <div class="container mb-5">
        <h1>Create New Feedback</h1>
        @if($errors->any())
            @foreach($errors->all() as $error)
                <p class="alert alert-danger mt-2">{{$error}}</p>
            @endforeach
        @endif
        <form action="{{ route('feedback.store') }}" method="POST">
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
                <label for="clinic_id">Clinic</label>
                <select name="clinic_id" class="form-control" required>
                    <option value="">Select a clinic</option>
                    @foreach($clinics as $clinic)
                        <option value="{{ $clinic->id }}">{{ $clinic->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-2">
                <label for="feedback">Feedback</label>
                <textarea name="feedback" class="form-control" required></textarea>
            </div>

            <button type="submit" class="btn btn-success mt-3">Create Feedback</button>
        </form>
    </div>
@endsection
