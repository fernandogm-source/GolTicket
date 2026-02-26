<?php
include("model/connect.php");

class DAOUser
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

	function select_all_user()
	{
		$sql = "SELECT * FROM usuario ORDER BY user ASC";
		$conexion = connect::con();
		$stmt = $conexion->prepare($sql);
		$stmt->execute();
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		connect::close($conexion);
		return $res;
	}

	function select_user($user)
	{
		$sql = "SELECT * FROM usuario WHERE user=:user";
		$conexion = connect::con();
		$stmt = $conexion->prepare($sql);
		$stmt->bindParam(':user', $user);
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

	function delete_user($user)
	{
		$sql = "DELETE FROM usuario WHERE user=:user";
		$conexion = connect::con();
		$stmt = $conexion->prepare($sql);
		$stmt->bindParam(':user', $user);
		$res = $stmt->execute();
		connect::close($conexion);
		return $res;
	}
}