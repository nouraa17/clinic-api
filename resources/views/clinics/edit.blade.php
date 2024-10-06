@extends('layouts.app')

@section('title', 'Clinics Edit')


@section('content')
    <div class="container mb-5">
        @if($errors->any())
            @foreach($errors->all() as $error)
                <p class="alert alert-danger mt-2">{{$error}}</p>
            @endforeach
        @endif
        <h1>Edit Clinic: {{ $clinic->name }}</h1>

        <form action="{{ route('clinic.update', $clinic->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Clinic Name</label>
                <input type="text" name="name" class="form-control" value="{{ $clinic->name }}">
            </div>

            <div class="form-group">
                <label for="location">Location</label>
                <textarea name="location" class="form-control">{{ $clinic->location }}</textarea>
            </div>

            <button type="submit" class="btn btn-success mt-3">Update Clinic</button>
        </form>
    </div>
@endsection
