@extends('layouts.app')

@section('content')
<div class="container">
    @if(session()->get('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif
    @if(session()->get('error'))
        <div class="alert alert-warning">
            {{ session()->get('error') }}
        </div>
    @endif
    <a href="{{ route('blog.create')}}" class="btn btn-info">Create blog</a><br><br>
    @if(Auth::user() && Auth::user()->is_admin)
        <div class="filter-box alert alert-info ">
            <h2>Filter blog</h2>
            <form action="/">
                <div class="form-group">
                    <label>Order by:</label>

                    <label><input type="radio"  name="order_by" value="status"  {{app('request')->input('order_by') == 'status' ? 'checked' : ''}}/> Status</label>
                    <label><input type="radio"  name="order_by" value="created_at" {{app('request')->input('order_by') == 'created_at' ? 'checked' : ''}} /> Date</label>
                </div>
                <div class="form-group">
                    <label>Sort by:</label>
                    <label><input type="radio"  name="sort_by" value="asc" {{app('request')->input('sort_by') == 'asc' ? 'checked' : ''}} /> Asc</label>
                    <label><input type="radio"  name="sort_by" value="desc" {{app('request')->input('sort_by') == 'desc' ? 'checked' : ''}}/> Desc</label>
                </div>
                <button type="submit" class="btn btn-primary">Fillter</button>
            </form>
        </div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Status</th>
                <th>Created</th>
                @if(Auth::user())
                    <th colspan="2">Action</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($items as $blog)
            <tr class="{{$blog->status == -1 ? 'table-warning': ''}}">
                <td>{{$blog->id}}</td>
                <td><a href="{{ route('blog.show',$blog->id)}}">{{$blog->title}}</a></td>
                <td>{{$blog->status == 1 ? 'Published' : 'Pending'}}</td>
                <td>{{date("Y-m-d", strtotime($blog->created_at))}}</td>
                @if(Auth::user() && (Auth::user()->id == $blog->user_id || Auth::user()->is_admin == 1))
                    <td>

                        <a href="{{ route('blog.edit',$blog->id)}}" class="btn btn-primary">Edit</a>
                        <form style="display: inline-block" action="{{ route('blog.destroy', $blog->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">Delete</button>
                        </form>

                    </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
