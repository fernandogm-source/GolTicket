<?php
$path = $_SERVER['DOCUMENT_ROOT'] . '/GolTicketsV13_MVC/';
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

	function select_all_cities()
	{
		// echo json_encode("select_all_user");
        // exit();
		$sql = "SELECT nombre_ciudad,img_ciudad FROM ciudad";
		$conexion = connect::con();
		$stmt = $conexion->prepare($sql);
		$stmt->execute();
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		connect::close($conexion);
		return $res;
	}

		function select_all_teams()
	{
		// echo json_encode("select_all_user");
        // exit();
		$sql = "SELECT nombre_equipo,img_equipo FROM equipo";
		$conexion = connect::con();
		$stmt = $conexion->prepare($sql);
		$stmt->execute();
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		connect::close($conexion);
		return $res;
	}

		function select_all_carousel()
	{
		// echo json_encode("select_all_user");
        // exit();
		$sql = "SELECT p.nombre_partido,c.nombre_competicion,p.fecha_partido,ca.nombre_campo,ca.img_campo
				FROM partido p, competicion c,campo ca
				WHERE p.id_equipolocal=ca.id_equipo AND p.id_competicion=c.id_competicion";
		$conexion = connect::con();
		$stmt = $conexion->prepare($sql);
		$stmt->execute();
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		connect::close($conexion);
		return $res;
	}
}