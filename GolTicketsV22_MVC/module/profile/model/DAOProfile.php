<?php
$path = $_SERVER['DOCUMENT_ROOT'] . '/GolTicketsV22_MVC/';
include($path . "model/connect.php");

class DAOProfile {

    // 1. Obtener los datos del usuario usando el username del token
    public function select_data_user($username) {
        $sql = "SELECT id_usuario, username, password, mail, role, avatar FROM users WHERE username = :username OR mail = :username";
        $conexion = connect::con();

        $stmt = $conexion->prepare($sql);
        $stmt->bindValue(':username', $username);
        $stmt->execute();

        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        connect::close($conexion);

        return $res ? $res : "error_user";
    }

    // Escenario A: Cambiar SOLO el Nombre de Usuario
    public function update_username_only($id_usuario, $new_username) {
        $sql = "UPDATE users SET username = :new_username WHERE id_usuario = :id_usuario";
        $conexion = connect::con();
        
        $stmt = $conexion->prepare($sql);
        $stmt->bindValue(':new_username', $new_username);
        $stmt->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);
        
        $res = $stmt->execute();
        connect::close($conexion);
        return $res;
    }

    // Escenario B: Cambiar SOLO la Contraseña
    public function update_password_only($id_usuario, $hashed_password) {
        $sql = "UPDATE users SET password = :password WHERE id_usuario = :id_usuario";
        $conexion = connect::con();
        
        $stmt = $conexion->prepare($sql);
        $stmt->bindValue(':password', $hashed_password);
        $stmt->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);
        
        $res = $stmt->execute();
        connect::close($conexion);
        return $res;
    }

    // Escenario C: Cambiar AMBAS cosas a la vez
    public function update_user_full($id_usuario, $new_username, $hashed_password) {
        $sql = "UPDATE users SET username = :new_username, password = :password WHERE id_usuario = :id_usuario";
        $conexion = connect::con();
        
        $stmt = $conexion->prepare($sql);
        $stmt->bindValue(':new_username', $new_username);
        $stmt->bindValue(':password', $hashed_password);
        $stmt->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);
        
        $res = $stmt->execute();
        connect::close($conexion);
        return $res;
    }

    public function count_likes_user($username) {
        $sql = "SELECT COUNT(*) AS contador 
                FROM likes_usuario l
                JOIN users u ON l.id_usuario = u.id_usuario
                WHERE u.username = :username";
        $conexion = connect::con();
        $stmt = $conexion->prepare($sql);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        connect::close($conexion);
        return $res;
    }

    public function select_load_likes_paginated($username, $limit, $offset) {
        $sql = "SELECT p.*, c.nombre_campo, co.nombre_competicion, ci.nombre_ciudad 
                FROM likes_usuario l
                JOIN users u         ON l.id_usuario     = u.id_usuario
                JOIN partido p       ON l.id_partido     = p.id_partido
                JOIN campo c         ON p.id_campo       = c.id_campo
                JOIN competicion co  ON p.id_competicion = co.id_competicion
                JOIN ciudad ci       ON c.id_ciudad      = ci.id_ciudad
                WHERE u.username = :username
                ORDER BY p.fecha_partido DESC
                LIMIT :limit OFFSET :offset";
                
        $conexion = connect::con();
        $stmt = $conexion->prepare($sql);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        // CRÍTICO: bindValue con PARAM_INT evita que MySQL reciba un string con comillas '3'
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        connect::close($conexion);
        return $res;
    }
}