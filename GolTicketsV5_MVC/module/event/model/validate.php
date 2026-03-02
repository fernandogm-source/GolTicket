<?php
function validate() {
    $errores = [];

    $usuario = trim($_POST['usuario'] ?? '');
    $pass = trim($_POST['pass'] ?? '');
    $nombre = trim($_POST['nombre'] ?? '');
    $dni = trim($_POST['DNI'] ?? '');
    $sexo = $_POST['sexo'] ?? '';
    $fecha = $_POST['fecha_nacimiento'] ?? '';
    $edad = trim($_POST['edad'] ?? '');
    $pais = $_POST['pais'] ?? '';
    $idioma = $_POST['idioma'] ?? [];
    $observaciones = trim($_POST['observaciones'] ?? '');
    $aficion = $_POST['aficion'] ?? [];
    
    // --- Usuario y Existencia (Solo si es Create) ---
    if (empty($usuario) || !preg_match("/^[a-zA-Z]*$/", $usuario)) {
        $errores['usuario'] = "El usuario introducido no es válido";
    // } elseif (validate_user_exists($usuario)) {
    } elseif (isset($_POST['create']) && validate_user_exists($usuario)) {
        $errores['usuario'] = "El usuario ya existe en la base de datos";
    }

    // --- Contraseña ---
    if (empty($pass) || !preg_match("/(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/", $pass)) {
        $errores['pass'] = "La contraseña introducida no es válida";
    }

    // --- Nombre ---
    if (empty($nombre) || !preg_match("/^[a-zA-Z]*$/", $nombre)) {
        $errores['nombre'] = "El nombre introducido no es válido";
    } else {
        // Verificar duplicado
        if (isset($_POST['create']) && validate_nombre($nombre, $usuario)) {
        // if (validate_nombre($nombre, $usuario)) {
            $errores['nombre'] = "El nombre no puede estar repetido";
        }
    }

    // --- DNI ---
    if (empty($dni)) { // Simple check, frontend does full validation
        $errores['DNI'] = "El DNI introducido no es válido";
    } else {
        if (isset($_POST['create']) && validate_dni($dni, $usuario)) {
        // if (validate_dni($dni, $usuario)) {
            $errores['DNI'] = "El DNI no puede estar repetido";
        }
    }

    // --- Sexo ---
    if (empty($sexo)) {
        $errores['sexo'] = "No has seleccionado ningún género";
    }

    // --- Fecha Nacimiento ---
    if (empty($fecha)) {
        $errores['fecha_nacimiento'] = "No has introducido ninguna fecha";
    }

    // --- Edad ---
    if (empty($edad) || !preg_match("/^[0-9]{1,2}$/", $edad)) {
        $errores['edad'] = "La edad introducida no es válida";
    }

    // --- Pais ---
    if (empty($pais)) {
        $errores['pais'] = "No has seleccionado ningún país";
    }

    // --- Idioma ---
    if (empty($idioma)) {
        $errores['idioma'] = "No has seleccionado ningún idioma";
    }

    // --- Observaciones ---
    if (empty($observaciones)) {
        $errores['observaciones'] = "El texto introducido no es válido";
    }

    // --- Afición ---
    if (empty($aficion)) {
        $errores['aficion'] = "No has seleccionado ninguna afición";
    }

    return $errores;
}

function validate_user_exists($user) {
    $sql = "SELECT count(*) FROM usuario WHERE user=:user";
    $conexion = connect::con();
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':user', $user);
    $stmt->execute();
    $count = $stmt->fetchColumn();
    return $count > 0;
}

function validate_nombre($nombre, $currentUser = ''){
    // $sql = "SELECT count(*) FROM usuario WHERE name=:nombre" . ($currentUser ? " AND user != :current" : "");
    $sql = "SELECT count(*) FROM usuario WHERE name=:nombre";
    $conexion = connect::con();
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':nombre', $nombre);
    // if ($currentUser) $stmt->bindParam(':current', $currentUser);
    $stmt->execute();
    $count = $stmt->fetchColumn();
    return $count > 0;
}

function validate_dni($dni, $currentUser = ''){
    // $sql = "SELECT count(*) FROM usuario WHERE dni=:dni" . ($currentUser ? " AND user != :current" : "");
    $sql = "SELECT count(*) FROM usuario WHERE dni=:dni";
    $conexion = connect::con();
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':dni', $dni);
    // if ($currentUser) $stmt->bindParam(':current', $currentUser);
    $stmt->execute();
    $count = $stmt->fetchColumn();
    return $count > 0;
}
?>