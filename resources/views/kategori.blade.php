@extends(('layouts.master')){{-- @extends dediğimiz zaman layous dosyasının içerisindeki master blade içerisine ekle demek--}}
@section('title', $kategori->kategori_adi){{-- master blade içerisindeki @yield içerisindeki title i kategori olarak yazıdr demek--}}
@section('content'){{--   burada da master blade içerisindeki content içeriisne ekle demek --}}

<div class="container">
    <ol class="breadcrumb">
        <li><a href="{{route('anasayfa')}}">Anasayfa</a></li>
        <li><a href="#">{{$kategori->kategori_adi}}</a></li>

    </ol>
    <div class="row">
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">{{$kategori->kategori_adi}}</div>
                <div class="panel-body">
                    @if(count($alt_kategoriler)>0)
                    <h3>Alt Kategoriler</h3>
                    <div class="list-group categories">

                        @foreach($alt_kategoriler as $alt_kategori)
                        <a href="{{route('kategori', $alt_kategori->slug)}}" class="list-group-item"><i class="fa fa-arrow-circle-right"></i> {{$alt_kategori->kategori_adi}}</a>
                        @endforeach
                    </div>

                    @else
                        <b style="color: red">Bu kategoride henüz alt kategori eklenmemiştir!</b>

                        @endif
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="products bg-content">
                @if(count($urunler)>0)

                Sırala

                <a href="?order=coksatanlar" class="btn btn-default">Çok Satanlar</a>
                <a href="?order=yeni" class="btn btn-default">Yeni Ürünler</a>
                <hr>

                @endif
                <div class="row">

                    @if(count($urunler)==0)
                        <div class="col-md-12" style="color: red" ><b>Bu kategoride henüz ürün eklenmemiştir!</b></div>
                    @endif
                    @foreach($urunler as $urun)

                    <div class="col-md-3 product">
                        <a href="{{route('urun', $urun->slug)}}"><img src="http://lorempixel.com/400/400/food/1"></a>
                        <p><a href="{{route('urun', $urun->slug)}}">{{$urun->urun_adi}}</a></p>
                        <p class="price">{{$urun->fiyati}} ₺</p>
                        <p><a href="#" class="btn btn-theme">Sepete Ekle</a></p>
                    </div>
                    @endforeach
                </div>
                    {{request()->has('order') ? $urunler->appends(['order'=>request('order')])->links() : $urunler->links()}}
              {{-- burada kategori kontrollerdn herhangi bir order isteiği almışşsak sayfalamayı ona göre yap eğer değilse daha önceki ürünlerin  sayfalamasını yap demek--}}
            </div>
        </div>
    </div>
</div>
@endsection
