<?php session_start();

//print_r( $_SESSION );  

//comprobamos si la sesión ya está seteada
//si no esta seteada es que no tiene sesion activa por tanto enviamos al index

/*if (!isset($_SESSION['nombre'])){
	header('Location: index.php');
}*/

try{
	$conexion = new PDO('mysql:host=155.210.68.183;dbname=almacen_pintura', 'root', 'bd2');

} catch (PDOException $e) { echo "Error: " . $e->getMessage(); }

$articulos = $conexion->prepare('SELECT cod_art, descripcion FROM articulo');
$articulos->execute();
$articulos = $articulos->fetchAll();

//var_dump($articulos);

$errores = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$articulo = $_POST['lista'];
	$cantidad = $_POST['cantidad'];
	date_default_timezone_set('Europe/Madrid');
	$fecha = date('Y-m-d H:i:s');

	//comprobar que los campos no estén vacios
	if (empty($articulo) || empty($cantidad)){
			$errores .= '<li>Por favor evite dejar campos vacios.</li>';
	} else {
		try{
	$conexion = new PDO('mysql:host=155.210.68.183;dbname=almacen_pintura', 'root', 'bd2');
		} catch (PDOException $e){
			echo "Error: " . $e->getMessage();
		}

		$max_stock = $conexion->prepare('SELECT a.max_stock FROM articulo a WHERE cod_art = :cod_art');
		$max_stock ->execute(array(
			':cod_art' => $articulo
			));
		$max_stock = $max_stock->fetch();

		$statement = $conexion->prepare('
			SELECT *
			FROM cliente 
			WHERE nif = :nif'
			);
		$statement->execute(array(
			':nif' => $_SESSION['nif']
			));
		//si resultado devuelve false es que el nproyecto no existe y podemos registrarlo
		$resultado = $statement->fetch();

		if($cantidad > $max_stock['max_stock']){
			$errores .= "<li>Cantidad excesiva. </li>";
			$errores .= "<li>Ingrese una cantidad menor. Stock actual en " . $max_stock['max_stock'] . " uds.</li>";
		}
	}

	if (empty($errores)){
		$statement = $conexion->prepare('INSERT INTO pedido (num_ped, nif, fecha) VALUES (null, :nif, :fecha)');
		$statement->execute(array(
			':nif' => $_SESSION['nif'], 
			':fecha' => $fecha
			));

		$ultimo_nped = $conexion->prepare('SELECT p.num_ped FROM pedido p WHERE nif = :nif AND p.fecha = (SELECT MAX(p.fecha) FROM pedido p)');
		$ultimo_nped ->execute(array(
			':nif' => $_SESSION['nif']
			));
		$ultimo_nped = $ultimo_nped->fetch();

		$ped_fac = $conexion->prepare('INSERT INTO forma (cod_art, num_ped, nif, cantidad) VALUES (:cod_art, :num_ped, :nif, :cantidad)');
		$ped_fac->execute(array(
			':cod_art' => $articulo, 
			':num_ped' => $ultimo_nped['num_ped'], 
			':nif' => $_SESSION['nif'], 
			':cantidad' => $cantidad
			));
	}

}


require 'views/ingresar.view.php';

 ?>