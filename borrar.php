<?php
	require_once "conexion.php";

	$id = $_GET['id'];

	$base->query("DELETE FROM datos_usuario WHERE id = '$id'");

	header("Location: index.php");
?>