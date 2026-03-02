<?php
$errores = $errores ?? [];

// $isUpdate = isset($user) && $user !== null && !empty($user['user']);
$isUpdate = isset($_GET['id']) ? true : false;
$action = $isUpdate ? "update" : "create";

// Fallback variables for creation or reloading
$u_user = $user['user'] ?? '';
$u_pass = $user['pass'] ?? '';
$u_name = $user['name'] ?? '';
$u_dni = $user['dni'] ?? '';
$u_sex = $user['sex'] ?? '';
$u_birthdate = $user['birthdate'] ?? '';
$u_age = $user['age'] ?? '';
$u_country = $user['country'] ?? '';
$u_comment = $user['comment'] ?? '';

// Arrays json (handle decoding if from DB, or arrays if from failed POST)
$u_lang_raw = $user['language'] ?? '[]';
$u_lang = is_array($u_lang_raw) ? $u_lang_raw : (json_decode($u_lang_raw, true) ?? []);

$u_hobby_raw = $user['hobby'] ?? '[]';
$u_hobby = is_array($u_hobby_raw) ? $u_hobby_raw : (json_decode($u_hobby_raw, true) ?? []);

function errorCampo($campo, $errores)
{
    return $errores[$campo] ?? '';
}

$opcionesSexo = ['Hombre' => 'Hombre', 'Mujer' => 'Mujer'];
$opcionesPais = ['España' => 'España', 'Portugal' => 'Portugal', 'Francia' => 'Francia'];
$opcionesIdioma = ['Español' => 'Español', 'Ingles' => 'Inglés', 'Portugues' => 'Portugués', 'Frances' => 'Francés'];
$opcionesAficion = ['Informatica' => 'Informática', 'Alimentacion' => 'Alimentación', 'Automovil' => 'Automóvil'];
?>
<div id="contenido">
    <form autocomplete="on" method="post" name="form_user" id="form_user" onsubmit="return validate();"
        action="index.php?page=controller_user&op=<?= $action?>">
        <!-- Retain id during update POSTs -->
        <input type="hidden" name="id" value="<?= htmlspecialchars($_GET['id'])?>">

        <h1>
            <?= $isUpdate ? 'Modificar usuario' : 'Usuario nuevo'?>
        </h1>
        <table border='0'>
            <tr>
                <td>Usuario: </td>
                <td>
                    <input type="text" id="usuario" name="usuario" placeholder="usuario"
                        value="<?= htmlspecialchars($u_user)?>"
                        class="<?= errorCampo('usuario', $errores) ? 'error' : ''?>" <?= $isUpdate ? 'readonly' : '' ?>/>
                </td>
                <td><span id="error_usuario" class="error-text">
                        <?= errorCampo('usuario', $errores) ? '❌ ' . errorCampo('usuario', $errores) : ''?>
                    </span></td>
            </tr>
            <tr>
                <td>Contraseña: </td>
                <td>
                    <input type="password" id="pass" name="pass" placeholder="contraseña"
                        value="<?= htmlspecialchars($u_pass)?>"
                        class="<?= errorCampo('pass', $errores) ? 'error' : ''?>" />
                </td>
                <td><span id="error_pass" class="error-text">
                        <?= errorCampo('pass', $errores) ? '❌ ' . errorCampo('pass', $errores) : ''?>
                    </span></td>
            </tr>
            <tr>
                <td>Nombre: </td>
                <td>
                    <input type="text" id="nombre" name="nombre" placeholder="nombre"
                        value="<?= htmlspecialchars($u_name)?>"
                        class="<?= errorCampo('nombre', $errores) ? 'error' : ''?>" <?= $isUpdate ? 'readonly' : '' ?>/>
                </td>
                <td><span id="error_nombre" class="error-text">
                        <?= errorCampo('nombre', $errores) ? '❌ ' . errorCampo('nombre', $errores) : ''?>
                    </span></td>
            </tr>
            <tr>
                <td>DNI: </td>
                <td>
                    <input type="text" id="DNI" name="DNI" placeholder="DNI" value="<?= htmlspecialchars($u_dni)?>"
                        class="<?= errorCampo('DNI', $errores) ? 'error' : ''?>" <?= $isUpdate ? 'readonly' : '' ?>/>
                </td>
                <td><span id="error_DNI" class="error-text">
                        <?= errorCampo('DNI', $errores) ? '❌ ' . errorCampo('DNI', $errores) : ''?>
                    </span></td>
            </tr>
            <tr>
                <td>Sexo: </td>
                <td>
                    <?php foreach ($opcionesSexo as $valor => $label): ?>
                    <label>
                        <input type="radio" name="sexo" value="<?= $valor?>" <?=($u_sex === $valor) ? 'checked' : '' ?>/>
                        <?= $label?>
                    </label>
                    <?php
