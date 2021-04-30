<!DOCTYPE html>
<html lang="es">
<head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
       <!--  <link rel="stylesheet" href="{{asset('css/camara.css')}}"> -->
    </head>
<body>
    <div class="container text-center">
        <div class="row mt-5">
            <div class="col-12">
                <h1>Login</h1>
            </div>
        </div>
        
        <form action="/Login" class="row mt-2" method="GET">
            <div class="col-12">
                <div class="form-group">
                    <label for="dniElegido">DNI</label>
                    <input maxlength="9" type="text" class="form-control text-center" name="dniElegido" id="dniElegido" autocomplete="off">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Loguearse</button>
                </div>
            </div>
        </form>
        
        
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html> 