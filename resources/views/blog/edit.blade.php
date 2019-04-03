@extends('layouts.app')

@section('content')
<div class="container">
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div>
    @endif
    <form method="post" action="{{ route('blog.update', $blog->id) }}">
        @method('PATCH')
        @csrf
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" class="form-control" name="title" value="{{ $blog->title }}" />
        </div>
        <div class="form-group">
            <label for="description">Description :</label>
            <textarea rows="10" class="form-control" name="description" >{{ $blog->description }}</textarea>
        </div>
        @if(Auth::user()->is_admin == 1)
            <div class="form-group">
                <label>Status:</label>
                <label><input type="radio"  name="status" value="1" {{ $blog->status == 1 ? 'checked' : ''}}/> Published</label>
                <label><input type="radio"  name="status" value="-1" {{ !$blog->status == -1 ? 'checked' : ''}}/> Pending</label>
            </div>
            <div class="form-group">
                <label for="title">Schedule publishing:</label>
                <input type="date" class="form-control" name="publish_up" value="{{ $blog->publish_up }}" />
            </div>
        @endif

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
