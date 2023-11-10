<?php
    session_start();
    if(!isset($_SESSION['email'])){
        header("Location:../index.php");
        die();
    }
    $id=$_SESSION['id']; //el id del usuario logeado;
    $email=$_SESSION['email'];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind css -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>posts</title>
</head>

<body style="background-color:blanchedalmond">
<ul class="flex flex-row-reverse mt-4 w-3/4 mx-auto">
  <li class="mr-6">
    <a class="text-blue-500 hover:text-blue-800" href="login.php"><i class="fa-solid fa-arrow-right-from-bracket"></i> Salir</a>
  </li>
  <li class="mr-6">
    <a class="text-blue-500 hover:text-blue-800" href="../index.php"><i class="fas fa-home"></i> Home</a>
  </li>
</ul>
<h3 class="text-xl text-center my-2">Posts de : <?php echo $email ?></h3>
</body>
</html>