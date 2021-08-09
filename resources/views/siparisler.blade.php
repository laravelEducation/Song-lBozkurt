@extends(('layouts.master')){{-- @extends dediğimiz zaman layous dosyasının içerisindeki master blade içerisine ekle demek--}}
@section('title', 'Siparisler'){{-- master blade içerisindeki @yield içerisindeki title i kategori olarak yazıdr demek--}}
@section('content'){{--   burada da master blade içerisindeki content içeriisne ekle demek --}}

<div class="container">
    <div class="bg-content">
        <h2>Siparişler</h2>
        @if(count($siparisler)== 0)
        <p>Henüz siparişiniz yok</p>
        @else
        <table class="table table-bordererd table-hover">
            <tr>
                <th>Sipariş Kodu</th>
                <th>Sipariş Tutarı</th>
                <th>Toplam Ürün</th>
                <th>Durum</th>
                <th></th>
            </tr>
            @foreach($siparisler as $siparis)
            <tr>
                <td>SP--{{$siparis->id}}</td>
                <td>{{$siparis->siparis_tutari * ((100+config('cart.tax'))/100)}}</td>
                <td>{{$siparis->sepet->sepet_urun_adet()}}</td>
                <td>{{$siparis-> durum}}</td>


                <td><a href="{{route('siparis', $siparis->id)}}" class="btn btn-sm btn-success">Detay</a></td>
            </tr>
            @endforeach
        </table>
            @endif
    </div>
</div>
@endsection
