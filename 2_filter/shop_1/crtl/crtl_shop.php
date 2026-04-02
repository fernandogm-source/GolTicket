<?php
$path = $_SERVER['DOCUMENT_ROOT'] . '/framework_php';
include($path . "/modules/shop/model/DAO_shop.php");

switch ($_GET['op']) {
    case 'list';
        include ('/modules/shop/view/inc/home_shop.html'); 
    break;
    
    case 'shopAll';
        $homeQuery = new DAO_shop();
        $selSlide = $homeQuery -> selectAll();
       
        if (!empty($selSlide)) {
            echo json_encode($selSlide);
        }
        else {
            echo "error";
        }
    break;

    case 'details';
        $homeQuery = new DAO_shop();
        $selSlide = $homeQuery -> details($_GET['id']);
        
        if (!empty($selSlide)) {
            echo json_encode($selSlide);
        }
        else {
            echo "error";
        }
        break;

    case 'print_filters';
        $homeQuery = new DAO_shop();
        $selSlide = $homeQuery -> print_filters();
        if (!empty($selSlide)) {
            echo json_encode($selSlide);
        }
        else {
            echo "error";
        }
        break;

    case 'filter';
        $homeQuery = new DAO_shop();
        $selSlide = $homeQuery -> filters($_POST['filter']);
        if (!empty($selSlide)) {
            echo json_encode($selSlide);
        }
        else {
            echo "error";
        }
        break;

    default;
        echo json_encode("404.html");
        break;
}
