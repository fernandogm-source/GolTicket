<?php
session_start();
include "connect.php";

$event_id = intval($_GET['event_id'] ?? 0);
$sql = "SELECT * FROM eventos WHERE event_id = :event_id";
$stmt = $conn->prepare($sql);
$stmt->execute([':event_id' => $event_id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

include "form.php";
