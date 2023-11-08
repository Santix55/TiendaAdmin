Eliminar pedido ...
<?php 
require("bd.php");
session_start();

// Control de flujo
if(!isset($_SESSION['userid']))
    header('Location: ./index.php');

if(isset($_REQUEST['codigo'])) {
    eliminarPedido($_REQUEST['codigo']);
    $_SESSION['pagina'] = "./pedidos.php";
    header('Location: ./menu.php');
}
else
    header('Location: ./index.php');
?>