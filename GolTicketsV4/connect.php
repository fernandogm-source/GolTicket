<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "goltickets";

try {
    $conn = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // lanza excepciones
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // fetch asociativo
            PDO::ATTR_EMULATE_PREPARES => false // prepared reales
        ]
    );
} catch (PDOException $e) {
    die("Error DB: " . $e->getMessage());
}
?>