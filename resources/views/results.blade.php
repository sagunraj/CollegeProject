@extends('layout')
@section('title')
    <title>Search Results for '{!! $queryString !!}'</title>
    @endsection
@section('content')
    <h2>Search Results for '{!! $queryString !!}'</h2>
    @foreach($imageModel as $image)
        <ul>
            <li style="list-style-type: none;"><img src="{!! asset('images/'.$image->image) !!}"/></li>
        </ul>
    @endforeach
@endsection