<?php
    $path = $_SERVER['DOCUMENT_ROOT'] . '/GolTicketsV8_MVC/';
    include($path . "/model/connect.php");
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
		/* $data = 'entrando a read one';
        die('<script>console.log('.json_encode( $data ) .');</script>'); */
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
    $id       = $datos['event_id'] ?? '';
    $name     = $datos['event_name'] ?? '';
    $descr    = $datos['event_description'] ?? '';
    $organ    = $datos['event_organization'] ?? '';
    $date     = $datos['event_date'] ?? '';
    $hour     = $datos['event_hour'] ?? '';
    $place    = $datos['event_place'] ?? '';
    $city     = $datos['event_city'] ?? '';
    $duration = $datos['event_duration'] ?? '';
    $capacity = $datos['event_capacity'] ?? '';
    $price    = $datos['event_price'] ?? '';
    $dispon   = $datos['event_disponibility'] ?? '';
    $services = $datos['event_services'] ?? '';
    $local    = $datos['event_local'] ?? '';
    $visitor  = $datos['event_visitor'] ?? '';
    $ticket   = $datos['ticket_type'] ?? '';
    $compet   = $datos['event_competition'] ?? '';
    $state    = $datos['event_state'] ?? '';

    $servicesJson = json_encode($services);
    $ticketJson   = json_encode($ticket);

    $sql = "UPDATE `eventos` 
            SET `event_name`=:event_name, `event_description`=:event_description, `event_organization`=:event_organization
            , `event_date`=:event_date, `event_hour`=:event_hour, `event_place`=:event_place
            , `event_city`=:event_city, `event_duration`=:event_duration, `event_capacity`=:event_capacity, `event_price`=:event_price
            , `event_disponibility`=:event_disponibility, `event_services`=:event_services
            , `event_local`=:event_local, `event_visitor`=:event_visitor, `ticket_type`=:ticket_type, `event_competition`=:event_competition
            , `event_state`=:event_state 
            WHERE event_id=:event_id";

    $conexion = connect::con();
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':event_id',           $id);           // ✅ CORREGIDO (faltaba)
    $stmt->bindParam(':event_name',         $name);         // ✅ CORREGIDO
    $stmt->bindParam(':event_description',  $descr);        // ✅ CORREGIDO
    $stmt->bindParam(':event_organization', $organ);        // ✅ CORREGIDO
    $stmt->bindParam(':event_date',         $date);         // ✅ CORREGIDO
    $stmt->bindParam(':event_hour',         $hour);         // ✅ CORREGIDO
    $stmt->bindParam(':event_place',        $place);        // ✅ CORREGIDO
    $stmt->bindParam(':event_city',         $city);         // ✅ CORREGIDO
    $stmt->bindParam(':event_duration',     $duration);     // ✅ CORREGIDO
    $stmt->bindParam(':event_capacity',     $capacity);     // ✅ CORREGIDO
    $stmt->bindParam(':event_price',        $price);        // ✅ CORREGIDO
    $stmt->bindParam(':event_disponibility',$dispon);       // ✅ CORREGIDO
    $stmt->bindParam(':event_services',     $servicesJson); // ✅ CORREGIDO
    $stmt->bindParam(':event_local',        $local);        // ✅ CORREGIDO
    $stmt->bindParam(':event_visitor',      $visitor);      // ✅ CORREGIDO
    $stmt->bindParam(':ticket_type',        $ticketJson);   // ✅ CORREGIDO
    $stmt->bindParam(':event_competition',  $compet);       // ✅ CORREGIDO
    $stmt->bindParam(':event_state',        $state);        // ✅ CORREGIDO

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

	function delete_all_event(){
			$sql = "DELETE FROM eventos";
			
			$conexion = connect::con();
            $stmt = $conexion->prepare($sql);
            $res = $stmt->execute();
            connect::close($conexion);
            return $res;
		}

	function dummies_event(){
			$sql = "DELETE FROM eventos;";
			
			$sql.= "INSERT INTO `eventos` (`event_id`, `event_name`, `event_description`, `event_organization`, `event_date`, `event_hour`, `event_release_date`, `event_place`, `event_city`, `event_duration`, `event_capacity`, `event_price`, `event_disponibility`, `event_services`, `event_img`, `event_local`, `event_visitor`, `ticket_type`, `event_competition`, `event_state`) VALUES
				(1, 'Real Madrid vs Barcelona', 'El Clásico de España partido de máxima rivalidad', 'LaLiga', '15/03/2025', '21:00', '2025-01-10', 'Santiago Bernabéu', 'Madrid', '120', '81044', '95', '15000', '[\"parking\", \"taquillas\", \"acceso a tienda de merchandising\"]', 'clasico.jpg', 'Real Madrid', 'Barcelona', '[\"general\", \"vip\", \"premium\", \"palco\"]', 'laliga', 'en_venta'),
				(2, 'Valencia vs Sevilla', 'Partido clave por puestos europeos', 'LaLiga', '02/04/2025', '18:30', '2025-02-01', 'Mestalla', 'Valencia', '110', '49000', '45', '12000', '[\"parking\", \"taquillas\"]', 'valencia_sevilla.jpg', 'Valencia CF', 'Sevilla FC', '[\"general\", \"grada\", \"vip\"]', 'laliga', 'en_venta'),
				(3, 'Levante vs Eibar', 'Duelo directo por el ascenso', 'LaLiga2', '20/02/2025', '20:45', '2025-01-05', 'Ciutat de Valencia', 'Valencia', '105', '26000', '25', '8000', '[\"taquillas\", \"acceso a tienda de merchandising\"]', 'levante_eibar.jpg', 'Levante UD', 'SD Eibar', '[\"general\", \"grada\"]', 'laliga2', 'programado'),
				(4, 'Athletic Club vs Real Sociedad', 'Derbi vasco en eliminatoria de Copa del Rey', 'RFEF', '28/01/2025', '22:00', '2024-12-20', 'San Mamés', 'Bilbao', '120', '53000', '60', '9000', '[\"parking\", \"taquillas\"]', 'derbi_vasco.jpg', 'Athletic Club', 'Real Sociedad', '[\"vip\", \"premium\", \"palco\"]', 'copa_del_rey', 'en_venta'),
				(5, 'Atlético de Madrid vs Bayern Múnich', 'Partido de Champions League fase de grupos', 'UEFA', '03/10/2025', '20:00', '2025-08-15', 'Cívitas Metropolitano', 'Madrid', '120', '68000', '85', '14000', '[\"parking\", \"acceso a tienda de merchandising\"]', 'atleti_bayern.jpg', 'Atlético de Madrid', 'Bayern Múnich', '[\"general\", \"vip\", \"premium\", \"palco\"]', 'champions_league', 'programado')";
			
			$conexion = connect::con();
            $stmt = $conexion->prepare($sql);
            $res = $stmt->execute();
            connect::close($conexion);
            return $res;
		}
}