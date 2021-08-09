<?php

namespace App\Mail;

use App\Models\Kullanici;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class KullaniciKayitMail extends Mailable
{
    use Queueable, SerializesModels;
    public $kullanici;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( Kullanici  $kullanici)
    {
        $this->kullanici= $kullanici;// kullanıcının kimliğini bilmek için kullanırlır ve public diyerek global olarak tanıtmak istiyoruz
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
          //  ->from('gulacarken.02@gmail.com.')// gönderilecek mail adresi bunu config mail dosa-yasında ayarlaidik
            ->subject(config('app.name'). '- Kullanıcı Kaydı')//uygulama adı  ve kullanıcı kaydı başlığını ayarşalırz
            ->view('mails.kullanici_kayit');
    }
}
