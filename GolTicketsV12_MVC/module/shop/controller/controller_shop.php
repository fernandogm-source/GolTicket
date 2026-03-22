<?php
$path = $_SERVER['DOCUMENT_ROOT'] . '/GolTicketsV12_MVC/';
include($path . "/module/shop/model/DAO_shop.php");

switch ($_GET['op']) {
    case 'view':
        include('module/shop/view/shop.html');
        break;

    case 'all_event':
        try {
            $daoshop = new DAOShop();
            $dates_event = $daoshop->select_all_event();
        } catch (Exception $e) {
            echo json_encode("error");
        }

        if (!empty($dates_event)) {
            echo json_encode($dates_event);
        } else {
            echo json_encode("error");
        }
        break;

    case 'details_event':
    try {
        $daoshop = new DAOShop();
        $Date_event  = $daoshop->select_one_event($_GET['id']);
        $Date_images = $daoshop->select_imgs_event($_GET['id']);
    } catch (Exception $e) {
        echo json_encode("error");
        exit();
    }

    if (!empty($Date_event)) {
        $rdo    = array();
        $rdo[0] = $Date_event;
        $rdo[1] = $Date_images;
        echo json_encode($rdo);
    } else {
        echo json_encode("error");
    }
    break;
}
