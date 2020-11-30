<?php 
	/**
	* Archivo que redirecciona al contenido que se va incrustar dentro de la header y el footer
	* Autor: Elivar Largo
	* Sitio Web: wwww.ecodeup.com
	**/
	error_reporting(error_reporting() & ~E_NOTICE);

	if ($_GET['menu']=='solicitudes') {
		require_once('views/solicitudes.php');
	} 
	else if($_GET['menu']=='personal'){
		require_once('views/persona.php');
	}
	else if($_GET['menu']=='admin'){
		require_once('views/administ.php');
	}
	else if ($_GET['menu']=='salir') {
		require_once('class/salir.php');
	} else{
		require_once('views/error.php');
	}

 ?>