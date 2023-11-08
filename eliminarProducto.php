Eliminando producto...
<?php 
require("bd.php");
session_start();

// Control de flujo
if(!isset($_SESSION['userid']))
    header('Location: ./index.php');

// Control de existencia de elementos en el formulario
if(!isset($_REQUEST['codigo']))
    header('Location: ./index.php');

eliminarProducto($_REQUEST['codigo']);

$_SESSION['pagina'] = "./productos.php";
header('Location: ./menu.php');
?>