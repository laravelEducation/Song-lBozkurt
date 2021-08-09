@extends('layouts.master'){{-- @extends dediğimiz zaman layous dosyasının içerisindeki master blade içerisine ekle demek--}}
@section('title', $urun->urun_adi){{-- master blade içerisindeki @yield içerisindeki title i kategori olarak yazıdr demek--}}
@section('content'){{--   burada da master blade içerisindeki content içeriisne ekle demek --}}
<div class="container">
    <ol class="breadcrumb">
        <li><a href="#">Anasayfa</a></li>

        @foreach($urun->kategoriler as $kategori)  {{--  burada biz ürün model içerisinde ürün kategoriyi tanımladığımız için burada kategoriyi çekebilriiz bu şkeilde--}}
        <li><a href="{{route('kategori', $kategori->slug)}}">{{$kategori->kategori_adi}}</a></li>
        @endforeach

        <li class="active">{{$urun->urun_adi}}</li>
    </ol>
    <div class="bg-content">
        <div class="row">
            <div class="col-md-5">
                <img src="http://lorempixel.com/400/200/food/1">
                <hr>
                <div class="row">
                    <div class="col-xs-3">
                        <a href="#" class="thumbnail"><img src="http://lorempixel.com/60/60/food/2"></a>
                    </div>
                    <div class="col-xs-3">
                        <a href="#" class="thumbnail"><img src="http://lorempixel.com/60/60/food/3"></a>
                    </div>
                    <div class="col-xs-3">
                        <a href="#" class="thumbnail"><img src="http://lorempixel.com/60/60/food/4"></a>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <h1>{{$urun->urun_adi}}</h1>
                <p class="price">{{$urun->fiyati}} ₺</p>

                <form action="{{route('sepet.ekle')}}" method="POST">
                    {{csrf_field()}}
                    <input type="hidden" name="id" value="{{$urun->id}}">
                    <input type="submit" class="btn btn-theme" value="Sepete Ekle">
                </form>

            </div>
        </div>

        <div>
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#t1" data-toggle="tab">Ürün Açıklaması</a></li>
                <li role="presentation"><a href="#t2" data-toggle="tab">Yorumlar</a></li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="t1">{{$urun->aciklama}}</div>
                <div role="tabpanel" class="tab-pane" id="t2">Henüz Yorum yapılmadı</div>
            </div>
        </div>

    </div>
</div>
@endsection
