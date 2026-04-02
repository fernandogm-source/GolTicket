<?php
$path = $_SERVER['DOCUMENT_ROOT'] . '/GolTicketsV13_MVC/';
include($path . "/model/connect.php");

class DAOShop{
	function select_all_event() {
    $sql = "SELECT 
                p.id_partido,
                p.nombre_partido,
                p.fecha_partido,
                c.nombre_campo,
                co.nombre_competicion,
                ci.nombre_ciudad,
				c.img_campo
            FROM partido p
            JOIN campo c ON p.id_campo = c.id_campo
            JOIN competicion co ON p.id_competicion = co.id_competicion
            JOIN ciudad ci ON c.id_ciudad = ci.id_ciudad";

    try {
        $conexion = connect::con(); // Debe devolver una instancia PDO

        $stmt = $conexion->prepare($sql);
        $stmt->execute();

        $retrArray = $stmt->fetchAll(PDO::FETCH_ASSOC);

        connect::close($conexion); // Si tu clase tiene un método para cerrar la conexión
        return $retrArray;
    } catch (PDOException $e) {
        // Manejo de errores
        error_log("Error en select_all_event: " . $e->getMessage());
        return [];
    }
}


	function select_one_event($id) {
		$sql = "SELECT p.id_partido, p.nombre_partido, p.fecha_partido,
					c.nombre_campo, co.nombre_competicion, ci.nombre_ciudad
				FROM partido p
				JOIN campo c       ON p.id_campo       = c.id_campo
				JOIN competicion co ON p.id_competicion = co.id_competicion
				JOIN ciudad ci     ON c.id_ciudad       = ci.id_ciudad
				WHERE p.id_partido = :id";

		$conexion = connect::con();
		$stmt = $conexion->prepare($sql);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		$res = $stmt->fetch(PDO::FETCH_OBJ);
		connect::close($conexion);

		return $res;
	}

	function select_imgs_event($id) {
		$sql = "SELECT i.img
				FROM img_partido i
				WHERE i.id_partido = :id";

		$conexion = connect::con();
		$stmt = $conexion->prepare($sql);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		connect::close($conexion);

		return $res;
	}

		function select_extra_event($id) {
		$sql = "SELECT e.nombre_extra,e.img_extra
				FROM partido_extra p,extra e
				WHERE e.id_extra=p.id_extra AND p.id_partido = :id";

		$conexion = connect::con();
		$stmt = $conexion->prepare($sql);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		connect::close($conexion);

		return $res;
	}
}
