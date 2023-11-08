<!DOCTYPE html>
<?php session_start(); // Control de flujo
if(!isset($_SESSION['userid']))
    header('Location: ./index.php');
?>
<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<!-- BOOTSTRAP LINK -->
		<link
			href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
			rel="stylesheet"
			integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65"
			crossorigin="anonymous">
			
		<!-- SCRIPT LIBCAPAS -->
		<script src="js/libCapas2223.js"></script>
		
		<!-- ICONOS -->
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
		
		<title>Administrador</title>
		<link rel="icon" type="image/x-icon" href="img/logo.png">
		

	</head>
	
	<!-- CONSULTAR QUE PÁGINA SE VA A CARGAR -->
	<?php
	if(isset($_SESSION['pagina'])){
		$pagina = $_SESSION['pagina'];
		unset($_SESSION['pagina']);
	}else{
		$pagina = "./productos.php";
	}
	?>
	<body onload="Cargar('<?=$pagina?>','cuerpo')">
		<!-- BARRA DE NAVEGACIÓN SUPERIOR -->	
		<nav class="navbar fixed-top navbar-expand-md navbar-dark bg-dark">
			<div class="container-fluid">
			
				<a class="navbar-brand" href="#">Administrador</a>
				<img src="img/logo.png" height="28" alt="CoolBrand">
				
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExampleDefault">
					<span class="navbar-toggler-icon"> </span>
				</button>
				
				<div class="collapse navbar-collapse" id="navbarsExampleDefault">
				
					<!-- Menú superior -->
					<ul class="navbar-nav me-auto">
						<li class="nav-item"><a class="nav-link" href="./cerrar.php"><span class="text-danger"><i class="bi bi-x-square"></i></span> Cerrar Sesión</a>
						</li>
						<li class="nav-item"><a class="nav-link" href="#" onclick="Cargar('./pedidos.php','cuerpo')">Pedidos</a>
						</li>
						<li class="nav-item"><a class="nav-link" href="#" onclick="Cargar('./productos.php','cuerpo')">Productos</a>
						</li>
						<li class="nav-item"><a class="nav-link" href="#" onclick="Cargar('./usuarios.php','cuerpo')">Usuarios</a>
						</li>
					</ul>
					
					
				</div>
			</div>
		</nav>
		
		<br>
		<br>
		<br>
		
		<!-- CARGAR UNO DE LOS HTML DEL CUERPO -->
		<div id="cuerpo"></div>	
		
		<!-- SCRIPT DE BOOTSTARPT -->
		<script
		src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
		crossorigin="anonymous"></script>
		
		<footer>
		</footer>
	</body>
	
</html>