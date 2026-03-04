<div id="contenido">
    <form autocomplete="on" method="post" name="delete_event" id="delete_event">
        <input type="hidden" name="id" value="<?= htmlspecialchars($_GET['id'])?>">
        <h1>Eliminar evento</h1>
        <table border='0'>
            <tr>
                <td align="center" colspan="2">
                    <h3>¿Desea seguro borrar al usuario
                        <?= htmlspecialchars($_GET['id'] ?? '')?>?
                    </h3>
                </td>
            </tr>
            <tr>
                <td align="center"><button type="button" class="Button_green" onclick="validate('delete')" name="delete" id="delete">Aceptar</button>
                </td>
                <td align="center"><a class="Button_red" href="index.php?page=controller_event&op=list">Cancelar</a></td>
            </tr>
        </table>
    </form>
</div>