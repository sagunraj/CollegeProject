@extends('layouts.app')
@section('title')
    <title>Upload a New Image - Image Search Engine</title>
@endsection
@section('content')


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Upload a new image</div>

                    <div class="card-body">
                            @if(session('uploaded'))
                                <div class="alert alert-success">
                                {!! session('uploaded') !!}
                                </div>
                            @endif
                            @if($errors)
                                {!! $errors->first() !!}
                            @endif
                            <form class="form-group" action="{!! route('admin.store') !!}" method="post" enctype="multipart/form-data">
                                {!! csrf_field() !!}
                                <input type="file" class="form-control" name="image"/>
                                <input class="btn btn-primary" style="margin-top: 1em; margin-left: 44%;" type="submit"/>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

