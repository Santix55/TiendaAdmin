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
	</head>
	<body>

		<!-- Mensaje que aparece solo después de una acción -->
		<h3 class="text-info text-center">
		<?php
		if(isset($_SESSION['mensaje'])){
		    echo '<br> <i class="bi bi-info-square-fill"></i> '.$_SESSION['mensaje']."<br><br>";
		    unset($_SESSION['mensaje']);
		}
		?>
		</h3>

		<div class="container">
			<div class="row">

			<!-- AÑADIR PRODUCTO -->
			<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
				<button type="button" class="btn btn-success" onclick="Cargar('./nuevoProducto.php','cuerpo')">
				<p class="h3"><strong> Añadir </strong></p> 
				<img src="img/productoNuevo.png" class="img-thumbnail" alt="productoNuevo.jpg"><br> 
				<br>
				<h4> Nuevo producto </h4> </button>
			</div>

			<?php
			$resultados = obtenerProductos();
			while($producto = mysqli_fetch_assoc($resultados)) {
			?>

				<!-- PRODUCTO -->
				<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12" style="margin-bottom:40px;">
					<p class="h3"><strong> ID: <?= $producto["codigo"]?> </strong></p>
					<img src=<?='"'.$producto["imagen"].'"'?> class="img-thumbnail" alt="img/producto.png"><br>

					<!-- FORMULARIO ELIMINAR -->
					<form method="post" action="./eliminarProducto.php" id="eliminar<?= $producto["codigo"]?>">
						<input type="hidden" name="codigo" value="<?= $producto["codigo"]?>">
					</form>

					<!-- FORUMULARIO EDITAR E INFO DEL PRODUCTO -->		
					<form method="post" action="./editarProdcuto.php">
					<input type="hidden" name="codigo" value="<?= $producto["codigo"]?>">
					
					<table>
						<tr>
							<td>
								<button type="submit" class="btn btn-primary"><i class="bi bi-pen"></i> Editar</button>
								<button type="button" class="btn btn-danger" onclick="document.getElementById('eliminar<?= $producto["codigo"]?>').submit()"><i class="bi bi-trash3"></i> Borrar</button>
							</td>
						</tr>
						<tr>
							<td>
								<label>Nombre:</label>
								<input type="text" value=<?='"'.$producto["nombre"].'"'?> class="form-control" name="nombre">
							</td>
						</tr>
						<tr>
							<td>
								<label>Imagen:</label>
								<input type="text" value=<?='"'.$producto["imagen"].'"'?> class="form-control" name="imagen">
							</td>
						</tr>
						<tr>
							<td>
								<label>Precio (₽):</label>
								<input type="number" value=<?='"'.$producto["precio"].'"'?>  min="0" class="form-control" name="precio">
							</td>
						</tr>
						<tr>
							<td>
								<label>Existencias: </label>
								<input type="number" value="<?=$producto["existencias"] ?>"  min="0" class="form-control" name="existencias">
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-outline">
								  <label class="form-label">Descripción:</label>
								  <textarea class="form-control" rows="4" name="descripcion"><?=$producto["descripcion"]?></textarea>
								</div>
							</td>
						</tr>
						
					</table>
					</form>
				</div>
			<?php } ?>
			
				

				
			</div>
		</div>
		<footer>
		</footer>
	</body>
</html>