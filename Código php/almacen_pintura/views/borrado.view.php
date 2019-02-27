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
		<h1 class="titulo">Quitar Pedido</h1>
		<hr class="border">

		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="formulario" name="login">

			<div class="form-group">
				<i class="icono izquierda fa fa-book"></i><input type="text" name="num_ped" class="npedido" placeholder="Número Pedido">
			</div>

			<div class="form-group">
				<i class="icono izquierda fa fa-book"></i><input type="text" name="num_ped2" class="nombre_btn" placeholder="Repetir número pedido">
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
			¿ Quieres añadir algún pedido ?
			<a href="ingresar.php">Añadir pedido.</a>
		</p>
		<p class="texto-ingresar">
			¿ Quieres ver el listado de pedidose ?
			<a href="listado.php">Echar un vistazo.</a>
		</p>

	</div>
	
</body>
</html>