<!DOCTYPE html>
<?php session_start(); // Control de flujo
if(!isset($_SESSION['userid']))
    header('Location: ./index.php');
?>
</html>
    <head>
		<meta charset="UTF-8">
		<title>Tienda Pokemon</title>
	</head>
		
	<body>
		<!-- SECCIÓN ADAPTABLE -->
		<div class="vh-100">
		  <div class="container py-5 h-100">
		    <div class="row d-flex align-items-center justify-content-center h-100">

              <!-- Izquierda -->
		      <div class="col-md-8 col-lg-7 col-xl-6">
              <img src="img/productoNuevo.png" class="img-fluid" alt="Phone image" style="width: 60%; height: 60%;">
		      </div>

		      <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
		      	<!-- FORMULARIO DE CONSULTA O MODIFICACIÓN -->
		        <form method="post" action="./procesarNuevoProducto.php">
		          <!-- Nombre -->
		          <div class="form-outline mb-4">
		            <input type="text" name="nombre" class="form-control form-control-lg">
		            <label class="form-label" ><i class="bi bi-tag-fill"></i> Nombre</label>
		          </div>
		
		          <!-- Precio -->
		          <div class="form-outline mb-4">
		            <input type="number" name="precio" class="form-control form-control-lg">
		            <label class="form-label" ><i class="bi bi-cash"></i> Precio (&#8381)</label>
		          </div>

                  <!-- Existencias -->
		          <div class="form-outline mb-4">
		            <input type="number" name="existencias" class="form-control form-control-lg">
		            <label class="form-label" ><i class="bi bi-boxes"></i> Existencias</label>
		          </div>

                  <!-- Imagen -->
		          <div class="form-outline mb-4">
		            <input type="text" name="imagen" class="form-control form-control-lg"></input>
		            <label class="form-label" ><i class="bi bi-image"></i> Imagen</label>
		          </div>

                  <!-- Descripcion -->
		          <div class="form-outline mb-4">
		            <textarea type="number" name="descripcion" class="form-control form-control-lg"></textarea>
		            <label class="form-label" ><i class="bi bi-file-text-fill"></i> Descripción</label>
		          </div>

		          
		          <!-- Botón para modificar -->
		          <button type="submit" class="btn btn-success btn-lg btn-block"><i class="bi bi-pen"></i> Añadir</button>
		          
		          <!-- Botón para volver -->
		          <button type="button" class="btn btn-secondary btn-lg btn-block" onclick="Cargar('./productos.php','cuerpo')"><i class="bi bi-arrow-return-left"></i> Volver</button>
		        
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
		
	<footer>
	</footer>
</html>