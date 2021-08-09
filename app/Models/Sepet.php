<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Sepet extends Model
{
    use SoftDeletes;
    protected $table = 'sepet';
    protected $guarded = [];// TÜM TABLOLARI DOLDURULABİLİR OLDUĞUNU  BİLDİRMEK İÇİN KULLANILIR

    const CREATED_AT = 'oluşturulma_tarihi';//kategori tablosunda türkçe karakter olarak oluşturduğumuz için burada tanıtmamız gerekiyordu
    const UPDATED_AT = 'guncelleme_tarihi';
    const DELETED_AT = 'silinme_tarihi';

    public function siparis()
    {
        return $this ->hasOne('App\Models\Siparis');
    }

    public function sepet_urunler()// siapris detay sayfasını görğntülemek için bu bağlantıyı kullanmılırız
    {
        return $this ->hasMany('App\Models\SepetUrun');
    }

    public static function aktif_sepet_id() // burada sepet işleminde oturum açtıktan sonra sepeti dersgtory et ve tekrar yeni derken oradaki sepette aktif sepeti hep 1. id olarak algılamaması için düzenleyeceğiz
    {
        $aktif_sepet = DB::table('sepet as s')// veritabanındaki sepeti s ile kısalttık
            ->leftJoin('siparis as si', 'si.sepet_id', '=','s.id')// burada ise leftjıin ile sepet id ve siparis id lerinin birleştrime yaptık
            ->where('s.kullanici_id',auth()->id())// aktif kullanicinin id sini çek
            ->whereRaw('si.id is null')// siğaris id si null olanı getir
            ->orderByDesc('s.oluşturulma_tarihi')// olulturma sırasına göre
            ->select('s.id')// ilk siparis id yi al demektir
            ->first();

        if(!is_null($aktif_sepet))
            return$aktif_sepet->id;
    }


    //spete ait ürün adedini hesaplamak için aşağaıdaki kodu kullanırız
    public function sepet_urun_adet()
    {
        return DB::table('sepet_urun')->where('sepet_id', $this->id)->sum('adet');// ürün adet sayısını belirtmek için kullanırız// sum topla demek
    }

}
