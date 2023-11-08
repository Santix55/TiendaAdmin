<!DOCTYPE html>
<?php 
require("bd.php");
session_start();

// Control de flujo
if(!isset($_SESSION['userid']))
    header('Location: ./index.php');

if(isset($_SESSION['codigo'])){
    $codigo = $_SESSION['codigo'];
    unset($_SESSION['codigo']);
} else {
    header('Location: ./index.php');
}

$usuario = obtenerUsuario($codigo);
if(is_null($usuario)){
	$_SESSION['mensaje'] = "No se ha podido cargar el usurio"; 
	$_SESSION['pagina'] = "./usuarios.php";
	header('Location: ./menu.php');
}

?>

		<!-- SECCIÓN ADAPTABLE -->
		<div class="vh-100">
		  <div class="container py-5 h-100">
		    <div class="row d-flex align-items-center justify-content-center h-100">
		      <div class="col-md-8 col-lg-7 col-xl-6">
		        <img src="img/pawmotLogin.png" class="img-fluid" alt="Phone image">
		      </div>
		      <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
		      
		      	<!-- FORMULARIO DE CONSULTA O MODIFICACIÃ“N -->
		        <form method="post" action="./procesarModificarUsuario.php">

				  <input type="hidden" name="codigo" value="<?=$codigo?>"></input>

		          <!-- Nombre -->
		          <div class="form-outline mb-4">
		            <input type="text" name="nombre" class="form-control form-control-lg" value="<?=$usuario['nombre']?>">
		            <label class="form-label"><i class="bi bi-person-fill"></i> Nombre y Apellidos</label>
		          </div>
		          
		          <!-- ContraseÃ±a -->
		          <div class="form-outline mb-4">
		            <input type="password" name="clave" class="form-control form-control-lg">
		            <label class="form-label"><i class="bi bi-key-fill"></i> Contraseña <span class="text-info"><i class="bi bi-asterisk"></i> Deja este campo vacío para dejar la anterior</span></label>
		          </div>
		          
		          <!-- Repetir contraseÃ±a -->
		          <div class="form-outline mb-4">
		            <input type="password" name="clave2" class="form-control form-control-lg">
		            <label class="form-label"><i class="bi bi-key-fill"></i> Repetir Contraseña <span class="text-info"><i class="bi bi-asterisk"></i></span></label>
		          </div>
		          
		          <!-- Telefono -->
		          <div class="form-outline mb-4">
		            <input type="text" name="telefono" class="form-control form-control-lg" value="<?=$usuario['telefono']?>">
		            <label class="form-label"><i class="bi bi-telephone-fill"></i> Telefono</label>
		          </div>
		          
		          <!-- DirecciÃ³n -->
		          <div class="form-outline mb-4">
		            <input type="text" name="domicilio" class="form-control form-control-lg" value="<?=$usuario['domicilio']?>">
		            <label class="form-label"><i class="bi bi-geo-alt-fill"></i> Dirección <span class="text-danger"><i class="bi bi-asterisk"></i></span></label>
		          </div>
		          
		          <!-- Tipo de pago -->
		          <div class="form-outline mb-4">
			          <div class="form-check form-check-inline">
					      <input class="form-check-input" type="radio" name="tipopago" value="0" <?=$usuario['tipopago']==0?"checked":""?>>
					      <label class="form-label">Tarjeta</label>
					  </div>
	
					 <div class="form-check form-check-inline">
					       <input class="form-check-input" type="radio" name="tipopago" value="1" <?=$usuario['tipopago']==1?"checked":""?>>
					       <label class="form-label">Transferencia</label>
					  </div>
				  </div>
		          
		          <!-- Tarjeta de credito -->
		          <div class="form-outline mb-4">
		            <input type="text" name="tarjeta" class="form-control form-control-lg" value="<?=$usuario['tarjeta']?>">
		            <label class="form-label"><i class="bi bi-credit-card"></i> Tarjeta</label>
		          </div>
		          
		          <!-- Cuenta Bancaria -->
		          <div class="form-outline mb-4">
		            <input type="text" name="cuenta" class="form-control form-control-lg" value="<?=$usuario['cuenta']?>">
		            <label class="form-label"><i class="bi bi-credit-card"></i> Cuenta bancaria</label>
		          </div>
		          
		          
		          <!-- Botón para modificar -->
		          <button type="submit" class="btn btn-success btn-lg btn-block"><i class="bi bi-pen"></i> Modificar</button>
		          <button type="button" class="btn btn-secondary btn-lg btn-block" onclick="Cargar('./usuarios.php','cuerpo')"><i class="bi bi-arrow-return-left"></i> Volver</button>
		          <h5><span class="text-danger">  </span></h5>
		        </form>
		        
		      </div>
		    </div>
		 </div>
		</div>
		
	<footer>
	</footer>
</div>