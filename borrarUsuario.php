<!DOCTYPE html>
<?php 
require("bd.php");
session_start();

// Control de flujo
if(!isset($_SESSION['userid']))
    header('Location: ./index.php');

// Control de que párametros del formulario
if(!isset($_REQUEST['codigo']))
    header('Location: ./index.php');

eliminarUsuario($_REQUEST['codigo']);
$_SESSION['pagina'] = "./usuarios.php";
header('Location: ./menu.php');
?>