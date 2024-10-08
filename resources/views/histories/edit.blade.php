@extends('layouts.app')

@section('title', 'Edit History')

@section('content')
    <div class="container mb-5">
        @if($errors->any())
            @foreach($errors->all() as $error)
                <p class="alert alert-danger mt-2">{{$error}}</p>
            @endforeach
        @endif
        <h1>Edit History for {{ $history->user->name }}</h1>

        <form action="{{ route('history.update', $history->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="user_id">User</label>
                <select name="user_id" class="form-control" required>
                    <option value="">Select a user</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $history->user_id == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="chronic_diseases">Chronic diseases</label>
                <textarea name="chronic_diseases" class="form-control" required>{{ $history->chronic_diseases }}</textarea>
            </div>

            <div class="form-group">
                <label for="prescriptions">Prescriptions</label>
                <textarea name="prescriptions" class="form-control" required>{{ $history->prescriptions }}</textarea>
            </div>

            <div class="form-group">
                <label for="time">Last Visit Time</label>
                <input type="datetime-local" name="last_visit" class="form-control" value="{{ \Carbon\Carbon::parse($history->last_visit)->format('Y-m-d\TH:i') }}" required>
            </div>

            <button type="submit" class="btn btn-success mt-3">Update History</button>
        </form>
    </div>
@endsection
