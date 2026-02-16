<?php
session_start();
include "connect.php";

$errores = [];
$old = $_POST;

// ========================
// RECIBIR DATOS
// ========================
$event_id=$_POST['event_id']??null;
$event_name = test_input($_POST['event_name'] ?? '');
$event_description = test_input($_POST['event_description'] ?? '');
$event_organization = test_input($_POST['event_organization'] ?? '');
$event_date = test_input($_POST['event_date'] ?? '');
$event_hour = test_input($_POST['event_hour'] ?? '');
$event_place = test_input($_POST['event_place'] ?? '');
$event_city = test_input($_POST['event_city'] ?? '');
$event_duration = test_input($_POST['event_duration'] ?? '');
$event_capacity = test_input($_POST['event_capacity'] ?? '');
$event_price = test_input($_POST['event_price'] ?? '');
$event_disponibility = test_input($_POST['event_disponibility'] ?? '');
$event_services = $_POST['event_services'] ?? [];
$event_local = test_input($_POST['event_local'] ?? '');
$event_visitor = test_input($_POST['event_visitor'] ?? '');
$event_ticket_type = $_POST['ticket_type'] ?? [];
$event_type = $_POST['event_competition'] ?? '';
$event_state = $_POST['event_state'] ?? '';

/* ========= NOMBRE ========= */
$event_name = test_input($_POST['event_name'] ?? '');
$old['event_name'] = $event_name;

if ($event_name === '') {
  $errores['event_name'] = "El nombre es obligatorio.";
} elseif (!preg_match("/^[a-zA-Z-'ñ ]*$/",$event_name)) {
    $errores['event_name'] = "Solo se pueden usar letras y espacios";
}

/* ========= DESCRIPCION ========= */
$event_description = test_input($_POST['event_description'] ?? '');
$old['event_description'] = $event_description;

if ($event_description === '') {
  $errores['event_description'] = "La descripción es obligatorio.";
} elseif (!preg_match("/^[a-zA-Z-'ñ ]*$/",$event_description)) {
    $errores['event_description'] = "Solo se pueden usar letras y espacios";
}

/* ========= ORGANIZACION ========= */
$event_organization = test_input($_POST['event_organization'] ?? '');
$old['event_organization'] = $event_organization;

if ($event_organization === '') {
  $errores['event_organization'] = "El organizador es obligatorio.";
} elseif (!preg_match("/^[a-zA-Z-'ñ ]*$/",$event_organization)) {
    $errores['event_organization'] = "Solo se pueden usar letras y espacios";
}

/* ========= FECHA EVENTO ========= */
if ($event_date === '') {
  $errores['event_date'] = "La fecha es obligatoria.";
} else {
  $fechaObj = DateTime::createFromFormat('d/m/Y', $event_date);
  $dateErrors = DateTime::getLastErrors();
  $warnings = $dateErrors['warning_count'] ?? 0; 
  $errors   = $dateErrors['error_count']  ?? 0;

  if (!$fechaObj || $warnings > 0 || $errors > 0) {
    $errores['event_date'] = "Formato de fecha inválido.";
  } else {
    $hoy = new DateTime('today');
    if ($fechaObj < $hoy) {
      $errores['event_date'] = "No se permiten fechas anteriores.";
    }
  }
}

/* ========= HORA ========= */
$event_hour = test_input($_POST['event_hour'] ?? '');
$old['event_hour'] = $event_hour;

if ($event_hour === '') {
  $errores['event_hour'] = "La hora es obligatorio.";
}

/* ========= LUGAR ========= */
$event_place = test_input($_POST['event_place'] ?? '');
$old['event_place'] = $event_place;

if ($event_place === '') {
  $errores['event_place'] = "El lugar es obligatorio.";
} elseif (!preg_match("/^[a-zA-Z-'ñ ]*$/",$event_place)) {
    $errores['event_place'] = "Solo se pueden usar letras y espacios";
}

/* ========= CIUDAD ========= */
$event_city = test_input($_POST['event_city'] ?? '');
$old['event_city'] = $event_city;

if ($event_city === '') {
  $errores['event_city'] = "La ciudad es obligatoria.";
} elseif (!preg_match("/^[a-zA-Z-'ñ ]*$/",$event_city)) {
    $errores['event_city'] = "Solo se pueden usar letras y espacios";
}

