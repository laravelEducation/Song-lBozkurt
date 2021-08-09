<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SepetUrun extends Model
{
    use SoftDeletes;
    protected $table = 'sepet_urun';
    protected $guarded = [];// TÜM TABLOLARI DOLDURULABİLİR OLDUĞUNU  BİLDİRMEK İÇİN KULLANILIR
    const CREATED_AT = 'oluşturulma_tarihi';//kategori tablosunda türkçe karakter olarak oluşturduğumuz için burada tanıtmamız gerekiyordu
    const UPDATED_AT = 'guncelleme_tarihi';
    const DELETED_AT = 'silinme_tarihi';

    public function urun()
    {
        return $this ->belongsTo('App\Models\Urun');
    }
}
