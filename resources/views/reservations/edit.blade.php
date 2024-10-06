@extends('layouts.app')

@section('title', 'Edit Reservation')

@section('content')
    <div class="container mb-5">
        @if($errors->any())
            @foreach($errors->all() as $error)
                <p class="alert alert-danger mt-2">{{$error}}</p>
            @endforeach
        @endif
        <h1>Edit Reservation for {{ $reservation->user->name }} at {{ $reservation->clinic->name }}</h1>

        <form action="{{ route('reservation.update', $reservation->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="clinic_id">Clinic</label>
                <select name="clinic_id" class="form-control" required>
                    <option value="">Select a clinic</option>
                    @foreach($clinics as $clinic)
                        <option value="{{ $clinic->id }}" {{ $reservation->clinic_id == $clinic->id ? 'selected' : '' }}>
                            {{ $clinic->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="user_id">User</label>
                <select name="user_id" class="form-control" required>
                    <option value="">Select a user</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $reservation->user_id == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="age">Age</label>
                <input type="text" name="age" class="form-control" value="{{ $reservation->age }}" required>
            </div>

            <div class="form-group">
                <label for="gender">Gender</label>
                <select name="gender" class="form-control" required>
                    <option value="">Select gender</option>
                    <option value="male" {{ $reservation->gender == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ $reservation->gender == 'female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>

            <div class="form-group">
                <label for="specialization">Specialization</label>
                <input type="text" name="specialization" class="form-control" value="{{ $reservation->specialization }}" required>
            </div>

            <div class="form-group">
                <label for="time">Reservation Time</label>
                <input type="datetime-local" name="time" class="form-control" value="{{ \Carbon\Carbon::parse($reservation->time)->format('Y-m-d\TH:i') }}" required>
            </div>

            <button type="submit" class="btn btn-success mt-3">Update Reservation</button>
        </form>
    </div>
@endsection
