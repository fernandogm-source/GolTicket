<?php
$path = $_SERVER['DOCUMENT_ROOT'] . '/CONCESIONARIO';
include($path . "/model/connect.php");

class DAOShop{
	function select_all_cars(){
		$sql = "SELECT * 
		FROM car c, model m
		WHERE c.model = m.id_model  
		ORDER BY c.count DESC";

		$conexion = connect::con();
		$res = mysqli_query($conexion, $sql);
		connect::close($conexion);

		$retrArray = array();
		if (mysqli_num_rows($res) > 0) {
			while ($row = mysqli_fetch_assoc($res)) {
				$retrArray[] = $row;
			}
		}
		return $retrArray;
	}

	function select_one_car($id){
		$sql = "SELECT *
		FROM car c, model m, type_motor t, category ca
		WHERE c.id_car = '$id'
		AND  c.model = m.id_model 
		AND c.category = ca.id_cat
		AND c.motor = t.cod_tmotor";

		$conexion = connect::con();
		$res = mysqli_query($conexion, $sql)->fetch_object();
		connect::close($conexion);

		return $res;
	}

	function select_imgs_car($id){
		$sql = "SELECT i.id_car, i.img_cars
			    FROM img_cars i
			    WHERE i.id_car = '$id'";

		$conexion = connect::con();
		$res = mysqli_query($conexion, $sql);
		connect::close($conexion);

		$imgArray = array();
		if (mysqli_num_rows($res) > 0) {
			foreach ($res as $row) {
				array_push($imgArray, $row);
			}
		}
		return $imgArray;
	}

	function select_filter_cars(){
		//coger las variable de cada uno de los filtros que vienen parseadas de antes
		$doors = $_GET['doors'];
		$color = $_GET['color'];
		$category = $_GET['category'];

		//Guardaremos los filtros pulsados dependiendo de si estan llenos o no
		$filtros = "";

		if ($color != '*' && $doors == '*' && $category == '*') {
			$exp_colors = explode(",", $color);
			for ($i = 0; $i < sizeof($exp_colors); $i++) {
				if ($i == 0) {
					$filtros .= "(color ='" . $exp_colors[$i] . "'";
				} else if ($i == (sizeof($exp_colors) - 1)) {
					$filtros .= "OR color = '" . $exp_colors[$i] . "')";
				} else {
					$filtros .= "OR color = '" . $exp_colors[$i] . "'";
				}
				if (sizeof($exp_colors) == 1) {
					$filtros .= ")";
				}
			}
		} else if ($color == '*' && $doors != '*' && $category == '*') {
			$filtros = "num_doors = '" . $doors . "'";
		} else if ($color == '*' && $doors == '*' && $category != '*') {
			$filtros = "category = '" . $category . "'";
		} else if ($color != '*' && $doors != '*' && $category == '*') {
			$filtros = "num_doors = '" . $doors . "' AND";

			$exp_colors = explode(",", $color);
			for ($i = 0; $i < sizeof($exp_colors); $i++) {
				if ($i == 0) {
					$filtros .= "(color ='" . $exp_colors[$i] . "'";
				} else if ($i == (sizeof($exp_colors) - 1)) {
					$filtros .= "OR color = '" . $exp_colors[$i] . "')";
				} else {
					$filtros .= "OR color = '" . $exp_colors[$i] . "'";
				}
				if (sizeof($exp_colors) == 1) {
					$filtros .= ")";
				}
			}
		} else if ($color != '*' && $doors == '*' && $category != '*') {
			$filtros = "category = '" . $category . "' AND";

			$exp_colors = explode(",", $color);
			for ($i = 0; $i < sizeof($exp_colors); $i++) {
				if ($i == 0) {
					$filtros .= "(color ='" . $exp_colors[$i] . "'";
				} else if ($i == (sizeof($exp_colors) - 1)) {
					$filtros .= "OR color = '" . $exp_colors[$i] . "')";
				} else {
					$filtros .= "OR color = '" . $exp_colors[$i] . "'";
				}
				if (sizeof($exp_colors) == 1) {
					$filtros .= ")";
				}
			}
		} else if ($color == '*' && $doors != '*' && $category != '*') {
			$filtros = "num_doors = '" . $doors . "' AND category = '" . $category . "'";
		} else {
			$filtros = "num_doors = '" . $doors . "' AND category = '" . $category . "' AND";
			$exp_colors = explode(",", $color);
			for ($i = 0; $i < sizeof($exp_colors); $i++) {
				if ($i == 0) {
					$filtros .= "(color ='" . $exp_colors[$i] . "'";
				} else if ($i == (sizeof($exp_colors) - 1)) {
					$filtros .= "OR color = '" . $exp_colors[$i] . "')";
				} else {
					$filtros .= "OR color = '" . $exp_colors[$i] . "'";
				}
				if (sizeof($exp_colors) == 1) {
					$filtros .= ")";
				}
			}
		}

		if ($doors == '*' && $color == '*' && $category == '*') {
			$sql = "SELECT c.*,m.id_brand, m.name_model, t.name_tmotor, ca.name_cat
			FROM car c, model m, type_motor t, category ca
			WHERE  c.model = m.id_model 
			AND c.category = ca.id_cat
			AND c.motor = t.cod_tmotor";
		} else {
			$sql = "SELECT c.*,m.id_brand, m.name_model, t.name_tmotor, ca.name_cat
			FROM car c, model m, type_motor t, category ca
			WHERE  c.model = m.id_model 
			AND c.category = ca.id_cat
			AND c.motor = t.cod_tmotor
			AND $filtros";
		}

		$conexion = connect::con();
		$res = mysqli_query($conexion, $sql);
		connect::close($conexion);

		$filtArray = array();
		if (mysqli_num_rows($res) > 0) {
			while ($row = mysqli_fetch_assoc($res)) {
				$filtArray[] = $row;
			}
		}

		return $filtArray;
	}
}
