<?php
$path = $_SERVER['DOCUMENT_ROOT'] . '/framework_php';
include($path . "/model/connect.php");

class DAO_shop {
    function selectAll() {
       $select = "SELECT c.*, ct.cat_name, t.type_name, b.brand_name
       FROM car c, categoria ct, type t, brand b
       WHERE c.categoria=ct.id_categoria AND c.combustible=t.id_type AND c.marca = b.id_brand
       ORDER BY c.visitas DESC";

        $conexion = connect::con();
        $res = mysqli_query($conexion, $select);
        connect::close($conexion);

        $retrArray = array();
        if ($res -> num_rows > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $retrArray[] = $row;
            }
        }
        return $retrArray;
    }

    function details($id) {
        $id = $_GET['id'];

        $select = "SELECT c.*, i.img, b.brand_name, t.type_name
        FROM car c, car_img i, brand b, type t
        WHERE c.id = i.car AND c.marca = b.id_brand AND c.combustible = t.id_type AND c.id = '$id'";
 
         $conexion = connect::con();
         $res = mysqli_query($conexion, $select);
         connect::close($conexion);
 
         $retrArray = array();
         if ($res -> num_rows > 0) {
             while ($row = mysqli_fetch_assoc($res)) {
                 $retrArray[] = $row;
             }
         }
         return $retrArray;
     }

    function print_filters() {
        $select = "SELECT * FROM car";
         $conexion = connect::con();
         $res = mysqli_query($conexion, $select);
         connect::close($conexion);

         $retrArray = array();
         if ($res -> num_rows > 0) {
             while ($row = mysqli_fetch_assoc($res)) {
                 $retrArray[] = $row;
             }
         }
         return $retrArray;
    }

    function filters($filter){
        //'<option value="Electrico">Electrico</option>'
        //$consulta.= " WHERE c." . $filter[$i][0] . "=' . $filter[$i][1].'";

        //'<option value="1">Electrico</option>'
        //$consulta.= " WHERE c." . $filter[$i][0] . "=" . $filter[$i][1];

        $consulta = "SELECT c.*, i.img, ca.cat_name, t.type_name, b.brand_name
        FROM car c INNER JOIN car_img i INNER JOIN categoria ca INNER JOIN type t INNER JOIN brand b
        ON c.id = i.car AND  i.img LIKE ('%1%') AND c.categoria = ca.id_categoria AND c.combustible = t.id_type AND c.marca = b.id_brand";
        
            for ($i=0; $i < count($filter); $i++){
                if ($i==0){
                    $consulta.= " WHERE c." . $filter[$i][0] . "=" . $filter[$i][1];
                }else {
                    $consulta.= " AND c." . $filter[$i][0] . "=" . $filter[$i][1];
                }        
            }   

        $conexion = connect::con();
        $res = mysqli_query($conexion, $consulta);
        connect::close($conexion);

        $retrArray = array();
        if ($res -> num_rows > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $retrArray[] = $row;
            }
        }
        return $retrArray;
    }
}
