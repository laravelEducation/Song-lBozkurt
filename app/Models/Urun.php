<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Urun extends Model
{
    use SoftDeletes;
    protected $table = 'urun';
    protected $guarded = [];// TÜM TABLOLARI DOLDURULABİLİR OLDUĞUNU  BİLDİRMEK İÇİN KULLANILIR
    const CREATED_AT = 'oluşturulma_tarihi';//kategori tablosunda türkçe karakter olarak oluşturduğumuz için burada tanıtmamız gerekiyordu
    const UPDATED_AT = 'guncelleme_tarihi';
    const DELETED_AT = 'silinme_tarihi';


    public function kategoriler()
    {
        return $this->belongsToMany('App\Models\Kategori', 'kategori_urun'); // kategori_urun tablosunun modelini oluşturmadan foreign yapısını kullanmak için bu kodu model içeriisnde yazarız, anlamı kategori modeli içerisndeki kategori_urun ile  foreign yapısını oluşturtur
    }
    public function detay()
    {
        return $this->hasOne('App\Models\UrunDetay');
    }

}
