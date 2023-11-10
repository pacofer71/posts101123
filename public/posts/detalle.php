<?php

use App\Db\Post;

if (!isset($_GET['id'])) {
    header("Location:index.php");
    die();
}
$id = $_GET['id'];
require_once __DIR__ . "/../../vendor/autoload.php";
$post = Post::detalle($id);
if (!$post) {
    header("Location:index.php");
    die();
}
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
    <h3 class="text-xl text-center my-2">Post detallado</h3>
    <!-- card -->

    <div class="w-1/3 mx-auto bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        <img class="rounded-t-lg w-full" src="<?php echo "./../" . $post->imagen ?>" alt="">
        <div class="p-5">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"><?php echo $post->titulo ?></h5>
            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400"><?php echo $post->descripcion ?></p>
            <p class="mb-3 font-normal text-blue-700 dark:text-blue-400">Usuario: <?php echo $post->email ?></p>
        </div>

        <!-- fin card -->
    </div>
</body>

</html>