@extends('layouts.app')

@section('title', 'Clinics List')

@section('content')
    <div class="container mb-5">
        <h1>Clinics</h1>
        <form method="GET" action="{{ route('clinic.index') }}">
            <div class="row">
                <div class="col-md-3">
                    <label>Clinic Name</label>
                    <input type="text" name="filter_name" class="form-control" placeholder="Clinic Name" value="{{ request('filter_name') }}">
                </div>
                <div class="col-md-3">
                    <label>Clinic Location</label>
                    <input type="text" name="location" class="form-control" placeholder="Location" value="{{ request('location') }}">
                </div>
                <div class="col-md-3">
                    <label>Clinic Start Date</label>
                    <input type="date" name="filter_start_date" class="form-control" placeholder="Start Date" value="{{ request('filter_start_date') }}">
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Filter</button>
            <a href="{{route('clinic.create')}}" class="btn btn-success mt-3 float-end">Add Clinic</a>
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
                <th>ID</th>
                <th>Name</th>
                <th>Location</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($clinics as $clinic)
                <tr>
                    <td>{{ $clinic->id }}</td>
                    <td>{{ $clinic->name }}</td>
                    <td>{{ $clinic->location }}</td>
                    <td>{{ $clinic->created_at }}</td>
                    <td>
                        <a href="{{ route('clinic.show', $clinic->id) }}" class="btn btn-info mb-2 mb-lg-0">View</a>
                        <a href="{{ route('clinic.edit', $clinic->id) }}" class="btn btn-warning mb-2 mb-lg-0">Edit</a>
                        <form action="{{ route('clinic.destroy', $clinic->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete();">
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
    {{$clinics->links()}}
@endsection

