<?php
$path = $_SERVER['DOCUMENT_ROOT'] . '/GolTicketsV18_MVC/';
include($path . "module/search/model/DAOSearch.php");
 
$op = $_GET['op'] ?? '';
 
switch ($op) {
 
    // Autocomplete del header: busca en partidos, equipos, ciudades y competiciones
    case 'autocomplete':
        $term = trim($_POST['term'] ?? '');
        if ($term === '') {
            echo json_encode([]);
            exit;
        }
        try {
            $dao  = new DAOSearch();
            $data = $dao->select_autocomplete($term);
            echo json_encode($data);
        } catch (Exception $e) {
            echo json_encode([]);
        }
        break;
 
    default:
        echo json_encode([]);
        break;
}