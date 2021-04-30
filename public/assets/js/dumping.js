"use strict";
let botonDumping = document.getElementById("botonDump"); 
botonDumping.addEventListener("click", function(){
    console.log("Yo")
    $.ajax({
        url: '/DumpOficial/Confirmado',
        type: 'GET',       
        success: function (response) {
            console.log("Nice: ");
            console.log("Enviado=> /DumpOficial/Confirmado");
            HacerDescarga(response);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("Error: " + errorThrown);
        }
    });  
});

function HacerDescarga(response) {        
    let date = new Date();
    let fechaActual=""+date.getDate()+"-"+(date.getMonth()+1)+"-"+date.getFullYear();
    console.log(fechaActual)
    let filename = "picados-empresa_"+fechaActual+".sql";    
    let archivoElemento = document.createElement("a");
    archivoElemento.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(response));
    archivoElemento.setAttribute('download', filename);
    archivoElemento.setAttribute('class', "");
    document.body.appendChild(archivoElemento);
    archivoElemento.click();
    document.body.removeChild(archivoElemento); 
}
