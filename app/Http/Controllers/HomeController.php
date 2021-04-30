<?php

namespace App\Http\Controllers;

use App\Models\trabajadores;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //Muestra el login
    public function showLogin()
    {
        return view('login');
    }
    //Verific el dni recibido en caso de Exito verifica cual es su nivel de privilegios dependiendo este
    //mandará a la página con los datos necesarios correspondientes.
    public function doLogin(Request $request)
    {
        $dni=$request->input('dniElegido');
        $result=$this->dniExiste($dni);        
        if($result["resultado"]!="No"){
            switch($result["nivel"]){
                case 0:
                    return view("picadobusqueda")->with("usuarioDatos",$result);
                    break;
                case 1:                            
                    return view("admin")->with("usuarioDatos",$result);                                        
                    break;
            }
        }else{
            return view('login');
        } 
    }
    //Sirve para mandar desde una página administrador a la página de busquedas
    public function cambioURL(Request $request){
        $idUsuario=$request->input('idUsuario');     
        $datosUsuario=$this->devolverDatos($idUsuario);    
        if($datosUsuario['resultado']=="no"){
            return view('login');
        }else{
            return view('picadobusqueda')->with("usuarioDatos",$datosUsuario);
        }        
    }
    //Muestra la página de dumping en caso de fallo devuelve a login sin un mensaje de error
    public function paginaDump(Request $request){
        $idUsuario=$request->input('idUsuario');
        $datosUsuario=$this->devolverDatos($idUsuario);    
        if($datosUsuario['resultado']=="no"){
            return view('login');
        }else{
            return view('dumping')->with("usuarioDatos",$datosUsuario);
        }    
    }

    //Realiza un dump de la base de datos devolviendo como string todo sobre la BD 
    public function dumpBaseDatos(){
        $host = env('DB_HOST');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $database = env('DB_DATABASE');
        $result=shell_exec('mysqldump --user='.$username.' --password='.$password.' --host='.$host.' '.$database.'');
        return $result;
    }
    //Realiza una busqueda del dni seleccionado en caso de exito devuelve resultado=>si y los datos
    //En caso de fallo resultado=>no
    private function dniExiste($dniString){
        $stringDNI=strval($dniString);
        $arrayResultado = trabajadores::where('dni',"=",$stringDNI)->get();
        if(sizeOf($arrayResultado)==0){
            $arrayString = array("resultado"=>"No");
            return $arrayString;
        }else{
            $arrayString = array(
                "resultado"=>"Si",
                "idBD"=>$arrayResultado[0]["id"],
                "nombre"=>$arrayResultado[0]["nombre"],
                "dni"=>$arrayResultado[0]["dni"],
                "nivel"=>$arrayResultado[0]["nivel"]
            );
            return $arrayString;
        }      
    }

   //Devuelve un array con los datos del id usuario seleccionado en caso de exito devuelve resultado=>si y los datos
   //En caso de fallo resultado=>no
    private function devolverDatos($idUsuario){
        $arrayResultado = trabajadores::where('id',"=",$idUsuario)->get();       
        if(sizeOf($arrayResultado)==0){
            $arrayString = array("resultado"=>"No");
            return $arrayString;
        }else{
            $arrayString = array(
                "resultado"=>"Si",
                "idBD"=>$arrayResultado[0]["id"],
                "nombre"=>$arrayResultado[0]["nombre"],
                "dni"=>$arrayResultado[0]["dni"],
                "nivel"=>$arrayResultado[0]["nivel"]
            );
            return $arrayString;
        }    
    }
}
