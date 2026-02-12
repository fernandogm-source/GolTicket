<?php
include "connect.php";

$result = $conn->query("SELECT * FROM eventos ORDER BY id_evento DESC");
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
        <td><?= htmlspecialchars($row['nombre_evento']) ?></td>
        <td><?= $row['descripcion_evento'] ?></td>
        <td><?= $row['organizacion_evento'] ?></td>
        <td><?= $row['fecha_evento'] ?></td>
        <td><?= $row['hora_evento'] ?></td>
        <td><?= $row['fecha_publicacion_evento'] ?></td>
        <td><?= $row['lugar_evento'] ?></td>
        <td><?= $row['ciudad_evento'] ?></td>
        <td><?= $row['duracion_evento'] ?></td>
        <td><?= $row['capacidad_evento'] ?></td>
        <td><?= $row['precio_evento'] ?>€</td>
        <td><?= $row['entradas_disponibles_evento'] ?></td>
        <td><?= implode(', ', json_decode($row['servicios_disponibles_evento'], true)) ?></td></td>
        <td><?= $row['equipo_local'] ?></td>
        <td><?= $row['equipo_visitante'] ?></td>
        <td><?= implode(', ', json_decode($row['tipo_entrada_evento'], true)) ?></td></td>
        <td><?= $row['tipo_partido_evento'] ?></td>
        <td><?= $row['estado_evento'] ?></td>
        <td>
            <a href="edit.php?id_evento=<?= $row['id_evento'] ?>">✏️</a>
            <a href="delete.php?id_evento=<?= $row['id_evento'] ?>" onclick="return confirm('Eliminar?')">❌</a>
        </td>
    </tr>
<?php endforeach; ?>
</table>