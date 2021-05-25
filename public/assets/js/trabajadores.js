
let botonCrear= document.getElementById('botonCrear');
//Realiza la llamada AJAX para mostrar todos los trabajadores
let buttonReseteo = document.getElementById('botonReseteo');
consultaTodosEmpleadosTabla();
//En caso de selecionar el boton crear inicializará un formulario
botonCrear.addEventListener('click',function(){
    inicializarFormulario()
});
buttonReseteo.addEventListener('click',resetearPass);

function resetearPass(){
    let inputIdTrabajador= document.getElementById('idBDForm').value;
    $.ajax({
        url: '/reseteoPass',
        type: 'GET',
        data: {
            'idTrabajador': inputIdTrabajador
        },
        success: function (response) {
            console.log("Nice: ");
            console.log("Enviado=> /reseteoPass?" + "idTrabajador" + "=" + inputIdTrabajador);
            mostrarMensaje(response);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("Error: " + errorThrown);
        }
    });
}
//Realiza la consulta a base de datos para realizar la tabla de empleados
function consultaTodosEmpleadosTabla() {
    let numeroBD=document.getElementById('idBDActual'); 
    let tituloOriginal = document.getElementById("tituloOriginal");  
    tituloOriginal.setAttribute('class','');
    $.ajax({
        url: '/personalBusqueda',
        type: 'GET',
        data: {
            'idConsultante': numeroBD.value
        },
        success: function (response) {
            console.log("Nice: ");
            console.log("Enviado=> /personalBusqueda?" + "idConsultante" + "=" + numeroBD.value);
            mostrarResultado(response);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("Error: " + errorThrown);
        }
    });
}
function mostrarMensaje(Mensaje){
alert(Mensaje)
}
//Muestra el resultado de todos los trabajadadores y añade botones que añadirá funcionalidad en el futuro
function mostrarResultado(resultado){
    let divResultado = document.getElementById('resultado');    
    if(resultado=="nope"){
        mostrarErrores("Se han cometido errores");
    }else{
        let stringTabla =
        '<table class="table">'+
        '<thead class="thead-dark">'+
        '<tr>'+             
            '<th scope="col">Nombre</th>'+
            '<th scope="col">DNI</th>'+
            '<th scope="col">Empresa</th>'+           
            '<th scope="col"></th>'+             
        '</tr>'+
        '</thead>'+
        '<tbody class="table-active">';        
        resultado.forEach(function(item){
            stringTabla+='<tr>';
            stringTabla+='<td>'+item.nombre+'</td>';
            stringTabla+='<td>'+item.dni+'</td>';
            stringTabla+='<td>'+item.empresaNombre+'</td>';
            stringTabla+='<td>'+
                '<button class="btn btn-primary botonEditar" data-code="'+item.idTrabajador+'">Editar'
                +'</button>'+        
            '</td>'
            stringTabla+='</tr>';        
        });
        stringTabla+="</tbody></table>"
        divResultado.innerHTML=stringTabla;
        botonLiseneres();
    }
}
//Añade la funcionalidad a los botones de la tabla para poder recoger los datos del trabajador en cuestion
function botonLiseneres(){
    let botonesEditar =document.getElementsByClassName('botonEditar');
    for (let i = 0; i < botonesEditar.length; i++) {
        botonesEditar[i].addEventListener("click",function(event){
            let target = event.toElement || event.relatedTarget || event.target || function () { throw "Failed to attach an event target!"; }
            MostrarEditarEmpleado(target.getAttribute('data-code'));                    
        });
    }   
}
//Con el data code rellena el input donde tiene el idDB para que pueda buscar los datos requeridos al inicializarlo
//El código es el id
function MostrarEditarEmpleado(code){
    let inputDB = document.getElementById('idBDForm');
    inputDB.value=code;
    let buttonReseteo = document.getElementById('botonReseteo');
    buttonReseteo.setAttribute('class','btn btn-warning');
    inicializarFormulario();
}

//Rellena el select de empresas en el formulario
function rellenarSelect(respuesta){
    let selectDivEmpresas = document.getElementById('empresasInput');
    let stringElementos;
    for(let a=0;a<respuesta.length;a++){
        let valueEmpresaNombre =respuesta[a]['nombre'];
        let valueEmpresaID =respuesta[a]['id'];
        stringElementos += "<option value='"+valueEmpresaID+"'>"+valueEmpresaNombre+"</option>"
    }
    selectDivEmpresas.innerHTML=stringElementos;
}

//Al realizarse un submit del form se llama a esta funcion
//Esta función recoge todos los valores que se necesitan para insertar un valor y 
//prueba si estan vacíos o si el DNI no es si quiera valido
function validacionDatos(){
    let inputDBvalue = document.getElementById('idBDForm').value;
    let inputNombrevalue = document.getElementById('nombreInput').value;
    let inputDNIvalue = document.getElementById('dniInput').value;
    let selectEmpresavalue = document.getElementById('empresasInput').value; 
    //Las diferentes pruebas a los campos excepto inputDBvalue se podría modificar 
    //para que compruebe que sea int pero no lo veo necesario
    if((inputNombrevalue==null)||(inputNombrevalue==='')){
        mostrarErrores("El campo de nombre esta vacío tiene caracter obligatorio");
        return false;
    }else{
        if(testDNI(inputDNIvalue)==true){
            if((selectEmpresavalue!="")&&(selectEmpresavalue!=0)){
                console.log("NICE");
                return true;                
            }else{
                mostrarErrores("El campo de dni no es correcto");
                return false;
            }
        }else{
            mostrarErrores("El campo de dni no es correcto");
            return false;
        }
    }  
}

