<div id="contenido">
    <h1>⚽ Información del Evento</h1>

    <table class="read-event-table">
        <tr><td>Nombre</td><td><?= htmlspecialchars($event['event_name']) ?></td></tr>
        <tr><td>Descripción</td><td><?= htmlspecialchars($event['event_description']) ?></td></tr>
        <tr><td>Organización</td><td><?= htmlspecialchars($event['event_organization']) ?></td></tr>
        <tr><td>Fecha</td><td><?= htmlspecialchars($event['event_date']) ?></td></tr>
        <tr><td>Hora</td><td><?= htmlspecialchars($event['event_hour']) ?></td></tr>
        <tr><td>Fecha de publicación</td><td><?= htmlspecialchars($event['event_release_date']) ?></td></tr>
        <tr><td>Lugar</td><td><?= htmlspecialchars($event['event_place']) ?></td></tr>
        <tr><td>Ciudad</td><td><?= htmlspecialchars($event['event_city']) ?></td></tr>
        <tr><td>Duración</td><td><?= htmlspecialchars($event['event_duration']) ?> min</td></tr>
        <tr><td>Capacidad</td><td><?= htmlspecialchars($event['event_capacity']) ?> personas</td></tr>
        <tr><td>Precio</td><td><?= htmlspecialchars($event['event_price']) ?> €</td></tr>
        <tr><td>Entradas disponibles</td><td><?= htmlspecialchars($event['event_disponibility']) ?></td></tr>
        <tr><td>Servicios extra</td><td><?= implode(', ', json_decode($event['event_services'], true) ?? []) ?></td></tr>
        <tr><td>Equipo local</td><td><?= htmlspecialchars($event['event_local']) ?></td></tr>
        <tr><td>Equipo visitante</td><td><?= htmlspecialchars($event['event_visitor']) ?></td></tr>
        <tr><td>Tipos de entrada</td><td><?= implode(', ', json_decode($event['ticket_type'], true) ?? []) ?></td></tr>
        <tr><td>Competición</td><td><?= htmlspecialchars($event['event_competition']) ?></td></tr>
        <tr><td>Estado</td><td><?= htmlspecialchars($event['event_state']) ?></td></tr>
    </table>

    <div class="form-actions" style="margin-top:20px;">
        <a class="Button_blue" href="index.php?page=controller_event&op=list">⬅ Volver a la lista</a>
        <a class="Button_green" href="index.php?page=controller_event&op=update&id=<?= htmlspecialchars($event['event_id']) ?>">✏️ Editar evento</a>
    </div>
</div>
