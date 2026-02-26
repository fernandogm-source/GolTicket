<?php
$lang = json_decode($user['language'], true) ?? [];
$afi = json_decode($user['hobby'], true) ?? [];
?>
<div id="contenido">
    <h1>Informacion del Usuario</h1>
    <p>
    <table border='2'>
        <tr>
            <td>Usuario: </td>
            <td>
                <?= htmlspecialchars($user['user'] ?? '')?>
            </td>
        </tr>
        <tr>
            <td>Contraseña: </td>
            <td>
                <?= htmlspecialchars($user['pass'] ?? '')?>
            </td>
        </tr>
        <tr>
            <td>Nombre: </td>
            <td>
                <?= htmlspecialchars($user['name'] ?? '')?>
            </td>
        </tr>
        <tr>
            <td>DNI: </td>
            <td>
                <?= htmlspecialchars($user['dni'] ?? '')?>
            </td>
        </tr>
        <tr>
            <td>Sexo: </td>
            <td>
                <?= htmlspecialchars($user['sex'] ?? '')?>
            </td>
        </tr>
        <tr>
            <td>Fecha de nacimiento: </td>
            <td>
                <?= htmlspecialchars($user['birthdate'] ?? '')?>
            </td>
        </tr>
        <tr>
            <td>Edad: </td>
            <td>
                <?= htmlspecialchars($user['age'] ?? '')?>
            </td>
        </tr>
        <tr>
            <td>Pais: </td>
            <td>
                <?= htmlspecialchars($user['country'] ?? '')?>
            </td>
        </tr>
        <tr>
            <td>Idioma: </td>
            <td>
                <?= htmlspecialchars(implode(', ', $lang))?>
            </td>
        </tr>
        <tr>
            <td>Observaciones: </td>
            <td>
                <?= htmlspecialchars($user['comment'] ?? '')?>
            </td>
        </tr>
        <tr>
            <td>Aficiones: </td>
            <td>
                <?= htmlspecialchars(implode(', ', $afi))?>
            </td>
        </tr>
    </table>
    </p>
    <p><a href="index.php?page=controller_user&op=list">Volver</a></p>
</div>