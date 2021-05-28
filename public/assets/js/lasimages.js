console.log('hola');
var storagePath = "{!! storage_path(/principal) !!}";
console.log(storagePath)
$.ajax({
    method: "GET",
    url:"/ImagenIndividual",
    headers:{
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    data:{                   
        "direccionImage":'principal/2021/05/2021-05-26-134008-43.png'
    },                
    success: function(response) {           
        console.log('/ImagenIndividual?direccionImage='+'principal/2021/05/2021-05-26-134008-43.png');
        console.log(response);         
        let imagen = document.getElementById('ImagenResultante');
        imagen.setAttribute('src',response);
    },
    error: function(xhr) {
       // errorJavascript('Error conectando Servidor');
       console.log(xhr)
    }
}); 