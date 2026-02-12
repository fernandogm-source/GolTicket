<?php
include "connect.php";

$event_id = intval($_GET['event_id']);
$sql = "DELETE FROM eventos WHERE event_id = :event_id";
$stmt = $conn->prepare($sql);
$stmt->execute([':event_id' => $event_id]);

header("Location:index.php");