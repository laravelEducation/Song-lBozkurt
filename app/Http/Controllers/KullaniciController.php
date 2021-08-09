<?php

namespace App\Http\Controllers;

use App\Mail\KullaniciKayitMail;
use App\Models\Kullanici;
use App\Models\KullaniciDetay;
use App\Models\Sepet;
use App\Models\SepetUrun;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class KullaniciController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function __construct()
    {
        $this ->middleware('guest')->except('oturumukapat');// kullanıcı kontroller fonksiyonuna sadece gusetler ulaşabilsin oturumu kapat methodu hariç
    }

    public function giris_form()
    {
        return view('kullanici.oturumac');//burada 'kullanici.oturumac' demek kullanici klasör içerisindeki oturumac bladeini açar
    }


    public function giris()
    {
        $this->validate(request(),[
            'email'=> 'required|email',
            'sifre' => 'required'
        ]);

        if(auth()->attempt(['email'=> request('email'), 'password'=> request('sifre')], request()->has('benihatirla')))
// eğer giriş işlemleri doğru ise ;
        {
            request()->session()->regenerate(); // oturumu yenile

            $aktif_sepet_id = Sepet::aktif_sepet_id();
            //$aktif_sepet_id = Sepet::firstOrCreate(['kullanici_id'=>auth()->id()])->id;// kullanıcının sepet id sini çektik
          //sepet:.firstocreate aktif için  bunu sepet model de public funciton  aktif_sepet de düzenledik

            if(is_null($aktif_sepet_id))
            {
                $aktif_sepet =Sepet::create(['kullanici_id'=>auth()->id()]);
                $aktif_sepet_id = $aktif_sepet->id;
            }


            session()->put('aktif_sepet_id',$aktif_sepet_id);// bunu session a aktarmış olduk

            if(Cart::count()>0) // session da yer alan tüm ürünleri  veritabanında  varsa güncelledik yoksa da veritabanına ekledik
            {
                foreach (Cart::content() as $cartItem) {
                    SepetUrun::updateOrCreate(
                        ['sepet_id' => $aktif_sepet_id, 'urun_id' => $cartItem->id],
                        ['adet' => $cartItem->qty, 'fiyati' => $cartItem->price, 'durum' => 'beklemede']
                    );
                }
            }

            Cart::destroy();// tüm bu yukarıdaki işlemleri yerine getirmek için sepeti bi sildik rekrar temize çekmek için

            $sepetUrunler=SepetUrun::where('sepet_id', $aktif_sepet_id)->get();// ve bura da tüm veritabanındaki ürünleri sepete eklemiş olduk
            // bölyelikle ürünlerimiz hem sesiionda hem veritabanında sepetimizde yer edindirmiş olduk
            foreach ($sepetUrunler as $sepetUrun)
            {
                Cart::add($sepetUrun->urun->id, $sepetUrun->urun->urun_adi,  $sepetUrun->adet, $sepetUrun->fiyati,0, ['slug'=>$sepetUrun->urun->slug]);
            }

            return redirect()->intended('/'); // amaca yönelik istenilen  yönlendirmeyi yapar yönlendir
        }
        else
        {
            $errors = ['email' => 'Hatali Giriş '];
            return back()->withErrors($errors);
        }

    }

    public function kaydol_form()
    {
        return view('kullanici.kaydol');
    }


    public function kaydol()
    {
        $this->validate(request(),[
            'adsoyad'=>'required|min:1|max:60',
            'email'=>'required|email|unique:kullanici',
            'sifre'=>'required|confirmed|min:5|max:15',
        ]);

        $kullanici = Kullanici::create([ //burada kaydol.blade formdan çektiğimiz değerler create methodu ile oluşutşururoyruz

            'adsoyad' => request('adsoyad'),
            'email' => request('email'),
            'sifre' => Hash::make(request('sifre')),
            'aktivasyon_anahtari' => Str::random(60),// 60 karakterlik rastgelel bir metin oluşturmamıza sağlar
            'aktif_mi' => 0
        ]);

        $kullanici->detay()->save(new KullaniciDetay());

        Mail::to(\request('email'))->send(new KullaniciKayitMail($kullanici));

        auth()->login($kullanici);
        return redirect()->route('anasayfa');
    }


    public function aktiflestir($anahtar)
    {

        $kullanici = Kullanici::where('aktivasyon_anahtari', $anahtar)->first();
        if(!is_null($kullanici))
        {
            $kullanici->aktivasyon_anahtari = null;
            $kullanici->aktif_mi =1;
            $kullanici->save();

            return redirect()->to('/')
                ->with('mesaj','Kullanici kaydınız Aktifleştirildi')
                ->with('mesaj_tur', 'success');
        }
        else
        {
            return redirect()->to('/')
                ->with('mesaj','Kullanici kaydınız Aktifleştirilemedi')
                ->with('mesaj_tur', 'warning');

        }

    }

    public function oturumukapat()
    {

        auth()->logout();
        request()->session()->flush();// session  bilgilerini sıfırla
        request()->session()->regenerate();// sessione fresh et gibi bişi

        return redirect()->route('anasayfa');

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
