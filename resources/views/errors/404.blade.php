@extends('layouts.master'){{-- @extends dediğimiz zaman layous dosyasının içerisindeki master blade içerisine ekle demek--}}
@section('content'){{--   burada da master blade içerisindeki content içeriisne ekle demek --}}
<div class ="container">
    <div class="jumbotron text-center">
    <h1> 404</h1>
    <h2> Aradığınız sayfa bulunamadı</h2>
    <a href="{{route('anasayfa')}}" class="btn btn-primary">Anasayfa'ya Dön</a>
</div></div>
@endsection
