CambiarAdmin...
<?php 
require("bd.php");
session_start();

// Control de flujo
if(!isset($_SESSION['userid']))
    header('Location: ./index.php');

if(isset($_REQUEST['codigo'])) {
    negarCampoUsuario("activo", $_REQUEST['codigo']);
    $_SESSION["pagina"] = "./usuarios.php";
    header('Location: ./menu.php');
}

?>