/* ========= DURACION ========= */
$event_duration = test_input($_POST['event_duration'] ?? '');
$old['event_duration'] = $event_duration;

if ($event_duration === '') {
  $errores['event_duration'] = "La duración es obligatoria.";
}

/* ========= CAPACIDAD ========= */
$event_capacity = test_input($_POST['event_capacity'] ?? '');
$old['event_capacity'] = $event_capacity;

if ($event_capacity === '') {
  $errores['event_capacity'] = "La capacidad es obligatoria.";
}

/* ========= PRECIO ========= */
$event_price = test_input($_POST['event_price'] ?? '');
$old['event_price'] = $event_price;

if ($event_price === '') {
  $errores['event_price'] = "El precio es obligatorio.";
}

/* ========= DISPONIBILIDAD ========= */
$event_disponibility = test_input($_POST['event_disponibility'] ?? '');
$old['event_disponibility'] = $event_disponibility;

if ($event_disponibility === '') {
  $errores['event_disponibility'] = "El numero de entradas es obligatorio.";
}

/* ========= SERVICIOS ========= */
if (empty($event_services)) {
    $errores['selected_services'] = "Selecciona al menos un servicio";
}

/* ========= LOCAL ========= */
$event_local = test_input($_POST['event_local'] ?? '');
$old['event_local'] = $event_local;

if ($event_local === '') {
  $errores['event_local'] = "El equipo local es obligatorio.";
} elseif (!preg_match("/^[a-zA-Z-'ñ ]*$/",$event_local)) {
    $errores['event_local'] = "Solo se pueden usar letras y espacios";
}

/* ========= VISITANTE ========= */
$event_visitor = test_input($_POST['event_visitor'] ?? '');
$old['event_visitor'] = $event_visitor;

if ($event_visitor === '') {
  $errores['event_visitor'] = "El equipo visitante es obligatorio.";
} elseif (!preg_match("/^[a-zA-Z-'ñ ]*$/",$event_visitor)) {
    $errores['event_visitor'] = "Solo se pueden usar letras y espacios";
}

/* ========= TIPO ENTRADA ========= */
if (empty($event_ticket_type)) {
    $errores['ticket_type'] = "Selecciona al menos un tipo de entrada";
}

/* ========= TIPO Partido ========= */
$partidosValidos = ['laliga','laliga2','copa_del_rey','champions_league'];
if (!in_array($event_type, $partidosValidos)) {
    $errores['event_competition'] = "Tipo inválido";
}

/* ========= ESTADO EVENTO ========= */
$estadosValidos = ['programado','en_venta','agotado','cancelado','finalizado'];
if (!in_array($event_state, $estadosValidos)) {
    $errores['event_state'] = "Tipo inválido";
}

// ========================
// SI ERRORES -> volver
// ========================
if($errores){
    $_SESSION['errores']=$errores;
    $_SESSION['old']=$old;
    header("Location: ".($event_id?"edit.php?id=$event_id":"create.php"));
    exit;
}


function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

// ========================
// PREPARAR PARA DB
// ========================
$event_servicesJson=json_encode($event_services);
$event_ticket_typeJson=json_encode($event_ticket_type);

