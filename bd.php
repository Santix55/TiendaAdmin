<?php

function abrirConexionBD() {
    $recurso = mysqli_connect("localhost","root","","daw");
    if(mysqli_connect_error()){
        printf("Error conectando a la base de datos: %s", mysqli_connect_error());
        return false;
    }
    
    $recurso->set_charset("utf8");
    return $recurso;
}

function cerrarConexionBD(&$recurso) {
    mysqli_close($recurso);
}

/**
 * Devuelve el id perteneciente al usuario si coincinde el nombre y el hash de la contraseña y además es admin
 * @param string $usuario Nombre de usuario
 * @param string $clave   Clave antes del hash
 * @return int            Código de usuario (-1: No se encuentra)(-2: No se pudo acceder a la BD)
 */
function comprobarUsuario($usuario,$clave){
    $recurso = abrirConexionBD();
    
    if($recurso) {
        
        if($mi_consulta = mysqli_prepare($recurso, "SELECT `codigo` FROM `usuarios` WHERE usuario=? and clave=? and admin=1")){
            mysqli_stmt_bind_param($mi_consulta, "ss", $usuario, hash256($clave));
            mysqli_stmt_execute($mi_consulta);
            $resultados = mysqli_stmt_get_result($mi_consulta);
        }
        
        
        if($fila = mysqli_fetch_array($resultados))
            $userid = $fila[0];
        else
            $userid = -1;
    }
    
    
    mysqli_free_result($resultados);
    cerrarConexionBD($recurso);
    
    return $userid;
}

/**
 * Se utiliza para devolver el hash de una contraseña
 * @param string $s string del cual se quiere obtener el hash
 * @return string Representación base 64 del hash
 */
function hash256($s) {
    $hash = hash('sha256', $s, true);
    return base64_encode($hash);
}

/**
 * Devuelve el cursor que recorre los productos
 */
function obtenerProductos() {
    $recurso = abrirConexionBD();
    if($recurso) {
        $consulta = "SELECT * FROM `productos`";
        $resultados = mysqli_query($recurso, $consulta);
        
        cerrarConexionBD($recurso);
        return $resultados;
    }
    return null;
}

function anyadirProducto($nombre, $precio, $existencias, $imagen, $descripcion) {
    $recurso = abrirConexionBD();

    if(!$recurso){
        return "No se pudó conectar con la base de datos";
    }
    
    if($mi_consulta = mysqli_prepare($recurso, "INSERT INTO `productos` (nombre, precio, existencias, imagen, descripcion) VALUES (?,?,?,?,?)")){
        mysqli_stmt_bind_param($mi_consulta, "siiss", $nombre, $precio, $existencias, $imagen, $descripcion);
        mysqli_stmt_execute($mi_consulta);
        cerrarConexionBD($recurso);
        return "Se ha insertado correctamente el producto";        
    }
    else {
        cerrarConexionBD($recurso);
        return "Error al generar la consulta";
    }    
}

function editarProducto($codigo, $nombre, $precio, $existencias, $imagen, $descripcion) {
    $recurso = abrirConexionBD();

    if(!$recurso){
        return "No se pudó conectar a la base de datos";
    }

    if($mi_consulta = mysqli_prepare($recurso, "UPDATE `productos` SET nombre=?, precio=?, existencias=?, imagen=?, descripcion=? WHERE codigo=?")){
        mysqli_stmt_bind_param($mi_consulta, "siissi", $nombre, $precio, $existencias, $imagen, $descripcion, $codigo);
        mysqli_stmt_execute($mi_consulta);
        cerrarConexionBD($recurso);
        return "Se ha modificado correctamente el producto";   
    }
    else {
        cerrarConexionBD($recurso);
        return "Error al generar la consulta";
    }
}

/**
 * Obtiene un cursor con la lista de usuarios
 * @return cursor lista de usuarios (null si falla)
 */
function obtenerUsuarios() {
    $recurso = abrirConexionBD();
    if($recurso) {
        $consulta = "SELECT * FROM `usuarios`";
        $resultados = mysqli_query($recurso, $consulta);
        
        cerrarConexionBD($recurso);
        return $resultados;
    }
    return null;
}

