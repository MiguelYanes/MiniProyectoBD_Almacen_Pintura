<?php session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//Se almacena en una variable el num_ped del registro a eliminar
	//$num_ped = $_POST['num_ped'];

	try{
	$conexion = new PDO('mysql:host=155.210.68.183;dbname=almacen_pintura', 'root', 'bd2');
	} catch (PDOException $e){ echo "Error: " . $e->getMessage(); }


	$statement = $conexion->prepare("DELETE FROM pedido WHERE num_ped = {$_POST['num_ped']} AND nif = '" . $_SESSION['nif'] . "' LIMIT 1");
	$statement->execute();

	//redirigir nuevamente a la página para ver el resultado
	header("location: listado.php");
}

require 'views/listado.view.php';

 ?>
