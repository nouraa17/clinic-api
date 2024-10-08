@extends('layouts.app')

@section('title', 'Histories List')

@section('content')
    <div class="container mb-5">
        <h1>Histories</h1>
        <form method="GET" action="{{ route('history.index') }}">
            <div class="row">
                <div class="col-md-3">
                    <label>User ID</label>
                    <input type="number" name="user_id" class="form-control" placeholder="User ID" value="{{ request('user_id') }}">
                </div>
                <div class="col-md-3">
                    <label>Start Date</label>
                    <input type="date" name="filter_start_date" class="form-control" value="{{ request('filter_start_date') }}">
                </div>
                <div class="col-md-3">
                    <label>Last Visit Date</label>
                    <input type="date" name="last_visit" class="form-control" value="{{ request('last_visit') }}">
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Filter</button>
            <a href="{{route('history.create')}}" class="btn btn-success mt-3 float-end">Add History</a>
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
                <th>ID</th>
                <th>User ID</th>
                <th>User</th>
                <th>Chronic diseases</th>
                <th>Prescriptions</th>
                <th>Last Visit</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($histories as $history)
                <tr>
                    <td>{{ $history->id }}</td>
                    <td>{{ $history->user->id }}</td>
                    <td>{{ $history->user->name }}</td>
                    <td>{{ $history->chronic_diseases }}</td>
                    <td>{{ $history->prescriptions }}</td>
                    <td>{{ \Carbon\Carbon::parse($history->last_visit)->format('Y-m-d H:i:s') }}</td>
                    <td>
                        <a href="{{ route('history.show', $history->id) }}" class="btn btn-info mb-2 mb-lg-0">View</a>
                        <a href="{{ route('history.edit', $history->id) }}" class="btn btn-warning mb-2 mb-lg-0">Edit</a>
                        <form action="{{ route('history.destroy', $history->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete();">
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
    {{$histories->links()}}
@endsection

