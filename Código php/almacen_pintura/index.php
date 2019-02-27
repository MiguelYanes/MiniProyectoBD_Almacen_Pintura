<?php session_start();

if (isset($_SESSION['nombre'])){
	header('Location: ingresar.php');
} else {
	header('Location: login.php');
}

 ?>