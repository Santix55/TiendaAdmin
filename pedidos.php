<!DOCTYPE html>
<?php 
require("bd.php");
session_start();

// Control de flujo
if(!isset($_SESSION['userid']))
    header('Location: ./index.php');
?>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Administrador</title>

		<!-- Script para que al cambiar el valor del select del estado se envie el formulario -->
		<script>
			function submitForm(codigo) {
				let id = "formularioEstado"+codigo;
				console.log(id);
				document.getElementById(id).submit();
			}
		</script>
	</head>
	<body>
		<form id="prueba"></form>

		<!-- Mensaje de información -->
		<h5 class="text-info text-center">
		<?php
		if(isset($_SESSION['mensaje'])){
		    echo '<i class="bi bi-info-square-fill"></i> '.$_SESSION['mensaje']."<br>";
		    unset($_SESSION['mensaje']);
		}
		?>
		</h5>
	
		<table class="table table-striped">
		  <thead>
		    <tr>
		      <th scope="col">#ID Pedido</th>
		      <th scope="col">#ID Usuario</th>
			  <th scope="col">Fecha</th>
		      <th scope="col">Pedido</th>
			  <th scope="col">Estado</th>
		    </tr>
		  </thead>
		  
		  <tbody>
			<?php
			// Leer y borrar variables de sesión del filtro
			if(isset($_SESSION['campo'])) {
				$campo = $_SESSION['campo'];
				unset($_SESSION['campo']);
			} else {
				$campo = "";
			}

			if(isset($_SESSION['valor'])) {
				$valor = $_SESSION['valor'];
				unset($_SESSION['valor']);
			} else {
				$valor = "";
			}

			$resultados = obtenerPedidos($campo, $valor);
			

			while($pedido = mysqli_fetch_assoc($resultados)) {
			?>
		    <tr>
		      <!-- id pedidio -->
		      <th scope="row"><?=$pedido['codigo']?></th>
		      
		      <!-- id usuario -->
		      <td><?=$pedido['persona']?></td>
		      
			  <!-- fecha -->
			  <td><?=$pedido['dia']?></td>

		      <!-- pedido -->
		      <td>
		      	<?=obtenerDetallesPedido($pedido['codigo'])?>
		      </td>
		      
			  <!-- estado -->
		      <td>
					<form id="formularioEstado<?=$pedido['codigo']?>" method="post" action="./cambiarEstadoPedido.php">
					<input type="hidden" name="codigo" value="<?=$pedido['codigo']?>">
			  		<select class="selectpicker" name="estado" onchange="submitForm(<?=$pedido['codigo']?>)" <?=($pedido['estado']==3)?"disabled":""?>>
						<?php $estado = $pedido['estado']; echo $estado;?>
						<option value="0" <?=($estado==0)?"selected":""?>> Pendiente</option>
						<option value="1" <?=($estado==1)?"selected":""?>> Enviado</option>
						<option value="2" <?=($estado==2)?"selected":""?>> Entregado</option >
						<option value="3" <?=($estado==3)?"selected":""?>> Cancelado</option>
					</select>
					</form>

					<?php if($estado==3) { ?>
						<br>
						<form method="post" action="./eliminarPedido.php">
							<input type="hidden" value="<?=$pedido['codigo']?>" name="codigo">
							<button type="submit" class="btn btn-danger"><i class="bi bi-trash3"></i> Eliminar</button>
						</form>
					<?php } ?>
		      </td>
		    </tr>
			<?php } ?>
			</tbody>
		</table>
		<br>
		<br>
		<br>
		<br>
		<br> 
		 <!-- FOOTER -->
		 <footer class="bg-info fixed-bottom text-center">
		  <!-- Grid container -->
		  <div class="container p-4 pb-0">
		    <!-- Section: Form -->
		    <div class="">
		      <form method="post" action="./filtrarPedidos.php">
		        <!--Grid row-->
		        <div class="row d-flex justify-content-center">
		          <!--Grid column-->
		          <div class="col-auto">
		            <p class="pt-2">
		              <strong>Filtro:</strong>
		              <select class="selectpicker" name="campo">
						<option value="" <?=($campo=='')?"selected":""?>>Ninguno</option>
						<option value="producto" <?=($campo=='producto')?"selected":""?>>#ID Producto</option>
						<option value="persona" <?=($campo=='persona')?"selected":""?>>#ID Usuario</option>
						<option value="fecha" <?=($campo=='fecha')?"selected":""?>>Fecha</option>
					  </select>
		              
		            </p>
		          </div>
		          <!--Grid column-->
		
		          <!--Grid column-->
		          <div class="col-md-5 col-12">
		            <!-- Valor de búsqueda del fitro -->
		            <div class="form-outline mb-4">
		              <input type="text" class="form-control" value="<?=$valor?>" name="valor">
		            </div>
		          </div>
		          <!--Grid column-->
		
		          <!--Grid column-->
		          <div class="col-auto">
		            <!-- Submit button -->
		            <button type="submit" class="btn btn-primary mb-4">
		              <i class="bi bi-search"></i> Buscar
		            </button>
		          </div>
		          <!--Grid column-->
		        </div>
		        <!--Grid row-->
		      </form>
		    </div>
		    <!-- Section: Form -->
		  </div>
	</footer>
	</body>
</html>