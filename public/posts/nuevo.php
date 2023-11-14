<?php
session_start();
if(!isset($_SESSION['id'])){
    header("HTTP/1.1 401 Unauthorized");
    require __DIR__."/../errores/error401.htm";
    die();
}
$userId=$_SESSION['id']; //id del usuario logeado 

use App\Db\Post;
use App\Utils\Utilidades;

use const App\Utils\MAY_ON;



require_once __DIR__ . "/../../vendor/autoload.php";
if (isset($_POST['btn'])) {
    $titulo = Utilidades::sanearCadenas($_POST['titulo'], MAY_ON);
    $descripcion = Utilidades::sanearCadenas($_POST['descripcion'], MAY_ON);

    $errores = false;
    if (!Utilidades::cadenaValida("Titulo", $titulo, 3)) {
        $errores = true;
    }
    if (!Utilidades::cadenaValida("Descripcion", $descripcion, 10)) {
        $errores = true;
    }

    //Imagen 
    $imagen = "img/posts/default.jpg";
    if (is_uploaded_file($_FILES['imagen']['tmp_name'])) {
        if (!Utilidades::imagenValida($_FILES['imagen']['type'], $_FILES['imagen']['size'])) {
            $errores = true;
        } else {
            $ruta = "./../";
            $imagen = "img/posts/" . uniqid() . "_" . $_FILES['imagen']['name']; // "img/posts/123132as_imagen.jpg"
            if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta . $imagen)) {
                $_SESSION['Imagen'] = "*** Error No se pudo guardar la imagen";
            }
        }
    } 

    if ($errores) {
        header("Location:{$_SERVER['PHP_SELF']}");
        die();
    }

    (new Post)->setTitulo($titulo)
    ->setDescripcion($descripcion)
    ->setImagen($imagen)
    ->setUser($userId)
    ->create();
    $_SESSION['mensaje']="Post guardado";
    header("Location:index.php");
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
    <title>Crear</title>
</head>

<body style="background-color:blanchedalmond">
    <div class="container p-8 mx-auto">
        <!------------------------------------------------------ NAVBAR -->
        <ul class='flex flex-row-reverse mt-2'>
            <li class="mr-6">
                <a class="text-blue-500 hover:text-blue-800" href='close.php'><i class='fa-solid fa-arrow-right-from-bracket'></i> Salir</a>
            </li>
            <li class="mr-6">
                <a class="text-blue-500 hover:text-blue-800" href='index.php'><i class='fa-regular fa-newspaper'></i> Mis Posts</a>
            </li>
            <li class="mr-6">
                <a class="text-blue-500 hover:text-blue-800" href='../'><i class='fas fa-home'></i> Home</a>
            </li>
        </ul> <!----------------------------------------------------- FIN NAV BAR -->
        <h3 class="text-2xl text-center mt-4">Crear Post</h3>
        <div class="w-3/4 mx-auto p-6 rounded-xl bg-gray-400">
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
                <div class="mb-6">
                    <label for="titulo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Título</label>
                    <input type="text" name="titulo" id="nombre" placeholder="Título..." class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <?php
                    Utilidades::mostrarErrores("Titulo");
                    ?>
                </div>
                <div class="mb-6">
                    <label for="desc" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Descripción</label>
                    <textarea name="descripcion" rows='5' id="desc" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
                    <?php
                    Utilidades::mostrarErrores("Descripcion");
                    ?>
                </div>
                <div class="mb-6">
                    <div class="flex w-full">
                        <div class="w-1/2 mr-2">
                            <label for="imagen" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                IMAGEN</label>
                            <input type="file" id="imagen" oninput="img.src=window.URL.createObjectURL(this.files[0])" name="imagen" accept="image/*" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                            <?php
                            Utilidades::mostrarErrores("Imagen");
                            ?>
                        </div>
                        <div class="w-1/2">
                            <img src="../img/posts/default.jpg" class="h-72 rounded w-full object-cover border-4 border-black" id="img">
                        </div>
                    </div>

                </div>

                <div class="flex flex-row-reverse">
                    <button type="submit" name="btn" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <i class="fas fa-save mr-2"></i>GUARDAR
                    </button>
                    <button type="reset" class="mr-2 text-white bg-yellow-700 hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-blue-800">
                        <i class="fas fa-paintbrush mr-2"></i>LIMPIAR
                    </button>
                    <a href="index.php" class="mr-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-blue-800">
                        <i class="fas fa-backward mr-2"></i>VOLVER
                    </a>
                </div>

            </form>
        </div>
    </div>
</body>

</html>