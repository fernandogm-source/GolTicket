<?php
include "connect.php";

$result = $conn->query("SELECT * FROM eventos ORDER BY event_id DESC");
?>
<link rel="stylesheet" href="index.css">
<h2>⚽ GolTickets</h2>

        <div class="actions">
            <a href="create.php" class="btn-crear">
                <span class="icon">➕</span>
                <span class="text">Crear Nuevo Evento</span>
            </a>
        </div>
<table border="1" cellpadding="8">
    <tr>
        <th>Nombre</th>
        <th>Descripción</th>
        <th>Organización</th>
        <th>Fecha</th>
        <th>Hora</th>
        <th>Fecha de publicación</th>
        <th>Lugar</th>
        <th>Ciudad</th>
        <th>Duración</th>
        <th>Capacidad</th>
        <th>Precio</th>
        <th>Entradas disponibles</th>
        <th>Servicios extra</th>
        <th>Equipo Local</th>
        <th>Equipo Visitante</th>
        <th>Tipo de entradas</th>
        <th>Competición</th>
        <th>Estado</th>
        <th>Acciones</th>

    </tr>
   <?php foreach ($result as $row): ?>
    <tr>
        <td><?= htmlspecialchars($row['event_name']) ?></td>
        <td><?= $row['event_description'] ?></td>
        <td><?= $row['event_organization'] ?></td>
        <td><?= $row['event_date'] ?></td>
        <td><?= $row['event_hour'] ?></td>
        <td><?= $row['event_release_date'] ?></td>
        <td><?= $row['event_place'] ?></td>
        <td><?= $row['event_city'] ?></td>
        <td><?= $row['event_duration'] ?></td>
        <td><?= $row['event_capacity'] ?></td>
        <td><?= $row['event_price'] ?>€</td>
        <td><?= $row['event_disponibility'] ?></td>
        <td><?= implode(', ', json_decode($row['event_services'], true)) ?></td></td>
        <td><?= $row['event_local'] ?></td>
        <td><?= $row['event_visitor'] ?></td>
        <td><?= implode(', ', json_decode($row['ticket_type'], true)) ?></td></td>
        <td><?= $row['event_competition'] ?></td>
        <td><?= $row['event_state'] ?></td>
        <td>
            <a href="edit.php?event_id=<?= $row['event_id'] ?>">✏️</a>
            <a href="delete.php?event_id=<?= $row['event_id'] ?>" onclick="return confirm('Eliminar?')">❌</a>
        </td>
    </tr>
<?php endforeach; ?>
</table>