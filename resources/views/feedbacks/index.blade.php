@extends('layouts.app')

@section('title', 'Feedbacks List')

@section('content')
    <div class="container mb-5">
        <h1>Feedbacks</h1>
        <form method="GET" action="{{ route('feedback.index') }}">
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
                    <label>Date</label>
                    <input type="date" name="filter_start_date" class="form-control" value="{{ request('filter_start_date') }}">
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Filter</button>
            <a href="{{route('feedback.create')}}" class="btn btn-success mt-3 float-end">Add Feedback</a>
        </form>
{{--        <p>{{auth()->user()->type}}</p>--}}

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
                <th>Feedback ID</th>
                <th>Clinic ID</th>
                <th>Clinic</th>
                <th>User ID</th>
                <th>User</th>
                <th>Type</th>
                <th>Feedback</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($feedbacks as $feedback)
                <tr>
                    <td>{{ $feedback->id }}</td>
                    <td>{{ $feedback->clinic->id }}</td>
                    <td>{{ $feedback->clinic->name }}</td>
                    <td>{{ $feedback->user->id }}</td>
                    <td>{{ $feedback->user->name }}</td>
                    <td>{{ $feedback->user->type }}</td>
                    <td>{{ $feedback->feedback }}</td>
                    <td>
                        <a href="{{ route('feedback.show', $feedback->id) }}" class="btn btn-info mb-2 mb-lg-0">View</a>
                        <a href="{{ route('feedback.edit', $feedback->id) }}" class="btn btn-warning mb-2 mb-lg-0">Edit</a>
                        <form action="{{ route('feedback.destroy', $feedback->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete();">
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
    {{$feedbacks->links()}}
@endsection

