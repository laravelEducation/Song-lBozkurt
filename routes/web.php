<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'App\Http\Controllers\AnasayfaController@index')->name('anasayfa');

//Route::view('/kategori','kategori');//kategori yazdığımız zaman url e kategori view ini göster demiş olacağız
Route::get('/kategori/{slug_kategoriadi}', 'App\Http\Controllers\KategoriController@index')->name('kategori');//->name() dediğimiz zaman bu route a isim tanıtığımız anlamına gelir
Route::get('/urun/{slug_urunadi}', 'App\Http\Controllers\UrunController@index')->name('urun');//->name() dediğimiz zaman bu route a isim tanıtığımız anlamına gelir

Route::group(['prefix'=>'sepet'], function (){ // burada da kullanici routunu gruplandırmak için lkullanırız
    Route::get('/', 'App\Http\Controllers\SepetController@index')->name('sepet');//->middleware('auth');//->name() dediğimiz zaman bu route a isim tanıtığımız anlamına gelir
    Route::post('/ekle', 'App\Http\Controllers\SepetController@ekle')->name('sepet.ekle');//->middleware('auth');//->name() dediğimiz zaman bu route a isim tanıtığımız anlamına gelir
    Route::delete('/kaldir{rowid}', 'App\Http\Controllers\SepetController@kaldir')->name('sepet.kaldir');//->middleware('auth');//->name() dediğimiz zaman bu route a isim tanıtığımız anlamına gelir
    Route::delete('/bosalt', 'App\Http\Controllers\SepetController@bosalt')->name('sepet.bosalt');//->middleware('auth');//->name() dediğimiz zaman bu route a isim tanıtığımız anlamına gelir
    Route::patch('/guncelle/{rowid}', 'App\Http\Controllers\SepetController@guncelle')->name('sepet.guncelle');//burada sepetteki ürünü arttırma  veya  attırma işlemi yaptığımız zaman bu işlemi güncelleme de tutmak için kullanırız

});

Route::get('/odeme', 'App\Http\Controllers\OdemeController@index')->name('odeme');//->name() dediğimiz zaman bu route a isim tanıtığımız anlamına gelir
Route::post('/odeme', 'App\Http\Controllers\OdemeController@odemeyap')->name('odemeyap');//->name() dediğimiz zaman bu route a isim tanıtığımız anlamına gelir

Route::group(['middleware'=> 'auth'], function (){
    Route::get('/siparisler', 'App\Http\Controllers\SiparisController@index')->name('siparisler');//->name() dediğimiz zaman bu route a isim tanıtığımız anlamına gelir
    Route::get('/siparisler/{id}', 'App\Http\Controllers\SiparisController@detay')->name('siparis');//->name() dediğimiz zaman bu route a isim tanıtığımız anlamına gelir
});


Route::get('/kullanici/oturumac', 'App\Http\Controllers\KullaniciController@giris_form')->name('kullanici.oturumac');//->name() dediğimiz zaman bu route a isim tanıtığımız anlamına gelir
Route::get('/kullanici/kaydol', 'App\Http\Controllers\KullaniciController@kaydol_form')->name('kullanici.kaydol');//->name() dediğimiz zaman bu route a isim tanıtığımız anlamına gelir
Route::post('/ara','App\Http\Controllers\UrunController@ara')->name('urun_ara');
Route::get('/ara','App\Http\Controllers\UrunController@ara')->name('urun_ara');


Route::group(['prefix'=>'kullanici'], function (){ // burada da kullanici routunu gruplandırmak için lkullanırız
    Route::get('/oturumac', 'App\Http\Controllers\KullaniciController@giris_form')->name('kullanici.oturumac');//->name() dediğimiz zaman bu route a isim tanıtığımız anlamına gelir
    Route::post('/oturumac', 'App\Http\Controllers\KullaniciController@giris');//->name() dediğimiz zaman bu route a isim tanıtığımız anlamına gelir
    Route::get('/kaydol', 'App\Http\Controllers\KullaniciController@kaydol_form')->name('kullanici.kaydol');//->name() dediğimiz zaman bu route a isim tanıtığımız anlamına gelir
    Route::post('/kaydol', 'App\Http\Controllers\KullaniciController@kaydol');//->name() dediğimiz zaman bu route a isim tanıtığımız anlamına gelir
    Route::get('/aktiflestir/{anahtar}', 'App\Http\Controllers\KullaniciController@aktiflestir')->name('aktiflestir');//->name() dediğimiz zaman bu route a isim tanıtığımız anlamına gelir
    Route::post('/oturumkapat', 'App\Http\Controllers\KullaniciController@oturumukapat')->name('kullanici.oturumukapat');//->name() dediğimiz zaman bu route a isim tanıtığımız anlamına gelir

});

Route::get('/test/mail', function (){
    $kullanici = App\Models\Kullanici::find(1);//kullanici bilgilerini çekmek için kullanırız ve kullanici kayit blade nin de kullanici->adsoyad çekebiliriz
    return new App\Mail\KullaniciKayitMail($kullanici);
});
//
//Route::view('/urun','urun');
//Route::view('/sepet','sepet');

