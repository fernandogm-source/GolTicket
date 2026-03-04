<div id="contenido">
    <form autocomplete="on" method="post" name="delete_all_event" id="delete_all_event">
        <input type="hidden" name="id" value="prueba_delete_all">
        <table border='0'>
            <tr>
            <th width=1500><h3>Do you want to delete the whole list of users?</h3></th>
            </tr>
        </table>
        <table border='0'>
            <tr>
                <td width=680 align="right"><button type="button" class="Button_green" onclick="validate('delete_all')" name="delete_all_event" id="delete_all_event">Accept</button></td>
                <td><a class="Button_red" href="index.php?page=controller_event&op=list">Cancel</a></td>
            </tr>
        </table>
        <br>
        <br>
    </form>
</div>