Modificando Usuario ...
<?php 
require("bd.php");
session_start();

// Control de flujo
if(!isset($_SESSION['userid']))
    header('Location: ./index.php');

$_SESSION['pagina'] = "./usuarios.php";

// Control de parametros del formulario
if( !(isset($_REQUEST['tipopago'])
    && isset($_REQUEST['clave'])
    && isset($_REQUEST['clave2'])
    && isset($_REQUEST['nombre'])
    && isset($_REQUEST['codigo'])
    && isset($_REQUEST['tarjeta'])
    && isset($_REQUEST['cuenta'])
    && isset($_REQUEST['telefono'])
    && isset($_REQUEST['domicilio']))) {
    header('Location: ./index.php');
}

if($_REQUEST['domicilio']=="") {
    $_SESSION['mensaje'] = "El domicilio es un campo obligatorio";
    header('Location: ./menu.php');
}

echo $_REQUEST['clave'];
echo "|";
echo $_REQUEST['clave2'];

if($_REQUEST['clave'] != $_REQUEST['clave2']) {
    $_SESSION['mensaje'] = "La contraseña debe de ser la misma";
    header('Location: ./menu.php');
}

modificarUsuario(
    $_REQUEST['nombre'],
    $_REQUEST['clave'],
    $_REQUEST['domicilio'],
    $_REQUEST['telefono'],
    $_REQUEST['tipopago'],
    $_REQUEST['tarjeta'],
    $_REQUEST['cuenta'],
    $_REQUEST['codigo']
);

$_SESSION['pagina'] = "./usuarios.php";
header("Location: ./menu.php");
?>