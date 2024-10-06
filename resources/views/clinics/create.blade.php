@extends('layouts.app')

@section('title', 'Clinics Create')

@section('content')
    <div class="container mb-5">
        <h1>Create New Clinic</h1>
        @if($errors->any())
            @foreach($errors->all() as $error)
                <p class="alert alert-danger mt-2">{{$error}}</p>
            @endforeach
        @endif
        <form action="{{ route('clinic.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Clinic Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter clinic name">
            </div>

            <div class="form-group">
                <label for="location">Location</label>
                <textarea name="location" class="form-control" placeholder="Enter clinic location"></textarea>
            </div>

            <button type="submit" class="btn btn-success mt-3">Create Clinic</button>
        </form>
    </div>
@endsection
