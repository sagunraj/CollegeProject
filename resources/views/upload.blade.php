@extends('layout')

@section('content')
<form action="{!! route('admin.store') !!}" method="post" enctype="multipart/form-data">
    {!! csrf_field() !!}
    <input type="file" name="image"/>
    <input type="submit"/>
</form>
    @endsection