Validando...
<?php
require("bd.php");

session_start();

if(isset($_REQUEST['usuario']) && isset($_REQUEST['clave'])) {
    // Comprobar que es correcto usuario y clave para la redireccción
    $userid = comprobarUsuario($_REQUEST['usuario'], $_REQUEST['clave']); 

    switch ($userid) {
        case -2:
            $_SESSION['mensaje'] = "No se pudó acceder a la base de datos";
            header('Location: ./index.php');
        break;
        
        case -1:
            $_SESSION['mensaje'] = "El usuario y la contraseña no coinciden";
            header('Location: ./index.php');
        break;
        
        default:
            $_SESSION['userid'] = $userid;
            header('Location: ./menu.php');
        break;
    }
}
else{
    // Si se ha llamado directamente a este PHP te reenvia al login
    header('Location: ./index.php');
}
?>
