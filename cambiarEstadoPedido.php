Cambiando estado del pedido...
<?php 
require("bd.php");
session_start();

// Control de flujo
if(!isset($_SESSION['userid']))
    header('Location: ./index.php');

if(isset($_REQUEST['codigo']) && isset($_REQUEST['estado'])) {
    cambiarEstadoPedido($_REQUEST['codigo'], $_REQUEST['estado']);

    if($_REQUEST['estado']==3)
        restablecerStock($_REQUEST['codigo']);

    $_SESSION["pagina"] = "./pedidos.php";
    header('Location: ./menu.php');
}
?>