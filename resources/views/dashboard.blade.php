@extends('layouts.master')

@section('title', 'Dashboard')

@section('headerStyle')
<!-- Place favicon.ico in the root directory -->
<link rel="stylesheet" media="screen, print" href="{{ url('public/assets/css/miscellaneous/reactions/reactions.css') }}">
<link rel="stylesheet" media="screen, print" href="{{ url('public/assets/css/miscellaneous/fullcalendar/fullcalendar.bundle.css') }}">
<link rel="stylesheet" media="screen, print" href="{{ url('public/assets/css/miscellaneous/jqvmap/jqvmap.bundle.css') }}">
@stop

@section('content')
<!-- the #js-page-content id is needed for some plugins to initialize -->
<main id="js-page-content" role="main" class="page-content">
    <div class="p-4 rounded" style="background-color: #dff1e8">
        <h4 class="text-secondary">Good Evening!</h4>
        <h1 class="mb-0 text-dark font-weight-bold">Welcome Back, {{ ucfirst(auth()->user()->name) }}!<span class="ml-2"><img src="{{ url('public/assets/img/wave.png') }}" alt="wave.png" style="width: 26px; height: 26px;"></span></h1>
    </div>
</main>
@stop

@section('footerScript')

@stop
