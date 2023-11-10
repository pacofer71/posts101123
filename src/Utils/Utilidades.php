<?php
namespace App\Utils;
const MAY_ON=1;
const MAY_OFF=0;
class Utilidades{
    public static function sanearCadenas($valor, $mode=MAY_OFF): string{
        if($mode==MAY_ON){
           return ucfirst(htmlspecialchars(trim($valor)));
        }
        return htmlspecialchars(trim($valor));
    }
    public static function emailValido($email): bool{
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $_SESSION['Email']="*** Error el email NO es válido";
            return false;
        }
        return true;
    }

    public static function mostrarErrores($nombre){
        if(isset($_SESSION[$nombre])){
            echo "<p class='text-red-700 italic text-sm mt-2'>{$_SESSION[$nombre]}</p>";
            unset($_SESSION[$nombre]);
        }
    }

}