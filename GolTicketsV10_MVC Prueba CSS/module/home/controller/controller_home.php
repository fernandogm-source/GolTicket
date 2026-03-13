<?php
// $data = 'hola crtl home';
// die('<script>console.log('.json_encode( $data ) .');</script>');

$path = $_SERVER['DOCUMENT_ROOT'] . '/GolTicketsV10_MVC Prueba CSS/';
include($path . "module/home/model/DAOHome.php");

@session_start();

$op = $_GET['op'] ?? 'view';

switch ($op) {
    case 'view':
    default:
        include("module/home/view/home.html");
        break;

    case 'homePageCategory':
        // echo json_encode("homePageCategory");
        // exit();
        try{
            $daohome = new DAOHome();
            $SelectCategory = $daohome->select_all_categories();
            // echo json_encode($SelectCategory);
            // exit();
        } catch(Exception $e){
            echo json_encode("error");
        }
            
        if(!empty($SelectCategory)){
            echo json_encode($SelectCategory); 
        }
        else{
            echo json_encode("error");
        }
        break;
}