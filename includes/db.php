<?php

error_reporting(0);
ini_set('display_errors', '0');

// Conexion a base de datos

$dbuser="root";		 		  //usuario para acceder a la base de datos
$dbpassword=""; 			  //contraseña para acceder a la base de datos
$dbname="database"; 	      //nombre de la base de datos
$dbhost="localhost";		//servidor de base de datos

//Conexion
$mysqli = new mysqli($dbhost, $dbuser, $dbpassword, $dbname);
if (mysqli_connect_errno()) {
	printf("MySQLi connection failed: ", mysqli_connect_error());
	exit();
}

// Cambiar juego de caracteres a utf8
if (!$mysqli->set_charset('utf8')) {
	printf('Error loading character set utf8: %s\n', $mysqli->error);
}

?>
