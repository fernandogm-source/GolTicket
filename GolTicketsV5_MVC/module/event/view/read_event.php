<?php
/* $lang = json_decode($event['language'], true) ?? [];
$afi = json_decode($event['hobby'], true) ?? []; */
?>
<div id="contenido">
    <h1>Informacion del Evento</h1>
    <p>
    <table border='2'>
        <tr>
            <td>Nombre: </td>
            <td><?= htmlspecialchars($event['event_name']) ?></td>
        </tr>
        <tr>
            <td>Descripción: </td>
            <td><?= $event['event_description'] ?></td>
        </tr>
        <tr>
            <td>Organización: </td>
            <td><?= $event['event_organization'] ?></td>
        </tr>
        <tr>
            <td>Fecha: </td>
            <td><?= $event['event_date'] ?></td>
        </tr>
        <tr>
            <td>Hora: </td>
            <td><?= $event['event_hour'] ?></td>
        </tr>
        <tr>
            <td>Fecha de publicación: </td>
            <td><?= $event['event_release_date'] ?></td>
        </tr>
        <tr>
            <td>Lugar: </td>
            <td><?= $event['event_place'] ?></td>
        </tr>
        <tr>
            <td>Ciudad: </td>
            <td><?= $event['event_city'] ?></td>
        </tr>
        <tr>
            <td>Duración: </td>
            <td><?= $event['event_duration'] ?></td>
        </tr>
        <tr>
            <td>Capacidad: </td>
            <td><?= $event['event_capacity'] ?></td>
        </tr>
        <tr>
            <td>Precio: </td>
            <td><?= $event['event_price'] ?>€</td>
        </tr>
        <tr>
            <td>Entradas disponibles: </td>
            <td><?= $event['event_disponibility'] ?></td>
        </tr>
        <tr>
            <td>Servicios extra: </td>
            <td><?= implode(', ', json_decode($event['event_services'], true)) ?></td>
        </tr>
        <tr>
            <td>Equipo Local: </td>
            <td><?= $event['event_local'] ?></td>
        </tr>
        <tr>
            <td>Equipo Visitante: </td>
            <td><?= $event['event_visitor'] ?></td>
        </tr>
        <tr>
            <td>Tipo de entradas: </td>
            <td><?= implode(', ', json_decode($event['ticket_type'], true)) ?></td>
        </tr>
        <tr>
            <td>Competición: </td>
            <td><?= $event['event_competition'] ?></td>
        </tr>
        <tr>
            <td>Estado: </td>
            <td><?= $event['event_state'] ?></td>
        </tr>
    </table>
    </p>
    <p><a href="index.php?page=controller_event&op=list">Volver</a></p>
</div>