<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */


    public function index($slug_kategoriadi)// route üzeirnde biz slug_kategoriadi olarak belirttiğimiz için bunu burdan getiridtiririz
    {
        $kategori=Kategori::where('slug', $slug_kategoriadi)->firstOrFail();// burada firstorfaiil demek eğer veritabanında içerimi yoksa 404notfound hatasını al demek
        $alt_kategoriler = Kategori::where('ust_id', $kategori->id)->get();// alt lkategori başlığını almak için bu şekilde çağırırz.

        $order = request('order');
        if($order == 'coksatanlar')
        {
            $urunler = $kategori->urunler()
                ->distinct()//çift olanları tekte birleşitir
                ->join('urun_detay','urun_detay.urun_id','urun.id')// bağlama
                ->orderBy('urun_detay.goster_cok_satan','desc')//sıralama
                ->paginate(2);
        }

        else if($order == 'yeni')
        {
            $urunler = $kategori->urunler()
                ->distinct()
                ->orderByDesc('guncelleme_tarihi')
                ->paginate(2);
        }

        else
        {
            $urunler =  $kategori->urunler()->paginate(2);
        }


        return view('kategori', compact('kategori','alt_kategoriler','urunler'));

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
