<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link href='https://fonts.googleapis.com/css?family=Raleway:400,300' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

	<!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

	<!--  jQuery -->
	<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
	<!-- Bootstrap Date-Picker Plugin -->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script src="arriba.js"></script>

	<link rel="stylesheet" href="css/styles.css">
	<title>Pedidos</title>
</head>
<body>
	<span class="ir-arriba fa fa-arrow-up"></span>
	<div class="contenedor-listado">
		<h1 class="titulo">Historial de mis Pedidos</h1>
		<i class="icono izquierda fa fa-sign-out"></i><a href="cerrar.php"> Cerrar sesión.</a>

		<hr class="border">

		<div class="contenedor-tabla">

			<div class="form-group">
        		<div class="table-responsive">
           	 		<table class="table table-bordered" style="font-size:15px">
               		 <tr class="aux">
               		 	<th>Nº pedido</th>
                   	 	<th>Referencia</th>
                   	 	<th class="th-tipo">Tipo</th>
                   	 	<th class="th-descripcion">Descripcion</th>
                   	 	<th>Cantidad</th>
                   	 	<th>Estado</th>
                	</tr>
                	<?php foreach ($statement as $statement): ?>
		                <tr>
			                <td><?php echo $statement['num_ped'] ?></td> 
			                <td><?php echo $statement['cod_art'] ?></td>
			                <td><?php echo $statement['tipo'] ?></td>
			                <td><?php echo $statement['descripcion'] ?></td>
			                <td><?php echo $statement['cantidad'] ?></td>
			                <td>
			                	<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="<?php echo '#'.$statement['num_ped'] ?>">Mostrar</button>

								<!-- Modal -->
								<div id="<?php echo $statement['num_ped'] ?>" class="modal fade" role="dialog" data-backdrop=”static” data-keyboard=”false””>
								  	<div class="modal-dialog" id="mdialTamanio">

									    <!-- Modal content-->
									    <div class="modal-content">
										    <div class="modal-header">
										        	<button type="button" class="close" data-dismiss="modal">&times;</button>
										        <h4 class="modal-title">Estado de mi pedido</h4>
										    </div>
											<div class="modal-body">
											        <div class="contenedor-listado">
											            <div class="row bs-wizard" style="border-bottom:0;">
											                
											                <div class="col-xs-3 bs-wizard-step complete">
												                  <div class="text-center bs-wizard-stepnum">Pedido realizado.</div>
												                  <div class="progress"><div class="progress-bar"></div></div>
												                  <a href="#" class="bs-wizard-dot"></a>
												                  <div class="bs-wizard-info text-center">Pedido efectuado por el cliente.</div>
											                </div>
											                
											                <div class="col-xs-3 bs-wizard-step complete"><!-- complete -->
												                  <div class="text-center bs-wizard-stepnum">Preparando Envío</div>
												                  <div class="progress"><div class="progress-bar"></div></div>
												                  <a href="#" class="bs-wizard-dot"></a>
												                  <div class="bs-wizard-info text-center">El pedido se está gestionando.</div>
											                </div>
											                
											                <div class="col-xs-3 bs-wizard-step
											                <?php 

												                if ($statement['entregado'] == "entregado"){
												                	echo " complete";
												                } else echo " active";

											                ?>"><!-- complete -->
												                  <div class="text-center bs-wizard-stepnum">Enviado</div>
												                  <div class="progress"><div class="progress-bar"></div></div>
												                  <a href="#" class="bs-wizard-dot"></a>
												                  <div class="bs-wizard-info text-center">El pedido ha sido empaquetado para despachar.</div>
											                </div>
											                
											                <div class="col-xs-3 bs-wizard-step 

															<?php 

												                if ($statement['entregado'] == "pendiente"){
												                	echo " disabled";
												                } else echo " active";

											                ?>"><!-- active -->
												                  <div class="text-center bs-wizard-stepnum">Entregado</div>
												                  <div class="progress"><div class="progress-bar"></div></div>
												                  <a href="#" class="bs-wizard-dot"></a>
												                  <div class="bs-wizard-info text-center">Pago verificado.</div>
											                </div>
											            </div>
											      	 </div>

											       	<div class="panel-panel-default">
														 <div class="panel-body">Dirección de Entrega</div>
														 <div class="panel-footer">
															<p>Nombre: <?php echo $direccion['nombre'] ?></p>
												       		<p>Ciudad: <?php echo $direccion['ciudad'] ?> &nbsp; CP: <?php echo $direccion['cp'] ?></p>
												       		<p>Calle: <?php echo $direccion['calle'] ?> &nbsp; Número: <?php echo $direccion['numero'] ?>º</p>
												       		<p>Teléfono: <?php echo $direccion['tlf'] ?></p>
														 </div>
													</div>

													<?php if ($statement['entregado'] == "entregado" && $albaran['num_ped'] == $statement['num_ped']): ?>
														<div class="panel-panel-default">
															<div class="panel-body">Albarán</div>
															<div class="panel-footer">
															<p>Nº Albaran: <?php echo $albaran['num_alb'] ?></p>
												       		<p>Nº Pedido: <?php echo $albaran['num_ped'] ?></p>
												       		<p>Nº Factura: <?php echo $albaran['num_fact'] ?></p>
												       		<p>NIF: <?php echo $albaran['nif'] ?></p>
												       		<p>Fecha: <?php echo $albaran['fecha'] ?></p>
															</div>
														</div>
													<?php endif ?>
											</div>
											<div class="modal-footer" style="clear: left;">
											    	<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
											</div>
									    </div>

								  	</div>
								</div>
			                </td>

			                <?php if ($statement['entregado'] == "pendiente"): ?>
								<td>
									<form action='borrado.php?name="<?php echo $statement['num_ped']; ?>"' method="post">
	       								 <input type="hidden" name="num_ped" value="<?php echo $statement['num_ped']; ?>">
	       							 	<input type="submit" name="devolver" value="Devolver" class="btn btn-danger btn-xs">
	    							</form>
								</td>
							<?php endif ?>
		                 </tr>
                    <?php endforeach ?>
            		</table>
        		</div>
    		</div>
		</div>	

		<p class="texto-ingresar">
			¿ Quieres comprar otro artículo ?
			<a href="ingresar.php">Comprar artículo.</a>
		</p>

	</div>


	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

</body>
</html>