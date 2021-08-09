
//require('./bootstrap');

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
