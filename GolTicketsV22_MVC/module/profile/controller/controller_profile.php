<?php
$path = $_SERVER['DOCUMENT_ROOT'] . '/GolTicketsV22_MVC/';
include($path . "module/profile/model/DAOProfile.php");
include($path . "model/middleware_auth.php");

@session_start();
$_SESSION['tiempo'] = time();

$op = $_GET['op'] ?? 'view';

switch ($op) {
    case 'view':
        include("module/profile/view/profile.html");
        break;

    case 'get_user_data':
        ob_clean();
        header('Content-Type: application/json');
        
        try {
            // Decodificamos el token que viene por POST al igual que haces en 'controluser' o 'data_user'
            $token_dec = decode_token($_POST['token']);
            
            if (!$token_dec || !isset($token_dec['username'])) {
                echo json_encode("error_token");
                exit;
            }

            $daoProfile = new DAOProfile();
            $rdo = $daoProfile->select_data_user($token_dec['username']);

            if ($rdo == "error_user") {
                echo json_encode("error_user");
                exit;
            } else {
                // Quitamos datos sensibles por seguridad antes de retornar
                unset($rdo['password']);
                echo json_encode($rdo);
                exit;
            }
        } catch (Exception $e) {
            echo json_encode("error");
            exit;
        }
        break;

    case 'update_account':
        ob_clean();
        header('Content-Type: application/json');

        try {
            // 1. Validar Token JWT
            $token_dec = decode_token($_POST['token']);
            if (!$token_dec || !isset($token_dec['username'])) {
                echo json_encode("error_token");
                exit;
            }

            $daoProfile = new DAOProfile();
            
            // 2. Traer los datos actuales reales de la BD para comparar
            $current_db_user = $daoProfile->select_data_user($token_dec['username']);
            if ($current_db_user == "error_user") {
                echo json_encode("error_user");
                exit;
            }

            $id_usuario = $current_db_user['id_usuario'];
            $db_username = $current_db_user['username'];

            // Datos que vienen del formulario del Perfil
            $input_username = $_POST['username'] ?? '';
            $input_password = $_POST['password'] ?? '';

            // Banderas booleanas para saber qué ha cambiado
            $cambia_username = ($input_username !== $db_username && !empty($input_username));
            $cambia_password = !empty($input_password);

            // 3. Evaluar escenarios de forma independiente
            if ($cambia_username && $cambia_password) {
                // Escenario C: Cambia ambos campos
                if (strlen($input_username) < 5 || strlen($input_password) < 8) { echo json_encode("error_invalid_data"); exit; }
                
                $hashed_password = password_hash($input_password, PASSWORD_ARGON2ID);
                $rdo = $daoProfile->update_user_full($id_usuario, $input_username, $hashed_password);
                
            } else if ($cambia_username) {
                // Escenario A: Cambia SOLO el nombre de usuario
                if (strlen($input_username) < 5) { echo json_encode("error_username_corto"); exit; }
                $rdo = $daoProfile->update_username_only($id_usuario, $input_username);
                
            } else if ($cambia_password) {
                // Escenario B: Cambia SOLO la contraseña
                if (strlen($input_password) < 8) { echo json_encode("error_password_corta"); exit; }
                $hashed_password = password_hash($input_password, PASSWORD_ARGON2ID);
                $rdo = $daoProfile->update_password_only($id_usuario, $hashed_password);
                
            } else {
                // No ha cambiado nada (le ha dado a guardar teniendo los mismos datos puestos)
                echo json_encode("no_changes");
                exit;
            }

            // 4. Enviar respuesta final
            if ($rdo) {
                echo json_encode("success");
            } else {
                echo json_encode("error_update");
            }
            exit;

        } catch (Exception $e) {
            echo json_encode("error");
            exit;
        }
        break;

    case 'get_liked_events':
        header('Content-Type: application/json');
        
        try {
            if (!isset($_POST['token']) || empty($_POST['token'])) {
                echo json_encode(["status" => "error", "message" => "No token provided"]);
                exit;
            }

            // Decodificamos el token JWT
            $token_dec = decode_token($_POST['token']);
            
            if (!$token_dec) {
                echo json_encode(["status" => "error", "message" => "Token decoding failed"]);
                exit;
            }

            // Extraer el username de forma segura (sea Array u Objeto)
            $username = null;
            if (is_array($token_dec) && isset($token_dec['username'])) {
                $username = $token_dec['username'];
            } elseif (is_object($token_dec) && isset($token_dec->username)) {
                $username = $token_dec->username;
            }

            // Si no se encuentra el username en ninguna de las dos estructuras
            if (!$username) {
                echo json_encode(["status" => "error", "message" => "Username not found in token payload"]);
                exit;
            }

            // Instanciamos el modelo y cargamos los eventos pasándole el usuario limpio
            $daoProfile = new DAOProfile();
            $rdo = $daoProfile->select_liked_events($username);

            // Si no hay filas o da falso, devolvemos un array vacío compatible con .length de JS
            if (!$rdo || !is_array($rdo)) {
                echo json_encode([]);
            } else {
                echo json_encode($rdo);
            }
            exit;
        } catch (Exception $e) {
            echo json_encode(["status" => "error", "message" => $e->getMessage()]);
            exit;
        }
        break;
}