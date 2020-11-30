<?php
require 'Bd_function.php';
session_start();	

$usuario=$_POST['usuario'];
$clave= $_POST['clave'];
$array=Login::ObtenerUser($usuario); //llama a la funcion obtenerObtenerUser de la clase registro
if($array){
	$hashed_password = $array['Contraseña'];
	if(password_verify($clave, $hashed_password)){
		if($array['Rol'] == 'admin' && $array['Estado'] == 'activo'){
			$_SESSION['username']=$usuario;
			$_SESSION['rol']=$array['Rol'];
			echo "200";
		} else {
			echo "600";
		}
	}else{
		echo "500";
	}
} else {
	echo "700";
}

?>