/**
 * Obtine un cursor a los pedidos, con los filtros si estan especificados
 * @param ?string $campo Nombre del campo por el cual hay que filtrar (puede estar vacío)
 * @param string $valor Valor del campo a filtrar
 * @param cursor lista de productos, null si falla, (usa 'dia' en vez de fecha)
 */
function obtenerPedidos($campo, $valor){
    $recurso = abrirConexionBD();

    $consulta = "SELECT codigo, persona, importe, estado, DATE_FORMAT(fecha, '%d/%m/%Y') AS dia FROM `pedidos`";
    $order = " ORDER BY codigo DESC";

    if($recurso) {
        // Creación de la consulta dependiendo del filtro
        if(empty($campo) || $valor=="") {
            $mi_consulta = mysqli_prepare($recurso, $consulta.$order);
        } else if($campo == "fecha") {
            $mi_consulta = mysqli_prepare($recurso, $consulta." WHERE fecha = DATE_FORMAT(?,'%d/%m/%Y') ".$order);
            mysqli_stmt_bind_param($mi_consulta, "s", $valor);
            //$_SESSION['mensaje'] = "Productos seleccionados por fecha";
        } else if($campo == "producto") {
            $consulta = "SELECT ped.codigo, ped.persona, ped.importe, ped.estado, DATE_FORMAT(fecha, '%d/%m/%Y') AS dia "
            ." FROM `pedidos` AS ped "
            ." JOIN `detalle` AS det ON ped.codigo = det.codigo_pedido"
            ." WHERE det.codigo_producto = ? ".$order;
            $mi_consulta = mysqli_prepare($recurso, $consulta);
            mysqli_stmt_bind_param($mi_consulta, "i", $valor);
            //$_SESSION['mensaje'] = "Productos seleccionados por pedido";
        } else {
            $mi_consulta = mysqli_prepare($recurso, $consulta." WHERE $campo = ? ".$order);
            mysqli_stmt_bind_param($mi_consulta, "i", $valor);
            //$_SESSION['mensaje'] = "Productos seleccionados por usuario";
        }

        mysqli_stmt_execute($mi_consulta);
        $resultados = mysqli_stmt_get_result($mi_consulta);
        cerrarConexionBD($recurso);
        return $resultados;
    }
    return null;
}

/**
 * Devuelve el texto HTML que debe de ir en el campo del pedido al consultarse
 * @param $codigoPedido Código del pedido del cual se quieren obtener los detalles
 * @return string HTML que contiene una tabla con los detalles de los pedidos
 */
function obtenerDetallesPedido($codigoPedido) {
    $recurso = abrirConexionBD();

    $consulta = "SELECT d.codigo_producto, d.unidades, d.precio_unitario, p.nombre "
     ."FROM detalle d "
     ."JOIN productos p ON p.codigo = d.codigo_producto "
     ."WHERE d.codigo_pedido = ?";

    if(!$recurso ) {
        return "";
    } 
    else if($mi_consulta = mysqli_prepare($recurso, $consulta)) {
        mysqli_stmt_bind_param($mi_consulta, "i", $codigoPedido);
        mysqli_stmt_execute($mi_consulta);

        $resultados = mysqli_stmt_get_result($mi_consulta);

        if(!$resultados) {
            echo "Error en la consulta: " . mysqli_stmt_error($mi_consulta);
            return "";
        }

        $html = 
            "<h6><table class='table table-bordered' >
                <tr>
                    <th>Código</th>
                    <th>Precio Ud.</th>
                    <th>Nombre</th>
                    <th>Unidades</th>
                    <th>Total.</th>
                </tr>"; 
        
        $total = 0;
        while($fila = mysqli_fetch_array($resultados)) {
            // Consultar detalles del lote del producto
            $codigo = $fila[0];
            $unidades = $fila[1];
            $precio = $fila[2];
            $nombre = $fila[3];

            $html.="<tr>";
            $html.="<td>#$codigo</td>";
            $html.="<td>$precio&#8381</td>";
            $html.="<td>$nombre</td>";
            $html.="<td>x$unidades</td>";
            $html.="<td><strong>".($precio * $unidades)."&#8381</strong></td>";
            $html.="<tr>";

            $total += $precio * $unidades;
        }
        $html .= 
            "   <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><strong>TOTAL = </strong></td>
                    <td><strong>$total&#8381</strong></td>
                </tr>
            </table></h6>";

        cerrarConexionBD($recurso);
        return $html;
    }
}