if($event_id){
    $sql = "UPDATE `eventos` 
    SET `event_name`=:event_name,`event_description`=:event_description,`event_organization`=:event_organization
    ,`event_date`=:event_date,`event_hour`=:event_hour,`event_place`=:event_place
    ,`event_city`=:event_city,`event_duration`=:event_duration,`event_capacity`=:event_capacity,`event_price`=:event_price
    ,`event_disponibility`=:event_disponibility,`event_services`=:event_services
    ,`event_local`=:event_local,`event_visitor`=:event_visitor,`ticket_type`=:ticket_type,`event_competition`=:event_competition
    ,`event_state`=:event_state 
    WHERE event_id=:event_id";
    
    $stmt = $conn->prepare($sql);
     echo "<pre>";
     echo "SQL: $sql\n";
     print_r([
      ':event_name'                   => $event_name,
      ':event_description'            => $event_description,
      ':event_organization'           => $event_organization,
      ':event_date'                   => $event_date,
      ':event_hour'                   => $event_hour,
      ':event_place'                  => $event_place,
      ':event_city'                   => $event_city,
      ':event_duration'               => $event_duration,
      ':event_capacity'               => $event_capacity,
      ':event_price'                  => $event_price,
      ':event_disponibility'          => $event_disponibility,
      ':event_services'               => $event_servicesJson,
      ':event_local'                  => $event_local,
      ':event_visitor'                => $event_visitor,
      ':ticket_type'                  => $event_ticket_typeJson,
      ':event_competition'            => $event_type,
      ':event_state'                  => $event_state
     ]);
     echo "</pre>";
     exit;
/*     $stmt->execute([
      ':event_name'                   => $event_name,
      ':event_description'            => $event_description,
      ':event_organization'           => $event_organization,
      ':event_date'                   => $event_date,
      ':event_hour'                   => $event_hour,
      ':event_place'                  => $event_place,
      ':event_city'                   => $event_city,
      ':event_duration'               => $event_duration,
      ':event_capacity'               => $event_capacity,
      ':event_price'                  => $event_price,
      ':event_disponibility'          => $event_disponibility,
      ':event_services'               => $event_servicesJson,
      ':event_local'                  => $event_local,
      ':event_visitor'                => $event_visitor,
      ':ticket_type'                  => $event_ticket_typeJson,
      ':event_competition'            => $event_type,
      ':event_state'                  => $event_state
    ]); */
}else{
    $sql = "INSERT INTO `eventos`(`event_name`, `event_description`
            , `event_organization`, `event_date`, `event_hour`, `event_place`
            , `event_city`, `event_duration`, `event_capacity`, `event_price`
            , `event_disponibility`, `event_services`, `event_local`
            , `event_visitor`, `ticket_type`, `event_competition`, `event_state`)
        VALUES(:nombre_evento,:descripcion_evento,:organizacion_evento,:fecha_evento,:hora_evento
        ,:lugar_evento,:ciudad_evento,:duracion_evento,:capacidad_evento,:precio_evento,:entradas_disponibles_evento
        ,:servicios_disponibles_evento,:equipo_local,:equipo_visitante,:tipo_entrada_evento,:tipo_partido_evento,:estado_evento)";
    $stmt = $conn->prepare($sql);
/*      echo "<pre>";
     echo "SQL: $sql\n";
     print_r([
      ':nombre_evento'                  => $event_name,
      ':descripcion_evento'             => $event_description,
      ':organizacion_evento'            => $event_organization,
      ':fecha_evento'                   => $event_date,
      ':hora_evento'                    => $event_hour,
      ':lugar_evento'                   => $event_place,
      ':ciudad_evento'                  => $event_city,
      ':duracion_evento'                => $event_duration,
      ':capacidad_evento'               => $event_capacity,
      ':precio_evento'                  => $event_price,
      ':entradas_disponibles_evento'    => $event_disponibility,
      ':servicios_disponibles_evento'   => $event_servicesJson,
      ':equipo_local'                   => $event_local,
      ':equipo_visitante'               => $event_visitor,
      ':tipo_entrada_evento'            => $event_ticket_typeJson,
      ':tipo_partido_evento'            => $event_type,
      ':estado_evento'                  => $event_state
     ]);
     echo "</pre>";
     exit; */
    $stmt->execute([
      ':nombre_evento'                  => $event_name,
      ':descripcion_evento'             => $event_description,
      ':organizacion_evento'            => $event_organization,
      ':fecha_evento'                   => $event_date,
      ':hora_evento'                    => $event_hour,
      ':lugar_evento'                   => $event_place,
      ':ciudad_evento'                  => $event_city,
      ':duracion_evento'                => $event_duration,
      ':capacidad_evento'               => $event_capacity,
      ':precio_evento'                  => $event_price,
      ':entradas_disponibles_evento'    => $event_disponibility,
      ':servicios_disponibles_evento'   => $event_servicesJson,
      ':equipo_local'                   => $event_local,
      ':equipo_visitante'               => $event_visitor,
      ':tipo_entrada_evento'            => $event_ticket_typeJson,
      ':tipo_partido_evento'            => $event_type,
      ':estado_evento'                  => $event_state
    ]);
}
header("Location:index.php");