endforeach; ?>
                </td>
                <td><span id="error_sexo" class="error-text">
                        <?= errorCampo('sexo', $errores) ? '❌ ' . errorCampo('sexo', $errores) : ''?>
                    </span></td>
            </tr>
            <tr>
                <td>Fecha de nacimiento: </td>
                <td>
                    <input id="fecha" type="text" name="fecha_nacimiento" placeholder="fecha de nacimiento"
                        value="<?= htmlspecialchars($u_birthdate)?>"
                        class="<?= errorCampo('fecha_nacimiento', $errores) ? 'error' : ''?>" />
                </td>
                <td><span id="error_fecha_nacimiento" class="error-text">
                        <?= errorCampo('fecha_nacimiento', $errores) ? '❌ ' . errorCampo('fecha_nacimiento', $errores) : ''?>
                    </span></td>
            </tr>
            <tr>
                <td>Edad: </td>
                <td>
                    <input type="text" id="edad" name="edad" placeholder="edad" value="<?= htmlspecialchars($u_age)?>"
                        class="<?= errorCampo('edad', $errores) ? 'error' : ''?>" />
                </td>
                <td><span id="error_edad" class="error-text">
                        <?= errorCampo('edad', $errores) ? '❌ ' . errorCampo('edad', $errores) : ''?>
                    </span></td>
            </tr>
            <tr>
                <td>Pais: </td>
                <td>
                    <select id="pais" name="pais" class="<?= errorCampo('pais', $errores) ? 'error' : ''?>">
                        <option value="">Seleccione país</option>
                        <?php foreach ($opcionesPais as $valor => $label): ?>
                        <option value="<?= $valor?>" <?=($u_country === $valor) ? 'selected' : '' ?>>
                            <?= $label?>
                        </option>
                        <?php
endforeach; ?>
                    </select>
                </td>
                <td><span id="error_pais" class="error-text">
                        <?= errorCampo('pais', $errores) ? '❌ ' . errorCampo('pais', $errores) : ''?>
                    </span></td>
            </tr>
            <tr>
                <td>Idioma: </td>
                <td>
                    <select multiple size="4" id="idioma[]" name="idioma[]"
                        class="<?= errorCampo('idioma', $errores) ? 'error' : ''?>">
                        <?php foreach ($opcionesIdioma as $valor => $label): ?>
                        <option value="<?= $valor?>" <?= in_array($valor, $u_lang) ? 'selected' : '' ?>>
                            <?= $label?>
                        </option>
                        <?php
endforeach; ?>
                    </select>
                </td>
                <td><span id="error_idioma" class="error-text">
                        <?= errorCampo('idioma', $errores) ? '❌ ' . errorCampo('idioma', $errores) : ''?>
                    </span></td>
            </tr>
            <tr>
                <td>Observaciones: </td>
                <td>
                    <textarea cols="30" rows="5" id="observaciones" name="observaciones" placeholder="observaciones"
                        class="<?= errorCampo('observaciones', $errores) ? 'error' : ''?>"><?= htmlspecialchars($u_comment)?></textarea>
                </td>
                <td><span id="error_observaciones" class="error-text">
                        <?= errorCampo('observaciones', $errores) ? '❌ ' . errorCampo('observaciones', $errores) : ''?>
                    </span></td>
            </tr>
            <tr>
                <td>Aficiones: </td>
                <td>
                    <?php foreach ($opcionesAficion as $valor => $label): ?>
                    <label>
                        <input type="checkbox" name="aficion[]" value="<?= $valor?>" <?= in_array($valor, $u_hobby)
        ? 'checked' : '' ?>/>
                        <?= $label?>
                    </label><br>
                    <?php
endforeach; ?>
                </td>
                <td><span id="error_aficion" class="error-text">
                        <?= errorCampo('aficion', $errores) ? '❌ ' . errorCampo('aficion', $errores) : ''?>
                    </span></td>
            </tr>
            <tr>
                <td><input type="submit" name="<?= $action?>" id="<?= $action?>"
                        value="<?= $isUpdate ? 'Modificar' : 'Crear'?>" /></td>
                <td align="right"><a href="index.php?page=controller_user&op=list">Volver</a></td>
            </tr>
        </table>
    </form>
</div>
<style>
    .error {
        border: 1px solid #d93025 !important;
    }

    .error-text {
        color: #d93025;
        font-size: 0.9em;
    }
</style>