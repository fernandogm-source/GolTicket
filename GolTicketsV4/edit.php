<?php
session_start();
include "connect.php";

$id_evento = intval($_GET['id_evento'] ?? 0);
$sql = "SELECT * FROM eventos WHERE id_evento = :id_evento";
$stmt = $conn->prepare($sql);
$stmt->execute([':id_evento' => $id_evento]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

include "form.php";
