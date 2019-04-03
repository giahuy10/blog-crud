@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{$blog->title}}</h1>
    <div class="content">
        @markdown($blog->description)
    </div>
</div>
@endsection
