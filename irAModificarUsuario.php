Redirigiendo a modificar usuario ...
<?php 
require("bd.php");
session_start();

// Control de flujo
if(!isset($_SESSION['userid']))
    header('Location: ./index.php');

if(isset($_REQUEST['codigo'])){
    $_SESSION['codigo'] = $_REQUEST['codigo'];
    $_SESSION['pagina'] = "./modificarUsuario.php";
    header('Location: ./menu.php');
} else {
    header('Location: ./index.php');
}