/**
 * Pone a 0 el campo del usuario si estaba a 1, y pone a 1 si el campo no estaba a 0
 * @param string campo Campo binario a cambiar
 * @param codigo Codigo del usuario
 */
function negarCampoUsuario($campo, $codigo) {
    $recurso = abrirConexionBD();
    if(!$recurso){return;}

    $consulta = "UPDATE usuarios SET $campo = IF($campo<>1, 1, 0) WHERE codigo=?";
    if($mi_consulta = mysqli_prepare($recurso, $consulta)){
        mysqli_stmt_bind_param($mi_consulta, "i", $codigo);
        mysqli_stmt_execute($mi_consulta);
        cerrarConexionBD($recurso);
    }
}

function cambiarEstadoPedido($codigo, $estado){
    $recurso = abrirConexionBD();
    if(!$recurso){return;}

    $consulta = "UPDATE pedidos SET estado =? WHERE codigo=?";
    if($mi_consulta = mysqli_prepare($recurso, $consulta)){
        mysqli_stmt_bind_param($mi_consulta, "ii", $estado, $codigo);
        mysqli_stmt_execute($mi_consulta);
        cerrarConexionBD($recurso);
    }
}

/**
 * Elimina el producto, si este no esta en ningún pedido.
 */
function eliminarProducto($codigo) {
    $recurso = abrirConexionBD();

    if(!$recurso) {
        $_SESSION['mensaje'] = "No hay conexión en la base de datos";
        return;
    }

    $consulta = "SELECT codigo_producto FROM detalle WHERE codigo_producto=?";
    if($mi_consulta = mysqli_prepare($recurso, $consulta)) {
        mysqli_stmt_bind_param($mi_consulta, "i", $codigo);
        mysqli_stmt_execute($mi_consulta);

        if($resultados = mysqli_stmt_get_result($mi_consulta)){
            if($fila = mysqli_fetch_array($resultados)){
                $_SESSION['mensaje'] = "No se puede eliminar por que el producto $codigo aparece en algún pedidos";
                return;
            }
            else{

                // ELIMINAR PEDIDO
                $consultaEliminar = "DELETE FROM productos WHERE codigo=?";
                if($mi_consultaEliminar = mysqli_prepare($recurso, $consultaEliminar)) {
                    mysqli_stmt_bind_param($mi_consultaEliminar, "i", $codigo);
                    mysqli_stmt_execute($mi_consultaEliminar);
                    $_SESSION['mensaje'] = "Se eliminó el producto $codigo correctamente";
                }
                
            }
            cerrarConexionBD($recurso);
        }
        else {
            $_SESSION['mensaje'] = "Error con la generación de la consulta";
            return;
        }
    }
}

/**
 * Elimina un usuario si no ha hecho ningún pedido
 */
function eliminarUsuario($codigoUsuario) {
    $recurso = abrirConexionBD();

    if(!$recurso) {
        $_SESSION['mensaje'] = "No hay conexión en la base de datos";
        return;
    }

    $consulta = "SELECT persona FROM pedidos WHERE persona=?";
    if($mi_consulta = mysqli_prepare($recurso, $consulta)) {
        mysqli_stmt_bind_param($mi_consulta, "i", $codigoUsuario);
        mysqli_stmt_execute($mi_consulta);

        if($resultados = mysqli_stmt_get_result($mi_consulta)) {

            if($fila = mysqli_fetch_array($resultados)){
                $_SESSION['mensaje'] = "No se puede eliminar por que el usuario con código $codigoUsuario porque tiene pedidos a su nombre";
                return;
            }
            else {
                // ELIMINAR USUARIO
                $consultaEliminar = "DELETE FROM usuarios WHERE codigo=?";
                if($mi_consultaEliminar = mysqli_prepare($recurso, $consultaEliminar)) {
                    mysqli_stmt_bind_param($mi_consultaEliminar, "i", $codigoUsuario);
                    mysqli_stmt_execute($mi_consultaEliminar);
                    $_SESSION['mensaje'] = "Se eliminó el usuario con código $codigoUsuario correctamente";
                }
            }
            cerrarConexionBD($recurso);

        }
    } else {
        $_SESSION['mensaje'] = "Error con la generación de la consulta";
            return;
    }
}

