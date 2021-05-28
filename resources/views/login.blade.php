<?php 
    $detallesExito="";
    if($exito!=""){
        $detallesExito=$exito;
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
       <title>Mi Picado</title>
    </head>
<body>
    <div class="container text-center">
        @if(!empty($detallesExito))            
            <div class="row mt-2">
                <div class="col-12">
                @if($detallesExito=="Correo incorrecto")
                    <div class="alert alert-danger" role="alert">
                        {{$detallesExito}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @else
                    <div class="alert alert-success" role="alert">
                        {{$detallesExito}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                    
                </div>
            </div>
        @endif
        <div class="row mt-4 justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                    Mi Picado Login
                    </div>
                    <div class="card-body">
                        <form action="/Login" class="mt-2" method="POST">
                        @csrf
                            <div class="col-12">         
                                <div class="form-group row">
                                    <label for="correoInput" class="col-4">Correo</label>
                                    <input type="text" class="form-control text-left col-8" name="correo" id="correoInput" autocomplete="off">
                                </div>
                                <div class="form-group row">
                                    <label for="passwordInput" class="col-4">Contraseña</label>
                                    <input maxlength="9" type="password" class="form-control text-left col-8" name="password" id="passwordInput" autocomplete="off">
                                </div>
                                <div class="form-group row">
                                    <input type="hidden" class="d-none" name="_token" value="{{ csrf_token() }}" />
                                    <div class="col-4 text-right">
                                        <button type="submit" class="btn btn-primary">Loguearse</button>                                 
                                    </div>
                                    <a class="col-8" href="/olvidoPassword">Olvidé mi contraseña</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>                
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html> 