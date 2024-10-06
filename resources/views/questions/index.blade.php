@extends('layouts.app')

@section('title', 'Questions List')

@section('content')
    <div class="container mb-5">
        <h1>Questions</h1>
        <form method="GET" action="{{ route('question.index') }}">
            <div class="row">
                <div class="col-md-3">
                    <label>User ID</label>
                    <input type="number" name="user_id" class="form-control" placeholder="User ID" value="{{ request('user_id') }}">
                </div>
                <div class="col-md-3">
                    <label>Date</label>
                    <input type="date" name="filter_start_date" class="form-control" value="{{ request('filter_start_date') }}">
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Filter</button>
            <a href="{{route('question.create')}}" class="btn btn-success mt-3 float-end">Add Question</a>
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
                <th>Question ID</th>
                <th>User ID</th>
                <th>User</th>
                <th>Type</th>
                <th>Question</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($questions as $question)
                <tr>
                    <td>{{ $question->id }}</td>
                    <td>{{ $question->user->id }}</td>
                    <td>{{ $question->user->name }}</td>
                    <td>{{ $question->user->type }}</td>
                    <td>{{ $question->question }}</td>
                    <td>
                        <a href="{{ route('question.show', $question->id) }}" class="btn btn-info mb-2 mb-lg-0">View</a>
                        <a href="{{ route('question.edit', $question->id) }}" class="btn btn-warning mb-2 mb-lg-0">Edit</a>
                        <form action="{{ route('question.destroy', $question->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete();">
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
    {{$questions->links()}}
@endsection

