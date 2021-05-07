<?php 
$idUsuario=$usuarioDatos['idBD'];
var_dump(session('dniUsuario'));
session()->flash('dniUsuario',session('dniUsuario'));
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
                    <li class="nav-item"><a class="nav-link" href="/AdminApartado">Trabajadores</a></li>
                    <a class="nav-link" href="/PicadosApartado">Picados</a></li>
                    <li class="nav-item active"><a class="nav-link" href="/DumpBaseDatos">Dump Base Datos (No seguro)</a></li>
                    <li class="nav-item"><a class="nav-link" href="/Deslogarse">Deslogarse</a></li>
                </ul>
            </div>     
        <a class="navbar-brand">Cooperativas Agro-alimentarias</a>         
     
    </nav>
<div class="container text-center">
    <div class="row mt-4">
        <div class="col-12">
            <h1>Salvaguardar Base de datos actual</h1>
        </div>
        <div class="col-12 mt-2">
            <a class="btn btn-primary" target="_blank" href="/Dump66">Descargar inserts</a>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>