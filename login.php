<?php
session_start();
if (isset($_SESSION['username'])) {
	header("location: index.php");
}
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title> Policia Nacional </title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" type="img/x-icon" href="resources/img/siceo_icon.ico">
	<link rel="stylesheet" type="text/css" href="resources/diseño/estilo.css">
	<link rel="stylesheet" type="text/css" href="resources/diseño/default.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
	integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
</head>

<body>
	<div class="log">
		<div class="form">
			<form id="submit_form">
				<img src="resources/img/SICEO.png"  class="img-fluid" style="width: 200px;" alt=" Avatar" title="Avatar">
				<input type="text" placeholder="Usuario" name="usuario" id="usuario"><br>
				<span id="error_message_user" class="text-danger"></span>
				<input type="password" placeholder="Contraseña" name="clave" id="clave"> <br>
				<button type="button" name="submit" id="submit" class="btn btn-success">Ingresar</button><br>
				<button type="button" onclick="window.open('resources/img/SICEO-v1.0.apk')" class="btn btn-link">Descargar App</button>
				<div id="loading" class="spinner-border text-primary" role="status">
					<span class="sr-only">Loading...</span>
				</div>
				<span id="error_message" class="text-danger"></span>
			</form>
		</div>
	</div>
</body>

</html>

<script>
	$(document).ready(function() {
		$('#loading').hide();
		$('#submit').click(function() {
			var usuario = $('#usuario').val().trim();
			var clave = $('#clave').val().trim();
			if (usuario == '' || clave == '') {
				$('#error_message').html("Ingrese los datos porfavor");
			} else {
				$('#error_message').html('');
				$('#loading').show();
				$.ajax({
					url: "class/loguear.php",
					method: "POST",
					data: {
						usuario: usuario,
						clave: clave
					},
					success: function(data) {
						console.log(data.trim());
						if (data.trim() == "200") {
							window.location.href = 'index.php';
						} else if (data.trim() == "500") {
							$('#error_message').fadeIn().html("La contraseña es incorrecta");
						} else if (data.trim() == "600") {
							$('#error_message').fadeIn().html(
								"No cuenta con permisos para ingresar");
						} else if (data.trim() == "700") {
							$('#error_message').fadeIn().html("Usuario no encontrado");
						}
					},
					complete: function() {
						$('#loading').hide();
					},
					error: function(data) {
						$('#error_message').fadeIn().html("Error 500: Internal Sever Error");
					},
				});
			}
		});
	});
</script>