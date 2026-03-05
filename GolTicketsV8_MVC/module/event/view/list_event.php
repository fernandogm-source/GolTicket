<div id="contenido">
    <div class="list-header">
        <h3>⚽ Lista de Eventos</h3>
        <div class="list-actions">
            <a class="btn-crear" href="index.php?page=controller_event&op=create">➕ Crear evento</a>
            <a class="btn-dummies" href="index.php?page=controller_event&op=dummies">🗂 Cargar dummies</a>
            <a class="btn-delete-all" href="index.php?page=controller_event&op=delete_all">🗑 Borrar todos</a>
        </div>
    </div>

    <table>
        <tr>
            <th width="185">Nombre del evento</th>
            <th width="130">Organización</th>
            <th width="110">Fecha</th>
            <th>Acciones</th>
        </tr>
        <?php
        if (empty($rdo)) {
            echo '<tr><td colspan="4" class="empty-list">⚽ No hay ningún evento registrado</td></tr>';
        } else {
            foreach ($rdo as $row) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['event_name']) . '</td>';
                echo '<td>' . htmlspecialchars($row['event_organization']) . '</td>';
                echo '<td>' . htmlspecialchars($row['event_date']) . '</td>';
                echo '<td>';
                print ("<div class='event' id='".$row['event_id']."'>Read</div>");
                echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                /* echo '<a class="Button_blue" href="index.php?page=controller_event&op=read&id=' . htmlspecialchars($row['event_id']) . '">Ver</a> '; */
                echo '<a class="Button_green" href="index.php?page=controller_event&op=update&id=' . htmlspecialchars($row['event_id']) . '">Editar</a> ';
                echo '<a class="Button_red" href="index.php?page=controller_event&op=delete&id=' . htmlspecialchars($row['event_id']) . '">Borrar</a>';
                echo '</td>';
                echo '</tr>';
            }
        }
        ?>
    </table>
</div>

<!-- modal window -->
<section id="event_modal">
    <div id="details_event" hidden>
        <div id="details">
            <div id="container">
                <table class="read-event-table">
                    <tr><td>Nombre</td><td><div id="event_name"></div></tr>
                    <tr><td>Descripción</td><td><div id="event_description"></div></tr>
                    <tr><td>Organización</td><td><div id="event_organization"></div></tr>
                    <tr><td>Fecha</td><td><div id="event_date"></div></tr>
                    <tr><td>Hora</td><td><div id="event_hour"></div></tr>
                    <tr><td>Lugar</td><td><div id="event_place"></div></tr>
                    <tr><td>Ciudad</td><td><div id="event_city"></div></tr>
                    <tr><td>Duración</td><td><div id="event_duration"></div></tr>
                    <tr><td>Capacidad</td><td><div id="event_capacity"></div></tr>
                    <tr><td>Precio</td><td><div id="event_price"></div></tr>
                    <tr><td>Entradas disponibles</td><td><div id="event_disponibility"></div></tr>
                    <tr><td>Servicios extra</td><td><div id="services"></div></tr>
                    <tr><td>Equipo local</td><td><div id="event_local"></div></tr>
                    <tr><td>Equipo visitante</td><td><div id="event_visitor"></div></tr>
                    <tr><td>Tipos de entrada</td><td><div id="tickets"></div></tr>
                    <tr><td>Competición</td><td><div id="type"></div></tr>
                    <tr><td>Estado</td><td><div id="state"></div></tr>
                </table>
            </div>
        </div>
    </div>
</section>
