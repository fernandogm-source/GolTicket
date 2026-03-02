<?php
include "C:\wamp64\www\Prestamos\connect.php";
$result = $conn->query("SELECT prestamos.*,cartas.nombre FROM cartas INNER JOIN prestamos ON cartas.id_carta=prestamos.id_carta ORDER BY prestador_id DESC");
?>  
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="prestamos.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GolTickets - Personas</title>
</head>
<body>

    <nav class="sidebar">
        <div class="sidebar-title">Menu</div>
        <a href="..\index.php" class="nav-link">🏠 Inicio</a>
        <a href="..\personas\personas.php" class="nav-link">👤 Personas</a>
        <a href="..\cartas\cartas.php" class="nav-link">🃏 Cartas</a>
        <a href="..\prestamos\prestamos.php" class="nav-link active">💳 Prestamos</a>
    </nav>

    <main class="contenido">
        <h2>PRESTAMOS</h2>

        <div class="actions">
            <a href="createPersona.php" class="btn-crear">
                <span class="icon">➕</span>
                <span class="text">Añadir un prestamo</span>
            </a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Propietario</th>
                    <th>Prestado</th>
                    <th>Carta</th>
                    <th>Cantidad</th>
                    <th>Estado</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $row): ?>
                    <tr>
                        <td><?= $row['prestador_id'] ?></td>
                        <td><?= $row['prestatario_id'] ?></td>
                        <td><?= $row['nombre'] ?></td>
                        <td><?= $row['cantidad'] ?></td>
                        <td><?= $row['estado'] ?></td>
                        <td>
                            <a href="edit.php?id_prestamo=<?= $row['id_prestamo'] ?>">✏️</a>
                            <a href="delete.php?id_prestamo=<?= $row['id_prestamo'] ?>" onclick="return confirm('Eliminar?')">❌</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

</body>
</html>