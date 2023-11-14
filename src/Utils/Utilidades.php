<?php
namespace App\Utils;
const MAY_ON=1;
const MAY_OFF=0;
class Utilidades{
    public static array $tiposImagen = [
        'image/gif',
        'image/png',
        'image/jpeg',
        'image/bmp',
        'image/webp',
        'image/x-icon',
        'image/svg+xml'
    ];

    public static function sanearCadenas($valor, $mode=MAY_OFF): string{
        if($mode==MAY_ON){
           return ucfirst(htmlspecialchars(trim($valor)));
        }
        return htmlspecialchars(trim($valor));
    }

    public static function cadenaValida(string $nombre,string $valor,int $longitud): bool{
        if(strlen($valor)<$longitud){
            $_SESSION[$nombre]="*** El campo $nombre debe tener al menos una longitud de $longitud";
            return false;
        }
        return true;
    }

    public static function emailValido($email): bool{
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $_SESSION['Email']="*** Error el email NO es válido";
            return false;
        }
        return true;
    }

    public static function imagenValida(string $tipo, int $size): bool{
        if(!in_array($tipo, self::$tiposImagen)){
            $_SESSION['Imagen']="*** Se esperaba un archivo de imagen";
            return false;
        }
        if($size>2000000){
            $_SESSION['Imagen']="*** La imagen excede los 2MB permitidos";
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