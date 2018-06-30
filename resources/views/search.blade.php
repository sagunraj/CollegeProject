@extends('layout')

@section('content')
    @if($errors)
        <h2>{!! $errors->first() !!}</h2>
    @endif
    <form action="{!! route('search.store', 'q') !!}" method="GET" role="search">
        <input type="text" name="q" placeholder="Enter your query"/>
        <input type="submit" value="Search"/>
    </form>
@endsection