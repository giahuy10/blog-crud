@extends('layouts.app')

@section('content')
    <div class="container">
        <form method="post" action="{{ route('blogs.store') }}">
            <div class="form-group">
                @csrf
                <label for="name">Title:</label>
                <input type="text" class="form-control" name="title"/>
            </div>
            <div class="form-group">
                <label for="price">Description :</label>
                <textarea type="text" class="form-control" name="description"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Add</button>
        </form>
    </div>
@endsection
