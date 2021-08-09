<?php

namespace App\Http\Controllers;

use App\Models\Sepet;
use App\Models\SepetUrun;
use App\Models\Urun;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Validator;

class SepetController extends Controller
{
//    public function __construct()
//    {
//        $this ->middleware('auth');
//    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
          return view('sepet');
    }

    public function ekle()
    {
        $urun = Urun::find(request('id'));
        $cartItem =  Cart::add($urun->id, $urun->urun_adi, 1 , $urun->fiyati, 0,['slug' =>$urun->slug]);

        if(auth()->check()) // burada sepettteki ürünleri oturum kappatıldığında da da veri tabanında tutulması ve oturum açtıldığına da sepette ürünlerin gözükmesini sağlar
        {
            $aktif_sepet_id =session('aktif_sepet_id');
            if(!isset($aktif_sepet_id))// eğer aktif sepet id si yoksa create yani sepeti oluşturuyoruz varsa da eski sepeti çağıracağız
            {
                $aktif_sepet = Sepet::create(['kullanici_id' =>auth()->id()]);
                $aktif_sepet_id = $aktif_sepet->id;
                session()->put('aktif_sepet_id', $aktif_sepet_id);
            }

            SepetUrun::updateOrCreate( //  yukarıdaki if komutunda epee sepette ürün yoksa oluşturturduk, updateorcreate methodu ise eğet sepette ürün varsa bunları tanımla, yoksa da if döngüsünden sonra oluştutduğumuz ürünleri günceller, varsa çıkarıryoksa da oluştururur gibi bişi
                ['sepet_id'=>$aktif_sepet_id, 'urun_id'=> $urun->id],
                ['adet'=>$cartItem->qty, 'fiyati'=>$urun->fiyati, 'durum'=> 'beklemede']
            );


        }

        return redirect()->route('sepet')
            ->with('mesaj_tur','success')
            ->with('mesaj', 'Ürün Sepete Eklendi');

    }

    public  function kaldir($rowid)
    {
        if(auth()->check())
        {
            $aktif_sepet_id = session('aktif_sepet_id');
            $cartItem = Cart::get($rowid);

            SepetUrun::where('sepet_id',$aktif_sepet_id)->where('urun_id', $cartItem->id)->Delete();
        }
        Cart::remove($rowid);
        return redirect()->route('sepet')
        ->with('mesaj_tur', 'succes')
        ->with('mesaj', 'Ürün Sepettn kaldırırldı');

    }

    public function bosalt()
    {
        if(auth()->check())
        {
            $aktif_sepet_id = session('aktif_sepet_id');

            SepetUrun::where('sepet_id',$aktif_sepet_id)->Delete();
        }
        Cart::destroy();
        return redirect()->route('sepet')
            ->with('mesaj_tur', 'success')
            ->with('mesaj', 'Sepetiniz Boşaltıldı');
    }

    public function guncelle($rowid)
    {
        $validator = Validator::make(request()->all(),[
            'adet'=> 'required|numeric|between:1,5'
        ]);

        if($validator->fails())
       {
        session()->flash('mesaj_tur','danger');
        session()->flash('mesaj', 'Adet değeri 1 ile 5 arasaında olmalıdrı');

        return response()->json(['success'=> false]);
       }
        if(auth()->check())
        {
            $aktif_sepet_id = session('aktif_sepet_id');
            $cartItem = Cart::get($rowid);

            if(request('adet')==0)
            SepetUrun::where('sepet_id',$aktif_sepet_id)->where('urun_id', $cartItem->id)->Delete();

            else
            SepetUrun::where('sepet_id',$aktif_sepet_id)->where('urun_id', $cartItem->id)->Update(['adet'=>request('adet')]);


        }

        Cart::update($rowid, request('adet'));

        session()->flash('mesaj_tur', 'success');
        session()->flash('mesaj','Adet bilgisini Güncellendi');

        return response()->json(['success'=>true]);

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
