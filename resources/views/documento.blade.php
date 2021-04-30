<!DOCTYPE html>
<html lang="es">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    </head>
<body>
    <div class="container text-center">
        <div class="row">
            <div class="col-12">
                <h1>{{$Arreglo["usuario"]}}</h1>
                <p>Jornada desde {{$Arreglo["fechaInicial"]}} a {{$Arreglo["fechaFinal"]}} </p>
            </div>
            <div class="col-3">
            </div>
            <div class="col-9">
                <table class="table table-dark table-sm">
                    <thead>
                        <tr>                            
                            <th scope="col">Día</th>
                            <th scope="col">Hora Inicio</th>
                            <th scope="col">Hora Fin</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($Arreglo['fechas'] as $fecha)
                        <tr>
                            <td>{{$fecha["Fecha"]}}</td>
                            <td>{{$fecha["fechaMin"]}}</td>
                            <td>{{$fecha["fechaMax"]}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>