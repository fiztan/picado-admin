"use strict"
let botonBusquedaFecha=document.getElementById('botonBusquedaPicados');
botonBusquedaFecha.addEventListener('click',function(){
    let inputDesde = document.getElementById("Inicio");
    let inputHasta = document.getElementById("Final");
    comprobante(inputDesde.value,inputHasta.value);
});
function comprobante(fechaDesde,fechaHasta){
    if((fechaDesde!=undefined)&&(fechaHasta!=undefined)){
        let date1 = new Date(fechaHasta);
        let date2 = new Date(fechaDesde);        
        if(date1.getTime()>=date2.getTime()){
            let selectEmpleadoInputValue = document.getElementById('selectEmpleado').value;
            if(selectEmpleadoInputValue==null){
                busquedaFecha(fechaDesde,fechaHasta);
                console.log('Lol');
            }else{
                if(selectEmpleadoInputValue!=0){
                    let filtroBD = document.getElementById("filtroBaseDatosDato");
                    filtroBD.value=selectEmpleadoInputValue;
                }else{
                    let filtroBD = document.getElementById("filtroBaseDatosDato");
                    filtroBD.value="";
                }
                    busquedaFecha(fechaDesde,fechaHasta);
                    console.log('Lol');
            }
        }            
    }
}
function busquedaFecha(fechaDesde,fechaHasta){
    console.log("Fecha Desde=>"+fechaDesde);
    console.log("Fecha Hasta=>"+fechaHasta);
    let filtroBD = document.getElementById("filtroBaseDatosDato");
    let valorFiltro =filtroBD.value;
    animacionOn();
    if(valorFiltro==""){
        $.ajax({
            url: '/picados',
            type: 'GET',            
            data: {
                "fechaDesde":fechaDesde,"fechaHasta":fechaHasta
            },
            success: function(response){
                console.log("Nice: ")
                console.log("Enviado=> /picados?"+"fechaDesde="+fechaDesde+"&fechaHasta="+fechaHasta)
                mostrarResultado(response);
            },
            error: function( jqXHR, textStatus, errorThrown ){
                console.log("Error: "+errorThrown)
            }
        });
    }else{        
        $.ajax({
            url: '/picados',
            type: 'GET',            
            data: {
                "fechaDesde":fechaDesde,"fechaHasta":fechaHasta,"dniFiltro":valorFiltro
            },
            success: function(response){
                console.log("Nice: ")
                console.log("Enviado=> /picados?"+"fechaDesde="+fechaDesde+"&fechaHasta="+fechaHasta+"&dniFiltro="+valorFiltro)
                mostrarResultado(response);
            },
            error: function( jqXHR, textStatus, errorThrown ){
                console.log("Error: "+errorThrown)
            }
        });
    }    
}
//Devuelve como string a resultado una tabla con todos los detalles que se requieren observasr
//En caso de no localizarse datos mostrará una tabla vacía
function mostrarResultado(respuesta){
    let divResultado= document.getElementById('resultado');
    let stringTabla =
    '<table class="table">'+
    '<thead class="thead-dark">'+
        '<tr>'+             
            '<th scope="col">Nombre</th>'+
            '<th scope="col">Fecha</th>'+
            '<th scope="col">Hora</th>'+           
            '<th scope="col">Motivo</th>'+             
            '<th scope="col">Imagen</th>'+
            '<th scope="col">Localizacion</th>'+
        '</tr>'+
    '</thead>'+
    '<tbody class="table-active">';        
    respuesta.forEach(function(item){
        stringTabla+='<tr>';
        stringTabla+='<td>'+item.nombre+'</td>';
        stringTabla+='<td>'+slitFechaBarra(item.fecha)+'</td>';
        stringTabla+='<td>'+slitFechaHora(item.fecha)+'</td>';
        if((item.motivo==null)||(item.motivo=="")){
            stringTabla+='<td>No hay motivo </td>';
        }else{
            stringTabla+='<td>'+item.motivo+'</td>';
        }
        stringTabla+='<td>';
        if(item.imagen!=null){
        stringTabla+='<a data-fancybox="images" href="data:image/png;base64,'+item.imagen+'">'
        stringTabla+='<image height="50" width="50"';
        stringTabla+='src="data:image/png;base64,'+item.imagen+'">';
        stringTabla+='</image>';       
        stringTabla+="</a>" 
        }else{
            stringTabla+=""
        }
        stringTabla+='</td>';
        console.log(item.localizacion)
        if(item.localizacion!=null){
            let urlMapa="https://duckduckgo.com/?q="+splitLocalizacion(item.localizacion,1)+"%2C"+splitLocalizacion(item.localizacion,2)+"&t=h_&ia=maps&iaxm=maps&strict_bbox=0&bbox=53.27373540896428%2C-6.1256151147083955%2C53.26475225612308%2C-6.103667203284502";
            stringTabla+='<td><a type="button" target="_blank" class="btn btn-primary" href="'+urlMapa+'">'+'Ver localizacion'+'</a></td>';
        }else{
            stringTabla+='<td>'+'No tiene localizacion'+'</td>';
        }      
        stringTabla+='</tr>';        
    });
    stringTabla+="</tbody></table>";
    //Da tiempo al programa procesar la tabla para quitar la animacion y visualizar tanto la tabla como el botón de informe 
    setTimeout(function(){
        animacionOff();
        divResultado.innerHTML=stringTabla;
        visualizarBotonInforme();
    }, 500);    
}
//De un dato fecha con hora de la base de datos devuelve la fecha solo con un formato correcto
function slitFechaBarra(cadenaFecha){
    let stringArray = cadenaFecha.split(" ");
    let stringRayaBarra = stringArray[0].split("-");
    return stringRayaBarra[0]+"/"+stringRayaBarra[1]+"/"+stringRayaBarra[2];
}
//De un dato fecha con hora de la base de datos devuelve la hora
function slitFechaHora(cadenaFecha){
    let stringArray = cadenaFecha.split(" ");
    return stringArray[1];
}
//Recoge la latitud o longitud dependiendo a el dato requerido en numeroPos
function splitLocalizacion(latitudlongitud,numeroPos){
    let stringArray = latitudlongitud.split(",");
    if(numeroPos==1){
        return stringArray[0];
    }else{
        return stringArray[1];
    }    
}
//Inicializa la animación gif haciendola visible
function animacionOn(){
    console.log("Intro animacion");
    let gifAnimacion = document.getElementById("loadingGIF");
    gifAnimacion.setAttribute("class", " ");
    console.log(gifAnimacion)

}
//Finaliza la animación gif haciendola invisible
function animacionOff(){
    console.log("Finalizar animacion");
    let gifAnimacion = document.getElementById("loadingGIF");
    gifAnimacion.setAttribute("class", "d-none");
}
//Visualiza el botón de Informe
function visualizarBotonInforme(){
    let botonInforme = document.getElementById("botonInforme");
    if(botonInforme!=null){
        botonInforme.setAttribute("class","btn btn-success");
    }
}