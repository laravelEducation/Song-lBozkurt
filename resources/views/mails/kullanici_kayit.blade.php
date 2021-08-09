<h1> {{config('app.name')}}</h1>
<p> merhaba: {{$kullanici->adsoyad}}, Kaydınız Başarılı bir şekilde yapıldı</p>
<p> Kaydınızı aktifleştirmek iiçin <a href="{{config('app.url')}}/kullanici/aktiflestir/{{$kullanici->aktivasyon_anahtari}}" >Tıklayın</a>
    veya aşağıdaki gibi bağlantıyı trayıcınızda acin</p>
<p> {{config('app.url')}}/kullanici/aktiflestir/{{$kullanici->aktivasyon_anahtari}}</p>
