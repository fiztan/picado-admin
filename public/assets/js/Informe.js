'use strict'
let botonInforme = document.getElementById("botonInforme");
botonInforme.addEventListener("click",function(){
    let valorDesde = document.getElementById("Inicio").value;
    let valorHasta = document.getElementById("Final").value;
    if((valorDesde!="")&&(valorHasta!="")){
        let archivoElemento = document.createElement("a");
        let consulta = "fechaDesde="+valorDesde+"&"+"fechaHasta="+valorHasta;
        archivoElemento.setAttribute('href', "/GenerarDocumento?"+consulta);
        archivoElemento.setAttribute('target',"_blank");
        archivoElemento.setAttribute('class', "d-none");
        document.body.appendChild(archivoElemento);
        archivoElemento.click();
        document.body.removeChild(archivoElemento); 
    }
});