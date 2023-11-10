<?php

use App\Db\Post;
use App\Db\User;

    require_once __DIR__."/../vendor/autoload.php";
    User::generarUsuarios(15);
    Post::generarPosts(50);
    $posts=Post::readAll();
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
    <a class="text-blue-500 hover:text-blue-800" href="login.php">LOGIN</a>
  </li>
  <li class="mr-6">
    <a class="text-blue-500 hover:text-blue-800" href="./users/register.php">REGISTRASE</a>
  </li>
</ul>
<h3 class="text-xl text-center my-2">POSTS Al-ANDALUS</h3>
<div class="grid grid-cols-3 gap-2 mx-auto w-3/4">
    <?php
    foreach($posts as $item){
        echo <<< TXT
        <article class="h-80 w-full" style="background-image:url('./{$item->imagen}')">
          <div class="flex flex-col justify-around h-full">
            <div class="w-full text-center text-2xl font-semibold">{$item->titulo}</div>
            <div class='w-full text-center italic text-lg'>{$item->email}</div>
          </div>
        </article>
        TXT;
    }
    ?>
</div>
</body>
</html>










