@extends('layout')
@section('title')
    <title>Upload</title>
@endsection
@section('content')
    @if(session('uploaded'))
        {!! session('uploaded') !!}
    @endif
    @if($errors)
        {!! $errors->first() !!}
        @endif
<form action="{!! route('admin.store') !!}" method="post" enctype="multipart/form-data">
    {!! csrf_field() !!}
    <input type="file" name="image"/>
    <input type="submit"/>
</form>
    @endsection