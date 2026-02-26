<div id="contenido">
    <div class="container">
        <div class="row">
            <h3>LISTA DE USUARIOS</h3>
        </div>
        <div class="row">
            <p><a href="index.php?page=controller_user&op=create"><img src="view/img/anadir.png"></a></p>

            <table>
                <tr>
                    <td width=125><b>Usuario</b></th>
                    <td width=125><b>DNI</b></th>
                    <td width=125><b>Nombre</b></th>
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
        echo '<td width=125>' . htmlspecialchars($row['user']) . '</td>';
        echo '<td width=125>' . htmlspecialchars($row['dni']) . '</td>';
        echo '<td width=125>' . htmlspecialchars($row['name']) . '</td>';
        echo '<td width=350>';
        echo '<a class="Button_blue" href="index.php?page=controller_user&op=read&id=' . htmlspecialchars($row['user']) . '">Read</a>';
        echo '&nbsp;';
        echo '<a class="Button_green" href="index.php?page=controller_user&op=update&id=' . htmlspecialchars($row['user']) . '">Update</a>';
        echo '&nbsp;';
        echo '<a class="Button_red" href="index.php?page=controller_user&op=delete&id=' . htmlspecialchars($row['user']) . '">Delete</a>';
        echo '</td>';
        echo '</tr>';
    }
}
?>
            </table>
        </div>
    </div>
</div>