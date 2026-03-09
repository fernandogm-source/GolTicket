<div id="contenido">
    <form autocomplete="on" method="post" name="delete_all_event" id="delete_all_event">
        <input type="hidden" name="id" value="prueba_delete_all">

        <div class="confirm-box">
            <span class="confirm-icon">⚠️</span>
            <h3>¿Seguro que deseas borrar <strong>toda</strong> la lista de eventos?<br>Esta acción no se puede deshacer.</h3>
            <div class="confirm-actions">
                <button type="button" class="Button_green" onclick="validate('delete_all')" name="delete_all_event">✔ Aceptar</button>
                <a class="Button_red" href="index.php?page=controller_event&op=list">✖ Cancelar</a>
            </div>
        </div>
    </form>
</div>
