'use strict'
let botonInforme = document.getElementById("botonInforme");
botonInforme.addEventListener("click",function(){
    let valorDesde = document.getElementById("Inicio").value;
    let valorHasta = document.getElementById("Final").value;
    let valorEmpleado = document.getElementById('selectEmpleado').value;

    if((valorDesde!="")&&(valorHasta!="")){
        if(valorEmpleado==0){
            let archivoElemento = document.createElement("a");
            let consulta = "fechaDesde="+valorDesde+"&"+"fechaHasta="+valorHasta;
            archivoElemento.setAttribute('href', "/GenerarDocumento?"+consulta);
            archivoElemento.setAttribute('target',"_blank");
            archivoElemento.setAttribute('class', "d-none");
            document.body.appendChild(archivoElemento);
            archivoElemento.click();
            document.body.removeChild(archivoElemento); 
        }else{
            let archivoElemento = document.createElement("a");
            let consulta = "fechaDesde="+valorDesde+"&"+"fechaHasta="+valorHasta+"&"+"idTrabajador="+valorEmpleado;
            archivoElemento.setAttribute('href', "/GenerarDocumento?"+consulta);
            archivoElemento.setAttribute('target',"_blank");
            archivoElemento.setAttribute('class', "d-none");
            document.body.appendChild(archivoElemento);
            archivoElemento.click();
            document.body.removeChild(archivoElemento); 
        }
        
    }
});