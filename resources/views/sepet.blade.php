@extends(('layouts.master')){{-- @extends dediğimiz zaman layous dosyasının içerisindeki master blade içerisine ekle demek--}}
@section('title', 'Sepet'){{-- master blade içerisindeki @yield içerisindeki title i kategori olarak yazıdr demek--}}
@section('content'){{--   burada da master blade içerisindeki content içeriisne ekle demek --}}
<div class="container">
    <div class="bg-content">
        <h2>Sepet</h2>
        @include('layouts.partials.alert')

        @if(count(Cart::content())>0)
        <table class="table table-bordererd table-hover">
            <tr>
                <th colspan="2">Ürün</th>
                <th>Adet Fiyatı</th>
                <th>Adet</th>
                <th>Tutar</th>

            </tr>

{{--            <tr>--}}
{{--                <td colspan="5">Henüz sepette ürün yok</td>--}}
{{--            </tr>--}}

            @foreach(Cart::content() as $urunCartItem)
            <tr>
                <td style="width: 120px">
                    <a href="{{route('urun', $urunCartItem->options->slug)}}">
                        <img src="http://lorempixel.com/120/100/food/2">
                    </a>
                </td>

                <td>
                    <a href="{{route('urun', $urunCartItem->options->slug)}}">
                    {{$urunCartItem->name}}
                    </a>
                    <form action="{{ route('sepet.kaldir',$urunCartItem->rowId) }}" method="POST">
                        {{csrf_field()}}
                        {{method_field('DELETE')}}
                        <input type="submit" class="btn btn-danger btn-xs" value="Sepetten Kaldır">
                    </form>
                </td>

                <td>{{$urunCartItem->price}} $</td>
                <td>
                    <a href="#" class="btn btn-xs btn-default urun-adet-azalt" data-id="{{$urunCartItem->rowId}}" data-adet="{{$urunCartItem->qty-1}}">-</a>
                    <span style="padding: 10px 20px">{{$urunCartItem->qty}}</span>
                    <a href="#" class="btn btn-xs btn-default urun-adet-artir" data-id="{{$urunCartItem->rowId}}" data-adet="{{$urunCartItem->qty+1}}">+</a>
                </td>

                <td class="text-right">
                    {{$urunCartItem->subtotal}}
                </td>
            </tr>
            @endforeach
            <tr>
                <th colspan="4" class="text-right">Alt Toplam</th>
                <td class="text-right">{{Cart::subtotal()}} $</td>
            </tr>
            <tr>
                <th colspan="4" class="text-right">KDV</th>
                <td class="text-right">{{Cart::tax()}} $</td>
            </tr>
            <tr>
                <th colspan="4" class="text-right">Genel Toplam</th>
                <td class="text-right">{{Cart::total()}} $</td>
            </tr>
        </table>
            <div>

                <form action="{{ route('sepet.bosalt') }}" method="POST">
                    {{csrf_field()}}
                    {{method_field('DELETE')}}
                    <input type="submit" class="btn btn-info btn-lg" value="Sepeti Boşalt">
                </form>

                <a href="{{route('odeme')}}" class="btn btn-success pull-right btn-lg">Ödeme Yap</a>
            </div>
        @else
            <p style="color: red"> Sepetinizde Ürün Yok!</p>
        @endif

    </div>
</div>
@endsection
@section('footer')

    <script>
        require('./bootstrap');

        setTimeout(function (){
            $('.alert').slideUp(500);
        },3000);

        // $.ajaxSetup({
        //     headers:{
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     }
        // });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(function(){


            $('.urun-adet-artir, .urun-adet-azalt').on('click', function (){
                var id = $(this).attr('data-id');
                var adet = $(this).attr('data-adet');

                $.ajax({
                    type: 'PATCH',
                    url: '{{url('sepet/guncelle')}}'+ '/'+ id,
                    data:{adet:adet},
                    success:function (){
                        window.location.href = '{{route('sepet')}}';
                    }
                });
            });
        });

    </script>
@endsection
