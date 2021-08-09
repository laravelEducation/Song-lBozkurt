
require('./bootstrap');

setTimeout(function (){
$('.alert').slideUp(500);
},3000);

// $.ajaxSetup({
//     headers:{
//         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//     }
// });
$.ajaxSetup({
headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});

// burada biz sepette arttır veya azazltma tutşlarınıda güncellemeyi tutumak için kullanırız bu kodu
$('.urun-adet-artir, .urun-adet-azalt').on('click', function (){
var id = $(this).attr('data-id');
var adet = $(this).attr('data-adet');

$.axios({
method : 'post',
url: '/sepet/guncelle'+ id,
headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
},
data : {adet:adet},
}).then(res=>{
console.log(res)
{{ route('/sepet') }}
}).catch((err=>{
console.log({error : err})
}))




// $.ajax({
//     type: 'PATCH',
//     url: '/sepet/guncelle'+ id,
//     data:{adet:adet},
//     success:function (result){
//         window.location.href = '/sepet';
//     }
// });
});

