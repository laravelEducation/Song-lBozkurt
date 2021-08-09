<?php

namespace App\Http\Controllers;

use App\Models\Sepet;
use App\Models\Siparis;
use Illuminate\Http\Request;

class SiparisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $siparisler = Siparis::with('sepet')// kullanici id sine göre biz siparisl durumunu çekiyoruz biz burdağğ

            ->whereHas('sepet', function($query)
        {
            $query->where( 'kullanici_id',auth()->id() );
        })
            ->orderByDesc('olusturulma_tarihi')
            ->get();

        return view('siparisler', compact('siparisler'));
    }


    public function detay($id)
    {


        $siparis = Siparis::with('sepet.sepet_urunler.urun')
            ->whereHas('sepet', function($query)
            {
                $query->where( 'kullanici_id',auth()->id() );
            })
            ->where('siparis.id',$id)
            ->firstOrFail();// ilk veriyi çek yoksa da hata sayfasını döndür// with ile sepet bilgisini, urun bilgisinide sepetteki urunleri de   de elde etmiş oluruz


        return view('siparis', compact('siparis'));
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
