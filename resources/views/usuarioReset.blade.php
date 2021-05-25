<!DOCTYPE html>
<html lang="es">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
    </head>
    <body>
    <div class="container mt-4 text-center">
        <div class="row">
            <div class="col-12">
                <h1>Escriba el correo que tiene asignado</h1>
            </div>
        </div>
        <form action="/ReseteoPassUsuario" class="row mt-2" method="GET"  onsubmit="return validacionDatos()">
            <div class="col-12">
                <div class="form-group">
                    <label for="correoInput">Correo</label>
                    <input type="email" class="form-control text-center" name="correo" id="correoInput" autocomplete="off">
                </div>
            </div>
            <div class="col-12 form-group">
                <button type="submit" class="btn btn-primary">Reseteo</button>
            </div>
        </div>
    </div>
    <script src="{{asset('assets/js/resetearPass.js')}}"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    </body>   
</html>