@extends('layouts.app')

@section('title', 'Reservations List')

@section('content')
    <div class="container mb-5">
        <h1>Reservations</h1>
        <form method="GET" action="{{ route('reservation.index') }}">
            <div class="row">
                <div class="col-md-3">
                    <label>User ID</label>
                    <input type="number" name="user_id" class="form-control" placeholder="User ID" value="{{ request('user_id') }}">
                </div>
                <div class="col-md-3">
                    <label>Clinic ID</label>
                    <input type="number" name="clinic_id" class="form-control" placeholder="Clinic ID" value="{{ request('clinic_id') }}">
                </div>
                <div class="col-md-3">
                    <label>Age</label>
                    <input type="number" name="age" class="form-control" placeholder="Age" value="{{ request('age') }}">
                </div>
                <div class="col-md-3">
                    <label>Gender</label>
                    <input type="text" name="gender" class="form-control" placeholder="Gender" value="{{ request('gender') }}">
                </div>
                <div class="col-md-3">
                    <label>Reservation Date</label>
                    <input type="date" name="filter_start_date" class="form-control" value="{{ request('filter_start_date') }}">
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Filter</button>
            <a href="{{route('reservation.create')}}" class="btn btn-success mt-3 float-end">Add Reservation</a>
        </form>

        @if($errors->any())
            @foreach($errors->all() as $error)
                <p class="alert alert-danger mt-2">{{$error}}</p>
            @endforeach
        @endif

        @if(session('success'))
            <p class="alert alert-success mt-2">{{session('success')}}</p>
        @endif

        <table class="table mt-2">
            <thead>
            <tr>
                <th>User ID</th>
                <th>User</th>
                <th>Clinic</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Specialization</th>
                <th>Time</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($reservations as $reservation)
                <tr>
                    <td>{{ $reservation->user->id }}</td>
                    <td>{{ $reservation->user->name }}</td>
                    <td>{{ $reservation->clinic->name }}</td>
                    <td>{{ $reservation->age }}</td>
                    <td>{{ $reservation->gender }}</td>
                    <td>{{ $reservation->specialization }}</td>
                    <td>{{ \Carbon\Carbon::parse($reservation->time)->format('Y-m-d H:i:s') }}</td>
                    <td>
                        <a href="{{ route('reservation.show', $reservation->id) }}" class="btn btn-info mb-2 mb-lg-0">View</a>
                        <a href="{{ route('reservation.edit', $reservation->id) }}" class="btn btn-warning mb-2 mb-lg-0">Edit</a>
                        <form action="{{ route('reservation.destroy', $reservation->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete();">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger text-dark">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    {{$reservations->links()}}
@endsection

