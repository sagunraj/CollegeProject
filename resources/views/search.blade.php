@extends('layout')
@section('title')
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="{!! asset("css/customcss.css") !!}">
    <title>Image Search Engine</title>
    @endsection
@section('content')
    @if($errors)
        <h2>{!! $errors->first() !!}</h2>
    @endif

    <div class="container-fluid">
        <div class="row" >
            <div class="col-md-12 centered">
                <div class="center_text">
                    <h1 id="title_text" style="text-align: center">Image Search Engine</h1>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <form action="{!! route('search.store', 'q') !!}" method="GET" role="search" class="form-group">
                    <div class="row">
                        <div class="col-md-11">
                            <input placeholder="Enter your query here" name='q' type="text" class="form-control">
                        </div>

                <div class="col-md-1">
                    <button type="submit" id="searchicon" class="search_icon fas fa-search"></button>
                </div>
            </div>

            </form>
        </div>
    </div>
    <footer class="footer">Developed in Samriddhi College.</footer>
    </div>
@endsection