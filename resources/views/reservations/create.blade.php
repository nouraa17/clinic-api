@extends('layouts.app')

@section('title', 'Create Reservation')

@section('content')
    <div class="container mb-5">
        <h1>Create New Reservation</h1>
        @if($errors->any())
            @foreach($errors->all() as $error)
                <p class="alert alert-danger mt-2">{{$error}}</p>
            @endforeach
        @endif
        <form action="{{ route('reservation.store') }}" method="POST">
            @csrf
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
                <label for="user_id">User</label>
                <select name="user_id" class="form-control" required>
                    <option value="">Select a user</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-2">
                <label for="age">Age</label>
                <input type="text" name="age" class="form-control" placeholder="Enter age" required>
            </div>

            <div class="form-group mb-2">
                <label for="gender">Gender</label>
                <select name="gender" class="form-control" required>
                    <option value="">Select gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>

            <div class="form-group mb-2">
                <label for="specialization">Specialization</label>
                <input type="text" name="specialization" class="form-control" placeholder="Enter specialization" required>
            </div>

            <div class="form-group mb-2">
                <label for="time">Reservation Time</label>
                <input type="datetime-local" name="time" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success mt-3">Create Reservation</button>
        </form>
    </div>
@endsection
