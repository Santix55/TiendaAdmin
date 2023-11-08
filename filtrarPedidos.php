<?php
session_start();
// Control de flujo
if(!isset($_SESSION['userid']))
    header('Location: ./index.php');

// Redirigir a la página de pedidos, 
// pero ahora se carga con los datos especificados en el formulario
if(isset($_REQUEST['campo'])
   && isset($_REQUEST['valor'])
   && isset($_REQUEST['campo']) ) {
    $_SESSION['campo'] = $_REQUEST['campo'];
    $_SESSION['valor'] = $_REQUEST['valor'];
    $_SESSION['pagina'] = "./pedidos.php"; 
    header('Location: ./menu.php');
} else {
    header('Location: ./index.php');
}

?>