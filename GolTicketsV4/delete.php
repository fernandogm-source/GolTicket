<?php
include "connect.php";

$id_evento = intval($_GET['id_evento']);
$sql = "DELETE FROM eventos WHERE id_evento = :id_evento";
$stmt = $conn->prepare($sql);
$stmt->execute([':id_evento' => $id_evento]);

header("Location:index.php");