<?php 
    function devolverDiferencia($horaInicio,$horaFin){
        $dateInicial = new DateTime("2020-1-1 ".$horaInicio);
        $dateFin = new DateTime("2020-1-1 ".$horaFin);
        $diferencia =  $dateInicial->diff($dateFin);
        if($diferencia->h==0){
            $resultanteDiferencia = "M: ".$diferencia->i;
        }else{
            $resultanteDiferencia = "H: ".$diferencia->h." M: ".$diferencia->i;
        }
        return $resultanteDiferencia;
    }
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    </head>
<body>
    <div class="container text-center">
       <!-- For each primero -->
       @foreach($Arreglo as $ArregloActual)
       <!-- if comprueba si se han encontrado fechas entorno al rango puesto, solo mostrando las que tienen-->
       @if($ArregloActual["ArregloIndividual"]["existe"]=="Si")
        <div class="row">            
            <div class="col-12">
                <h2>{{$ArregloActual["ArregloIndividual"]["usuario"]}}</h2>
                <p> Jornada desde {{$ArregloActual["fechaInicial"]}} a
                 {{$ArregloActual["fechaFinal"]}}                
                </p>
            </div>
            <div class="col-12">            
                    <table class="table table-dark table-sm">
                        <thead>
                            <tr>                            
                                <th scope="col">Día</th>
                                <th scope="col">Hora Inicio</th>
                                <th scope="col">Hora Fin</th>
                                <th scope="col">Diferencia E/S</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $totalLineas=0; ?>
                        <!-- For each que muestra la hora minima y máxima recorriendo el array fechas corrrespondiente -->
                        <!-- Fecha contiene el día al que pertenecen las horas -->
                        @foreach($ArregloActual["ArregloIndividual"]['fechas'] as $fecha)
                            <?php ++$totalLineas; ?>

                            <tr>
                                <td>{{$fecha["Fecha"]}}</td>
                                <td>{{$fecha["fechaMin"]}}</td>
                                <td>{{$fecha["fechaMax"]}}</td>
                                <td>{{devolverDiferencia($fecha["fechaMin"],$fecha["fechaMax"])}}</td>
                            </tr>
                        @endforeach
                        <!--Se realiza un for para asegurarse que el espaciado de lineas es correcto para su impresion en pdf -->
                        @for($linea=0;$linea<=(40-$totalLineas);$linea++)
                            <tr>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                            </tr>
                        @endfor
                        </tbody>
                    </table>
            </div>          
        </div>
        @endif
        @endforeach            
    </div>
   
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script>
        $(window).on('load', function() {
            window.print();
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
