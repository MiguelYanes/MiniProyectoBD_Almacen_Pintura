<?php session_start();

/*//comprobamos si la sesión ya está seteada
if (isset($_SESSION['nombre'])){
	header('Location: ingresar.php');
}*/

$errores = '';

//si los datos han sido enviados...
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$nombre = filter_var(strtolower($_POST['nombre']), FILTER_SANITIZE_STRING);
	$password = $_POST['password'];
	$password_hash = hash('sha512', $password);

	//conectarnos a la base de datos
	try{
		//podriamos hacerlo en otra función
	$conexion = new PDO('mysql:host=155.210.68.183;dbname=almacen_pintura', 'root', 'bd2');
	} catch (PDOExcepction $e){
		echo "Error: " . $e->getMessage();
	}

	$statement = $conexion->prepare('SELECT * FROM cliente WHERE nombre = :nombre AND password = :password');
	//para sustituir los placeholders
	$statement->execute(array(
		':nombre' => $nombre,
		':password' => $password_hash
		));

	$resultado = $statement->fetch();
	if ($resultado !== false){
		//Enviamos al index.php porque es el encargado de decidir a donde enviarnos

		$_SESSION['nombre'] = $nombre;

		$row = array_values($resultado)[0];
		$_SESSION['nif'] = $row;

		//var_dump($row);

		header('Location: index.php');
	} else{
		$errores .= '<li>Datos incorrectos.</li>';
	}
}

require 'views/login.view.php';

 ?>