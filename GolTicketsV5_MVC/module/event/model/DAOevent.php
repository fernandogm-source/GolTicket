<?php
include("model/connect.php");

class DAOevent
{
	function insert_user($datos)
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

		$sql = "INSERT INTO usuario (user, pass, name, dni, sex, birthdate, age, country, language, comment, hobby) "
			. "VALUES (:user, :passwd, :name, :dni, :sex, :birthdate, :age, :country, :language, :comment, :hobby)";

		$conexion = connect::con();
		$stmt = $conexion->prepare($sql);
		$stmt->bindParam(':user', $user);
		$stmt->bindParam(':passwd', $passwd);
		$stmt->bindParam(':name', $name);
		$stmt->bindParam(':dni', $dni);
		$stmt->bindParam(':sex', $sex);
		$stmt->bindParam(':birthdate', $birthdate);
		$stmt->bindParam(':age', $age);
		$stmt->bindParam(':country', $country);
		$stmt->bindParam(':language', $language);
		$stmt->bindParam(':comment', $datos['observaciones']);
		$stmt->bindParam(':hobby', $hobby);

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
		$sql = "SELECT * FROM eventos WHERE event_id=:event";
		$conexion = connect::con();
		$stmt = $conexion->prepare($sql);
		$stmt->bindParam(':event', $event);
		$stmt->execute();
		$res = $stmt->fetch(PDO::FETCH_ASSOC);
		connect::close($conexion);
		return $res;
	}

	function update_user($datos)
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

		$sql = "UPDATE usuario SET pass=:passwd, name=:name, dni=:dni, sex=:sex, birthdate=:birthdate, age=:age, "
			. "country=:country, language=:language, comment=:comment, hobby=:hobby WHERE user=:user";

		$conexion = connect::con();
		$stmt = $conexion->prepare($sql);
		$stmt->bindParam(':user', $user);
		$stmt->bindParam(':passwd', $passwd);
		$stmt->bindParam(':name', $name);
		$stmt->bindParam(':dni', $dni);
		$stmt->bindParam(':sex', $sex);
		$stmt->bindParam(':birthdate', $birthdate);
		$stmt->bindParam(':age', $age);
		$stmt->bindParam(':country', $country);
		$stmt->bindParam(':language', $language);
		$stmt->bindParam(':comment', $datos['observaciones']);
		$stmt->bindParam(':hobby', $hobby);

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