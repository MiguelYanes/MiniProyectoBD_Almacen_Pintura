<?php session_start();

try {
	$conexion = new PDO('mysql:host=155.210.68.183;dbname=almacen_pintura', 'root', 'bd2');
} catch (PDOExcepcion $e){
	echo 'ERROR: ' . $e->getMessage();
	die('ERROR: No se pudo establecer conexion con la base de datos.');
}

$statement = $conexion->prepare("SELECT p.num_ped, a.cod_art, a.tipo, a.descripcion, f.cantidad,  p.entregado
								FROM pedido p, forma f, articulo a
								WHERE p.num_ped = f.num_ped AND f.cod_art = a.cod_art AND p.nif = '" . $_SESSION['nif'] . "' 
								ORDER BY p.entregado DESC"
								);
$statement->execute();
$statement = $statement->fetchAll();

/*'" . $_SESSION['nif'] . "'"


$telefonos = $conexion->prepare("SELECT t.tlf FROM TLF_CLIENTE t WHERE t.nif = '" . $_SESSION['nif'] . "'
								");
$telefonos->execute();
$telefonos = $telefonos->fetchAll();

*/

$direccion = $conexion->prepare('SELECT c.nombre, c.ciudad, c.calle, c.cp, c.numero, t.tlf FROM cliente c, tlf_cliente t WHERE c.nif = :nif AND c.nif = t.nif');
//para sustituir los placeholders
$direccion->execute(array(
	':nif' => $_SESSION['nif']
	));

$direccion = $direccion->fetch();


$albaran = $conexion->prepare("SELECT a.num_alb, a.num_ped, a.nif, a.num_fact, a.fecha FROM albaran a, pedido p WHERE a.num_ped = p.num_ped AND p.nif = '" . $_SESSION['nif'] . "'");
$albaran ->execute();
$albaran = $albaran->fetch();


require 'views/listado.view.php';
 ?>