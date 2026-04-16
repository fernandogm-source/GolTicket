<?php
$path = $_SERVER['DOCUMENT_ROOT'] . '/GolTicketsV15_MVC/';
include($path . "/model/connect.php");

class DAOShop {

    function select_all_event($filter = []) {
        $sql = "SELECT p.id_partido, p.nombre_partido, p.fecha_partido, p.precio,
                    c.nombre_campo, co.nombre_competicion, ci.nombre_ciudad, c.img_campo,
                    GROUP_CONCAT(DISTINCT i.img SEPARATOR ':') AS imgs_partido,
                    GROUP_CONCAT(DISTINCT c.img_campo SEPARATOR ':') AS imgs_campo
                FROM partido p
                JOIN campo c         ON p.id_campo          = c.id_campo
                JOIN competicion co  ON p.id_competicion    = co.id_competicion
                JOIN ciudad ci       ON c.id_ciudad          = ci.id_ciudad
                JOIN equipo el       ON p.id_equipolocal     = el.id_equipo
                JOIN equipo ev       ON p.id_equipovisitante = ev.id_equipo
                LEFT JOIN img_partido i ON p.id_partido      = i.id_partido";

        $params = [];
        $wheres = [];

        for ($i = 0; $i < count($filter); $i++) {
            $campo = $filter[$i][0];
            $valor = $filter[$i][1];

            if ($campo === 'nombre_equipo') {
                if (is_array($valor)) {
                    $placeholders = [];
                    foreach ($valor as $k => $v) {
                        $key = 'equipo_' . $k;
                        $placeholders[] = ':' . $key;
                        $params[$key] = $v;
                    }
                    $in = implode(',', $placeholders);
                    $wheres[] = "(el.nombre_equipo IN ($in) OR ev.nombre_equipo IN ($in))";
                } else {
                    $wheres[] = "(el.nombre_equipo = :nombre_equipo OR ev.nombre_equipo = :nombre_equipo)";
                    $params['nombre_equipo'] = $valor;
                }
            } elseif ($campo === 'precio') {
                // valor es [min, max]
                $wheres[] = "p.precio BETWEEN :precio_min AND :precio_max";
                $params['precio_min'] = $valor[0];
                $params['precio_max'] = $valor[1];
            } else {
                $placeholder = str_replace('.', '_', $campo);
                $wheres[] = $campo . " = :" . $placeholder;
                $params[$placeholder] = $valor;
            }
        }

        if (!empty($wheres)) {
            $sql .= " WHERE " . implode(" AND ", $wheres);
        }

        $sql .= " GROUP BY p.id_partido";

        $conexion = connect::con();
        $stmt = $conexion->prepare($sql);
        $stmt->execute($params);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        connect::close($conexion);

        foreach ($rows as &$row) {
            $imgs_partido = $row['imgs_partido'] ? explode(':', $row['imgs_partido']) : [];
            $imgs_campo   = $row['imgs_campo']   ? explode(':', $row['imgs_campo'])   : [];
            $row['imgs_partido'] = array_merge($imgs_campo, $imgs_partido);
            unset($row['imgs_campo']);
        }

        return $rows;
    }

    function get_dynamic_filters() {
        try {
            $conexion = connect::con();

            $sql = "SELECT * FROM config_filters ORDER BY id_filter";
            $stmt = $conexion->prepare($sql);
            $stmt->execute();
            $filtros = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $resultado = [];

            foreach ($filtros as $f) {
                $col = $f['db_column'];

                if ($f['html_type'] === 'slider') {
                    $sql_val = "SELECT MIN(precio) as min, MAX(precio) as max FROM partido";
                    $stmt_val = $conexion->prepare($sql_val);
                    $stmt_val->execute();
                    $f['valores'] = $stmt_val->fetch(PDO::FETCH_ASSOC);

                } elseif (!empty($f['join_table'])) {
                    $jt = $f['join_table'];
                    $jl = $f['db_column'];
                    $fk  = $f['join_label'];   // id_equipolocal
                    $fk2 = $f['join_fk2'] ?? null; // id_equipovisitante

                    if (!empty($fk2)) {
                    $sql_val = "SELECT DISTINCT j.$jl
                                FROM $jt j
                                WHERE j.id_equipo IN (
                                    SELECT t.$fk FROM partido t WHERE t.$fk IS NOT NULL
                                    UNION
                                    SELECT t.$fk2 FROM partido t WHERE t.$fk2 IS NOT NULL
                                )";
                    } else {
                        $sql_val = "SELECT DISTINCT j.$jl 
                                    FROM $jt j
                                    INNER JOIN partido t ON j.$fk = t.$fk
                                    WHERE t.$fk IS NOT NULL";
                    }

                    $stmt_val = $conexion->prepare($sql_val);
                    $stmt_val->execute();
                    $f['valores'] = $stmt_val->fetchAll(PDO::FETCH_COLUMN);
                }

                $resultado[] = $f;
            }

            $conexion = null;
            return $resultado;

        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    }

    function select_one_event($id) {
        $sql = "SELECT p.id_partido, p.nombre_partido, p.fecha_partido, p.precio,
                    c.nombre_campo, co.nombre_competicion, ci.nombre_ciudad
                FROM partido p
                JOIN campo c        ON p.id_campo       = c.id_campo
                JOIN competicion co ON p.id_competicion = co.id_competicion
                JOIN ciudad ci      ON c.id_ciudad      = ci.id_ciudad
                WHERE p.id_partido = :id";

        $conexion = connect::con();
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_OBJ);
        connect::close($conexion);

        return $res;
    }

    function select_imgs_event($id) {
        $sql = "SELECT i.img FROM img_partido i WHERE i.id_partido = :id";

        $conexion = connect::con();
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        connect::close($conexion);

        return $res;
    }

    function select_extra_event($id) {
        $sql = "SELECT e.nombre_extra, e.img_extra
                FROM partido_extra p, extra e
                WHERE e.id_extra = p.id_extra AND p.id_partido = :id";

        $conexion = connect::con();
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        connect::close($conexion);

        return $res;
    }
}
