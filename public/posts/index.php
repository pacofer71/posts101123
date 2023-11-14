<?php

use App\Db\Post;

session_start();
if (!isset($_SESSION['email'])) {
  header("Location:../index.php");
  die();
}
require_once __DIR__ . "/../../vendor/autoload.php";

$id = $_SESSION['id']; //el id del usuario logeado;
$email = $_SESSION['email'];
$posts = Post::readAll($id); //solo me devolverá los posts del usuario logeado
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
  <!-- NAV BAR -->
  <ul class="flex flex-row-reverse mt-4 w-3/4 mx-auto">
    <li class="mr-6">
      <a class="text-blue-500 hover:text-blue-800" href="logout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i> Salir</a>
    </li>
    <li class="mr-6">
      <a class="text-blue-500 hover:text-blue-800" href="../index.php"><i class="fas fa-home"></i> Home</a>
    </li>
  </ul>
  <!-- FIN NAVB BAR -->
  <h3 class="text-xl text-center my-2">Posts de : <?php echo $email ?></h3>
  <div class="w-3/4 mx-auto flex flex-row-reverse my-2">
    <a href="nuevo.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
      <i class="fas fa-add"></i> NUEVO
    </a>
  </div>
  <!-- Tabla POSTS-->
  <div class="w-3/4 mx-auto">
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
      <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
          <tr>
            <th scope="col" class="px-6 py-3">
              <span class="sr-only">Imagen</span>
            </th>
            <th scope="col" class="px-6 py-3">
              TITULO
            </th>
            <th scope="col" class="px-6 py-3">
              DESCRIPCION
            </th>
            <th scope="col" class="px-6 py-3">
              Action
            </th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($posts as $item) {
            echo <<<TXT
          <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
            <td class="w-32 p-4">
              <img src="./../{$item->imagen}" alt="{$item->titulo}">
            </td>
            <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
              {$item->titulo}
            </td>
            <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
              {$item->descripcion}
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <form action="borrar.php" method="POST">
              <input type="hidden" name="id" value="{$item->id}" />
              <a href="detalle.php?id={$item->id}"><i class="fas fa-info"></i><a>
              <a href="update.php?id={$item->id}"><i class="mx-2
              
              fas fa-edit"></i></a>
              <button type="submit"><i class="fas fa-trash"></i></button>
              </form>
            </td>
          </tr>
        TXT;
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
  <!-- FIN TABLA POSTS -->
  <?php
  if (isset($_SESSION['mensaje'])) {
    echo <<<TXT
      <script>
      Swal.fire({
        icon: "success",
        title: "{$_SESSION['mensaje']}",
        showConfirmButton: false,
        timer: 1500
      });
      </script>
      TXT;
    unset($_SESSION['mensaje']);
  }
  ?>
</body>

</html>