<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link href='https://fonts.googleapis.com/css?family=Raleway:400,300' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

	<link rel="stylesheet" href="css/styles.css">
	<title>Pedidos</title>
</head>
<body>
	<div class="contenedor">
		<h1 class="titulo">Añadir Pedido</h1>
		<hr class="border">

		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="formulario" name="login">

			<div class="form-group">
				<i class="icono fa fa-list"></i>
				<select class="select" name="lista">
					<option value="">Seleccione articulo:</option>
					<?php foreach ($articulos as $articulos):  ?>
                    	<option value="<?php echo $articulos['cod_art'] ?>">
                    		<?php echo $articulos['descripcion']  ?>
                    	</option>
                    <?php endforeach ?>
				</select>
			</div>

			<div class="form-group">
				<i class="icono izquierda fa fa-sort-numeric-desc"></i><input type="number" min="0" name="cantidad" class="cantidad_btn" placeholder="Cantidad">
				<i class="submit-btn fa fa-arrow-right" onclick="login.submit()"></i>
			</div>

			<?php if(!empty($errores)): ?>
				<div class="error">
					<ul>
						<?php echo $errores; ?>
					</ul>
				</div>
			<?php endif; ?>

		</form>

		<p class="texto-ingresar">
			¿ Quieres ver el historial de tus pedidos ?
			<a href="listado.php">Echar un vistazo.</a>
		</p>
	</div>
	
</body>
</html>