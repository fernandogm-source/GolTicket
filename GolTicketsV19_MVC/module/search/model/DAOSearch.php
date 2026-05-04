<?php
$path = $_SERVER['DOCUMENT_ROOT'] . '/GolTicketsV19_MVC/';
include($path . "model/connect.php");
 
class DAOSearch
{
    // Busca en partidos, equipos, ciudades y competiciones en una sola query.
    // Devuelve hasta 10 resultados con: type, label, filter_key y filter_val
    // para que el JS guarde el filtro correcto en localStorage.
 
    function select_autocomplete($term)
    {
        $like     = '%' . $term . '%';
        $conexion = connect::con();
 
        $sql = "
            SELECT 'partido'          AS type,
                   p.nombre_partido   AS label,
                   'p.id_partido'     AS filter_key,
                   p.id_partido       AS filter_val
            FROM partido p
            WHERE p.nombre_partido LIKE :like1
 
            UNION ALL
 
            SELECT 'equipo'           AS type,
                   e.nombre_equipo    AS label,
                   'nombre_equipo'    AS filter_key,
                   e.nombre_equipo    AS filter_val
            FROM equipo e
            WHERE e.nombre_equipo LIKE :like2
 
            UNION ALL
 
            SELECT 'ciudad'            AS type,
                   ci.nombre_ciudad    AS label,
                   'ci.nombre_ciudad'  AS filter_key,
                   ci.nombre_ciudad    AS filter_val
            FROM ciudad ci
            WHERE ci.nombre_ciudad LIKE :like3
 
            UNION ALL
 
            SELECT 'competicion'             AS type,
                   co.nombre_competicion     AS label,
                   'co.nombre_competicion'   AS filter_key,
                   co.nombre_competicion     AS filter_val
            FROM competicion co
            WHERE co.nombre_competicion LIKE :like4
 
            LIMIT 10
        ";
 
        $stmt = $conexion->prepare($sql);
        $stmt->execute([
            ':like1' => $like,
            ':like2' => $like,
            ':like3' => $like,
            ':like4' => $like,
        ]);
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        connect::close($conexion);
        return $res;
    }
}