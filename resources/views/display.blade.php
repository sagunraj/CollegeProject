@extends('layouts.app')
@section('title')
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Uploaded images</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="row">
                        @foreach($images as $image)
                            <div class="col-md-4" style="margin: 0 0 5px 0">
                                <div class="img-thumbnail" >
                                <img style="padding: 5px 5px 5px 5px" width="100%" src="{!! asset('images/'.$image->image) !!}"/>
                                    <form method="POST" action="{!! route('admin.delete', $image->id) !!}">
                                        {!! method_field('DELETE') !!}
                                        {!! csrf_field() !!}
                                        <div style="text-align: right;">
                                            <button type="submit" id="deleteicon" class="fas fa-trash-alt"></button></div>

                                    </form>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div style="margin: 0 50% 0 50%">
                            {{$images->links()}}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
