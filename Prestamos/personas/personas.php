<?php
include "C:\wamp64\www\Prestamos\connect.php";
$result = $conn->query("SELECT * FROM personas ORDER BY id_persona DESC");
?>  
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="personas.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GolTickets - Personas</title>
</head>
<body>

    <nav class="sidebar">
       <div class="sidebar-title">Menu</div>
        <a href="..\index.php" class="nav-link">🏠 Inicio</a>
        <a href="..\personas\personas.php" class="nav-link active">👤 Personas</a>
        <a href="..\cartas\cartas.php" class="nav-link">🃏 Cartas</a>
        <a href="..\prestamos\prestamos.php" class="nav-link">💳 Prestamos</a>
    </nav>

    <main class="contenido">
        <h2>PERSONAS</h2>

        <div class="actions">
            <a href="createPersona.php" class="btn-crear">
                <span class="icon">➕</span>
                <span class="text">Añadir una persona</span>
            </a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $row): ?>
                    <tr>
                        <td><?= $row['id_persona'] ?></td>
                        <td><?= $row['nombre'] ?></td>
                        <td>
                            <a href="edit.php?id_persona=<?= $row['id_persona'] ?>">✏️</a>
                            <a href="delete.php?id_persona=<?= $row['id_persona'] ?>" onclick="return confirm('Eliminar?')">❌</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

</body>
</html>