//En caso de de acceder a esta función la susodicha invibiliza el formulario y vacía sus contenidos.
//A parte de rellenar de nuevo la tabla con la primera consulta original
function funcionalidadBotonCancelar(){
    let botonCancelar = document.getElementById('botonVolver');
    botonCancelar.addEventListener('click',function(){
        let divTotalForm = document.getElementById('divForm');
        let tituloCrear = document.getElementById('tituloCrear');
        let tituloEditar = document.getElementById('tituloEditar');       
        let botonCrear = document.getElementById('botonCrear');
        let inputDB = document.getElementById('idBDForm');
        let inputNombre = document.getElementById('nombreInput');
        let inputDNI = document.getElementById('dniInput');
        let buttonReseteo = document.getElementById('botonReseteo');
        let inputCorreo = document.getElementById('correoInput');    
        buttonReseteo.setAttribute('class','d-none');
        inputNombre.value="";
        inputDNI.value="";
        inputDB.value="";
        inputCorreo.value="";
        divTotalForm.setAttribute('class','d-none');
        tituloCrear.setAttribute('class','d-none');
        tituloEditar.setAttribute('class','d-none');
        botonCrear.setAttribute('class','btn btn-success');  
        consultaTodosEmpleadosTabla();

    })
}

//Inicializa el formulario tanto el caso de que el usuario venga de editar o de modificar un empleado
function inicializarFormulario(){
    let divTotalForm = document.getElementById('divForm');
    let divTituloOriginal = document.getElementById('tituloOriginal');
    let tituloCrear = document.getElementById('tituloCrear');
    let tituloEditar = document.getElementById('tituloEditar');
    let inputDB = document.getElementById('idBDForm');
    let idDB= inputDB.value;
    let botonCrear = document.getElementById('botonCrear');
    if(idDB==""){
        inputDB.value="";
        tituloCrear.setAttribute('class','');
    }else{
        inputDB.value=idDB;
        tituloEditar.setAttribute('class','');
        consultaEmpleado(idDB);        
    }    
    botonCrear.setAttribute('class','d-none');
    divTotalForm.setAttribute('class','row mt-5');
    divTituloOriginal.setAttribute('class','d-none')
    let resultado = document.getElementById('resultado');
    resultado.innerHTML="";
    $.ajax({
        url: '/Empresas',
        type: 'GET',       
        success: function (response) {
            console.log("Nice: ");
            console.log("Enviado=> /Empresas");
            funcionalidadBotonCancelar();
            rellenarSelect(response);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("Error: " + errorThrown);
        }
    });    
}


//Realiza una consulta de los datos de un trabajador en especifico para que modifique el formulario
function consultaEmpleado(idEmpleado){
    $.ajax({
        url: '/EmpleadoEspecifico',
        type: 'GET',  
        dataType: "json",     
        data:{
            "idEmpleado":idEmpleado
        },
        success: function (response) {
            console.log("Nice: ");
            console.log("Enviado=> /EmpleadoEspecifico");
            console.log("Respuesta=>"+response)
            rellenarDatosInput(response);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("Error: " + errorThrown);
        }
    });    
}
//Rellena el formulario con los datos de la base de datos que se obtienen
function rellenarDatosInput(respuesta){
    let inputNombre = document.getElementById('nombreInput');
    let inputDNI = document.getElementById('dniInput');
    let selectEmpresa =document.getElementById('empresasInput');   
    let inputCorreo = document.getElementById('correoInput');    
    inputDNI.value=respuesta[0]["dni"];
    inputNombre.value=respuesta[0]["nombre"];
    selectEmpresa.value=respuesta[0]["id_empresa"];       
    inputCorreo.value=respuesta[0]['correo'];
}

//función que testea la vericidad de un DNI en caso de ser válida devuelve true en caso de no false
//Se ha modificado para que en caso de false salga del metodo consumiendo menos aunque se puede optimiazar
function testDNI(stringDNI){
    if(stringDNI.length!=9){
        return false
    }
    if(!isLetter(stringDNI.charAt(8))){
        return false
    }
    const splitAt = index => x => [stringDNI.slice(0, index), x.slice(index)]
    let arrayDNI=splitAt(8)(stringDNI);
    if(calculoDNILetra(arrayDNI)){
        return true
    } 
    else{
        return false
    }
}
//Determina si es una letra el carcter mandado
function isLetter(str) {
    return str.length === 1 && str.match(/[a-z]/i);
}
//Teniendo un array con los numeros y otro con la letra calculamos la letra resultante
//Y confirmamos o denegamos que sea igual a la que debería (En caso de minuscula devuelve false, mejorable)
function calculoDNILetra(arrayDNI){
    let cadenaLetras =['T','R','W','A','G','M','Y','F','P','D','X','B','N','J','Z','S','Q','V','H','L','C','K','E'];
    let resultanteNumero = arrayDNI[0]%23;
    if(arrayDNI[1]===(cadenaLetras[resultanteNumero])){
        return true;
    }else{
        return false
    } 
}

//Funcion que muestra un alert error con el string mencionado
function mostrarErrores(string){
    let divError = document.getElementById('errores');
    divError.setAttribute("class","alert alert-danger")
    divError.innerHTML=string;
}