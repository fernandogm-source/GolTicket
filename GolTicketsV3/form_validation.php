<?php
session_start();
$errores = [];
$old = $_POST;

// ========================
// RECIBIR DATOS
// ========================
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
$event_services = $_POST['selected_services'] ?? [];
$event_local = test_input($_POST['event_local'] ?? '');
$event_visitor = test_input($_POST['event_visitor'] ?? '');
$event_ticket_type = $_POST['selected_tickets'] ?? [];
$event_type = $_POST['selected_type'] ?? '';
$event_state = $_POST['selected_state'] ?? '';

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
$event_organization = test_input($_POST['event_hour'] ?? '');
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
    $errores['event_local'] = "Solo se pueden usar letras y espacios";
}

/* ========= TIPO ENTRADA ========= */
if (empty($event_ticket_type)) {
    $errores['selected_tickets'] = "Selecciona al menos un tipo de entrada";
}

/* ========= TIPO Partido ========= */
$partidosValidos = ['laliga','laliga2','copa_del_rey','champions_league'];
if (!in_array($event_type, $partidosValidos)) {
    $errores['selected_type'] = "Tipo inválido";
}

/* ========= ESTADO EVENTO ========= */
$estadosValidos = ['programado','en_venta','agotado','cancelado','finalizado'];
if (!in_array($event_state, $estadosValidos)) {
    $errores['selected_state'] = "Tipo inválido";
}

/* ========= SI HAY ERRORES ========= */
if ($errores) {
  $_SESSION['errores'] = $errores;
  $_SESSION['old'] = $old;
  header("Location: index.php");
  exit;
}


function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

