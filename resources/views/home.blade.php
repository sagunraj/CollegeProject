@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <a class="btn btn-primary" href="{!! route('admin.upload') !!}">Upload new image</a>
                    <a class="btn btn-danger" href="{!! route('admin.index') !!}">View Images</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
