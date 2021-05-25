function validacionDatos(){
    let correoInput = document.getElementById('correoInput').value;
    if(correoInput!=""){
        return true;
    }else{
        return false;
    }
}