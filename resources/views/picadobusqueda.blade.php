<?php
    $nombreUsuario=$usuarioDatos['nombre'];
    $idUsuario=$usuarioDatos['idBD'];
    $nivel=$usuarioDatos['nivel'];
    session()->flash('dniUsuario',$usuarioDatos['dni']);
    $filtro;
    if($nivel==0){
        $filtro=$idUsuario;
    }else{
        $filtro="";
    }
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
    </head>
<body>   
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                @if($nivel==1)
                    <li class="nav-item">               
                        <a class="nav-link" href="/AdminApartado">Trabajadores</a>                   
                    </li>
                    <li class="nav-item active">
                    <a class="nav-link" href="/PicadosApartado">Picados</a></li>
                    <li class="nav-item"><a class="nav-link" href="/DumpBaseDatos">Dump Base Datos (No seguro)</a></li>
                @endif
                    <li class="nav-item"><a class="nav-link" href="/Deslogarse">Deslogarse</a></li>
                </ul>
            </div>          
            <a class="navbar-brand">Cooperativas Agro-alimentarias</a>         
    </nav>
   
    <div class="container text-center">
        <div class="row mt-2">
            <div class="col-12">
            <h1>Picados</h1>
            </div>
        </div>
        <div class="row mt-2">       
            <div class="col-12 col-md-6">
                <h3>Desde</h3>
                <input type="date" class="form-control text-center mt-2" id="Inicio">
            </div>
            <div class="col-12 col-md-6">
                <h3>Hasta</h3>
                <input type="date"  class="form-control text-center mt-2" id="Final">
                <input id="IdBaseDatosDato" value="<?php echo $idUsuario?>" 
                readonly class="d-none">
                <input id="filtroBaseDatosDato" value="<?php echo $filtro?>" 
                readonly class="d-none">  
            </div> 
            @if($nivel==1)
            <div class="col-12 mt-4 text-center">
                <select id="selectEmpleado" class="form-control">
                    <!--For each -->
                    <option selected value="0">Elija empleado</option>
                    @foreach($empleados as $empleado)
                        <option value="{{$empleado->id}}">{{$empleado->nombre}}</option>
                    @endforeach
                </select>
            </div>
            @endif    
            <div class="col-12 mt-2">
                <button type="button" id="botonBusquedaPicados" class="btn btn-primary">Buscar</button>              
            </div>
            <div class="col-12 mt-2">
            @if($nivel==1)
                <button class="d-none" id="botonInforme">Generar Informe</button>
            @endif    
            </div>
        </div>
        <div class="row mt-4">            
            <div class="col-12" >
                <img class="d-none" src="{{asset('assets/imagenes/loading.gif')}}" id="loadingGIF">
            </div>
            <div class="col-12" id="resultado">

            </div>
        </div>
</div>
@if($nivel==1)
<script src="{{asset('assets/js/Informe.js')}}"></script>
@endif
<script src="{{asset('assets/js/base.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>