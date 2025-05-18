@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
<div class="text-center">
    <h1>Welcome to Culinary Oracle!</h1>
    <p class="lead">Confused about what to eat? Let the Oracle decide for you.</p>
    <a href="{{ route('oracle.pick.view') }}" class="btn btn-success btn-lg">Ask the Oracle Now!</a>
</div>
@endsection