<?php

namespace App\Http\Controllers;

use App\Models\picados;
use App\Models\trabajadores;
use App\Models\empresas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmpleadoController extends Controller
{    
    public function inserteEmpleado(Request $request){
        session()->flash('dniUsuario',session('dniUsuario'));
        $idEmpleado=$request->input('idBD');
        $nombre=$request->input('nombre');
        $dni=$request->input('dni');
        $empresa=$request->input('empresa');
        $correo=$request->input('correo');
        $idUsuario=$request->input('idBDUsuario');
        $datosUsario=$this->mostrarDatosUsuario($idUsuario);
        //Contiene todos los detalles del usuario actual en caso que necesitemos estos datos
        $arrayString = array(
            "resultado"=>"Si",
            "idBD"=>$idUsuario,
            "nombre"=>$datosUsario[0]["nombre"],
            "dni"=>$datosUsario[0]["dni"],
            "nivel"=>$datosUsario[0]["nivel"],
            "detalles"=>""
        );
        if($idEmpleado==null){
            //Hacer insert devuelve 1 en caso de exito           
            $resultado=$this->crearTrabajador($nombre,$dni,$empresa,$correo);
            if($resultado==1){
                $arrayString["detalles"]="Se ha realizado de forma correcta la insercción";
                session()->flash('exitoInsertando',$arrayString["detalles"]);
                return redirect()->route('AdminApartado');
                return view('trabajadores')->with("usuarioDatos",$arrayString);
            }else{
                $arrayString["detalles"]="No se ha realizado la insercción por algun error en BD";
                $arrayString["resultado"]="No";
                session()->flash('errorInsertando',$arrayString["detalles"]);
                return redirect()->route('AdminApartado');
                return view('trabajadores')->with("usuarioDatos",$arrayString);
            }
        }else{
            //Update ya se hace devuelve 1 en caso de exito                   
            $resultado=$this->updateTrabajador($idEmpleado,$nombre,$dni,$empresa,$correo);
            if($resultado==1){
                $arrayString["detalles"]="Se ha realizado de forma correcta la actualizacion";
                session()->flash('exitoInsertando',$arrayString["detalles"]);
                return redirect()->route('AdminApartado');
                return view('trabajadores')->with("usuarioDatos",$arrayString);
            }else{
                $arrayString["detalles"]="No se ha realizado la actualizacion por algun error en BD";
                $arrayString["resultado"]="No";
                session()->flash('errorInsertando',$arrayString["detalles"]);
                return redirect()->route('AdminApartado');
                return view('trabajadores')->with("usuarioDatos",$arrayString);
            }
        }
    }
    public function verPicados(Request $request){     
        //Consulta Requiere fechas=> 
        /*
            select trabajadores.nombre AS 'personal', picados.hora, picados.motivo, picados.imagen 
            FROM `picados`,`trabajadores` 
            WHERE trabajadores.id=picados.personal  
            and date(`hora`) BETWEEN '2021-04-08' AND '2021-04-23' AND picados.personal=43
        */
        session()->flash('dniUsuario',session('dniUsuario'));

        $fechaDesdeRecibida=strval($request->input("fechaDesde"));
        $fechaHastaRecibida=strval($request->input("fechaHasta"));
        $condicional=strval($request->input("dniFiltro"));
        if($condicional!=null){
            $arrayResultante=picados::selectRaw('trabajadores.nombre, 
            DATE_FORMAT(picados.hora,"%d-%m-%Y %H:%i:%S") as fecha, picados.motivo,
             picados.imagen, picados.localizacion')->join('trabajadores','trabajadores.id','=','picados.personal')
             ->whereRaw("date(`hora`) BETWEEN '".$fechaDesdeRecibida."' AND '".$fechaHastaRecibida."'")
             ->whereRaw('personal='.$condicional)->orderBy('fecha','desc')->get();          
        }else{
            $arrayResultante=picados::selectRaw('trabajadores.nombre, 
            DATE_FORMAT(picados.hora,"%d-%m-%Y %H:%i:%S") as fecha,
             picados.motivo, picados.imagen, picados.localizacion') ->join('trabajadores','trabajadores.id','=','picados.personal')->whereRaw("date(`hora`) BETWEEN '".$fechaDesdeRecibida."' AND '".$fechaHastaRecibida."'")->orderBy('fecha','desc')->get();

        }
        return $arrayResultante;
    }
    //Funcion que verifica si se tienen los permisos o no
    public function verEmpleados(Request $request){        
        $idRecibido=$request->input('idConsultante');        
        session()->flash('dniUsuario',session('dniUsuario'));
        $existe=$this->existeID($idRecibido);        
        if($existe=="Si"){
            return $this->mostrarEmpleados();
        }else{
            return "nope";
        }
    }
    public function reseteoPassEmpleado(Request $request){
        session()->flash('dniUsuario',session('dniUsuario'));
        $idTrabajador=$request->input('idTrabajador');
        $contraseniaSinMD5=$this->random_password();
        $trabajador=trabajadores::find($idTrabajador);
        $trabajador->password=md5($contraseniaSinMD5);
        $correo=$trabajador->correo;
        $trabajador->save();        
        //var_dump($correo);
    
        return $this->basic_email($correo,$contraseniaSinMD5);
        //return redirect()->route('reseteoContrasenia');
        //
    }
    private function basic_email($correo,$password) {
        session()->flash('correo',$correo);
        $contenido="La nueva contraseña es: ".$password."";
        Mail::raw($contenido, 
           function ($message) {
                $correo=session('correo');
                $message->to($correo)
                ->subject('Reseteo de contraseña');
           }
        ); 
        return "Compruebe su correo";
     } 
      
    private function random_password()  
    {  
        $longitud = 8; // longitud del password  
        $pass = substr(md5(rand()),0,$longitud);  
        return($pass); // devuelve el password   
    }  
    public function generarInforme(Request $resquest){
        $fechasRecibidaInicial=$this->devolverFechaEsp($resquest->input('fechaDesde'));
        $fechasRecibidaFinal=$this->devolverFechaEsp($resquest->input('fechaHasta'));
        $fechasEntre=[$resquest->input('fechaDesde'),$resquest->input('fechaHasta')];
        session()->flash('dniUsuario',session('dniUsuario'));
        $ArregloFinal=[];
        //Hacemos una consulta de trabjadores por su id para tener un array con los ids
        //de los trabajadores y poder recorrerlo correctamente
        $todasPersonasId=trabajadores::select('id')->get();
        for($reccorrido=0;$reccorrido<count($todasPersonasId);$reccorrido++){
            //Asociamos el id de la persona recorrida a una variable persona para facilitar las consultas
            $persona=$todasPersonasId[$reccorrido]["id"];       
            $resultado3=[];            
            //Recogemos el nombre especifico de esa persona y asociamos a una variable
            $busquedaUsuario=trabajadores::select('nombre')->where('id','=',$persona)->get();            
            $nombreUsuario=$busquedaUsuario[0]["nombre"];
            //Buscamos fechas distintas en las que esta persona haya hecho un picado           
            $resultado=picados::selectRaw('distinct Date_Format(picados.hora,"%Y-%m-%d") as dias, Date_Format(picados.hora,"%d/%m/%Y") as diasBien')
                ->whereRaw('date(hora) between "'.$fechasEntre[0].'" and "'.$fechasEntre[1].'" and personal='.$persona)
                    ->get();     
            //Recorremos los resultados buscando en cada fecha particular encontrada en la anterior busqueda
            //Esta devuelve la hora mínima y máxima de ese día particular       
            foreach($resultado as $item){
                $resultado2=picados::selectRaw('Max(DATE_FORMAT(picados.hora,"%H:%i:%S")) AS horasMax, Min(DATE_FORMAT(picados.hora,"%H:%i:%S")) AS horasMin')
                    ->whereRaw('date(hora) between "'.$item["dias"].'" and "'.$item["dias"].'" and  personal='.$persona)->get();
                //Estos datos lo guardamos en un array que llamamos fechas esta almacena la fecha
                //a desplegar y las horas mázimas y minimas
                $fechas=array(
                    "Fecha"=>$item["diasBien"],
                    "fechaMin"=>$resultado2[0]["horasMin"],
                    "fechaMax"=>$resultado2[0]["horasMax"]);
                //El array se añadirá a resultado3
                $resultado3[]=$fechas;       
            };
            //En caso de no encontrar picados en torno al rango el arregloPersona tendrá como resultado extio=no
            //Esto se usará para no mostrar este usuario
            if(empty($resultado3)){
                $ArregloPersona=[
                    "fechas"=>$resultado3,
                    "usuario"=>$nombreUsuario,
                    "existe"=>"No"                
                ];   
            }else{
                //En caso de que este relleno se confirmara con si. Aquí se guardará las fechas del anterior busqueda
                //Y el nombre de usuario
                $ArregloPersona=[
                    "fechas"=>$resultado3,
                    "usuario"=>$nombreUsuario,
                    "existe"=>"Si"                
                ];                            
            }
            //Y al final se guardarán en un arreglo final el rango de fechas y el anterior arreglo
            $ArregloFinal[]=[
                "idPersona"=>$persona,
                "ArregloIndividual"=>$ArregloPersona,
                "fechaInicial"=>$fechasRecibidaInicial,
                "fechaFinal"=>$fechasRecibidaFinal
            ];                      
        }
        //Devolvemos una vista donde se verán los resultados con capacidad de imprimirse en pdf        
        return view('documentocompleto')->with('Arreglo',$ArregloFinal);
    }

    
    //Busca una jornada especifica y un persona en especifico (Actualmente no tiene uso o esta adaptado a uso)
    //Pero se puede modificar para darle uso
    public function verJornadaEspecifica(){
        $persona=5;
        $fechasRecibidaInicial="02/03/2021";
        $fechasRecibidaFinal="30/03/2021";
        $fechasEntre=[$this->devolverFechaAmerica($fechasRecibidaInicial),$this->devolverFechaAmerica($fechasRecibidaFinal)];        
        $resultado3=[];
        
        //Condicionar nombre de usuario por si no existe
        $nombreUsuario=trabajadores::select('nombre')->where('id','=',$persona)->get();

        //Condicionar resultado1 puede devolver nulo;
        $resultado=picados::selectRaw('distinct Date_Format(picados.hora,"%Y-%m-%d") as dias, Date_Format(picados.hora,"%d/%m/%Y") as diasBien')
        ->whereRaw('date(hora) between "'.$fechasEntre[0].'" and "'.$fechasEntre[1].'" and personal='.$persona)
        ->get();
        foreach($resultado as $item){
            $resultado2=picados::selectRaw('Max(DATE_FORMAT(picados.hora,"%H:%i:%S")) AS horasMax, Min(DATE_FORMAT(picados.hora,"%H:%i:%S")) AS horasMin')
            ->whereRaw('date(hora) between "'.$item["dias"].'" and "'.$item["dias"].'" and  personal='.$persona)->get();
            $fechas=array(
                "Fecha"=>$item["diasBien"],
                "fechaMin"=>$resultado2[0]["horasMin"],
                "fechaMax"=>$resultado2[0]["horasMax"]);
            $resultado3[]=$fechas;       
        };
       //Se devolvera un array con los datos necesarios de la página
        $Arreglo=[
            "fechas"=>$resultado3,
            "usuario"=>$nombreUsuario[0]["nombre"],
            "fechaInicial"=>$fechasRecibidaInicial,
            "fechaFinal"=>$fechasRecibidaFinal
        ];        
        return view('documento')->with('Arreglo',$Arreglo);
    }
    //Devuelve todos las empresas
    public function verEmpresas(){
        session()->flash('dniUsuario',session('dniUsuario'));
        return empresas::select('id','nombre')->get();
    }
    
    //Muestra una consulta de un trabajador especifico mediante su idEmpleado con su nombre de empresa correspondiente
    public function verEmpleado(Request $request){
        session()->flash('dniUsuario',session('dniUsuario'));
        $idEmpleado=$request->input('idEmpleado'); 
        $arrayResultante=trabajadores::
        selectRaw("trabajadores.id, trabajadores.nombre, trabajadores.dni, trabajadores.correo, trabajadores.id_empresa")->
        where("id","=",$idEmpleado)->get();
        return $arrayResultante;
    }
   
    public function generarInformeSimplificado(Request $resquest){       
        session()->flash('dniUsuario',session('dniUsuario'));
        $fechasEntre=[$resquest->input('fechaDesde'),$resquest->input('fechaHasta')];              
        $ArregloFinal=$this->generarArrayInforme($fechasEntre);
        return view('documentocompleto')->with('Arreglo',$ArregloFinal);
    }
    
    //Verifica si el ID tiene permisos nivel 1 o no
    private function existeID($idRecibido){
        $idRecibido=strval($idRecibido);
        $trabajador=trabajadores::where('id','=',$idRecibido)->get();        
        if($trabajador[0]['nivel']==1){
            return "Si";
        }else{
            return "No";
        }
    }
    //Muestra una consulta de trabajadores con su nombre de empresa correspondiente
    private function mostrarEmpleados(){
        return trabajadores::selectRaw("trabajadores.id as 'idTrabajador', trabajadores.nombre, trabajadores.dni, empresas.nombre as 'empresaNombre'")
        ->join('empresas','empresas.id','=','trabajadores.id_Empresa')->get();
    }

    //Recibe una fecha española y devuelve una americana
    private function devolverFechaAmerica($fechaCorrecta){
        $arrayFecha=explode("/",$fechaCorrecta);
        return $arrayFecha[2]."-".$arrayFecha[1]."-".$arrayFecha[0];
    }
    //Recibe una fecha americana y devuelve una española
    private function devolverFechaEsp($fechaAmericana){
        $arrayFecha=explode("-",$fechaAmericana);
        return $arrayFecha[2]."/".$arrayFecha[1]."/".$arrayFecha[0];
    }
    private function mostrarDatosUsuario($idUsuario){
        return trabajadores::where("id","=",$idUsuario)->get();
    }

    //Añadir parametro
    private function crearTrabajador($nombre,$dni,$empresa,$correo)
    {
        $trabajador = new trabajadores;
        $trabajador->nombre = $nombre;
        $trabajador->dni = $dni;
        $trabajador->id_empresa = $empresa;
        $trabajador->nivel = 0;
        $trabajador->correo=$correo;
        $resultado=$trabajador->save();    
        return $resultado;
    }
    private function updateTrabajador($idEmpleado, $nombre, $dni, $empresa,$correo){
        $trabajador = trabajadores::find($idEmpleado);
        $trabajador->nombre = $nombre;
        $trabajador->dni = $dni;
        $trabajador->id_empresa = $empresa;
        $trabajador->correo=$correo;
        $resultado=$trabajador->save(); 
        return $resultado;
    }
    private function todosIDTrabajadores(){
        return trabajadores::select('id')->get();
    }
    private function busquedaNombreMedianteId($id){
        $busquedaUsuario=trabajadores::select('nombre')->where('id','=',$id)->get();            
        $nombreUsuario=$busquedaUsuario[0]["nombre"];
        return $nombreUsuario;
    }
    private function busquedaPicadosDiasDiferentesPicados($fechasEntre,$id){
        $resultado=picados::selectRaw('distinct Date_Format(picados.hora,"%Y-%m-%d") as dias, Date_Format(picados.hora,"%d/%m/%Y") as diasBien')
            ->whereRaw('date(hora) between "'.$fechasEntre[0].'" and "'.$fechasEntre[1].'" and personal='.$id)
            ->get(); 
        return $resultado; 
    }
    private function citasHoraInicioHoraFinalPorDia($item,$id){
        $resultado2=picados::selectRaw('Max(DATE_FORMAT(picados.hora,"%H:%i:%S")) AS horasMax, Min(DATE_FORMAT(picados.hora,"%H:%i:%S")) AS horasMin')
                ->whereRaw('date(hora) between "'.$item["dias"].'" and "'.$item["dias"].'" and  personal='.$id)
                ->get();
        $fechas=array(
            "Fecha"=>$item["diasBien"],
            "fechaMin"=>$resultado2[0]["horasMin"],
            "fechaMax"=>$resultado2[0]["horasMax"]);
        return  $fechas;
    } 
    private function resultadoEnArrayPersona($resultado3,$nombreUsuario){
        if(empty($resultado3)){
            $ArregloPersona=[
                "fechas"=>$resultado3,
                "usuario"=>$nombreUsuario,
                "existe"=>"No"                
            ];
            return $ArregloPersona;   
        }else{
            //En caso de que este relleno se confirmara con si. Aquí se guardará las fechas del anterior busqueda
            //Y el nombre de usuario
            $ArregloPersona=[
                "fechas"=>$resultado3,
                "usuario"=>$nombreUsuario,
                "existe"=>"Si"                
            ];
            return $ArregloPersona;          
        }
    }
    private function generarArrayInforme($fechasEntre){
        $fechasRecibidaInicial=$this->devolverFechaEsp($fechasEntre[0]);
        $fechasRecibidaFinal=$this->devolverFechaEsp($fechasEntre[1]);
        $todasPersonasId=$this->todosIDTrabajadores();
        $ArregloFinal=[];
        for($reccorrido=0;$reccorrido<count($todasPersonasId);$reccorrido++){
            $persona=$todasPersonasId[$reccorrido]["id"];       
            $nombreUsuario=$this->busquedaNombreMedianteId($persona);           
            $resultado=$this->busquedaPicadosDiasDiferentesPicados($fechasEntre,$persona);             
            $resultado3=$this->rellenarFechas($resultado,$persona);
            $ArregloPersona=$this->resultadoEnArrayPersona($resultado3,$nombreUsuario);           
            $ArregloFinal[]=[
                "idPersona"=>$persona,
                "ArregloIndividual"=>$ArregloPersona,
                "fechaInicial"=>$fechasRecibidaInicial,
                "fechaFinal"=>$fechasRecibidaFinal
            ]; 
        }
        return $ArregloFinal;
    }
    private function rellenarFechas($resultado,$id){
        $resultado3=[];            
        foreach($resultado as $item){                        
            $fechas=$this->citasHoraInicioHoraFinalPorDia($item,$id);
            $resultado3[]=$fechas;       
        };
        return $resultado3;
    }
}
