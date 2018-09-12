@extends('layout')
@section('title')
    <title>Search Results for '{!! $queryString !!}' - Image Search Engine</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
          integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="{!! asset("css/customcss.css") !!}">

@endsection
@section('content')
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    Image Search Engine
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>
        <div class="container">
            <form action="{!! route('search.store', 'q') !!}" method="GET" role="search" class="form-group">
                <div class="row">
                    <div class="col-md-11">
                        <input placeholder="Enter your query here" value={!! $queryString !!} name='q' type="text"
                               class="form-control">

                    </div>
                    <div class="col-md-1">
                        <button style="float:right;" type="submit" id="searchicon"
                                class="search_icon fas fa-search"></button>
                    </div>
                </div>
            </form>


        <h2>Search Results for '{!! $queryString !!}'</h2>
            <div class="row">
                @for($i=0; $i<=sizeof($finalResults)-1; $i++)
                    <div class="col-md-6" style="margin: 0 0 5px 0;">
                        <a href="{!! asset('images/'.$finalResults[$i]) !!}" target="_blank">

                        <div class="img-thumbnail" style="background: #e2e2e2;" >
                            <p class="text-center figure-caption">Keyword: {!! $wordResults[$i] !!}</p>
                            <img style="padding: 5px 5px 5px 5px" width="100%" src="{!! asset('images/'.$finalResults[$i]) !!}"/>
                        </div>
                        </a>

                    </div>
                @endfor
            </div>
    </div>
        <footer class="footer">Developed in Samriddhi College.</footer>

@endsection