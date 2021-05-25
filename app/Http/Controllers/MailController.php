<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
class MailController extends Controller
{
    //    
   public function basic_email() {
      $correo=session('correo');
      $pass=session('contrasenia');
      $contenido="La contraseña es: ".$pass."";
      Mail::raw($contenido, 
         function ($message) {
            $message->to($correo)
            ->subject('Hi, welcome user!');
         }
      ); 
      echo "Sa {{$correo}}";
   } 
    
    
}
