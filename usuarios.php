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

		

		<table class="table table-striped">
		  <thead>
		    <tr>
		      <th scope="col">#ID</th>
		      <th scope="col">Usuario</th>
		      <th scope="col">Acciones</th>
		      <th scope="col">Admin</th>
		      <th scope="col">Activo</th>
		    </tr>
		  </thead>

		  <tbody>
			<?php
			$resultados = obtenerUsuarios();
			while($usuario = mysqli_fetch_assoc($resultados)) {
			?>
		    <tr>
		      <th scope="row"><?=$usuario['codigo']?></th>
		      <td><input type="text" value="<?=$usuario['usuario']?>" name="usuario" disabled></td>
		      <td>
			  	<div style="display: flex;">
					<!-- Borrar usuario -->
					<form method="post" action="./borrarUsuario.php">
						<input type="hidden" value="<?=$usuario['codigo']?>" name="codigo"></input>
						<button type="submit" class="btn btn-danger"><i class="bi bi-trash3"></i> Borrar</button>
					</form>
					
					<!-- Modificar usuario -->
					<form method="post" action="./irAModificarUsuario.php">
						<input type="hidden" value="<?=$usuario['codigo']?>" name="codigo"></input>
						<button type="submit" class="btn btn-primary"><i class="bi bi-pen"></i> Modificar</button>
					</form>
				</div>
			  </td>

			  <!-- Admin -->
			  <td>
				<form method="post" action="./cambiarValorAdmin.php">
					<input type="hidden" name="codigo" value="<?= $usuario['codigo']?>">
					<?php if ($usuario['admin'] == 1) { ?>
					<button type="submit" class="btn btn-outline-primary" id="botonAdmin<?= $usuario['codigo']?>" style="width: 100px;">
						<i class="bi bi-check-square"></i> Sí
					</button>
					<script>
						document.getElementById("botonAdmin<?= $usuario['codigo']?>").addEventListener("mouseover",()=>{document.getElementById("botonAdmin<?= $usuario['codigo']?>").innerHTML = 'Quitar'});
						document.getElementById("botonAdmin<?= $usuario['codigo']?>").addEventListener("mouseout", ()=>{document.getElementById("botonAdmin<?= $usuario['codigo']?>").innerHTML = '<i class="bi bi-check-square"></i> Sí'});
					</script>
					<?php } else { ?>
					<button type="submit" class="btn btn-outline-primary" id="botonAdmin<?=$usuario['codigo']?>" style="width: 100px;">
						<i class="bi bi-square"></i> No
					</button>
					<script>
						document.getElementById("botonAdmin<?= $usuario['codigo']?>").addEventListener("mouseover",()=>{document.getElementById("botonAdmin<?= $usuario['codigo']?>").innerHTML = 'Poner'});
						document.getElementById("botonAdmin<?= $usuario['codigo']?>").addEventListener("mouseout", ()=>{document.getElementById("botonAdmin<?= $usuario['codigo']?>").innerHTML = '<i class="bi bi-square"></i> No'});
					</script>
					<?php } ?>
				</form>
			  </td>

			  <!-- Activo -->
			  <td>
			   <form method="post" action="./cambiarValorActivo.php">
					<input type="hidden" name="codigo" value="<?= $usuario['codigo']?>">
					<?php if ($usuario['activo'] == 1) { ?>
					<button type="submit" class="btn btn-outline-primary" id="botonActivo<?= $usuario['codigo']?>" style="width: 100px;">
						<i class="bi bi-check-square"></i> Sí
					</button>
					<script>
						document.getElementById("botonActivo<?= $usuario['codigo']?>").addEventListener("mouseover",()=>{document.getElementById("botonActivo<?= $usuario['codigo']?>").innerHTML = 'Desactivar'});
						document.getElementById("botonActivo<?= $usuario['codigo']?>").addEventListener("mouseout", ()=>{document.getElementById("botonActivo<?= $usuario['codigo']?>").innerHTML = '<i class="bi bi-check-square"></i> Sí'});
					</script>
					<?php } else { ?>
					<button type="submit" class="btn btn-outline-primary" id="botonActivo<?=$usuario['codigo']?>" style="width: 100px;">
						<i class="bi bi-square"></i> No
					</button>
					<script>
						document.getElementById("botonActivo<?= $usuario['codigo']?>").addEventListener("mouseover",()=>{document.getElementById("botonActivo<?= $usuario['codigo']?>").innerHTML = 'Activar'});
						document.getElementById("botonActivo<?= $usuario['codigo']?>").addEventListener("mouseout", ()=>{document.getElementById("botonActivo<?= $usuario['codigo']?>").innerHTML = '<i class="bi bi-square"></i> No'});
					</script>
					<?php } ?>
				</form>
			  </td>
		    </tr>

			<?php } ?>
		  </tbody>
		</table>
		
		<footer>
		</footer>
	</body>

</html>