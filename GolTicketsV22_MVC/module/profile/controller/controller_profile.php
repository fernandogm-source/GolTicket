<?php
$path = $_SERVER['DOCUMENT_ROOT'] . '/GolTicketsV22_MVC/';
include($path . "module/profile/model/DAOProfile.php");
include($path . "model/middleware_auth.php");

@session_start();

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

    case 'count_likes_user':
        ob_clean();
        header('Content-Type: application/json');
        try {
            $token = $_POST['token'] ?? '';
            $json = decode_token($token);
            
            if (!$json || !isset($json['username'])) {
                echo json_encode(["contador" => 0, "status" => "error_token"]);
                exit;
            }

            // Llamamos al método correcto dentro de tu DAO de perfil
            $daoProfile = new DAOProfile();
            $rdo = $daoProfile->count_likes_user($json['username']); 
            
            if ($rdo && isset($rdo['contador'])) {
                echo json_encode($rdo);
            } else {
                echo json_encode(["contador" => 0]);
            }
        } catch (Exception $e) {
            echo json_encode(["contador" => 0, "error" => $e->getMessage()]);
        }
        exit;
        break;

    case 'load_likes_user_paginated':
        ob_clean();
        header('Content-Type: application/json');
        try {
            $token = $_POST['token'] ?? '';
            $json = decode_token($token);
            
            if (!$json || !isset($json['username'])) {
                echo json_encode([]);
                exit;
            }

            $limit = isset($_POST['limit']) ? intval($_POST['limit']) : 3;
            $offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;
            
            // 1. Cargamos la información del partido usando tu DAOProfile
            $daoProfile = new DAOProfile();
            $partidos = $daoProfile->select_load_likes_paginated($json['username'], $limit, $offset);
            
            if (is_array($partidos)) {
                // 2. Cargamos el DAO de la tienda SOLAMENTE para extraer las imágenes secundarias
                $path = $_SERVER['DOCUMENT_ROOT'] . '/GolTicketsV22_MVC/';
                include_once($path . "module/shop/model/DAO_shop.php");
                $daoShop = new DAOShop();

                foreach ($partidos as $key => $partido) {
                    $imgs = $daoShop->select_img_partido($partido['id_partido']);
                    $partidos[$key]['imgs_partido'] = array_column($imgs, 'ruta_img');
                }
                echo json_encode($partidos);
            } else {
                echo json_encode([]);
            }
        } catch (Exception $e) {
            echo json_encode([]);
        }
        exit;
        break;
}