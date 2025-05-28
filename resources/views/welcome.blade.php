@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
<div class="text-center">
    <h1>Selamat Datang di Dapur Gaib</h1>
    <p class="lead">Bingung mau makan apa? Biar Dapur Gaib yang merekomendasikanmu</p>
    <a href="{{ route('oracle.pick.view') }}" class="btn btn-success btn-lg">Tanya Sekarang</a>
</div>
@endsection