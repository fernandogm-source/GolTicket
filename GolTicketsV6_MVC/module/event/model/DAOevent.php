<?php
include("model/connect.php");

class DAOevent
{
	function insert_event($datos)
	{
		$name = $datos['event_name'] ?? '';
		$descr = $datos['event_description'] ?? '';
		$organ = $datos['event_organization'] ?? '';
		$date = $datos['event_date'] ?? '';
		$hour = $datos['event_hour'] ?? '';
		$place = $datos['event_place'] ?? '';
		$city = $datos['event_city'] ?? '';
		$duration = $datos['event_duration'] ?? '';
		$capacity = $datos['event_capacity'] ?? '';
		$price = $datos['event_price'] ?? '';
		$dispon = $datos['event_disponibility'] ?? '';
		$services = $datos['event_services'] ?? '';
		$local = $datos['event_local'] ?? '';
		$visitor = $datos['event_visitor'] ?? '';
		$ticket = $datos['ticket_type'] ?? '';
		$compet = $datos['event_competition'] ?? '';
		$state = $datos['event_state'] ?? '';

		// Encodear checkboxes como JSON
		$servicesJson=json_encode($services);
		$ticketJson=json_encode($ticket);

		/* $data = 'hola crtl user';
		die('<script>console.log('.json_encode( $datos['event_services'] ?? '' ) .');</script>');	 */	

    $sql = "INSERT INTO `eventos`(`event_name`, `event_description`
            , `event_organization`, `event_date`, `event_hour`, `event_place`
            , `event_city`, `event_duration`, `event_capacity`, `event_price`
            , `event_disponibility`, `event_services`, `event_local`
            , `event_visitor`, `ticket_type`, `event_competition`, `event_state`)
        VALUES(:nombre_evento,:descripcion_evento,:organizacion_evento,:fecha_evento,:hora_evento
        ,:lugar_evento,:ciudad_evento,:duracion_evento,:capacidad_evento,:precio_evento,:entradas_disponibles_evento
        ,:servicios_disponibles_evento,:equipo_local,:equipo_visitante,:tipo_entrada_evento,:tipo_partido_evento,:estado_evento)";

		$conexion = connect::con();
		$stmt = $conexion->prepare($sql);
		$stmt->bindParam(':nombre_evento', $name);
		$stmt->bindParam(':descripcion_evento', $descr);
		$stmt->bindParam(':organizacion_evento', $organ);
		$stmt->bindParam(':fecha_evento', $date);
		$stmt->bindParam(':hora_evento', $hour);
		$stmt->bindParam(':lugar_evento', $place);
		$stmt->bindParam(':ciudad_evento', $city);
		$stmt->bindParam(':duracion_evento', $duration);
		$stmt->bindParam(':capacidad_evento', $capacity);
		$stmt->bindParam(':precio_evento', $price);
		$stmt->bindParam(':entradas_disponibles_evento', $dispon);
		$stmt->bindParam(':servicios_disponibles_evento', $servicesJson);
		$stmt->bindParam(':equipo_local', $local);
		$stmt->bindParam(':equipo_visitante', $visitor);
		$stmt->bindParam(':tipo_entrada_evento', $ticketJson);
		$stmt->bindParam(':tipo_partido_evento', $compet);
		$stmt->bindParam(':estado_evento', $state);

		$res = $stmt->execute();
		connect::close($conexion);
		return $res;
	}

	function select_all_event()
	{
		$sql = "SELECT * FROM eventos";
		$conexion = connect::con();
		$stmt = $conexion->prepare($sql);
		$stmt->execute();
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		connect::close($conexion);
		return $res;
	}

	function select_event($event)
	{
		$sql = "SELECT * FROM eventos WHERE event_id=:event_id";
		$conexion = connect::con();
		$stmt = $conexion->prepare($sql);
		$stmt->bindParam(':event_id', $event);
		$stmt->execute();
		$res = $stmt->fetch(PDO::FETCH_ASSOC);
		connect::close($conexion);
		return $res;
	}

	function update_event($datos)
	{
		$user = $datos['usuario'] ?? '';
		$passwd = $datos['pass'] ?? '';
		$name = $datos['nombre'] ?? '';
		$dni = $datos['DNI'] ?? '';
		$sex = $datos['sexo'] ?? '';
		$birthdate = $datos['fecha_nacimiento'] ?? '';
		$age = $datos['edad'] ?? '';
		$country = $datos['pais'] ?? '';

		// Encodear checkboxes como JSON
		$language = json_encode($datos['idioma'] ?? []);
		$hobby = json_encode($datos['aficion'] ?? []);

		$sql = "UPDATE `eventos` 
				SET `event_name`=:event_name,`event_description`=:event_description,`event_organization`=:event_organization
				,`event_date`=:event_date,`event_hour`=:event_hour,`event_place`=:event_place
				,`event_city`=:event_city,`event_duration`=:event_duration,`event_capacity`=:event_capacity,`event_price`=:event_price
				,`event_disponibility`=:event_disponibility,`event_services`=:event_services
				,`event_local`=:event_local,`event_visitor`=:event_visitor,`ticket_type`=:ticket_type,`event_competition`=:event_competition
				,`event_state`=:event_state 
				WHERE event_id=:event_id";

		$conexion = connect::con();
		$stmt = $conexion->prepare($sql);
		$stmt->bindParam(':nombre_evento', $name);
		$stmt->bindParam(':descripcion_evento', $descr);
		$stmt->bindParam(':organizacion_evento', $organ);
		$stmt->bindParam(':fecha_evento', $date);
		$stmt->bindParam(':hora_evento', $hour);
		$stmt->bindParam(':lugar_evento', $place);
		$stmt->bindParam(':ciudad_evento', $city);
		$stmt->bindParam(':duracion_evento', $duration);
		$stmt->bindParam(':capacidad_evento', $capacity);
		$stmt->bindParam(':precio_evento', $price);
		$stmt->bindParam(':entradas_disponibles_evento', $dispon);
		$stmt->bindParam(':servicios_disponibles_evento', $servicesJson);
		$stmt->bindParam(':equipo_local', $local);
		$stmt->bindParam(':equipo_visitante', $visitor);
		$stmt->bindParam(':tipo_entrada_evento', $ticketJson);
		$stmt->bindParam(':tipo_partido_evento', $compet);
		$stmt->bindParam(':estado_evento', $state);

		$res = $stmt->execute();
		connect::close($conexion);
		return $res;
	}

	function delete_event($event)
	{

			/* $data = 'hola crtl user controller';
 			die('<script>console.log('.json_encode( $event ) .');</script>'); */

		$sql = "DELETE FROM eventos WHERE event_id=:event";
		$conexion = connect::con();
		$stmt = $conexion->prepare($sql);
		$stmt->bindParam(':event', $event);
		$res = $stmt->execute();
		connect::close($conexion);
		return $res;
	}
}