/**
 * Obtiene un mapa con los datos del usuario que tiene en la base de datos dicho código.
 * La clave es el nombre del campo.
 * Devuelve null en caso de no poderse encontrar por cualquier motivo.
 */
function obtenerUsuario($codigo) {
    $recurso = abrirConexionBD();
    if(!$recurso)
        return null;
    
    $consulta = "SELECT * FROM usuarios WHERE codigo = ?";
    if($mi_consulta = mysqli_prepare($recurso, $consulta)) {
        mysqli_stmt_bind_param($mi_consulta, "i", $codigo);
        mysqli_stmt_execute($mi_consulta);

        if($resultados = mysqli_stmt_get_result($mi_consulta)) {
            if($usuario = mysqli_fetch_assoc($resultados)){
                cerrarConexionBD($recurso);
                return $usuario;
            }
        }
    }
    cerrarConexionBD($recurso);
    return null;
}


function modificarUsuario($nombre, $clave, $domicilio, $telefono, $tipoPago, $tarjeta, $cuenta, $codigoUsuario) {
    $recurso = abrirConexionBD();
    $clave = ($clave=="")? "": hash256($clave);

    if(!$recurso){
        $_SESSION['mensaje'] = "No hay conexión a la base de datos";
        return; 
    }                                    // 1            2           3           4          5         6           7      8                      9
                                         // s            s           s           i          s         s           s      s                      i
    $consulta = "UPDATE usuarios SET nombre=?, domicilio=?, telefono=?, tipopago=?, tarjeta=?, cuenta=?, clave=IF(?<>'', ?, clave) WHERE codigo=?";
    if($mi_consulta = mysqli_prepare($recurso, $consulta)) {
        mysqli_stmt_bind_param(
                        // 123456789
            $mi_consulta, "sssissssi",
            $nombre, $domicilio, $telefono, $tipoPago, $tarjeta, $cuenta, $clave, $clave, $codigoUsuario
            //   1           2        3        4          5          6      7      8            9
        );
        mysqli_stmt_execute($mi_consulta);
        $_SESSION['mensaje'] = "Se editó correctamente la base de datos";
    }

    cerrarConexionBD($recurso);
}

/**
 * Vuelve añadir al stock, las unidades de un producto que se acaba de cancelar
 */
function restablecerStock($codigoPedido) {
    $recurso = abrirConexionBD();
    $consulta1 = "SELECT codigo_producto, unidades FROM detalle WHERE codigo_pedido=?";
    $consulta2 = "UPDATE productos SET existencias=existencias+? WHERE codigo=?";

    if(!$recurso)
        return;

    if($mi_consulta1 = mysqli_prepare($recurso, $consulta1)) {
        mysqli_stmt_bind_param($mi_consulta1, "i", $codigoPedido);
        mysqli_stmt_execute($mi_consulta1);
        $resultados = mysqli_stmt_get_result($mi_consulta1);

        while($producto = mysqli_fetch_assoc($resultados)) {
            if($mi_consulta2 = mysqli_prepare($recurso, $consulta2)) {
                mysqli_stmt_bind_param($mi_consulta2, "ii", $producto['unidades'], $producto['codigo_producto']);
                mysqli_stmt_execute($mi_consulta2);
            }
        }
    }

    cerrarConexionBD($recurso);
}

function eliminarPedido($codigo) {
    $recurso = abrirConexionBD();
    $consulta1 = "DELETE FROM detalle WHERE codigo_pedido=?";
    $consulta2 = "DELETE FROM pedidos WHERE codigo=?";

    if($mi_consulta1 = mysqli_prepare($recurso, $consulta1)){
        mysqli_stmt_bind_param($mi_consulta1, "i", $codigo);
        mysqli_stmt_execute($mi_consulta1);
    }
    
    if($mi_consulta2 = mysqli_prepare($recurso, $consulta2)){
        mysqli_stmt_bind_param($mi_consulta2, "i", $codigo);
        mysqli_stmt_execute($mi_consulta2);
    }
    cerrarConexionBD($recurso);
}
?>