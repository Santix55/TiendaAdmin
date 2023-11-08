Añadiendo nuevo producto...
<?php
require("bd.php");
session_start();

// Control de flujo
if(!isset($_SESSION['userid']))
    header('Location: ./index.php');

$nombre = $_REQUEST['nombre'];
$precio = $_REQUEST['precio'];
$existencias = $_REQUEST['existencias'];
$imagen = $_REQUEST['imagen'];
$descripcion = $_REQUEST['descripcion'];
/*
// DEBUG
echo "nombre".$nombre."\n";
echo "precio".$precio."\n";
echo "existencias".$existencias."\n";
echo "imagen".$imagen."\n";
echo "descripcion".$descripcion."\n";
*/

error_log(var_export($nombre, true));
error_log(var_export($precio, true));
error_log(var_export($existencias, true));
error_log(var_export($imagen, true));
error_log(var_export($descripcion, true));

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
    $mensaje = anyadirProducto($nombre, $precio, $existencias, $imagen, $descripcion);
    if($mensaje == "Se ha insertado correctamente el producto"){
        $_SESSION['mensaje'] = $mensaje;
        $_SESSION['pagina'] = "./productos.php";
        header('Location: ./menu.php');
    } else {
        redirigirError($mensaje);
    }
}

function redirigirError($mensajeError) {
    $_SESSION['mensaje'] = $mensajeError;
    $_SESSION['pagina'] = "./nuevoProducto.php";
    header('Location: ./menu.php');
}

?>