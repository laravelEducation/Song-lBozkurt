<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class KullaniciDetay extends Model
{

    protected $table = 'kullanici_detay';
    public $timestamps =false;
    protected $guarded = [];// TÜM TABLOLARI DOLDURULABİLİR OLDUĞUNU  BİLDİRMEK İÇİN KULLANILIR

    public function kullanici()
    {
        return $this ->belongsTo('App\Models\Kullanici');
    }
}
