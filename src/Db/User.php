<?php
namespace App\Db;
use \PDO;
use \PDOException;

class User extends Conexion{
    private int $id;
    private string $email;
    private string $password;
    private string $foto;
    private int $isAdmin;

    public function __construct()
    {
        parent::__construct();
    }
    //---------------------------------------------- CRUD -------------------
    public function create(){
        $q="insert into users(email, password, foto, isAdmin) values(:e, :p, :f, :iA)";
        $stmt=parent::$conexion->prepare($q);
        try{
            $stmt->execute([
                ':e'=>$this->email,
                ':p'=>$this->password,
                ':f'=>$this->foto,
                ':iA'=>$this->isAdmin
            ]);
        }catch(PDOException $ex){
            die("Error en create: ".$ex->getMessage());
        }
        parent::$conexion=null;
    }
    //---------------------------------------------- OTROS METODOS ----------
    public static function login(string $email, string $password){
        parent::setConexion();
        $q="select id, isAdmin, password from users where email=:e";
        $stmt=parent::$conexion->prepare($q);
        try{    
            $stmt->execute([':e'=>$email]);
        }catch(PDOException $ex){
            die("Error en Login: ".$ex->getMessage());
        }
        parent::$conexion=null;
        $datos=$stmt->fetch(PDO::FETCH_OBJ);
        if(!$datos) return false; 
        //ok el correo existe vamos a ver si el pass es correcto
        if(!password_verify($password, $datos->password)){
            //el correo era valido pero NO el password
            return false;
        }
        //Si he llegado aqui el login es correcto necesito enviar isAdmin
        return $datos;
    }

    //---------------------------------------------- FAKER ------------------
    private static function hayUsuarios():bool{
        parent::setConexion();
        $q="select id from users";
        $stmt=parent::$conexion->prepare($q);
        try{
            $stmt->execute();
        }catch(PDOException $ex){
            die("error en hayDatos: ".$ex->getMessage());
        }
        parent::$conexion=null;
        return $stmt->rowCount();
    }
    public static function generarUsuarios(int $cant){
        if(self::hayUsuarios()) return;
        $faker= \Faker\Factory::create('es_ES');
        for($i=0; $i<$cant; $i++){
            $email=$faker->unique()->email;
            $password="secret0";
            $foto="img/perfil/default.webp";
            $isAdmin=random_int(0,1);

            (new User)->setEmail($email)
            ->setPassword($password)
            ->setFoto($foto)
            ->setIsAdmin($isAdmin)
            ->create();
        }
    }
    //devolveremos un array con todos los id de los usuarios para el faker de posts
    public static function devolverUserId(): array{
        parent::setConexion();
        $q="select id from users";
        $stmt=parent::$conexion->prepare($q);
        try{
            $stmt->execute();
        }catch(PDOException $ex){
            die("error en devolver ids de user: ".$ex->getMessage());
        }
        parent::$conexion=null;
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    
    //---------------------------------------------- SETTERS ----------------
    

    /**
     * Set the value of id
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set the value of email
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Set the value of password
     */
    public function setPassword(string $password): self
    {
        $this->password = password_hash($password, PASSWORD_BCRYPT);

        return $this;
    }

    /**
     * Set the value of foto
     */
    public function setFoto(string $foto): self
    {
        $this->foto = $foto;

        return $this;
    }

    /**
     * Set the value of isAdmin
     */
    public function setIsAdmin(int $isAdmin): self
    {
        $this->isAdmin = $isAdmin;

        return $this;
    }
}