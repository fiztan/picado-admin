<?php 
$nombreUsuario=$usuarioDatos['nombre'];
$idUsuario=$usuarioDatos['idBD']; 
$nivel=$usuarioDatos['nivel'];
session()->flash('dniUsuario',session('dniUsuario'));
$detallesExito="";
$detallesError="";
if(isset($usuarioDatos["detalles"])){
    if($usuarioDatos["resultado"]=="Si"){
        $detallesExito=$usuarioDatos["detalles"];
    }else{
        $detallesError=$usuarioDatos["detalles"];
    }
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>                  
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                    <a class="nav-link" href="/AdminApartado">Trabajadores</a></li>
                    <li class="nav-item">
                    <a class="nav-link" href="/PicadosApartado">Picados</a></li>
                    <li class="nav-item"><a class="nav-link" href="/DumpBaseDatos">Dump Base Datos (No seguro)</a></li>
                    <li class="nav-item"><a class="nav-link" href="/Deslogarse">Deslogarse</a></li>
                </ul>
            </div>
            <a class="navbar-brand">Cooperativas Agro-alimentarias</a>            
        </nav>
        
        <div class="container text-center mt-4">
        <div class="row">
            <div class="col-12">
                <h1 id="tituloOriginal">Trabajadores</h1>          
            </div>        
        </div>
        <div class="row mt-2">
            <div class="col-12 text-center">
                <h1 class="d-none" id="tituloEditar">Editar Empleado</h1>
                <h1 class="d-none" id="tituloCrear">Crear Empleado</h1>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-12"> 
                <div id="errores" class="d-none alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>  
                @if($detallesError!="")
                    <div class="alert alert-danger" role="alert">
                        {{$detallesError}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                @if($detallesExito!="")
                    <div class="alert alert-success" role="alert">
                    {{$detallesExito}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                @endif
            </div>
        </div>        
        <div class="row mt-5 d-none" id="divForm">
        
           <form method="post" action="/InsertarTrabajador"  onsubmit="return validacionDatos()" class="col-12 text-center">        
                
                <div class="form-group text-left">
                    
                    <label for="nombreInput">Nombre</label>
                    <input type="text" class="form-control" name="nombre" id="nombreInput" placeholder="Marc">
                   
                   <input type="text" class="d-none" name="idBD" id="idBDForm">
                   
                    <input class="d-none" id="idBDActual" name="idBDUsuario" value="<?php echo $idUsuario?>">
                    
                </div>
              
                <div class="form-group text-left">
                    <label for="dniInput text-left">DNI</label>
                    <input type="text" class="form-control" name="dni" id="dniInput" maxlength=9 placeholder="XXXXXXXXA">
                </div>
                <div class="form-group text-left">
                    <label for="empresasInput">Empresa</label>
                    <select class="form-control" name="empresa" id="empresasInput">                                   
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Enviar</button>   
                <button type="button" class="btn btn-danger" id="botonVolver">Volver</button>                
                <button type="button" class="d-none btn btn-warning" id="botonReseteo">Resetear Contraseña</button>                
            </form>                     
        </div>
        <div class="row">
            <div class="col-12">
                <button class="btn btn-success" id="botonCrear">Crear empleado</button>
            </div>
            <div class="col-12 mt-4">
                <div id="resultado">
                </div>
            </div>      
        </div>        
        </div>   
        
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script src="{{asset('assets/js/trabajadores.js')}}"></script>
    </body>
</html> 