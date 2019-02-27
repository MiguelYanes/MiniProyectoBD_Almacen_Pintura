<?php 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	//para limpiar codigo, strtolower todo a minusculas
	$nombre = filter_var(strtoupper($_POST['nombre']), FILTER_SANITIZE_STRING);
	$nif = filter_var(strtolower($_POST['nif']), FILTER_SANITIZE_STRING);
	$password = $_POST['password'];
	$password2 = $_POST['password2'];

	$errores = '';

	//comprobar que los campos no estén vacios
	if (empty($nombre) || empty($nif) || empty($password) or empty($password2)){
		$errores .= '<li>Por favor rellena todos los datos correctamente.</li>';
	} else {
		//comprobar que el usuario no exista
		try{
	$conexion = new PDO('mysql:host=155.210.68.183;dbname=almacen_pintura', 'root', 'bd2');
		} catch (PDOException $e){
			echo "Error: " . $e->getMessage();
		}

		//nuestras consultas
		$statement = $conexion->prepare('SELECT * FROM cliente WHERE nif = :nif LIMIT 1');
		$statement->execute(array(
			':nif' => $nif
			));
		//si resultado devuelve false es que el nif del cliente no existe y podemos registrarlo
		$resultado = $statement->fetch();

		if($resultado){
			$errores .= '<li>El nif del cliente ya existe.</li>';
		}

		//"encriptar" contraseña
		$password = hash('sha512', $password);
		$password2 = hash('sha512', $password2);
		if ($password != $password2){
			$errores .= "<li>Las contraseñas no coinciden.</li>";
		}
	}

	//Ahora, vamos a comprobar que sino hay errores para que se pueda registrar el usuario en la base de datos

	if (empty($errores)){
		$statement = $conexion->prepare('INSERT INTO cliente (nif, nombre, password) VALUES (:nif, :nombre, :password)');
		$statement->execute(array(
			':nif' => $nif,
			':nombre' => $nombre, 
			':password' => $password
			));

		header('Location: login.php');
	}

}

require 'views/registrate.view.php';


 ?>