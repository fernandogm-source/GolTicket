<div id="contenido">
    <div class="container">
        <div class="row">
            <h3>LISTA DE EVENTOS</h3>
        </div>
        <div class="row">
            <p><a href="index.php?page=controller_event&op=create">Create</a></p>
            <p><a href="index.php?page=controller_event&op=dummies">Dummies</a></p>
            <p><a href="index.php?page=controller_event&op=delete_all">Delete All</a></p>

            <table>
                <tr>
                    <td width=125><b>Nombre del evento</b></th>
                    <td width=125><b>Organización</b></th>
                    <td width=125><b>Fecha</b></th>
                    <th width=350><b>Accion</b></th>
                </tr>
                <?php
if (empty($rdo)) {
    echo '<tr>';
    echo '<td align="center" colspan="4">NO HAY NINGUN USUARIO</td>';
    echo '</tr>';
}
else {
    foreach ($rdo as $row) {
        echo '<tr>';
        echo '<td width=125>' . htmlspecialchars($row['event_name']) . '</td>';
        echo '<td width=125>' . htmlspecialchars($row['event_organization']) . '</td>';
        echo '<td width=125>' . htmlspecialchars($row['event_date']) . '</td>';
        echo '<td width=350>';
        echo '<a class="Button_blue" href="index.php?page=controller_event&op=read&id=' . htmlspecialchars($row['event_id']) . '">Read</a>';
        echo '&nbsp;';
        echo '<a class="Button_green" href="index.php?page=controller_event&op=update&id=' . htmlspecialchars($row['event_id']) . '">Update</a>';
        echo '&nbsp;';
        echo '<a class="Button_red" href="index.php?page=controller_event&op=delete&id=' . htmlspecialchars($row['event_id']) . '">Delete</a>';
        echo '</td>';
        echo '</tr>';
    }
}
?>
            </table>
        </div>
    </div>
</div>