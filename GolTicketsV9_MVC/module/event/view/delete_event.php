<div id="contenido">
    <form autocomplete="on" method="post" name="delete_event" id="delete_event">
        <input type="hidden" name="id" value="<?= htmlspecialchars($_GET['id'] ?? '') ?>">

        <div class="confirm-box">
            <span class="confirm-icon">🗑️</span>
            <h3>¿Seguro que deseas borrar el evento<br><strong><?= htmlspecialchars($_GET['id'] ?? '') ?></strong>?</h3>
            <div class="confirm-actions">
                <button type="button" class="Button_green" onclick="validate('delete')">✔ Aceptar</button>
                <a class="Button_red" href="index.php?page=controller_event&op=list">✖ Cancelar</a>
            </div>
        </div>
    </form>
</div>
