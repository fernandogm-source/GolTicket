<?php
// $data = 'hola crtl home';
// die('<script>console.log('.json_encode( $data ) .');</script>');

$path = $_SERVER['DOCUMENT_ROOT'] . '/GolTicketsV13_MVC/';
include($path . "module/home/model/DAOHome.php");

@session_start();

$op = $_GET['op'] ?? 'view';

switch ($op) {
    case 'view':
    default:
        include("module/home/view/home.html");
        break;

    case 'homePageCarousel':
        try {
            $daohome = new DAOHome();
            $SelectCarousel = $daohome->select_all_carousel();
        } catch(Exception $e) {
            echo json_encode("error"); exit();
        }
        echo !empty($SelectCarousel) ? json_encode($SelectCarousel) : json_encode("error");
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

    case 'homePageCities':
         //echo json_encode("homePageCities");
         //echo "Estas en cities";
        // exit();
        try{
            $daohome = new DAOHome();
            $SelectCity = $daohome->select_all_cities();
            // echo json_encode($SelectCity);
            // exit();
        } catch(Exception $e){
            echo json_encode("error");
        }
            
        if(!empty($SelectCity)){
            echo json_encode($SelectCity); 
        }
        else{
            echo json_encode("error");
        }
        break;

    case 'homePageTeams':
         //echo json_encode("homePageTeams");
         //echo "Estas en teams";
        // exit();
        try{
            $daohome = new DAOHome();
            $SelectTeam = $daohome->select_all_teams();
            // echo json_encode($SelectTeam);
            // exit();
        } catch(Exception $e){
            echo json_encode("error");
        }
            
        if(!empty($SelectTeam)){
            echo json_encode($SelectTeam); 
        }
        else{
            echo json_encode("error");
        }
        break;
}