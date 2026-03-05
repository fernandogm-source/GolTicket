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
                echo '<a class="Button_blue" href="index.php?page=controller_event&op=read&id=' . htmlspecialchars($row['event_id']) . '">Ver</a> ';
                echo '<a class="Button_green" href="index.php?page=controller_event&op=update&id=' . htmlspecialchars($row['event_id']) . '">Editar</a> ';
                echo '<a class="Button_red" href="index.php?page=controller_event&op=delete&id=' . htmlspecialchars($row['event_id']) . '">Borrar</a>';
                echo '</td>';
                echo '</tr>';
            }
        }
        ?>
    </table>
</div>
