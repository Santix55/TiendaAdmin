Editando producto...
<?php
require("bd.php");
session_start();

// Control de flujo
if(!isset($_SESSION['userid']))
    header('Location: ./index.php');

if(!(isset($_REQUEST['codigo'])
   && isset($_REQUEST['nombre'])
   && isset($_REQUEST['precio'])
   && isset($_REQUEST['existencias'])
   && isset($_REQUEST['imagen'])
   && isset($_REQUEST['descripcion']))) {
    header('Location: ./index.php');
}

$codigo = (int) $_REQUEST['codigo'];
$nombre = $_REQUEST['nombre'];
$precio = $_REQUEST['precio'];
$existencias = $_REQUEST['existencias'];
$imagen = $_REQUEST['imagen'];
$descripcion = $_REQUEST['descripcion'];

// Comprobar que los números sean correctos
$error_num = !is_numeric($precio) || !is_numeric($existencias);
if(!$error_num) {
    $precio = (int) $precio;
    $existencias = (int) $existencias;

    $error_num = $precio<0 || $existencias<0;
}

if($error_num) {    // Comprobar que los números son correctos
    redirigirError("Los precios y las existencias deben de ser números mayores o iguales que 0");
}
else if(empty($nombre)||empty($imagen)||empty($descripcion)) { // Comprobar que el resto de datos no esten vacíos
    redirigirError("No se pueden dejar campos vacíos");
}
else {
    $mensaje = editarProducto($codigo, $nombre, $precio, $existencias, $imagen, $descripcion);
    if($mensaje == "Se ha modificado correctamente el producto"){
        $_SESSION['mensaje'] = $mensaje;
        $_SESSION['pagina'] = "./productos.php";
        header('Location: ./menu.php');
    } else {
        redirigirError($mensaje);
    }
}

function redirigirError($mensajeError) {
    $_SESSION['mensaje'] = $mensajeError;
    $_SESSION['pagina'] = "./productos.php";
    header('Location: ./menu.php');
}

?>