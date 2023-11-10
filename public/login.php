<?php

use App\Db\User;
use App\Utils\Utilidades;

session_start();
require_once __DIR__."/../vendor/autoload.php";
if(isset($_POST['btn'])){
    $email=Utilidades::sanearCadenas($_POST['email']);
    $password=Utilidades::sanearCadenas($_POST['password']);
    $errores=false;
    if(!Utilidades::emailValido($email)){
        $errores=true;
    }
    if($errores){
      header("Location:login.php");
      die();
    }
    //intentamos validarnos
    $datos=User::login($email, $password); //esto sera false si falla la val
    if(!$datos){
        $_SESSION['errVal']="Email o password Incorrectos!!!";
        header("Location:login.php");
        die();
    }
    //si estoy aqui login valido voy a index del posts
    $_SESSION['email']=$email;
    $_SESSION['id']=$datos->id;
    $_SESSION['perfil']=$datos->isAdmin;
    header("Location:./posts/index.php");

    
}
?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind css -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Document</title>
</head>

<body style="background-color:blanchedalmond">
    <h3 class="text-2xl text-center mt-4">POSTS AL-ANDALUS</h3>
    <!-- Formulario login -->
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto lg:py-0 mt-4">
        <div class="w-full bg-white rounded-xl shadow-xl dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                    Sign in to your account
                </h1>
                <form class="space-y-4 md:space-y-6" action="login.php" method="POST">
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
                        <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@company.com" required="">
                        <?php
                            Utilidades::mostrarErrores("Email");
                        ?>
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                        <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
                        <?php
                            Utilidades::mostrarErrores("errVal");
                        ?>
                    </div>
                    <button type="submit" name="btn" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-xl"><i class="fa-solid fa-arrow-right-to-bracket mr-2"></i>Sign in</button>
                    <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                        Don’t have an account yet? <a href="./users/register.php" class="font-medium text-primary-600 hover:underline dark:text-primary-500">Registrate</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
    <!-- FIN FORMULARIO -->
</body>

</html>