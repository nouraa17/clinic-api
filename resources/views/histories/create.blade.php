@extends('layouts.app')

@section('title', 'Create History')

@section('content')
    <div class="container mb-5">
        <h1>Create New History</h1>
        @if($errors->any())
            @foreach($errors->all() as $error)
                <p class="alert alert-danger mt-2">{{$error}}</p>
            @endforeach
        @endif
        <form action="{{ route('history.store') }}" method="POST">
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
                <label for="chronic_diseases">Chronic diseases</label>
                <textarea name="chronic_diseases" class="form-control" required></textarea>
            </div>

            <div class="form-group mb-2">
                <label for="prescriptions">Prescriptions</label>
                <textarea name="prescriptions" class="form-control" required></textarea>
            </div>

            <div class="form-group mb-2">
                <label for="time">Last Visit Time</label>
                <input type="datetime-local" name="last_visit" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success mt-3">Create History</button>
        </form>
    </div>
@endsection
