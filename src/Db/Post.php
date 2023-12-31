<?php
namespace App\Db;

use \PDOException;
use \PDO;

class Post extends Conexion{
    private int $id;
    private string $titulo;
    private string $descripcion;
    private string $imagen;
    private int $user;

    public function __construct()
    {
        parent::__construct();
    }
    //_________________________________________________ CRUD ____________
    public function  create(){
        $q="insert into posts(titulo, descripcion, imagen, user) values(:t, :d, :i, :u)";
        $stmt=parent::$conexion->prepare($q);
        try{
            $stmt->execute([
                ':t'=>$this->titulo,
                ':d'=>$this->descripcion,
                ':i'=>$this->imagen,
                ':u'=>$this->user,
            ]);
        }catch(PDOException $ex){
            die("Error en create: ".$ex->getMessage());
        }
        parent::$conexion=null;
    }

    public function update(int $id){
        $q="update posts set titulo=:t, descripcion=:d, imagen=:i, user=:u where id=:id";
        $stmt=parent::$conexion->prepare($q);
        try{
            $stmt->execute([
                ':t'=>$this->titulo,
                ':d'=>$this->descripcion,
                ':i'=>$this->imagen,
                ':u'=>$this->user,
                ':id'=>$id
            ]);
        }catch(PDOException $ex){
            die("Error en update: ".$ex->getMessage());
        }
        parent::$conexion=null;
    }

    public static function readAll(?int $id=null){
        parent::setConexion();
        $q=($id==null) ?
        "select posts.*, email from users, posts where users.id=posts.user order by posts.id desc" :
        "select posts.*, email from users, posts where users.id=posts.user AND users.id=:i order by posts.id desc";
        $stmt=parent::$conexion->prepare($q);
        try{
            ($id==null) ? $stmt->execute() : $stmt->execute([':i'=>$id]);
        }catch(PDOException $ex){
            die("error en readAll: ".$ex->getMessage());
        }
        parent::$conexion=null;
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public static function detalle(int $idPost, int $idUser=null){
        parent::setConexion();
        $q=($idUser==null) ? "select posts.*, email from users, posts where users.id=posts.user AND posts.id=:idP"
        : "select * from posts where id=:idP AND user=:idU ";

        $opciones=($idUser==null) ? [':idP'=>$idPost] : [':idP'=>$idPost, ':idU'=>$idUser];

        $stmt=parent::$conexion->prepare($q);
        try{
            $stmt->execute($opciones);
        }catch(PDOException $ex){
            die("error en detalle: ".$ex->getMessage());
        }
        parent::$conexion=null;
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public static function delete(int $id){
        parent::setConexion();
        $q="delete from posts where id=:i";
        $stmt=parent::$conexion->prepare($q);
        try{
            $stmt->execute([':i'=>$id]);
        }catch(PDOException $ex){
            die("error en borrar: ".$ex->getMessage());
        }
        parent::$conexion=null;

    }

    //_________________________________________________ FAKER ___________
    private static function hayPosts():bool{
        parent::setConexion();
        $q="select id from posts";
        $stmt=parent::$conexion->prepare($q);
        try{
            $stmt->execute();
        }catch(PDOException $ex){
            die("error en hayPosts: ".$ex->getMessage());
        }
        parent::$conexion=null;
        return $stmt->rowCount();
    }
    public static function generarPosts(int $cant){
        if(self::hayPosts()) return;
        $faker=\Faker\Factory::create('es_ES');
        $faker->addProvider(new \Mmo\Faker\PicsumProvider($faker));
        for($i=0; $i<$cant; $i++){
            $titulo=ucfirst($faker->words(random_int(2,4), true));
            $descripcion=$faker->text();
            $imagen="img/posts/".$faker->picsum("./img/posts/", 640, 480, false);
            $user=$faker->randomElement(User::devolverUserId())->id;

            (new Post)->setTitulo($titulo)
            ->setDescripcion($descripcion)
            ->setImagen($imagen)
            ->setUser($user)
            ->create();



        }
    }

    //_________________________________________________ SETTERS _________
    

    /**
     * Set the value of id
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set the value of titulo
     */
    public function setTitulo(string $titulo): self
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Set the value of descripcion
     */
    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Set the value of imagen
     */
    public function setImagen(string $imagen): self
    {
        $this->imagen = $imagen;

        return $this;
    }

    /**
     * Set the value of user
     */
    public function setUser(int $user): self
    {
        $this->user = $user;

        return $this;
    }
}