<!DOCTYPE html>
<?php session_start()?>
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
			
		<!-- ICONOS -->
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
		
		<!-- SCRIPT LIBCAPAS -->
		<script src="./js/libCapas2223.js"></script>
		
		<title>Admin DAW</title>
	</head>
	
	<body>
	
	<div id="cuerpo0">
	
		<!-- SECCIÓN ADAPTABLE -->
		<div class="vh-100">
		  <div class="container py-5 h-100">
		    <div class="row d-flex align-items-center justify-content-center h-100">
		      <div class="col-md-8 col-lg-7 col-xl-6">
		        <img src="img/pawmotLogin.png"
		          class="img-fluid" alt="Phone image">
		      </div>
		      <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
		      
		      	<!-- FORMULARIO DE AUTENTICACION -->
		      	<form method="post" action="./validar.php">
		          <!-- Correo -->
		          <div class="form-outline mb-4">
		            <input type="text" id="Usuario" name="usuario" value="" class="form-control form-control-lg" >
		            <label class="form-label"><i class="bi bi-person-circle"></i> Usuario</label>
		          </div>
		
		          <!-- Password input -->
		          <div class="form-outline mb-4">
		            <input type="password" id="password" name="clave" value="" class="form-control form-control-lg" >
		            <label class="form-label"><i class="bi bi-key-fill"></i> Contraseña</label>
		          </div>
		
		          <!-- Entrar a Mantenimiento -->
		          <button type="submit" class="btn btn-primary btn-lg btn-block"> <i class="bi bi-box-arrow-in-right"></i> Entrar a mantenimiento</button>
		          
		          <!-- Mensaje que solo se muestra después un intento fallido de registo -->
		          <h4 class="text-danger"><br>
		          <?php
		          if(isset($_SESSION['mensaje'])){
		              echo $_SESSION['mensaje'];
		              unset($_SESSION['mensaje']);
		          }
		          ?>
		          </h4>
		        </form>
		        
		      </div>
		    </div>
		 </div>
		</div>
	
	
	</div>
	
		<!-- SCRIPT DE BOOTSTARPT -->
		<script
		src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
		crossorigin="anonymous"></script>
		
		<footer>
		</footer>
	</body>
</html>


