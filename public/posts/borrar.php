<?php

use App\Db\Post;

session_start();
if(!isset($_POST['id']) || !isset($_SESSION['email'])){
    header("Location:index.php");
    die();
}
$idPost=$_POST['id'];
$idUser=$_SESSION['id']; 

//  echo "id_post=$idPost <br>";
//  echo "id_user=$idUser <br>";
//  die();

require_once __DIR__."/../../vendor/autoload.php";

//Tenemos que comprobar que el post a borrar pertenece al usuario logeado
$post=Post::detalle($idPost, $idUser); //me devolvera o bien false si ese post no pertenece al user o los datops del post 


if(!$post){
    header("HTTP/1.1 401 Unauthorized");
    require __DIR__."/../errores/error401.htm";
    die();
}
//el post que queremos borra es nuestro, procedemos a borrarlo pero cuidado con la imagen
$imagen=$post->imagen;
if(basename($imagen)!='default.jpg'){
    //tengo que borrarla img/posts/nombre.jpg
    unlink("./../$imagen");
}
//borro el post
Post::delete($idPost);
$_SESSION['mensaje']="POST Borrado con relativo éxito";
header("Location:index.php");