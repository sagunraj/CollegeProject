@extends('layout')
@section('title')
    <title>Search Results for '{!! $queryString !!}' - Image Search Engine</title>
    @endsection
@section('content')
    <h2>Search Results for '{!! $queryString !!}'</h2>
    @foreach($finalResults as $finalResult)
        <ul>
            <li style="list-style-type: none;"><img src="{!! asset('images/'.$finalResult) !!}"/></li>
        </ul>
    @endforeach
@endsection