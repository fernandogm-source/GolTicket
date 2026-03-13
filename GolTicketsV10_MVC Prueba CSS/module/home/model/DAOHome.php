<?php
$path = $_SERVER['DOCUMENT_ROOT'] . '/GolTicketsV10_MVC Prueba CSS/';
include($path . "model/connect.php");

class DAOHome
{
	function select_all_categories()
	{
		// echo json_encode("select_all_user");
        // exit();
		$sql = "SELECT nombre_competicion,img_competicion FROM competicion";
		$conexion = connect::con();
		$stmt = $conexion->prepare($sql);
		$stmt->execute();
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		connect::close($conexion);
		return $res;
	}

}