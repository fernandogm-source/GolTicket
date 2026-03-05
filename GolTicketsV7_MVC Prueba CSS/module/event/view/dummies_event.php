<div id="contenido">
    <form autocomplete="on" method="post" name="dummies_event" id="dummies_event">
        <input type="hidden" name="id" value="prueba_dummies">

        <div class="confirm-box">
            <span class="confirm-icon">🗂️</span>
            <h3>¿Deseas cargar la lista de eventos de ejemplo (dummies)?<br>Se borrarán los eventos actuales.</h3>
            <div class="confirm-actions">
                <button type="button" class="Button_green" onclick="validate('dummies')" name="dummies">✔ Aceptar</button>
                <a class="Button_red" href="index.php?page=controller_event&op=list">✖ Cancelar</a>
            </div>
        </div>
    </form>
</div>
